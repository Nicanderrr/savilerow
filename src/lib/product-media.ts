import type { Product, ProductCategory } from "./types";

/** Unsplash — free to use (https://unsplash.com/license) */
function u(photoId: string, w = 1200): string {
  return `https://images.unsplash.com/${photoId}?w=${w}&q=85&auto=format&fit=crop`;
}

function gallery(...ids: string[]): string[] {
  return ids.map((id) => u(id));
}

const G = {
  // Shoes
  oxford: gallery(
    "photo-1549298101-4078d3e94726",
    "photo-1543163521-1bf539c55dd2",
    "photo-1614252238876-b12c01c463b3",
    "photo-1533869882585-06a64e519e70"
  ),
  loafer: gallery(
    "photo-1614252238876-b12c01c463b3",
    "photo-1549298101-4078d3e94726",
    "photo-1606107557195-0a9c0c4e8b1e",
    "photo-1543163521-1bf539c55dd2"
  ),
  "chelsea-boot": gallery(
    "photo-1608255972709-15c7b6bdc093",
    "photo-1605812870420-406dead3a1e1",
    "photo-1549298101-4078d3e94726",
    "photo-1606107557195-0a9c0c4e8b1e"
  ),
  sneaker: gallery(
    "photo-1525968543494-aa9eadeca662",
    "photo-1606107557195-0a9c0c4e8b1e",
    "photo-1542291026-7eec264c27ff",
    "photo-1605348532761-099c80dcb4da"
  ),
  sandal: gallery(
    "photo-1460353572617-92503a6ef020",
    "photo-1543163521-1bf539c55dd2",
    "photo-1515348543167-1f8213c1f52f",
    "photo-1543163521-1bf539c55dd2"
  ),
  pump: gallery(
    "photo-1460353572617-92503a6ef020",
    "photo-1515348543167-1f8213c1f52f",
    "photo-1543163521-1bf539c55dd2",
    "photo-1463104859042-0061ad7f5f8f"
  ),
  boot: gallery(
    "photo-1605812870420-406dead3a1e1",
    "photo-1608255972709-15c7b6bdc093",
    "photo-1543163521-1bf539c55dd2",
    "photo-1606107557195-0a9c0c4e8b1e"
  ),
  // Suits & tailoring
  "two-piece": gallery(
    "photo-1594938383989-324dcb6d845d",
    "photo-1507680434567-5739acb3ff90",
    "photo-1617127367283-6319887e1f4b",
    "photo-1556905055-8f356a2880f2"
  ),
  "three-piece": gallery(
    "photo-1617127367283-6319887e1f4b",
    "photo-1594938383989-324dcb6d845d",
    "photo-1507680434567-5739acb3ff90",
    "photo-1556905055-8f356a2880f2"
  ),
  tuxedo: gallery(
    "photo-1507680434567-5739acb3ff90",
    "photo-1594938383989-324dcb6d845d",
    "photo-1617127367283-6319887e1f4b",
    "photo-1556905055-8f356a2880f2"
  ),
  "morning-coat": gallery(
    "photo-1617127367283-6319887e1f4b",
    "photo-1507680434567-5739acb3ff90",
    "photo-1594938383989-324dcb6d845d",
    "photo-1556905055-8f356a2880f2"
  ),
  blazer: gallery(
    "photo-1594633312681-425c7b4c840b",
    "photo-1594938383989-324dcb6d845d",
    "photo-1617127367283-6319887e1f4b",
    "photo-1539109136881-3be0616acf4b"
  ),
  // Bags
  weekender: gallery(
    "photo-1590871196725-e441b20f21dd",
    "photo-1584917865442-89aaa48b9e27",
    "photo-1548036328-c9fa89d128fa",
    "photo-1594223274512-ad480373949b"
  ),
  clutch: gallery(
    "photo-1584917865442-89aaa48b9e27",
    "photo-1590871196725-e441b20f21dd",
    "photo-1548036328-c9fa89d128fa",
    "photo-1564422170194-896b89110c8a"
  ),
  tote: gallery(
    "photo-1548036328-c9fa89d128fa",
    "photo-1584917865442-89aaa48b9e27",
    "photo-1590871196725-e441b20f21dd",
    "photo-1594223274512-ad480373949b"
  ),
  briefcase: gallery(
    "photo-1594223274512-ad480373949b",
    "photo-1590871196725-e441b20f21dd",
    "photo-1548036328-c9fa89d128fa",
    "photo-1584917865442-89aaa48b9e27"
  ),
  crossbody: gallery(
    "photo-1564422170194-896b89110c8a",
    "photo-1584917865442-89aaa48b9e27",
    "photo-1548036328-c9fa89d128fa",
    "photo-1590871196725-e441b20f21dd"
  ),
  backpack: gallery(
    "photo-1553062407-98eeb64c6a62",
    "photo-1548036328-c9fa89d128fa",
    "photo-1590871196725-e441b20f21dd",
    "photo-1553062407-98eeb64c6a62"
  ),
  // Perfumes
  "eau-de-parfum": gallery(
    "photo-1541643600911-8f9927d532a5",
    "photo-1592945403249-b5cb72df6777",
    "photo-1587017539504-545cf4be1c4e",
    "photo-1594035910387-fea47794261f"
  ),
  cologne: gallery(
    "photo-1592945403249-b5cb72df6777",
    "photo-1541643600911-8f9927d532a5",
    "photo-1587017539504-545cf4be1c4e",
    "photo-1594035910387-fea47794261f"
  ),
  "eau-de-toilette": gallery(
    "photo-1587017539504-545cf4be1c4e",
    "photo-1541643600911-8f9927d532a5",
    "photo-1592945403249-b5cb72df6777",
    "photo-1594035910387-fea47794261f"
  ),
  extrait: gallery(
    "photo-1594035910387-fea47794261f",
    "photo-1541643600911-8f9927d532a5",
    "photo-1587017539504-545cf4be1c4e",
    "photo-1592945403249-b5cb72df6777"
  ),
  // Accessories
  cufflinks: gallery(
    "photo-1523179079325-7f32d9cd0e0e",
    "photo-1611591434801-40d1a9d2f0b8",
    "photo-1606760227091-3dd870ed254f",
    "photo-1523179079325-7f32d9cd0e0e"
  ),
  belts: gallery(
    "photo-1624222247344-550fb6059580",
    "photo-1611591434801-40d1a9d2f0b8",
    "photo-1523179079325-7f32d9cd0e0e",
    "photo-1606760227091-3dd870ed254f"
  ),
  wallets: gallery(
    "photo-1627120293439-6344d95e0a4a",
    "photo-1624222247344-550fb6059580",
    "photo-1611591434801-40d1a9d2f0b8",
    "photo-1523179079325-7f32d9cd0e0e"
  ),
  "pocket-square": gallery(
    "photo-1618354691373-d851c5c3a989",
    "photo-1601925260368-ae2f83cf8b87",
    "photo-1611591434801-40d1a9d2f0b8",
    "photo-1523179079325-7f32d9cd0e0e"
  ),
  scarf: gallery(
    "photo-1601925260368-ae2f83cf8b87",
    "photo-1618354691373-d851c5c3a989",
    "photo-1611591434801-40d1a9d2f0b8",
    "photo-1606760227091-3dd870ed254f"
  ),
  tie: gallery(
    "photo-1618354691373-d851c5c3a989",
    "photo-1611591434801-40d1a9d2f0b8",
    "photo-1523179079325-7f32d9cd0e0e",
    "photo-1606760227091-3dd870ed254f"
  ),
};

