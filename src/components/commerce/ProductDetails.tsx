"use client";

import { useState } from "react";

const SECTIONS = [
  { id: "description", label: "Description" },
  { id: "material", label: "Material" },
  { id: "care", label: "Care" },
  { id: "shipping", label: "Shipping" },
] as const;

export function ProductDetails({
  description,
  material,
  care,
  shippingNote,
}: {
  description: string;
  material?: string;
  care?: string;
  shippingNote?: string;
}) {
  const [open, setOpen] = useState<string>("description");

  const content: Record<string, string | undefined> = {
    description,
    material,
    care,
    shipping: shippingNote,
  };

  return (
    <section className="mt-10 border-t border-cl-gray-mid pt-8">
      <h2 className="text-label text-cl-muted">Product details</h2>
      <div className="mt-4 divide-y divide-cl-gray-mid">
        {SECTIONS.map((s) => {
          const text = content[s.id];
          if (!text) return null;
          const isOpen = open === s.id;
          return (
            <div key={s.id}>
              <button
                type="button"  onClick={() => setOpen(isOpen ? "" : s.id)} className="flex w-full items-center justify-between py-4 text-left text-[12px] uppercase tracking-[0.2em]"  >
               
                
              aria-expanded={isOpen}
              
                {s.label}
                <span className="text-lg font-light">{isOpen ? "−" : "+"}</span>
              </button>
              {isOpen && (
                <p className="pb-4 text-[13px] leading-relaxed text-cl-muted">{text}</p>
              )}
            </div>
          );
        })}
      </div>
    </section>
  );
}
