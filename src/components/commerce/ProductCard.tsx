"use client";

import Image from "next/image";
import Link from "next/link";
import { useState } from "react";
import { IconCompare, IconHeart } from "@/components/icons/LouboutinIcons";
import { convertPrice, formatPrice } from "@/lib/format";
import { useMarket } from "@/lib/market-context";
import { useWishlist } from "@/lib/wishlist-context";
import type { Product } from "@/lib/types";

function shortDescription(text: string, max = 100) {
  if (text.length <= max) return text;
  return `${text.slice(0, max).trim()}…`;
}

export function ProductCard({
  product,
  layout = "grid",
  showDescription = true,
}: {
  product: Product;
  layout?: "grid" | "list";
  showDescription?: boolean;
}) {
  const { marketCode } = useMarket();
  const { has, toggle } = useWishlist();
  const [imgIndex, setImgIndex] = useState(0);
  const images = product.images;
  const price = convertPrice(product.price, marketCode);
  const wished = has(product.id);

  if (layout === "list") {
    return (
      <article className="flex gap-6 border-b border-cl-gray-mid pb-8">
        <Link href={`/products/${product.slug}`} className="relative h-40 w-32 shrink-0 bg-cl-gray">
          <Image src={images[0]} alt={product.name} fill className="object-cover" sizes="128px" />
        </Link>
        <div className="flex flex-1 flex-col justify-center">
          <div className="flex items-start justify-between gap-4">
            <div>
              {product.isNew && (
                <span className="text-[10px] uppercase tracking-widest text-cl-muted">New</span>
              )}
              <h3 className="font-serif text-xl">{product.name}</h3>
              {showDescription && (
                <p className="mt-2 max-w-md text-[12px] leading-relaxed text-cl-muted">
                  {shortDescription(product.description, 140)}
                </p>
              )}
            </div>
            <div className="flex gap-2">
              <button type="button" onClick={() => toggle(product.id)} aria-label="Add to wishlist">
                <IconHeart filled={wished} />
              </button>
              <button type="button" aria-label="Compare">
                <IconCompare />
              </button>
            </div>
          </div>
          <p className="mt-3 text-[13px]">
            <span className="text-cl-muted">As low as </span>
            <span className="font-semibold text-black">{formatPrice(price, marketCode)}</span>
          </p>
        </div>
      </article>
    );
  }

  return (
    <article className="group relative">
      <div className="absolute right-2 top-2 z-10 flex flex-col gap-2 opacity-0 transition group-hover:opacity-100">
        <button
          type="button"
          onClick={() => toggle(product.id)}
          className="flex h-8 w-8 items-center justify-center bg-white/90"
          aria-label="Add to wishlist"
        >
          <IconHeart filled={wished} className="h-4 w-4" />
        </button>
        <button
          type="button"
          className="flex h-8 w-8 items-center justify-center bg-white/90"
          aria-label="Compare"
        >
          <IconCompare />
        </button>
      </div>

      <Link href={`/products/${product.slug}`} className="block">
        <div className="relative aspect-[3/4] overflow-hidden bg-cl-gray">
          <Image
            src={images[imgIndex] ?? images[0]}
            alt={product.name}
            fill
            className="object-cover transition duration-500 group-hover:scale-[1.02] motion-reduce:transition-none"
            sizes="(max-width: 768px) 50vw, 25vw"
          />
          {images.length > 1 && (
            <div className="absolute bottom-3 left-0 right-0 flex justify-center gap-1 opacity-0 group-hover:opacity-100">
              {images.map((_, i) => (
                <button
                  key={i}
                  type="button"
                  onClick={(e) => {
                    e.preventDefault();
                    setImgIndex(i);
                  }}
                  className={`h-1 w-1 rounded-full ${i === imgIndex ? "bg-black" : "bg-black/30"}`}
                  aria-label={`Slide ${i + 1} of ${images.length}`}
                />
              ))}
            </div>
          )}
          {product.isNew && (
            <span className="absolute left-3 top-3 bg-black px-2 py-0.5 text-[9px] uppercase tracking-widest text-white">
              New
            </span>
          )}
        </div>
        <h3 className="mt-4 text-center font-serif text-lg">{product.name}</h3>
        {showDescription && (
          <p className="mx-auto mt-2 max-w-[220px] text-center text-[11px] leading-relaxed text-cl-muted md:max-w-none">
            {shortDescription(product.description, 90)}
          </p>
        )}
        <p className="mt-2 text-center text-[13px]">
          <span className="text-cl-muted">As low as </span>
          <span className="font-semibold text-black">{formatPrice(price, marketCode)}</span>
        </p>
      </Link>
    </article>
  );
}
