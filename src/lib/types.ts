export type Gender = "women" | "men" | "kids";

export type ProductCategory =
  | "suits"
  | "shoes"
  | "bags"
  | "perfumes"
  | "accessories";

export type VariantOption = {
  id: string;
  label: string;
  value: string;
  inStock: boolean;
};

export type ProductVariant = {
  id: string;
  sku: string;
  size?: string;
  color?: string;
  material?: string;
  volumeMl?: number;
  priceModifier: number;
  inStock: boolean;
};

export type Product = {
  id: string;
  slug: string;
  name: string;
  description: string;
  gender: Gender;
  category: ProductCategory;
  subcategory?: string;
  price: number;
  currency: string;
  images: string[];
  /** Per-color image sets; keys match color `value` */
  colorImages: Record<string, string[]>;
  colors: VariantOption[];
  sizes: VariantOption[];
  materials?: VariantOption[];
  variants: ProductVariant[];
  tags: string[];
  material?: string;
  care?: string;
  shippingNote?: string;
  isNew?: boolean;
  isBespokeEligible?: boolean;
};

export type MarketCode = "US" | "UK" | "EU" | "UAE" | "AU";

export type Market = {
  code: MarketCode;
  country: string;
  currency: string;
  currencySymbol: string;
  locale: string;
  language: string;
  vatInclusive: boolean;
  vatRate: number;
  shippingNote: string;
};

export type FulfillmentMethod = "ship" | "pickup";

export type CartItem = {
  productId: string;
  variantId: string;
  slug: string;
  name: string;
  image: string;
  size?: string;
  color?: string;
  quantity: number;
  unitPrice: number;
  fulfillment?: FulfillmentMethod;
};

export type BespokeConfig = {
  fabric: string;
  lapel: string;
  lining: string;
  measurementsNote: string;
};

export type AppointmentType =
  | "fitting"
  | "trunk-show"
  | "virtual-consultation";
