"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { useEffect, useState } from "react";
import { MobileMenu } from "./MobileMenu";
import { PromoBar } from "./PromoBar";
import {
  IconAccount,
  IconBag,
  IconHeart,
  IconMenu,
  IconSearch,
} from "@/components/icons/LouboutinIcons";
import { useCart } from "@/lib/cart-context";
import { useWishlist } from "@/lib/wishlist-context";
import { useUi } from "@/lib/ui-context";

export function Header() {
  const pathname = usePathname();
  const { itemCount } = useCart();
  const { count: wishCount } = useWishlist();
  const {
    heroLight,
    setMenuOpen,
    setSearchOpen,
    setBagOpen,
    promoVisible,
  } = useUi();
  const [pastHero, setPastHero] = useState(pathname !== "/");

  const onHomeHero = pathname === "/" && heroLight && !pastHero;

  useEffect(() => {
    if (pathname !== "/") {
      setPastHero(true);
      return;
    }

    setPastHero(false);

    const sentinel = document.getElementById("hero-scroll-sentinel");
    if (!sentinel) {
      const onScroll = () => setPastHero(window.scrollY > 48);
      onScroll();
      window.addEventListener("scroll", onScroll, { passive: true });
      return () => window.removeEventListener("scroll", onScroll);
    }

    const observer = new IntersectionObserver(
      ([entry]) => setPastHero(!entry.isIntersecting),
      { threshold: 0, rootMargin: "-1px 0px 0px 0px" }
    );
    observer.observe(sentinel);
    return () => observer.disconnect();
  }, [pathname, heroLight]);

  const textClass = onHomeHero ? "text-white" : "text-black";
  const headerBg = onHomeHero
    ? "bg-transparent"
    : "border-b border-cl-gray-mid bg-white";

  return (
    <header className="sticky top-0 z-40">
      {promoVisible && <PromoBar onHero={onHomeHero} />}
      <div className={`transition-colors duration-300 ${headerBg}`}>
        <div
          className={`mx-auto flex h-header-main max-w-[1600px] items-center justify-between px-4 md:px-8 ${textClass}`}
        >
          <div className="flex min-w-[80px] items-center md:min-w-[200px]">
            <button
              type="button"
              onClick={() => setMenuOpen(true)}
              className="flex items-center gap-3"
              aria-label="Menu"
            >
              <IconMenu />
              <span className="hidden text-label md:inline">Menu</span>
            </button>
          </div>

          <Link
            href="/"
            className={`font-serif text-xl tracking-wide md:text-2xl ${onHomeHero ? "text-white" : "text-black"}`}
            aria-label="Savile Row — Home"
          >
            Savile Row
          </Link>

          <div className="flex min-w-[120px] items-center justify-end gap-3 md:min-w-[200px] md:gap-5">
            <Link
              href="/market"
              className="shrink-0"
              aria-label="My account"
            >
              <IconAccount />
            </Link>
            <button
              type="button"
              onClick={() => setSearchOpen(true)}
              className="shrink-0"
              aria-label="Search"
            >
              <IconSearch />
            </button>
            <Link
              href="/collections/men/suits"
              className="relative shrink-0"
              aria-label={`My wishlist, ${wishCount} items`}
            >
              <IconHeart />
              {wishCount > 0 && (
                <span className="absolute -right-2 -top-2 flex h-4 min-w-4 items-center justify-center rounded-full bg-cl-red px-1 text-[9px] text-white">
                  {wishCount}
                </span>
              )}
            </Link>
            <button
              type="button"
              onClick={() => setBagOpen(true)}
              className="relative shrink-0"
              aria-label={`Shopping bag, ${itemCount} items`}
            >
              <IconBag />
              {itemCount > 0 && (
                <span className="absolute -right-2 -top-2 flex h-4 min-w-4 items-center justify-center rounded-full bg-cl-red px-1 text-[9px] text-white">
                  {itemCount}
                </span>
              )}
            </button>
          </div>
        </div>
      </div>
      <MobileMenu />
    </header>
  );
}
