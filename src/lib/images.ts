/**
 * Product & promo imagery (Unsplash — free licence).
 * Per-product galleries are applied in product-media.ts by subcategory.
 */
import { PROMO_IMAGES } from "./product-media";

export const PHOTOS = {
  ...PROMO_IMAGES,
  /** Legacy keys referenced in catalog before media override */
  suitNavy1: PROMO_IMAGES.menPromo,
  suitNavy2: PROMO_IMAGES.menPromo,
  suitNavy3: PROMO_IMAGES.menPromo,
  suitNavy4: PROMO_IMAGES.menPromo,
  suitNavy5: PROMO_IMAGES.menPromo,
  suitNavy6: PROMO_IMAGES.menPromo,
  morningCoat1: PROMO_IMAGES.menPromo,
  morningCoat2: PROMO_IMAGES.menPromo,
  morningCoat3: PROMO_IMAGES.menPromo,
  morningCoat4: PROMO_IMAGES.menPromo,
  tuxedo1: PROMO_IMAGES.menPromo,
  tuxedo2: PROMO_IMAGES.menPromo,
  tuxedo3: PROMO_IMAGES.menPromo,
  tuxedo4: PROMO_IMAGES.menPromo,
  oxfordBlack1: PROMO_IMAGES.shoePromo,
  oxfordBlack2: PROMO_IMAGES.shoePromo,
  oxfordBlack3: PROMO_IMAGES.shoePromo,
  oxfordBlack4: PROMO_IMAGES.shoePromo,
  oxfordBurgundy1: PROMO_IMAGES.shoePromo,
  oxfordBurgundy2: PROMO_IMAGES.shoePromo,
  loafer1: PROMO_IMAGES.shoePromo,
  loafer2: PROMO_IMAGES.shoePromo,
  loafer3: PROMO_IMAGES.shoePromo,
  bagWeekender1: PROMO_IMAGES.bagPromo,
  bagWeekender2: PROMO_IMAGES.bagPromo,
  bagWeekender3: PROMO_IMAGES.bagPromo,
  clutch1: PROMO_IMAGES.bagPromo,
  clutch2: PROMO_IMAGES.bagPromo,
  clutch3: PROMO_IMAGES.bagPromo,
  perfume1: PROMO_IMAGES.accessoriesPromo,
  perfume2: PROMO_IMAGES.accessoriesPromo,
  perfume3: PROMO_IMAGES.accessoriesPromo,
  cologne1: PROMO_IMAGES.accessoriesPromo,
  cologne2: PROMO_IMAGES.accessoriesPromo,
  cufflinks1: PROMO_IMAGES.accessoriesPromo,
  cufflinks2: PROMO_IMAGES.accessoriesPromo,
  cufflinks3: PROMO_IMAGES.accessoriesPromo,
  belt1: PROMO_IMAGES.accessoriesPromo,
  belt2: PROMO_IMAGES.accessoriesPromo,
  belt3: PROMO_IMAGES.accessoriesPromo,
  blazerW1: PROMO_IMAGES.womenPromo,
  blazerW2: PROMO_IMAGES.womenPromo,
  blazerW3: PROMO_IMAGES.womenPromo,
  pump1: PROMO_IMAGES.shoePromo,
  pump2: PROMO_IMAGES.shoePromo,
  kidsBlazer1: PROMO_IMAGES.kidsPromo,
  kidsBlazer2: PROMO_IMAGES.kidsPromo,
  wallet1: PROMO_IMAGES.accessoriesPromo,
  wallet2: PROMO_IMAGES.accessoriesPromo,
  wallet3: PROMO_IMAGES.accessoriesPromo,
} as const;

export type PhotoPath = (typeof PHOTOS)[keyof typeof PHOTOS];

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
