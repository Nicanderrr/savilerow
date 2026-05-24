"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { useState } from "react";
import {
  CATEGORY_LABELS,
  getProductBySlug,
  getRelatedProducts,
  getProductsByCollection,
} from "@/lib/catalog";
import type { ProductCategory } from "@/lib/types";

const COLLECTION_LINKS: { label: string; href: string }[] = [
  { label: "Men's shoes", href: "/collections/men/shoes" },
  { label: "Women's shoes", href: "/collections/women/shoes" },
  { label: "Suits & tailoring", href: "/collections/men/suits" },
  { label: "Bags", href: "/collections/women/bags" },
  { label: "Perfumes", href: "/collections/men/perfumes" },
  { label: "Accessories", href: "/collections/men/accessories" },
  { label: "New arrivals", href: "/collections/all/products" },
  { label: "Visit our boutique", href: "/boutique" },
];

export function SuggestionsMenu() {
  const pathname = usePathname();
  const [open, setOpen] = useState(false);

  const productMatch = pathname.match(/^\/products\/([^/]+)$/);
  const collectionMatch = pathname.match(
    /^\/collections\/(women|men|kids)\/(suits|shoes|bags|perfumes|accessories)$/
  );

  let title = "Discover more";
  let links: { label: string; href: string }[] = COLLECTION_LINKS;

  if (productMatch) {
    const product = getProductBySlug(productMatch[1]);
    if (product) {
      title = "You may also like";
      links = getRelatedProducts(product, 8).map((p) => ({
        label: p.name,
        href: `/products/${p.slug}`,
      }));
      if (links.length < 4) {
        links = [
          ...links,
          ...COLLECTION_LINKS.filter((l) => l.href.includes(product.category)).slice(
            0,
            4 - links.length
          ),
        ];
      }
    }
  } else if (collectionMatch) {
    const [, gender, category] = collectionMatch;
    const cat = category as ProductCategory;
    title = `More ${CATEGORY_LABELS[cat].toLowerCase()}`;
    links = getProductsByCollection(gender as "men" | "women" | "kids", cat)
      .slice(0, 8)
      .map((p) => ({ label: p.name, href: `/products/${p.slug}` }));
  }

  if (pathname === "/" || pathname.startsWith("/cart") || pathname.startsWith("/checkout")) {
    return null;
  }

  return (
    <section className="border-t border-cl-gray-mid bg-cl-gray">
      <div className="mx-auto max-w-[1600px] px-6">
        <button
          type="button"
          onClick={() => setOpen((v) => !v)}
          className="flex w-full items-center justify-between py-5 text-left"
          aria-expanded={open}
        >
          <span className="font-serif text-lg uppercase tracking-wide">{title}</span>
          <span className="text-xl leading-none text-cl-muted" aria-hidden>
            {open ? "−" : "+"}
          </span>
        </button>
        {open && (
          <nav
            aria-label={title}
            className="grid gap-2 border-t border-cl-gray-mid/80 pb-6 pt-4 sm:grid-cols-2 md:grid-cols-4"
          >
            {links.map((link) => (
              <Link
                key={link.href + link.label}
                href={link.href}
                className="py-2 text-[12px] uppercase tracking-[0.12em] text-black/80 transition hover:text-black hover:underline"
              >
                {link.label}
              </Link>
            ))}
          </nav>
        )}
      </div>
    </section>
  );
}
