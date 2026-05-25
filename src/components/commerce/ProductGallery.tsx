"use client";

import Image from "next/image";
import { useCallback, useEffect, useRef, useState } from "react";

function FramedImage({ src, alt }: { src: string; alt: string }) {
  return (
    <div className="relative aspect-[3/4] bg-cl-gray p-3 shadow-[0_8px_30px_rgba(0,0,0,0.06)] ring-1 ring-black/10">
      <div className="relative h-full w-full border border-cl-gray-mid/60 bg-white p-2 shadow-inner">
        <div className="relative h-full w-full overflow-hidden">
          <Image
            src={src}
            alt={alt}
            fill
            className="object-cover select-none"
            sizes="(max-width: 768px) 45vw, 28vw"
            draggable={false}
          />
        </div>
      </div>
    </div>
  );
}

export function ProductGallery({
  images,
  alt,
}: {
  images: string[];
  alt: string;
}) {
  const [index, setIndex] = useState(0);
  const touchStart = useRef<number | null>(null);
  const touchDelta = useRef(0);

  const pairCount = Math.max(1, Math.ceil(images.length / 2));
  const currentPair = Math.floor(index / 2);

  const goPair = useCallback(
    (dir: -1 | 1) => {
      setIndex((i) => {
        const pair = Math.floor(i / 2);
        const nextPair = (pair + dir + pairCount) % pairCount;
        return nextPair * 2;
      });
    },
    [pairCount]
  );

  useEffect(() => {
    setIndex(0);
  }, [images]);

  const onTouchStart = (e: React.TouchEvent) => {
    touchStart.current = e.touches[0].clientX;
    touchDelta.current = 0;
  };

  const onTouchMove = (e: React.TouchEvent) => {
    if (touchStart.current == null) return;
    touchDelta.current = e.touches[0].clientX - touchStart.current;
  };

  const onTouchEnd = () => {
    if (Math.abs(touchDelta.current) > 48) {
      goPair(touchDelta.current < 0 ? 1 : -1);
    }
    touchStart.current = null;
    touchDelta.current = 0;
  };

  if (images.length === 0) return null;

  const leftIndex = (currentPair * 2) % images.length;
  const rightIndex =
    images.length > 1 ? (leftIndex + 1) % images.length : leftIndex;

  return (
    <div className="relative px-4 py-6 md:px-8 md:py-10">
      <div
        className="touch-pan-y"
        onTouchStart={onTouchStart}
        onTouchMove={onTouchMove}
        onTouchEnd={onTouchEnd}
      >
        <div className="grid grid-cols-2 gap-3 md:gap-4">
          <FramedImage src={images[leftIndex]} alt={`${alt} — view ${leftIndex + 1}`} />
          {images.length > 1 ? (
            <FramedImage src={images[rightIndex]} alt={`${alt} — view ${rightIndex + 1}`} />
          ) : (
            <div className="aspect-[3/4] bg-cl-gray/50 ring-1 ring-black/5" aria-hidden />
          )}
        </div>

        {images.length > 2 && (
          <>
            <button
              type="button"
              onClick={() => goPair(-1)}
              className="absolute left-0 top-1/2 z-10 hidden h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-black/15 bg-white/95 text-xl text-black shadow-sm hover:bg-white md:flex"
              aria-label="Previous images"
            >
              ‹
            </button>
            <button
              type="button"
              onClick={() => goPair(1)}
              className="absolute right-0 top-1/2 z-10 hidden h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-black/15 bg-white/95 text-xl text-black shadow-sm hover:bg-white md:flex"
              aria-label="Next images"
            >
              ›
            </button>
          </>
        )}
      </div>

      {images.length > 1 && (
        <p className="mt-4 text-center text-[11px] text-cl-muted md:hidden">
          Swipe for more · Pair {currentPair + 1} of {pairCount}
        </p>
      )}

      {images.length > 2 && (
        <div className="mt-6 flex justify-center gap-1.5">
          {Array.from({ length: pairCount }).map((_, i) => (
            <button
              key={i}
              type="button"
              onClick={() => setIndex(i * 2)}
              className={`h-1.5 rounded-full transition-all ${
                i === currentPair ? "w-6 bg-black" : "w-1.5 bg-black/25"
              }`}
              aria-label={`Show image pair ${i + 1}`}
            />
          ))}
        </div>
      )}
    </div>
  );
}
