"use client";

import { useState } from "react";
import { IconFilter } from "@/components/icons/LouboutinIcons";

type Filters = {
  sort: string;
  onlyNew: boolean;
  inStock: boolean;
};

type Props = {
  filters: Filters;
  onChange: (f: Filters) => void;
};

export function FilterDrawer({ filters, onChange }: Props) {
  const [open, setOpen] = useState(false);

  return (
    <>
      <button
        type="button"
        onClick={() => setOpen(true)}
        className="flex items-center gap-2 rounded-full bg-cl-red px-5 py-2.5 text-[11px] uppercase tracking-[0.15em] text-white"
        aria-label="Refine - Filter products"
      >
        <IconFilter className="text-white" />
        Refine
      </button>

      {open && (
        <>
          <div
            className="fixed inset-0 z-40 bg-black/40 animate-fade-in"
            onClick={() => setOpen(false)}
            aria-hidden
          />
          <aside
            className="fixed right-0 top-0 z-50 flex h-full w-full max-w-md flex-col bg-cl-white animate-slide-in-right shadow-2xl"
            aria-label="Refine filters"
          >
            <div className="flex items-center justify-between border-b border-cl-gray-mid px-6 py-5">
              <h2 className="font-serif text-xl uppercase">Refine</h2>
              <button
                type="button"
                onClick={() => setOpen(false)}
                className="text-2xl"
                aria-label="Close filters"
              >
                ×
              </button>
            </div>
            <div className="flex-1 overflow-y-auto px-6 py-8">
              <FilterControls filters={filters} onChange={onChange} />
            </div>
            <div className="border-t border-cl-gray-mid p-6">
              <button
                type="button"
                onClick={() => setOpen(false)}
                className="btn-red w-full"
              >
                Apply
              </button>
            </div>
          </aside>
        </>
      )}
    </>
  );
}

function FilterControls({
  filters,
  onChange,
}: {
  filters: Filters;
  onChange: (f: Filters) => void;
}) {
  return (
    <div className="space-y-8 text-[13px]">
      <fieldset>
        <legend className="text-label text-cl-muted">Sort by</legend>
        <div className="mt-3 space-y-2">
          {[
            ["featured", "Featured"],
            ["new", "Newest"],
            ["price-asc", "Price: Low to High"],
            ["price-desc", "Price: High to Low"],
          ].map(([value, label]) => (
            <label key={value} className="flex items-center gap-3">
              <input
                type="radio"
                name="sort"
                checked={filters.sort === value}
                onChange={() => onChange({ ...filters, sort: value })}
              />
              {label}
            </label>
          ))}
        </div>
      </fieldset>
      <label className="flex items-center gap-3">
        <input
          type="checkbox"
          checked={filters.onlyNew}
          onChange={(e) => onChange({ ...filters, onlyNew: e.target.checked })}
        />
        New arrivals only
      </label>
      <label className="flex items-center gap-3">
        <input
          type="checkbox"
          checked={filters.inStock}
          onChange={(e) => onChange({ ...filters, inStock: e.target.checked })}
        />
        In stock
      </label>
    </div>
  );
}
