"use client";

import Image from "next/image";
import { useCallback, useEffect, useRef, useState } from "react";

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

  const go = useCallback(
    (dir: -1 | 1) => {
      setIndex((i) => {
        const next = i + dir;
        if (next < 0) return images.length - 1;
        if (next >= images.length) return 0;
        return next;
      });
    },
    [images.length]
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
      go(touchDelta.current < 0 ? 1 : -1);
    }
    touchStart.current = null;
    touchDelta.current = 0;
  };

  const onMouseDown = (e: React.MouseEvent) => {
    touchStart.current = e.clientX;
    touchDelta.current = 0;
  };

  const onMouseMove = (e: React.MouseEvent) => {
    if (touchStart.current == null || e.buttons !== 1) return;
    touchDelta.current = e.clientX - touchStart.current;
  };

  const onMouseUp = () => {
    if (touchStart.current == null) return;
    if (Math.abs(touchDelta.current) > 48) {
      go(touchDelta.current < 0 ? 1 : -1);
    }
    touchStart.current = null;
    touchDelta.current = 0;
  };

  if (images.length === 0) return null;

  return (
    <div className="relative">
      <div
        className="relative aspect-[3/4] w-full touch-pan-y bg-cl-gray md:aspect-square md:min-h-[70vh]"
        onTouchStart={onTouchStart}
        onTouchMove={onTouchMove}
        onTouchEnd={onTouchEnd}
        onMouseDown={onMouseDown}
        onMouseMove={onMouseMove}
        onMouseUp={onMouseUp}
        onMouseLeave={onMouseUp}
      >
        <Image
          key={images[index]}
          src={images[index]}
          alt={alt}
          fill
          className="object-cover select-none"
          sizes="(max-width: 1024px) 100vw, 55vw"
          priority={index === 0}
          draggable={false}
        />
        {images.length > 1 && (
          <>
            <button
              type="button"
              onClick={() => go(-1)}
              className="absolute left-3 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center border border-black/20 bg-white/90 text-black hover:bg-white"
              aria-label="Previous image"
            >
              ‹
            </button>
            <button
              type="button"
              onClick={() => go(1)}
              className="absolute right-3 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center border border-black/20 bg-white/90 text-black hover:bg-white"
              aria-label="Next image"
            >
              ›
            </button>
          </>
        )}
      </div>
      {images.length > 1 && (
        <div className="mt-4 flex gap-2 overflow-x-auto px-1">
          {images.map((src, i) => (
            <button
              key={`${src}-${i}`}
              type="button"
              onClick={() => setIndex(i)}
              className={`relative h-20 w-16 shrink-0 border-2 ${
                i === index ? "border-black" : "border-transparent"
              }`}
              aria-label={`View image ${i + 1}`}
              aria-current={i === index}
            >
              <Image src={src} alt="" fill className="object-cover" sizes="64px" />
            </button>
          ))}
        </div>
      )}
      {images.length > 1 && (
        <p className="mt-2 text-center text-[11px] text-cl-muted md:hidden">
          {index + 1} / {images.length}
        </p>
      )}
    </div>
  );
}
