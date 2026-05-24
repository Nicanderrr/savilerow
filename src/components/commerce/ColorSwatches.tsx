"use client";

import Image from "next/image";
import type { VariantOption } from "@/lib/types";

export function ColorSwatches({
  colors,
  colorImages,
  value,
  onChange,
  centered,
}: {
  colors: VariantOption[];
  colorImages: Record<string, string[]>;
  value: string;
  onChange: (v: string) => void;
  centered?: boolean;
}) {
  return (
    <div>
      <p className="text-label text-cl-muted">Colour</p>
      <ul className={`mt-3 flex flex-wrap gap-2 ${centered ? "justify-center" : ""}`}>
        {colors.map((c) => {
          const thumb = colorImages[c.value]?.[0];
          const selected = value === c.value;
          return (
            <li key={c.id}>
              <button
                type="button"
                onClick={() => onChange(c.value)}
                disabled={c.inStock === false}
                className={`relative h-14 w-11 overflow-hidden border-2 transition ${
                  selected ? "border-black" : "border-cl-gray-mid hover:border-black"
                } ${c.inStock === false ? "opacity-40" : ""}`}
                aria-label={`Colour ${c.label}`}
                aria-pressed={selected}
                title={c.label}
              >
                {thumb ? (
                  <Image src={thumb} alt="" fill className="object-cover" sizes="44px" />
                ) : (
                  <span className="block h-full w-full bg-cl-gray" />
                )}
              </button>
            </li>
          );
        })}
      </ul>
    </div>
  );
}