const CATEGORY_FALLBACK: Record<ProductCategory, string[]> = {
  suits: G["two-piece"],
  shoes: G.oxford,
  bags: G.weekender,
  perfumes: G["eau-de-parfum"],
  accessories: G.cufflinks,
};

export const PROMO_IMAGES = {
  heroPoster: u("photo-1507003211169-0a1dd7228f2d", 1920),
  womenPromo: u("photo-1594633312681-425c7b4c840b", 1600),
  menPromo: u("photo-1594938383989-324dcb6d845d", 1600),
  kidsPromo: u("photo-1519238263537-3bbece3b72b8", 1600),
  accessoriesPromo: u("photo-1523179079325-7f32d9cd0e0e", 1600),
  bagPromo: u("photo-1584917865442-89aaa48b9e27", 1600),
  shoePromo: u("photo-1549298101-4078d3e94726", 1600),
  fitting: u("photo-1556905055-8f356a2880f2", 1200),
  store: u("photo-1441986300917-64674bd600d8", 1600),
  tailoring: u("photo-1556905055-8f356a2880f2", 1200),
  contact: u("photo-1441986300917-64674bd600d8", 1200),
};

export function imagesForProduct(
  category: ProductCategory,
  subcategory?: string
): string[] {
  if (subcategory && subcategory in G) {
    return G[subcategory as keyof typeof G];
  }
  return CATEGORY_FALLBACK[category];
}

export function applyProductMedia(product: Product): Product {
  const imgs = imagesForProduct(product.category, product.subcategory);
  const colorImages: Record<string, string[]> = {};
  for (const c of product.colors) {
    colorImages[c.value] = imgs;
  }
  return {
    ...product,
    images: imgs,
    colorImages,
  };
}
