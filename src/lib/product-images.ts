import type { Product, ProductCategory } from "./types";
import { colorGalleries, gallery } from "./images";

/** Unsplash (free to use) — category-accurate product photography */
const U = (id: string, w = 900) =>
  `https://images.unsplash.com/${id}?auto=format&fit=crop&w=${w}&q=85`;

const SETS = {
  oxford: gallery(
    U("photo-1614252239476-9c5ad177b00d"),
    U("photo-1460353581641-37baddab0363"),
    U("photo-1549298916-b41d501d3772"),
    U("photo-1595950650236-5489d3b7f947"),
    U("photo-1638247025967-d1e38b4c1f94"),
    U("photo-1608256246200-53e635b5b65f")
  ),
  loafer: gallery(
    U("photo-1533867612568-9a06e1c247b1"),
    U("photo-1627225924765-0f060b44f4f4"),
    U("photo-1614252239476-9c5ad177b00d"),
    U("photo-1543163521-1bf539c55dd2"),
    U("photo-1605810230434-7631ed960020"),
    U("photo-1460353581641-37baddab0363")
  ),
  "chelsea-boot": gallery(
    U("photo-1608256246200-53e635b5b65f"),
    U("photo-1638247025967-d1e38b4c1f94"),
    U("photo-1549298916-b41d501d3772"),
    U("photo-1614252239476-9c5ad177b00d"),
    U("photo-1595950650236-5489d3b7f947"),
    U("photo-1460353581641-37baddab0363")
  ),
  sneaker: gallery(
    U("photo-1549298916-b41d501d3772"),
    U("photo-1606107557195-0a29c8381e44"),
    U("photo-1608231387042-66d1773070a9"),
    U("photo-1595950650236-5489d3b7f947"),
    U("photo-1605810230434-7631ed960020"),
    U("photo-1543163521-1bf539c55dd2")
  ),
  sandal: gallery(
    U("photo-1543163521-1bf539c55dd2"),
    U("photo-1596700501127-2a6c796a3b6e"),
    U("photo-1560769629-975ec94e6a86"),
    U("photo-1549298916-b41d501d3772"),
    U("photo-1460353581641-37baddab0363"),
    U("photo-1595950650236-5489d3b7f947")
  ),
  pump: gallery(
    U("photo-1543163521-1bf539c55dd2"),
    U("photo-1596700501127-2a6c796a3b6e"),
    U("photo-1560769629-975ec94e6a86"),
    U("photo-1549298916-b41d501d3772"),
    U("photo-1460353581641-37baddab0363"),
    U("photo-1595950650236-5489d3b7f947")
  ),
  boot: gallery(
    U("photo-1608256246200-53e635b5b65f"),
    U("photo-1638247025967-d1e38b4c1f94"),
    U("photo-1549298916-b41d501d3772"),
    U("photo-1605810230434-7631ed960020"),
    U("photo-1614252239476-9c5ad177b00d"),
    U("photo-1595950650236-5489d3b7f947")
  ),
  shoes: gallery(
    U("photo-1614252239476-9c5ad177b00d"),
    U("photo-1533867612568-9a06e1c247b1"),
    U("photo-1549298916-b41d501d3772"),
    U("photo-1595950650236-5489d3b7f947"),
    U("photo-1608256246200-53e635b5b65f"),
    U("photo-1543163521-1bf539c55dd2")
  ),
  "two-piece": gallery(
    U("photo-1594938298603-c8148c4dae35"),
    U("photo-1507003211169-0a1dd7228f2d"),
    U("photo-1617131984098-23e4d1405a44"),
    U("photo-1593030761757-71fae48a0a3f"),
    U("photo-1624222247344-550fb60583fd"),
    U("photo-1594938298603-c8148c4dae35", 800)
  ),
  "three-piece": gallery(
    U("photo-1617131984098-23e4d1405a44"),
    U("photo-1594938298603-c8148c4dae35"),
    U("photo-1507003211169-0a1dd7228f2d"),
    U("photo-1593030761757-71fae48a0a3f"),
    U("photo-1624222247344-550fb60583fd"),
    U("photo-1617131984098-23e4d1405a44", 800)
  ),
  tuxedo: gallery(
    U("photo-1593030761757-71fae48a0a3f"),
    U("photo-1617131984098-23e4d1405a44"),
    U("photo-1507003211169-0a1dd7228f2d"),
    U("photo-1594938298603-c8148c4dae35"),
    U("photo-1624222247344-550fb60583fd"),
    U("photo-1593030761757-71fae48a0a3f", 800)
  ),
  "morning-coat": gallery(
    U("photo-1617131984098-23e4d1405a44"),
    U("photo-1593030761757-71fae48a0a3f"),
    U("photo-1594938298603-c8148c4dae35"),
    U("photo-1507003211169-0a1dd7228f2d"),
    U("photo-1624222247344-550fb60583fd"),
    U("photo-1617131984098-23e4d1405a44", 800)
  ),
  blazer: gallery(
    U("photo-1594938298603-c8148c4dae35"),
    U("photo-1507003211169-0a1dd7228f2d"),
    U("photo-1617131984098-23e4d1405a44"),
    U("photo-1624222247344-550fb60583fd"),
    U("photo-1593030761757-71fae48a0a3f"),
    U("photo-1594938298603-c8148c4dae35", 800)
  ),
  suits: gallery(
    U("photo-1594938298603-c8148c4dae35"),
    U("photo-1617131984098-23e4d1405a44"),
    U("photo-1507003211169-0a1dd7228f2d"),
    U("photo-1593030761757-71fae48a0a3f"),
    U("photo-1624222247344-550fb60583fd"),
    U("photo-1594938298603-c8148c4dae35", 800)
  ),
  weekender: gallery(
    U("photo-1548036328-9e88e0a5d389"),
    U("photo-1590874103328-eac142c7e1fe"),
    U("photo-1584917865442-de89d76b69a1"),
    U("photo-1594223274512-ad4803739b7c"),
    U("photo-1548036328-9e88e0a5d389", 800),
    U("photo-1590874103328-eac142c7e1fe", 800)
  ),
  clutch: gallery(
    U("photo-1584917865442-de89d76b69a1"),
    U("photo-1590874103328-eac142c7e1fe"),
    U("photo-1548036328-9e88e0a5d389"),
    U("photo-1594223274512-ad4803739b7c"),
    U("photo-1584917865442-de89d76b69a1", 800),
    U("photo-1590874103328-eac142c7e1fe", 800)
  ),
  tote: gallery(
    U("photo-1590874103328-eac142c7e1fe"),
    U("photo-1548036328-9e88e0a5d389"),
    U("photo-1584917865442-de89d76b69a1"),
    U("photo-1594223274512-ad4803739b7c"),
    U("photo-1590874103328-eac142c7e1fe", 800),
    U("photo-1548036328-9e88e0a5d389", 800)
  ),
  briefcase: gallery(
    U("photo-1548036328-9e88e0a5d389"),
    U("photo-1594223274512-ad4803739b7c"),
    U("photo-1584917865442-de89d76b69a1"),
    U("photo-1590874103328-eac142c7e1fe"),
    U("photo-1548036328-9e88e0a5d389", 800),
    U("photo-1594223274512-ad4803739b7c", 800)
  ),
  crossbody: gallery(
    U("photo-1584917865442-de89d76b69a1"),
    U("photo-1590874103328-eac142c7e1fe"),
    U("photo-1548036328-9e88e0a5d389"),
    U("photo-1594223274512-ad4803739b7c"),
    U("photo-1584917865442-de89d76b69a1", 800),
    U("photo-1590874103328-eac142c7e1fe", 800)
  ),
  backpack: gallery(
    U("photo-1594223274512-ad4803739b7c"),
    U("photo-1548036328-9e88e0a5d389"),
    U("photo-1584917865442-de89d76b69a1"),
    U("photo-1590874103328-eac142c7e1fe"),
    U("photo-1594223274512-ad4803739b7c", 800),
    U("photo-1548036328-9e88e0a5d389", 800)
  ),
  bags: gallery(
    U("photo-1548036328-9e88e0a5d389"),
    U("photo-1590874103328-eac142c7e1fe"),
    U("photo-1584917865442-de89d76b69a1"),
    U("photo-1594223274512-ad4803739b7c"),
    U("photo-1548036328-9e88e0a5d389", 800),
    U("photo-1590874103328-eac142c7e1fe", 800)
  ),
  "eau-de-parfum": gallery(
    U("photo-1541643600914-78b084683601"),
    U("photo-1592945403244-b3fbafd7f539"),
    U("photo-1587017539504-54566cfbc10b"),
    U("photo-1594035910381-fea79402674e"),
    U("photo-1541643600914-78b084683601", 800),
    U("photo-1592945403244-b3fbafd7f539", 800)
  ),
  cologne: gallery(
    U("photo-1592945403244-b3fbafd7f539"),
    U("photo-1541643600914-78b084683601"),
    U("photo-1587017539504-54566cfbc10b"),
    U("photo-1594035910381-fea79402674e"),
    U("photo-1592945403244-b3fbafd7f539", 800),
    U("photo-1541643600914-78b084683601", 800)
  ),
  "eau-de-toilette": gallery(
    U("photo-1587017539504-54566cfbc10b"),
    U("photo-1541643600914-78b084683601"),
    U("photo-1592945403244-b3fbafd7f539"),
    U("photo-1594035910381-fea79402674e"),
    U("photo-1587017539504-54566cfbc10b", 800),
    U("photo-1541643600914-78b084683601", 800)
  ),
  extrait: gallery(
    U("photo-1594035910381-fea79402674e"),
    U("photo-1541643600914-78b084683601"),
    U("photo-1592945403244-b3fbafd7f539"),
    U("photo-1587017539504-54566cfbc10b"),
    U("photo-1594035910381-fea79402674e", 800),
    U("photo-1541643600914-78b084683601", 800)
  ),
  perfumes: gallery(
    U("photo-1541643600914-78b084683601"),
    U("photo-1592945403244-b3fbafd7f539"),
    U("photo-1587017539504-54566cfbc10b"),
    U("photo-1594035910381-fea79402674e"),
    U("photo-1541643600914-78b084683601", 800),
    U("photo-1592945403244-b3fbafd7f539", 800)
  ),
  cufflinks: gallery(
    U("photo-1617032213174-1e571b2e826b"),
    U("photo-1606760227091-3dd870ed254f"),
    U("photo-1617032213174-1e571b2e826b", 800),
    U("photo-1606760227091-3dd870ed254f", 800),
    U("photo-1617032213174-1e571b2e826b", 700),
    U("photo-1606760227091-3dd870ed254f", 700)
  ),
  belts: gallery(
    U("photo-1624222247344-550fb60583fd"),
    U("photo-1617032213174-1e571b2e826b"),
    U("photo-1606760227091-3dd870ed254f"),
    U("photo-1624222247344-550fb60583fd", 800),
    U("photo-1617032213174-1e571b2e826b", 800),
    U("photo-1606760227091-3dd870ed254f", 800)
  ),
  wallets: gallery(
    U("photo-1584917865442-de89d76b69a1"),
    U("photo-1548036328-9e88e0a5d389"),
    U("photo-1590874103328-eac142c7e1fe"),
    U("photo-1584917865442-de89d76b69a1", 800),
    U("photo-1548036328-9e88e0a5d389", 800),
    U("photo-1590874103328-eac142c7e1fe", 800)
  ),
  "pocket-square": gallery(
    U("photo-1617131984098-23e4d1405a44"),
    U("photo-1594938298603-c8148c4dae35"),
    U("photo-1507003211169-0a1dd7228f2d"),
    U("photo-1617131984098-23e4d1405a44", 800),
    U("photo-1594938298603-c8148c4dae35", 800),
    U("photo-1507003211169-0a1dd7228f2d", 800)
  ),
  scarf: gallery(
    U("photo-1594938298603-c8148c4dae35"),
    U("photo-1617131984098-23e4d1405a44"),
    U("photo-1507003211169-0a1dd7228f2d"),
    U("photo-1594938298603-c8148c4dae35", 800),
    U("photo-1617131984098-23e4d1405a44", 800),
    U("photo-1507003211169-0a1dd7228f2d", 800)
  ),
  tie: gallery(
    U("photo-1617131984098-23e4d1405a44"),
    U("photo-1594938298603-c8148c4dae35"),
    U("photo-1507003211169-0a1dd7228f2d"),
    U("photo-1617131984098-23e4d1405a44", 800),
    U("photo-1594938298603-c8148c4dae35", 800),
    U("photo-1507003211169-0a1dd7228f2d", 800)
  ),
  accessories: gallery(
    U("photo-1617032213174-1e571b2e826b"),
    U("photo-1606760227091-3dd870ed254f"),
    U("photo-1617131984098-23e4d1405a44"),
    U("photo-1594938298603-c8148c4dae35"),
    U("photo-1617032213174-1e571b2e826b", 800),
    U("photo-1606760227091-3dd870ed254f", 800)
  ),
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
    if (c.value === "black" || c.value === "burgundy" || c.value === "navy") {
      out[c.value] = gallery(...base);
    } else if (c.value === "cream" || c.value === "gold") {
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
