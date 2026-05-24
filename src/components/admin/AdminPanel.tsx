"use client";

import { useState } from "react";
import { PRODUCTS } from "@/lib/catalog";
import type { Product } from "@/lib/types";

export function AdminPanel() {
  const [products, setProducts] = useState<Product[]>(PRODUCTS);
  const [editing, setEditing] = useState<string | null>(null);
  const [draft, setDraft] = useState({ name: "", price: "" });

  const startEdit = (p: Product) => {
    setEditing(p.id);
    setDraft({ name: p.name, price: String(p.price) });
  };

  const save = (id: string) => {
    setProducts((prev) =>
      prev.map((p) =>
        p.id === id
          ? { ...p, name: draft.name, price: Number(draft.price) || p.price }
          : p
      )
    );
    setEditing(null);
  };

  return (
    <div className="mt-8 overflow-x-auto">
      <table className="w-full text-left text-sm">
        <thead>
          <tr className="border-b border-sr-cream-dark text-xs uppercase tracking-widest">
            <th className="py-3 pr-4">SKU / Slug</th>
            <th className="py-3 pr-4">Name</th>
            <th className="py-3 pr-4">Price (USD base)</th>
            <th className="py-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          {products.map((p) => (
            <tr key={p.id} className="border-b border-sr-cream-dark/60">
              <td className="py-3 pr-4 font-mono text-xs">{p.slug}</td>
              <td className="py-3 pr-4">
                {editing === p.id ? (
                  <input
                    value={draft.name}
                    onChange={(e) => setDraft({ ...draft, name: e.target.value })}
                    className="w-full border px-2 py-1"
                  />
                ) : (
                  p.name
                )}
              </td>
              <td className="py-3 pr-4">
                {editing === p.id ? (
                  <input
                    value={draft.price}
                    onChange={(e) => setDraft({ ...draft, price: e.target.value })}
                    className="w-24 border px-2 py-1"
                  />
                ) : (
                  p.price
                )}
              </td>
              <td className="py-3">
                {editing === p.id ? (
                  <button
                    type="button"
                    onClick={() => save(p.id)}
                    className="text-xs uppercase text-sr-gold"
                  >
                    Save
                  </button>
                ) : (
                  <button
                    type="button"
                    onClick={() => startEdit(p)}
                    className="text-xs uppercase text-sr-navy"
                  >
                    Edit
                  </button>
                )}
              </td>
            </tr>
          ))}
        </tbody>
      </table>
      <p className="mt-6 text-xs text-sr-navy/50">
        Changes are session-only. Wire Sanity webhooks or Strapi REST to persist.
      </p>
    </div>
  );
}
