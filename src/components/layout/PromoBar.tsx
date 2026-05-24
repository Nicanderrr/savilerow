"use client";

import Link from "next/link";
import { useUi } from "@/lib/ui-context";

export function PromoBar({ onHero = false }: { onHero?: boolean }) {
  const { promoVisible, dismissPromo } = useUi();

  if (!promoVisible) return null;

  const wrapClass = onHero
    ? "bg-transparent text-white"
    : "border-b border-cl-gray-mid bg-cl-white text-black";
  const textColor = onHero ? "text-white" : "text-black";

  return (
    <div
      className={`relative flex h-header-promo items-center justify-center px-10 text-center transition-colors duration-300 ${wrapClass}`}
    >
      <p className={`text-[11px] ${textColor}`}>
        Discover the new{" "}
        <Link href="/collections/men/suits" className="underline underline-offset-2">
          Spring / Summer 2026 Collection
        </Link>
        .
      </p>
      <button
        type="button"
        onClick={dismissPromo}
        className={`absolute right-4 top-1/2 -translate-y-1/2 text-lg leading-none ${textColor}`}
        aria-label="Close notifications"
      >
        ×
      </button>
    </div>
  );
}
