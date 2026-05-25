"use client";

import Link from "next/link";
import { getAllProducts } from "@/lib/catalog";

const featured = getAllProducts().filter((p) => p.isNew).slice(0, 12);

export function ProductNameCarousel() {
  return (
    <section className="border-y border-cl-gray-mid bg-cl-white py-12">
      <div className="mx-auto max-w-[1600px] px-6">
        <h2 className="font-serif text-2xl uppercase md:text-3xl">New arrivals</h2>
        <div className="-mx-6 mt-8 overflow-x-auto px-6 pb-4 scrollbar-hide md:mx-0 md:px-0">
          <div className="flex w-max min-w-full gap-8">
            {featured.map((p) => (
              <Link
                key={p.id}
                href={`/products/${p.slug}`}
                className="shrink-0 border-b border-transparent pb-2 font-serif text-xl uppercase tracking-wide transition hover:border-black md:text-2xl"
              >
                {p.name}
              </Link>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
