"use client";

import Image from "next/image";
import Link from "next/link";
import { useState } from "react";
import { IconCompare, IconHeart } from "@/components/icons/LouboutinIcons";
import { convertPrice, formatPrice } from "@/lib/format";
import { isRemoteImage } from "@/lib/product-images";
import { useMarket } from "@/lib/market-context";
import { useWishlist } from "@/lib/wishlist-context";
import type { Product } from "@/lib/types";

function shortDescription(text: string, max = 100) {
  if (text.length <= max) return text;
  return `${text.slice(0, max).trim()}…`;
}

function ProductImage({
  src,
  alt,
  className,
  sizes,
  fill,
}: {
  src: string;
  alt: string;
  className?: string;
  sizes: string;
  fill?: boolean;
}) {
  if (isRemoteImage(src)) {
    return (
      <Image
        src={src}
        alt={alt}
        fill={fill}
        className={className}
        sizes={sizes}
        unoptimized
      />
    );
  }
  return (
    <Image src={src} alt={alt} fill={fill} className={className} sizes={sizes} />
  );
}

export function ProductCard({
  product,
  layout = "grid",
  showDescription = true,
  framed = false,
}: {
  product: Product;
  layout?: "grid" | "list";
  showDescription?: boolean;
  framed?: boolean;
}) {
  const { marketCode } = useMarket();
  const { has, toggle } = useWishlist();
  const [imgIndex, setImgIndex] = useState(0);
  const images = product.images;
  const price = convertPrice(product.price, marketCode);
  const wished = has(product.id);

  const imageFrame = framed ? (
    <div className="rounded-sm border border-cl-gray-mid bg-cl-gray/40 p-2 shadow-sm">
      <div className="relative aspect-[3/4] overflow-hidden bg-cl-gray">
        <ProductImage
          src={images[imgIndex] ?? images[0]}
          alt={product.name}
          fill
          className="object-cover transition duration-500 group-hover:scale-[1.02] motion-reduce:transition-none"
          sizes="(max-width: 768px) 50vw, 25vw"
        />
      </div>
    </div>
  ) : (
    <div className="relative aspect-[3/4] overflow-hidden bg-cl-gray">
      <ProductImage
        src={images[imgIndex] ?? images[0]}
        alt={product.name}
        fill
        className="object-cover transition duration-500 group-hover:scale-[1.02] motion-reduce:transition-none"
        sizes="(max-width: 768px) 50vw, 25vw"
      />
    </div>
  );

  if (layout === "list") {
    return (
      <article className="flex flex-col gap-4 sm:flex-row sm:gap-6 sm:border-b sm:border-cl-gray-mid sm:pb-8">
        <Link
          href={`/products/${product.slug}`}
          className={`relative shrink-0 ${framed ? "w-full sm:w-36" : "h-48 w-full sm:h-40 sm:w-32"}`}
        >
          {framed ? (
            <div className="rounded-sm border border-cl-gray-mid bg-cl-gray/40 p-2 shadow-sm">
              <div className="relative aspect-[3/4] w-full overflow-hidden bg-cl-gray sm:aspect-square sm:h-36">
                <ProductImage
                  src={images[0]}
                  alt={product.name}
                  fill
                  className="object-cover"
                  sizes="144px"
                />
              </div>
            </div>
          ) : (
            <div className="relative h-48 w-full bg-cl-gray sm:h-40 sm:w-32">
              <ProductImage
                src={images[0]}
                alt={product.name}
                fill
                className="object-cover"
                sizes="128px"
              />
            </div>
          )}
        </Link>
        <div className="flex flex-1 flex-col justify-center">
          <div className="flex items-start justify-between gap-4">
            <div>
              {product.isNew && (
                <span className="text-[10px] uppercase tracking-widest text-cl-muted">New</span>
              )}
              <h3 className="font-serif text-lg sm:text-xl">{product.name}</h3>
              {showDescription && (
                <p className="mt-2 text-[12px] leading-relaxed text-cl-muted">
                  {shortDescription(product.description, 140)}
                </p>
              )}
            </div>
            <div className="hidden gap-2 sm:flex">
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

      <Link href={`/products/${product.slug}`} className="relative block">
        {imageFrame}
        {images.length > 1 && !framed && (
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
          <span className="absolute left-3 top-3 z-10 bg-black px-2 py-0.5 text-[9px] uppercase tracking-widest text-white">
            New
          </span>
        )}
        <h3 className="mt-4 text-center font-serif text-base md:text-lg">{product.name}</h3>
        {showDescription && (
          <p className="mx-auto mt-2 max-w-[220px] px-1 text-center text-[11px] leading-relaxed text-cl-muted">
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
