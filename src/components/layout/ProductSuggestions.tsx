"use client";

import Image from "next/image";
import Link from "next/link";
import { usePathname } from "next/navigation";
import {
  CATEGORY_LABELS,
  getProductBySlug,
  getRelatedProducts,
  getProductsByCollection,
} from "@/lib/catalog";
import { convertPrice, formatPrice } from "@/lib/format";
import { useMarket } from "@/lib/market-context";
import type { Product, ProductCategory } from "@/lib/types";

function SuggestionCard({ product }: { product: Product }) {
  const { marketCode } = useMarket();
  const price = convertPrice(product.price, marketCode);

  return (
    <Link
      href={`/products/${product.slug}`}
      className="group shrink-0 w-[140px] sm:w-[160px]"
    >
      <div className="relative aspect-[3/4] overflow-hidden bg-cl-gray ring-1 ring-black/10 transition group-hover:ring-black/25">
        <Image
          src={product.images[0]}
          alt={product.name}
          fill
          className="object-cover transition duration-500 group-hover:scale-[1.03]"
          sizes="160px"
        />
      </div>
      <p className="mt-3 font-serif text-[13px] uppercase leading-snug">{product.name}</p>
      <p className="mt-1 text-[12px] font-semibold text-black">
        {formatPrice(price, marketCode)}
      </p>
    </Link>
  );
}

export function ProductSuggestions() {
  const pathname = usePathname();

  const productMatch = pathname.match(/^\/products\/([^/]+)$/);
  const collectionMatch = pathname.match(
    /^\/collections\/(women|men|kids)\/(suits|shoes|bags|perfumes|accessories)$/
  );

  let title = "You may also like";
  let products: Product[] = [];

  if (productMatch) {
    const product = getProductBySlug(productMatch[1]);
    if (product) {
      products = getRelatedProducts(product, 10);
    }
  } else if (collectionMatch) {
    const [, gender, category] = collectionMatch;
    title = `More ${CATEGORY_LABELS[category as ProductCategory].toLowerCase()}`;
    products = getProductsByCollection(
      gender as "men" | "women" | "kids",
      category as ProductCategory
    ).slice(0, 10);
  } else if (pathname.startsWith("/collections")) {
    products = getProductsByCollection(undefined, undefined)
      .filter((p) => p.isNew)
      .slice(0, 8);
  }

  if (
    products.length === 0 ||
    pathname === "/" ||
    pathname.startsWith("/cart") ||
    pathname.startsWith("/checkout")
  ) {
    return null;
  }

  return (
    <section className="border-t border-cl-gray-mid bg-cl-white py-12">
      <div className="mx-auto max-w-[1600px] px-6">
        <h2 className="font-serif text-xl uppercase tracking-wide md:text-2xl">{title}</h2>
        <div className="-mx-6 mt-8 overflow-x-auto px-6 pb-2 scrollbar-hide md:mx-0 md:px-0">
          <div className="flex gap-6 md:gap-8">
            {products.map((p) => (
              <SuggestionCard key={p.id} product={p} />
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
