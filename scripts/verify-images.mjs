/**
 * Verifies all catalog image paths exist on disk.
 * Run: node scripts/verify-images.mjs
 */
import fs from "fs";
import path from "path";
import { fileURLToPath } from "url";

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = path.join(__dirname, "..");
const imagesTs = fs.readFileSync(
  path.join(root, "src", "lib", "images.ts"),
  "utf8"
);

const filenames = [
  ...imagesTs.matchAll(/img\("([a-z0-9-]+\.jpg)"\)/g),
].map((m) => m[1]);

const unique = [...new Set(filenames)];
const missing = [];

for (const filename of unique) {
  const file = path.join(root, "public", "images", "products", filename);
  if (!fs.existsSync(file)) {
    missing.push(filename);
  } else if (fs.statSync(file).size < 1000) {
    missing.push(`${filename} (too small)`);
  }
}

if (missing.length) {
  console.error("Missing or invalid product images:");
  missing.forEach((p) => console.error(`  - ${p}`));
  process.exit(1);
}

console.log(`OK: ${unique.length} product images verified.`);
