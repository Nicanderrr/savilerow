/**
 * One-time setup: download product placeholder JPGs from Picsum (deterministic seeds).
 * Run: node scripts/download-product-images.mjs
 */
import fs from "fs";
import path from "path";
import { fileURLToPath } from "url";

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = path.join(__dirname, "..");
const outDir = path.join(root, "public", "images", "products");

const PHOTO_KEYS = [
  "suitNavy1", "suitNavy2", "suitNavy3", "suitNavy4", "suitNavy5", "suitNavy6",
  "morningCoat1", "morningCoat2", "morningCoat3", "morningCoat4",
  "tuxedo1", "tuxedo2", "tuxedo3", "tuxedo4",
  "oxfordBlack1", "oxfordBlack2", "oxfordBlack3", "oxfordBlack4",
  "oxfordBurgundy1", "oxfordBurgundy2",
  "loafer1", "loafer2", "loafer3",
  "bagWeekender1", "bagWeekender2", "bagWeekender3",
  "clutch1", "clutch2", "clutch3",
  "perfume1", "perfume2", "perfume3", "cologne1", "cologne2",
  "cufflinks1", "cufflinks2", "cufflinks3",
  "belt1", "belt2", "belt3",
  "blazerW1", "blazerW2", "blazerW3",
  "pump1", "pump2",
  "kidsBlazer1", "kidsBlazer2",
  "wallet1", "wallet2", "wallet3",
  "heroPoster", "womenPromo", "menPromo", "kidsPromo",
  "accessoriesPromo", "bagPromo", "shoePromo",
  "fitting", "store", "tailoring", "contact",
];

function toKebab(key) {
  return key
    .replace(/([a-z])([A-Z])/g, "$1-$2")
    .replace(/(\d+)/g, "-$1")
    .toLowerCase()
    .replace(/^-/, "")
    .replace(/--+/g, "-");
}

fs.mkdirSync(outDir, { recursive: true });

for (const key of PHOTO_KEYS) {
  const filename = `${toKebab(key)}.jpg`;
  const dest = path.join(outDir, filename);
  const seed = `savile-row-${toKebab(key)}`;
  const url = `https://picsum.photos/seed/${encodeURIComponent(seed)}/800/1000.jpg`;

  if (fs.existsSync(dest) && fs.statSync(dest).size > 10_000) {
    console.log(`skip ${filename}`);
    continue;
  }

  const res = await fetch(url, { redirect: "follow" });
  if (!res.ok) {
    throw new Error(`Failed ${url}: ${res.status}`);
  }
  const buf = Buffer.from(await res.arrayBuffer());
  fs.writeFileSync(dest, buf);
  console.log(`ok ${filename} (${buf.length} bytes)`);
}

console.log(`Done: ${PHOTO_KEYS.length} images in public/images/products/`);
