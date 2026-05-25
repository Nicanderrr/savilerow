/**
 * Local product imagery under public/images/products/.
 * Each PHOTOS key maps to a stable JPG (no remote hotlinks).
 */
const BASE = "/images/products";

function img(filename: string): string {
  return `${BASE}/${filename}`;
}

export const PHOTOS = {
  suitNavy1: img("suit-navy-1.jpg"),
  suitNavy2: img("suit-navy-2.jpg"),
  suitNavy3: img("suit-navy-3.jpg"),
  suitNavy4: img("suit-navy-4.jpg"),
  suitNavy5: img("suit-navy-5.jpg"),
  suitNavy6: img("suit-navy-6.jpg"),
  morningCoat1: img("morning-coat-1.jpg"),
  morningCoat2: img("morning-coat-2.jpg"),
  morningCoat3: img("morning-coat-3.jpg"),
  morningCoat4: img("morning-coat-4.jpg"),
  tuxedo1: img("tuxedo-1.jpg"),
  tuxedo2: img("tuxedo-2.jpg"),
  tuxedo3: img("tuxedo-3.jpg"),
  tuxedo4: img("tuxedo-4.jpg"),
  oxfordBlack1: img("oxford-black-1.jpg"),
  oxfordBlack2: img("oxford-black-2.jpg"),
  oxfordBlack3: img("oxford-black-3.jpg"),
  oxfordBlack4: img("oxford-black-4.jpg"),
  oxfordBurgundy1: img("oxford-burgundy-1.jpg"),
  oxfordBurgundy2: img("oxford-burgundy-2.jpg"),
  loafer1: img("loafer-1.jpg"),
  loafer2: img("loafer-2.jpg"),
  loafer3: img("loafer-3.jpg"),
  chelseaBoot1: img("chelsea-boot-1.jpg"),
  chelseaBoot2: img("chelsea-boot-2.jpg"),
  chelseaBoot3: img("chelsea-boot-3.jpg"),
  sneaker1: img("sneaker-1.jpg"),
  sneaker2: img("sneaker-2.jpg"),
  sneaker3: img("sneaker-3.jpg"),
  sandal1: img("sandal-1.jpg"),
  sandal2: img("sandal-2.jpg"),
  sandal3: img("sandal-3.jpg"),
  bagWeekender1: img("bag-weekender-1.jpg"),
  bagWeekender2: img("bag-weekender-2.jpg"),
  bagWeekender3: img("bag-weekender-3.jpg"),
  clutch1: img("clutch-1.jpg"),
  clutch2: img("clutch-2.jpg"),
  clutch3: img("clutch-3.jpg"),
  perfume1: img("perfume-1.jpg"),
  perfume2: img("perfume-2.jpg"),
  perfume3: img("perfume-3.jpg"),
  cologne1: img("cologne-1.jpg"),
  cologne2: img("cologne-2.jpg"),
  cufflinks1: img("cufflinks-1.jpg"),
  cufflinks2: img("cufflinks-2.jpg"),
  cufflinks3: img("cufflinks-3.jpg"),
  belt1: img("belt-1.jpg"),
  belt2: img("belt-2.jpg"),
  belt3: img("belt-3.jpg"),
  blazerW1: img("blazer-w-1.jpg"),
  blazerW2: img("blazer-w-2.jpg"),
  blazerW3: img("blazer-w-3.jpg"),
  pump1: img("pump-1.jpg"),
  pump2: img("pump-2.jpg"),
  kidsBlazer1: img("kids-blazer-1.jpg"),
  kidsBlazer2: img("kids-blazer-2.jpg"),
  wallet1: img("wallet-1.jpg"),
  wallet2: img("wallet-2.jpg"),
  wallet3: img("wallet-3.jpg"),
  heroPoster: img("hero-poster.jpg"),
  womenPromo: img("women-promo.jpg"),
  menPromo: img("men-promo.jpg"),
  kidsPromo: img("kids-promo.jpg"),
  accessoriesPromo: img("accessories-promo.jpg"),
  bagPromo: img("bag-promo.jpg"),
  shoePromo: img("shoe-promo.jpg"),
  fitting: img("fitting.jpg"),
  store: img("store.jpg"),
  tailoring: img("tailoring.jpg"),
  contact: img("contact.jpg"),
} as const;

export type PhotoPath = (typeof PHOTOS)[keyof typeof PHOTOS];

/** All catalog image paths (for verification scripts). */
export const ALL_IMAGE_PATHS: readonly string[] = Object.values(PHOTOS);

export function gallery(...paths: string[]): string[] {
  return paths;
}

export function colorGalleries(
  sets: Record<string, string[]>
): Record<string, string[]> {
  const out: Record<string, string[]> = {};
  for (const [color, paths] of Object.entries(sets)) {
    out[color] = gallery(...paths);
  }
  return out;
}
