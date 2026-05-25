"use client";

import Image from "next/image";
import Link from "next/link";
import { usePathname } from "next/navigation";
import {
  CATEGORY_LABELS,
  getProductBySlug,
  getProductsByCollection,
  getRelatedProducts,
} from "@/lib/catalog";
import { convertPrice, formatPrice } from "@/lib/format";
import { useMarket } from "@/lib/market-context";
import type { Product, ProductCategory } from "@/lib/types";

function SuggestedProductCard({ product }: { product: Product }) {
  const { marketCode } = useMarket();
  const price = convertPrice(product.price, marketCode);
  const src = product.images[0];
  const remote = src.startsWith("http");

  return (
    <Link
      href={`/products/${product.slug}`}
      className="group block shrink-0 w-[42vw] max-w-[200px] sm:w-[180px] md:w-[220px]"
    >
      <div className="rounded-sm border border-cl-gray-mid bg-white p-2 shadow-sm transition group-hover:border-black">
        <div className="relative aspect-[3/4] overflow-hidden bg-cl-gray">
          <Image
            src={src}
            alt={product.name}
            fill
            unoptimized={remote}
            className="object-cover transition duration-300 group-hover:scale-[1.02]"
            sizes="220px"
          />
        </div>
      </div>
      <h3 className="mt-3 font-serif text-sm uppercase leading-snug md:text-base">
        {product.name}
      </h3>
      <p className="mt-1 text-[12px]">
        <span className="font-semibold text-black">
          {formatPrice(price, marketCode)}
        </span>
      </p>
    </Link>
  );
}

export function SuggestedProducts() {
  const pathname = usePathname();

  const productMatch = pathname.match(/^\/products\/([^/]+)$/);
  const collectionMatch = pathname.match(
    /^\/collections\/(women|men|kids)\/(suits|shoes|bags|perfumes|accessories)$/
  );

  let title = "Discover more";
  let products: Product[] = [];

  if (productMatch) {
    const product = getProductBySlug(productMatch[1]);
    if (product) {
      title = "You may also like";
      products = getRelatedProducts(product, 6);
    }
  } else if (collectionMatch) {
    const [, gender, category] = collectionMatch;
    const cat = category as ProductCategory;
    title = `More ${CATEGORY_LABELS[cat].toLowerCase()}`;
    products = getProductsByCollection(
      gender as "men" | "women" | "kids",
      cat
    ).slice(0, 6);
  } else if (pathname === "/collections/all/products") {
    title = "Featured for you";
    products = getProductsByCollection("men", "shoes").slice(0, 4);
    products = [
      ...products,
      ...getProductsByCollection("women", "bags").slice(0, 2),
    ];
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
    <section className="border-t border-cl-gray-mid bg-cl-white py-10 md:py-14">
      <div className="mx-auto max-w-[1600px] px-6">
        <h2 className="font-serif text-xl uppercase tracking-wide md:text-2xl">
          {title}
        </h2>
        <div className="-mx-6 mt-6 overflow-x-auto px-6 pb-2 scrollbar-hide">
          <div className="flex gap-4 md:gap-6">
            {products.map((p) => (
              <SuggestedProductCard key={p.id} product={p} />
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
