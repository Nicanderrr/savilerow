"use client";

import { useState } from "react";
import { useRouter } from "next/navigation";
import { useUi } from "@/lib/ui-context";

export function SearchOverlay() {
  const { searchOpen, setSearchOpen } = useUi();
  const [query, setQuery] = useState("");
  const router = useRouter();

  if (!searchOpen) return null;

  const submit = (e: React.FormEvent) => {
    e.preventDefault();
    setSearchOpen(false);
    router.push(`/collections/all/products?q=${encodeURIComponent(query)}`);
  };

  return (
    <>
      <div
        className="fixed inset-0 z-[70] bg-black/50 animate-fade-in"
        onClick={() => setSearchOpen(false)}
        aria-hidden
      />
      <div className="fixed inset-x-0 top-0 z-[80] animate-slide-in-right bg-cl-white px-6 py-8 shadow-lg md:px-12">
        <div className="mx-auto flex max-w-4xl items-start justify-between gap-6">
          <form onSubmit={submit} className="flex-1">
            <label htmlFor="site-search" className="text-label text-cl-muted">
              Search by keyword
            </label>
            <input
              id="site-search"
              type="search"
              autoFocus
              value={query}
              onChange={(e) => setQuery(e.target.value)}
              className="mt-3 w-full border-0 border-b border-black bg-transparent py-3 font-serif text-2xl text-black outline-none focus:ring-0"
              placeholder=""
            />
          </form>
          <button
            type="button"
            onClick={() => setSearchOpen(false)}
            className="text-2xl text-black"
            aria-label="Close search"
          >
            ×
          </button>
        </div>
      </div>
    </>
  );
}
