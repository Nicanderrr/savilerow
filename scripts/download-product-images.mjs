/**
 * Downloads free product-specific catalog JPGs.
 * Sources are free-to-use Unsplash photos, saved locally so the storefront does
 * not depend on remote image hotlinks at runtime.
 *
 * Run: node scripts/download-product-images.mjs
 */
import fs from "fs";
import path from "path";
import { fileURLToPath } from "url";

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = path.join(__dirname, "..");
const outDir = path.join(root, "public", "images", "products");

const img = (id) =>
  `https://images.unsplash.com/${id}?auto=format&fit=crop&w=1200&h=1500&q=85`;
const sleep = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

async function writeFileWithRetry(file, buf) {
  let lastError;

  for (let attempt = 0; attempt < 5; attempt += 1) {
    try {
      fs.writeFileSync(file, buf);
      return;
    } catch (error) {
      lastError = error;
      await sleep(500);
    }
  }

  throw lastError;
}

const SOURCES = {
  "suit-navy-1.jpg": img("photo-1594938298603-c8148c4dae35"),
  "suit-navy-2.jpg": img("photo-1594938298603-c8148c4dae35"),
  "suit-navy-3.jpg": img("photo-1594938298603-c8148c4dae35"),
  "suit-navy-4.jpg": img("photo-1594938298603-c8148c4dae35"),
  "suit-navy-5.jpg": img("photo-1594938298603-c8148c4dae35"),
  "suit-navy-6.jpg": img("photo-1594938298603-c8148c4dae35"),
  "morning-coat-1.jpg": img("photo-1594938298603-c8148c4dae35"),
  "morning-coat-2.jpg": img("photo-1594938298603-c8148c4dae35"),
  "morning-coat-3.jpg": img("photo-1594938298603-c8148c4dae35"),
  "morning-coat-4.jpg": img("photo-1594938298603-c8148c4dae35"),
  "tuxedo-1.jpg": img("photo-1594938298603-c8148c4dae35"),
  "tuxedo-2.jpg": img("photo-1594938298603-c8148c4dae35"),
  "tuxedo-3.jpg": img("photo-1594938298603-c8148c4dae35"),
  "tuxedo-4.jpg": img("photo-1594938298603-c8148c4dae35"),
  "blazer-w-1.jpg": img("photo-1594938298603-c8148c4dae35"),
  "blazer-w-2.jpg": img("photo-1594938298603-c8148c4dae35"),
  "blazer-w-3.jpg": img("photo-1594938298603-c8148c4dae35"),
  "kids-blazer-1.jpg": img("photo-1594938298603-c8148c4dae35"),
  "kids-blazer-2.jpg": img("photo-1594938298603-c8148c4dae35"),

  "oxford-black-1.jpg": "https://images.pexels.com/photos/15557052/pexels-photo-15557052.jpeg?cs=srgb&dl=pexels-alipli-15557052.jpg&fm=jpg",
  "oxford-black-2.jpg": "https://images.pexels.com/photos/31785887/pexels-photo-31785887.jpeg?cs=srgb&dl=pexels-alokkd1-31785887.jpg&fm=jpg",
  "oxford-black-3.jpg": "https://images.pexels.com/photos/15557052/pexels-photo-15557052.jpeg?cs=srgb&dl=pexels-alipli-15557052.jpg&fm=jpg",
  "oxford-black-4.jpg": "https://images.pexels.com/photos/31785887/pexels-photo-31785887.jpeg?cs=srgb&dl=pexels-alokkd1-31785887.jpg&fm=jpg",
  "oxford-burgundy-1.jpg": "https://images.pexels.com/photos/8670488/pexels-photo-8670488.jpeg?cs=srgb&dl=pexels-pushpendra-singh-78160205-8670488.jpg&fm=jpg",
  "oxford-burgundy-2.jpg": "https://images.pexels.com/photos/8670488/pexels-photo-8670488.jpeg?cs=srgb&dl=pexels-pushpendra-singh-78160205-8670488.jpg&fm=jpg",
  "loafer-1.jpg": "https://images.pexels.com/photos/17577101/pexels-photo-17577101.jpeg?cs=srgb&dl=pexels-joao-pedro-454808227-17577101.jpg&fm=jpg",
  "loafer-2.jpg": "https://images.pexels.com/photos/17577101/pexels-photo-17577101.jpeg?cs=srgb&dl=pexels-joao-pedro-454808227-17577101.jpg&fm=jpg",
  "loafer-3.jpg": "https://images.pexels.com/photos/17577101/pexels-photo-17577101.jpeg?cs=srgb&dl=pexels-joao-pedro-454808227-17577101.jpg&fm=jpg",
  "chelsea-boot-1.jpg": "https://images.pexels.com/photos/35654955/pexels-photo-35654955.jpeg?cs=srgb&dl=pexels-prolificpeople-35654955.jpg&fm=jpg",
  "chelsea-boot-2.jpg": "https://images.pexels.com/photos/35654955/pexels-photo-35654955.jpeg?cs=srgb&dl=pexels-prolificpeople-35654955.jpg&fm=jpg",
  "chelsea-boot-3.jpg": "https://images.pexels.com/photos/35654955/pexels-photo-35654955.jpeg?cs=srgb&dl=pexels-prolificpeople-35654955.jpg&fm=jpg",
  "sneaker-1.jpg": "https://images.pexels.com/photos/2529147/pexels-photo-2529147.jpeg?cs=srgb&dl=pexels-melvin-buezo-1253763-2529147.jpg&fm=jpg",
  "sneaker-2.jpg": "https://images.pexels.com/photos/2529147/pexels-photo-2529147.jpeg?cs=srgb&dl=pexels-melvin-buezo-1253763-2529147.jpg&fm=jpg",
  "sneaker-3.jpg": "https://images.pexels.com/photos/2529147/pexels-photo-2529147.jpeg?cs=srgb&dl=pexels-melvin-buezo-1253763-2529147.jpg&fm=jpg",
  "sandal-1.jpg": "https://images.pexels.com/photos/31450733/pexels-photo-31450733.jpeg?cs=srgb&dl=pexels-pedro-furtado-2149998739-31450733.jpg&fm=jpg",
  "sandal-2.jpg": "https://images.pexels.com/photos/17826424/pexels-photo-17826424.jpeg?cs=srgb&dl=pexels-rankzl-192436742-17826424.jpg&fm=jpg",
  "sandal-3.jpg": "https://images.pexels.com/photos/31450733/pexels-photo-31450733.jpeg?cs=srgb&dl=pexels-pedro-furtado-2149998739-31450733.jpg&fm=jpg",
  "pump-1.jpg": "https://images.pexels.com/photos/17826424/pexels-photo-17826424.jpeg?cs=srgb&dl=pexels-rankzl-192436742-17826424.jpg&fm=jpg",
  "pump-2.jpg": "https://images.pexels.com/photos/10070653/pexels-photo-10070653.jpeg?cs=srgb&dl=pexels-pablopolo-10070653.jpg&fm=jpg",

  "bag-weekender-1.jpg": img("photo-1548036328-c9fa89d128fa"),
  "bag-weekender-2.jpg": img("photo-1548036328-c9fa89d128fa"),
  "bag-weekender-3.jpg": img("photo-1548036328-c9fa89d128fa"),
  "clutch-1.jpg": "https://unsplash.com/photos/APNnyM36puU/download?force=true",
  "clutch-2.jpg": "https://unsplash.com/photos/APNnyM36puU/download?force=true",
  "clutch-3.jpg": "https://unsplash.com/photos/APNnyM36puU/download?force=true",

  "perfume-1.jpg": img("photo-1541643600914-78b084683601"),
  "perfume-2.jpg": img("photo-1592945403244-b3fbafd7f539"),
  "perfume-3.jpg": img("photo-1541643600914-78b084683601"),
  "cologne-1.jpg": img("photo-1592945403244-b3fbafd7f539"),
  "cologne-2.jpg": img("photo-1541643600914-78b084683601"),

  "cufflinks-1.jpg": "https://unsplash.com/photos/7_XrKXM1mms/download?force=true",
  "cufflinks-2.jpg": "https://unsplash.com/photos/7_XrKXM1mms/download?force=true",
  "cufflinks-3.jpg": "https://unsplash.com/photos/7_XrKXM1mms/download?force=true",
  "belt-1.jpg": "https://unsplash.com/photos/eNEa7Gsfzzs/download?force=true",
  "belt-2.jpg": "https://unsplash.com/photos/eNEa7Gsfzzs/download?force=true",
  "belt-3.jpg": "https://unsplash.com/photos/eNEa7Gsfzzs/download?force=true",
  "wallet-1.jpg": "https://unsplash.com/photos/-lN0HnySy7w/download?force=true",
  "wallet-2.jpg": "https://unsplash.com/photos/-lN0HnySy7w/download?force=true",
  "wallet-3.jpg": "https://unsplash.com/photos/-lN0HnySy7w/download?force=true",

  "hero-poster.jpg": img("photo-1594938298603-c8148c4dae35"),
  "women-promo.jpg": img("photo-1594938298603-c8148c4dae35"),
  "men-promo.jpg": img("photo-1594938298603-c8148c4dae35"),
  "kids-promo.jpg": img("photo-1594938298603-c8148c4dae35"),
  "accessories-promo.jpg": "https://unsplash.com/photos/7_XrKXM1mms/download?force=true",
  "bag-promo.jpg": img("photo-1548036328-c9fa89d128fa"),
  "shoe-promo.jpg": img("photo-1614253429340-98120bd6d753"),
  "fitting.jpg": img("photo-1594938298603-c8148c4dae35"),
  "store.jpg": img("photo-1594938298603-c8148c4dae35"),
  "tailoring.jpg": img("photo-1594938298603-c8148c4dae35"),
  "contact.jpg": img("photo-1594938298603-c8148c4dae35"),
};

fs.mkdirSync(outDir, { recursive: true });

const startAt = process.argv[2];
let started = !startAt;

for (const [filename, url] of Object.entries(SOURCES)) {
  if (!started) {
    started = filename === startAt;
    if (!started) continue;
  }

  const dest = path.join(outDir, filename);
  const res = await fetch(url, { redirect: "follow" });

  if (!res.ok) {
    throw new Error(`Failed ${filename}: ${res.status} ${url}`);
  }

  const contentType = res.headers.get("content-type") ?? "";
  if (!contentType.includes("image")) {
    throw new Error(`Failed ${filename}: expected image, got ${contentType}`);
  }

  const buf = Buffer.from(await res.arrayBuffer());
  if (buf.length < 10_000) {
    throw new Error(`Failed ${filename}: downloaded file is too small (${buf.length} bytes)`);
  }

  await writeFileWithRetry(dest, buf);
  console.log(`ok ${filename} (${buf.length} bytes)`);
}

console.log(`Done: ${Object.keys(SOURCES).length} product images in public/images/products/`);
