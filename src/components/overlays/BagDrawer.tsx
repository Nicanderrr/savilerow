"use client";

import Image from "next/image";
import Link from "next/link";
import { Trash2 } from "lucide-react";
import { formatPrice } from "@/lib/format";
import { useCart } from "@/lib/cart-context";
import { useMarket } from "@/lib/market-context";
import { useUi } from "@/lib/ui-context";

export function BagDrawer() {
  const { bagOpen, setBagOpen } = useUi();
  const { items, itemCount, subtotal, removeItem, updateQuantity } = useCart();
  const { marketCode } = useMarket();

  if (!bagOpen) return null;

  return (
    <>
      <div
        className="fixed inset-0 z-[70] bg-black/40 animate-fade-in"
        onClick={() => setBagOpen(false)}
        aria-hidden
      />
      <aside
        className="fixed right-0 top-0 z-[80] flex h-full w-full max-w-md flex-col bg-cl-white animate-slide-in-right shadow-2xl"
        aria-label="Shopping bag"
      >
        <div className="flex items-center justify-between border-b border-cl-gray-mid px-6 py-5">
          <h2 className="font-serif text-xl">Shopping bag</h2>
          <button
            type="button"
            onClick={() => setBagOpen(false)}
            className="text-2xl"
            aria-label="Close bag"
          >
            ×
          </button>
        </div>

        <p className="border-b border-cl-gray-mid px-6 py-3 text-[12px] text-cl-muted">
          Free returns — no ifs, ands, or buts
        </p>

        <div className="flex-1 overflow-y-auto px-6 py-6">
          {itemCount === 0 ? (
            <p className="py-12 text-center text-[14px] text-cl-muted">
              It&apos;s looking a little empty in here.
            </p>
          ) : (
            <ul className="space-y-6">
              {items.map((item) => (
                <li key={item.variantId} className="flex gap-4">
                  <div className="relative h-24 w-20 shrink-0 bg-cl-gray">
                    <Image
                      src={item.image}
                      alt={item.name}
                      fill
                      className="object-cover"
                      sizes="80px"
                    />
                  </div>
                  <div className="flex-1">
                    <p className="text-[13px] font-medium">{item.name}</p>
                    <p className="mt-1 text-[12px] text-cl-muted">
                      {item.color} / {item.size}
                    </p>
                    <p className="mt-2 text-[13px]">
                      {formatPrice(item.unitPrice, marketCode)}
                    </p>
                    <div className="mt-2 flex items-center gap-3">
                      <button
                        type="button"
                        onClick={() =>
                          updateQuantity(item.variantId, item.quantity - 1)
                        }
                        className="text-lg"
                        aria-label="Decrease quantity"
                      >
                        −
                      </button>
                      <span className="text-[13px]">{item.quantity}</span>
                      <button
                        type="button"
                        onClick={() =>
                          updateQuantity(item.variantId, item.quantity + 1)
                        }
                        className="text-lg"
                        aria-label="Increase quantity"
                      >
                        +
                      </button>
                      <button
                        type="button"
                        onClick={() => removeItem(item.variantId)}
                        className="ml-auto text-cl-muted hover:text-black"
                        aria-label="Remove item"
                      >
                        <Trash2 className="h-4 w-4" strokeWidth={1.5} />
                      </button>
                    </div>
                  </div>
                </li>
              ))}
            </ul>
          )}
        </div>

        {itemCount > 0 && (
          <div className="border-t border-cl-gray-mid px-6 py-6">
            <div className="flex justify-between text-[14px]">
              <span>Subtotal</span>
              <span>{formatPrice(subtotal, marketCode)}</span>
            </div>
            <Link
              href="/checkout"
              onClick={() => setBagOpen(false)}
              className="btn-red mt-6 block w-full text-center"
            >
              Checkout
            </Link>
            <Link
              href="/cart"
              onClick={() => setBagOpen(false)}
              className="mt-3 block text-center text-[11px] uppercase tracking-widest underline"
            >
              View bag
            </Link>
          </div>
        )}
      </aside>
    </>
  );
}
