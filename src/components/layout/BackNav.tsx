"use client";

import { useRouter } from "next/navigation";
import Link from "next/link";

export function BackNav({
  href,
  label = "Back",
}: {
  href?: string;
  label?: string;
}) {
  const router = useRouter();

  if (href) {
    return (
      <Link
        href={href}
        className="inline-flex items-center gap-2 py-4 text-[12px] uppercase tracking-[0.2em] text-cl-muted hover:text-black"
      >
        <span aria-hidden>←</span>
        {label}
      </Link>
    );
  }

  return (
    <button
      type="button"
      onClick={() => router.back()}
      className="inline-flex items-center gap-2 py-4 text-[12px] uppercase tracking-[0.2em] text-cl-muted hover:text-black"
    >
      <span aria-hidden>←</span>
      {label}
    </button>
  );
}
