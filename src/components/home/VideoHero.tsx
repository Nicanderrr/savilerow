"use client";

import Link from "next/link";
import { useEffect, useRef } from "react";
import { PHOTOS } from "@/lib/images";
import { useUi } from "@/lib/ui-context";

export function VideoHero() {
  const videoRef = useRef<HTMLVideoElement>(null);
  const { setHeroLight } = useUi();

  useEffect(() => {
    setHeroLight(true);
    return () => setHeroLight(false);
  }, [setHeroLight]);

  useEffect(() => {
    const v = videoRef.current;
    if (!v) return;
    v.muted = true;
    const play = () => {
      v.play().catch(() => {});
    };
    play();
    v.addEventListener("loadeddata", play);
    return () => v.removeEventListener("loadeddata", play);
  }, []);

  return (
    <section className="relative -mt-[var(--header-total)] pt-[var(--header-total)] h-[100svh] w-full overflow-hidden bg-black">
      <video
        ref={videoRef}
        className="hero-video absolute inset-0 h-full w-full object-cover"
        autoPlay
        loop
        muted
        playsInline
        preload="auto"
        poster={PHOTOS.heroPoster}
        disablePictureInPicture
        controls={false}
      >
        <source src="/video/hero.mp4" type="video/mp4" />
      </video>
      <div className="absolute inset-0 bg-black/15" aria-hidden />
      <div
        id="hero-scroll-sentinel"
        className="pointer-events-none absolute bottom-0 left-0 right-0 h-px"
        aria-hidden
      />

      <div className="absolute bottom-16 left-0 right-0 px-6 pb-8 text-center text-white md:bottom-24 md:pb-12">
        <p className="text-label">New collection</p>
        <h1 className="mt-3 font-serif text-4xl uppercase tracking-wide md:text-6xl lg:text-7xl">
          Spring / Summer 2026
        </h1>
        <Link href="/collections/men/suits" className="btn-ghost-white mt-8 inline-block">
          Discover
        </Link>
      </div>
    </section>
  );
}
