import type { Product } from "./types";
import { PHOTOS, gallery } from "./images";

const SETS = {
  oxford: gallery(
    PHOTOS.oxfordBlack1,
    PHOTOS.oxfordBlack2,
    PHOTOS.oxfordBlack3,
    PHOTOS.oxfordBlack4,
    PHOTOS.oxfordBurgundy1,
    PHOTOS.oxfordBurgundy2
  ),
  loafer: gallery(PHOTOS.loafer1, PHOTOS.loafer2, PHOTOS.loafer3, PHOTOS.loafer1, PHOTOS.loafer2, PHOTOS.loafer3),
  "chelsea-boot": gallery(
    PHOTOS.chelseaBoot1,
    PHOTOS.chelseaBoot2,
    PHOTOS.chelseaBoot3,
    PHOTOS.chelseaBoot1,
    PHOTOS.chelseaBoot2,
    PHOTOS.chelseaBoot3
  ),
  sneaker: gallery(PHOTOS.sneaker1, PHOTOS.sneaker2, PHOTOS.sneaker3, PHOTOS.sneaker1, PHOTOS.sneaker2, PHOTOS.sneaker3),
  sandal: gallery(PHOTOS.sandal1, PHOTOS.sandal2, PHOTOS.sandal3, PHOTOS.sandal1, PHOTOS.sandal2, PHOTOS.sandal3),
  pump: gallery(PHOTOS.pump1, PHOTOS.pump2, PHOTOS.pump1, PHOTOS.pump2, PHOTOS.pump1, PHOTOS.pump2),
  boot: gallery(
    PHOTOS.chelseaBoot2,
    PHOTOS.chelseaBoot1,
    PHOTOS.chelseaBoot3,
    PHOTOS.chelseaBoot2,
    PHOTOS.chelseaBoot1,
    PHOTOS.chelseaBoot3
  ),
  shoes: gallery(PHOTOS.oxfordBlack1, PHOTOS.loafer1, PHOTOS.chelseaBoot1, PHOTOS.sneaker1, PHOTOS.sandal1, PHOTOS.pump1),
  "two-piece": gallery(
    PHOTOS.suitNavy1,
    PHOTOS.suitNavy2,
    PHOTOS.suitNavy3,
    PHOTOS.suitNavy4,
    PHOTOS.suitNavy5,
    PHOTOS.suitNavy6
  ),
  "three-piece": gallery(
    PHOTOS.suitNavy3,
    PHOTOS.suitNavy1,
    PHOTOS.suitNavy2,
    PHOTOS.suitNavy4,
    PHOTOS.suitNavy5,
    PHOTOS.suitNavy6
  ),
  tuxedo: gallery(PHOTOS.tuxedo1, PHOTOS.tuxedo2, PHOTOS.tuxedo3, PHOTOS.tuxedo4, PHOTOS.tuxedo1, PHOTOS.tuxedo2),
  "morning-coat": gallery(
    PHOTOS.morningCoat1,
    PHOTOS.morningCoat2,
    PHOTOS.morningCoat3,
    PHOTOS.morningCoat4,
    PHOTOS.morningCoat1,
    PHOTOS.morningCoat2
  ),
  blazer: gallery(PHOTOS.blazerW1, PHOTOS.blazerW2, PHOTOS.blazerW3, PHOTOS.suitNavy1, PHOTOS.suitNavy2, PHOTOS.suitNavy3),
  suits: gallery(PHOTOS.suitNavy1, PHOTOS.tuxedo1, PHOTOS.blazerW1, PHOTOS.morningCoat1, PHOTOS.suitNavy2, PHOTOS.tuxedo2),
  weekender: gallery(
    PHOTOS.bagWeekender1,
    PHOTOS.bagWeekender2,
    PHOTOS.bagWeekender3,
    PHOTOS.bagWeekender1,
    PHOTOS.bagWeekender2,
    PHOTOS.bagWeekender3
  ),
  clutch: gallery(PHOTOS.clutch1, PHOTOS.clutch2, PHOTOS.clutch3, PHOTOS.clutch1, PHOTOS.clutch2, PHOTOS.clutch3),
  tote: gallery(
    PHOTOS.bagWeekender2,
    PHOTOS.bagWeekender1,
    PHOTOS.bagWeekender3,
    PHOTOS.bagWeekender2,
    PHOTOS.bagWeekender1,
    PHOTOS.bagWeekender3
  ),
  briefcase: gallery(
    PHOTOS.bagWeekender3,
    PHOTOS.bagWeekender1,
    PHOTOS.bagWeekender2,
    PHOTOS.bagWeekender3,
    PHOTOS.bagWeekender1,
    PHOTOS.bagWeekender2
  ),
  crossbody: gallery(PHOTOS.clutch1, PHOTOS.bagWeekender2, PHOTOS.clutch2, PHOTOS.bagWeekender1, PHOTOS.clutch3, PHOTOS.bagWeekender3),
  backpack: gallery(
    PHOTOS.bagWeekender3,
    PHOTOS.bagWeekender2,
    PHOTOS.bagWeekender1,
    PHOTOS.bagWeekender3,
    PHOTOS.bagWeekender2,
    PHOTOS.bagWeekender1
  ),
  bags: gallery(PHOTOS.bagWeekender1, PHOTOS.clutch1, PHOTOS.bagWeekender2, PHOTOS.clutch2, PHOTOS.bagWeekender3, PHOTOS.clutch3),
  "eau-de-parfum": gallery(PHOTOS.perfume1, PHOTOS.perfume2, PHOTOS.perfume3, PHOTOS.perfume1, PHOTOS.perfume2, PHOTOS.perfume3),
  cologne: gallery(PHOTOS.cologne1, PHOTOS.cologne2, PHOTOS.perfume1, PHOTOS.cologne1, PHOTOS.cologne2, PHOTOS.perfume2),
  "eau-de-toilette": gallery(PHOTOS.perfume2, PHOTOS.perfume1, PHOTOS.cologne1, PHOTOS.perfume3, PHOTOS.perfume2, PHOTOS.cologne2),
  extrait: gallery(PHOTOS.perfume3, PHOTOS.perfume1, PHOTOS.perfume2, PHOTOS.cologne1, PHOTOS.perfume3, PHOTOS.cologne2),
  perfumes: gallery(PHOTOS.perfume1, PHOTOS.cologne1, PHOTOS.perfume2, PHOTOS.cologne2, PHOTOS.perfume3, PHOTOS.perfume1),
  cufflinks: gallery(PHOTOS.cufflinks1, PHOTOS.cufflinks2, PHOTOS.cufflinks3, PHOTOS.cufflinks1, PHOTOS.cufflinks2, PHOTOS.cufflinks3),
  belts: gallery(PHOTOS.belt1, PHOTOS.belt2, PHOTOS.belt3, PHOTOS.belt1, PHOTOS.belt2, PHOTOS.belt3),
  wallets: gallery(PHOTOS.wallet1, PHOTOS.wallet2, PHOTOS.wallet3, PHOTOS.wallet1, PHOTOS.wallet2, PHOTOS.wallet3),
  "pocket-square": gallery(PHOTOS.cufflinks3, PHOTOS.cufflinks1, PHOTOS.cufflinks2, PHOTOS.cufflinks3, PHOTOS.cufflinks1, PHOTOS.cufflinks2),
  scarf: gallery(PHOTOS.cufflinks2, PHOTOS.cufflinks3, PHOTOS.cufflinks1, PHOTOS.cufflinks2, PHOTOS.cufflinks3, PHOTOS.cufflinks1),
  tie: gallery(PHOTOS.cufflinks1, PHOTOS.cufflinks2, PHOTOS.cufflinks3, PHOTOS.cufflinks1, PHOTOS.cufflinks2, PHOTOS.cufflinks3),
  accessories: gallery(PHOTOS.cufflinks1, PHOTOS.belt1, PHOTOS.wallet1, PHOTOS.cufflinks2, PHOTOS.belt2, PHOTOS.wallet2),
} as const;

type ImageSetKey = keyof typeof SETS;

function resolveImageSet(product: Product): string[] {
  const sub = product.subcategory as ImageSetKey | undefined;
  if (sub && sub in SETS) return [...SETS[sub]];

  const cat = product.category as ImageSetKey;
  if (cat in SETS) return [...SETS[cat]];

  return [...SETS.suits];
}

function buildColorImages(product: Product, base: string[]): Record<string, string[]> {
  const out: Record<string, string[]> = {};

  for (const c of product.colors) {
    if (c.value === "cream" || c.value === "gold") {
      out[c.value] = gallery(base[1] ?? base[0], base[0], ...base.slice(2));
    } else {
      out[c.value] = gallery(...base);
    }
  }

  if (Object.keys(out).length === 0) {
    out.default = base;
  }

  return out;
}

export function applyProductImages(product: Product): Product {
  const images = resolveImageSet(product);
  const colorImages = buildColorImages(product, images);
  return { ...product, images, colorImages };
}

export function isRemoteImage(src: string): boolean {
  return src.startsWith("http://") || src.startsWith("https://");
}
