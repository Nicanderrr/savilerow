"use client";

import Image from "next/image";
import Link from "next/link";
import { Trash2 } from "lucide-react";
import { BackNav } from "@/components/layout/BackNav";
import { formatPrice } from "@/lib/format";
import { useCart } from "@/lib/cart-context";
import { useMarket } from "@/lib/market-context";

export default function CartPage() {
  const { items, subtotal, updateQuantity, removeItem } = useCart();
  const { marketCode, market } = useMarket();

  if (items.length === 0) {
    return (
      <main id="main-content" className="mx-auto max-w-2xl px-6 py-24 text-center">
        <h1 className="font-serif text-3xl uppercase">Your bag is empty</h1>
        <p className="mt-4 text-[13px] text-cl-muted">
          It&apos;s looking a little empty in here.
        </p>
        <Link href="/collections/all/products" className="btn-outline mt-10 inline-block">
          Continue shopping
        </Link>
      </main>
    );
  }

  return (
    <main id="main-content" className="mx-auto max-w-4xl px-6 py-12 md:py-16">
      <BackNav href="/collections/all/products" label="Continue shopping" />
      <h1 className="font-serif text-3xl uppercase md:text-4xl">Shopping bag</h1>
      <p className="mt-2 text-[12px] text-cl-muted">
        Free returns — no ifs, ands, or buts
      </p>
      <ul className="mt-10 divide-y divide-cl-gray-mid">
        {items.map((item) => (
          <li key={item.variantId} className="flex gap-4 py-8">
            <div className="relative h-28 w-20 shrink-0 bg-cl-gray">
              <Image src={item.image} alt={item.name} fill className="object-cover" sizes="80px" />
            </div>
            <div className="flex flex-1 flex-col">
              <Link href={`/products/${item.slug}`} className="font-serif text-lg">
                {item.name}
              </Link>
              <p className="text-[12px] text-cl-muted">
                {[
                  item.color,
                  item.size,
                  item.fulfillment === "pickup" ? "In-store pickup" : "Ship to me",
                ]
                  .filter(Boolean)
                  .join(" · ")}
              </p>
              <div className="mt-auto flex items-center justify-between pt-4">
                <div className="flex items-center gap-2">
                  <button
                    type="button"
                    onClick={() => updateQuantity(item.variantId, item.quantity - 1)}
                    className="h-8 w-8 border border-cl-gray-mid"
                    aria-label="Decrease quantity"
                  >
                    −
                  </button>
                  <span className="w-8 text-center text-[13px]">{item.quantity}</span>
                  <button
                    type="button"
                    onClick={() => updateQuantity(item.variantId, item.quantity + 1)}
                    className="h-8 w-8 border border-cl-gray-mid"
                    aria-label="Increase quantity"
                  >
                    +
                  </button>
                </div>
                <p className="text-[13px] font-medium">
                  {formatPrice(item.unitPrice * item.quantity, marketCode)}
                </p>
              </div>
              <button
                type="button"
                onClick={() => removeItem(item.variantId)}
                className="mt-2 flex items-center gap-1 self-start text-cl-muted hover:text-black"
                aria-label="Remove item"
              >
                <Trash2 className="h-4 w-4" strokeWidth={1.5} />
              </button>
            </div>
          </li>
        ))}
      </ul>
      <div className="mt-8 border-t border-cl-gray-mid pt-8">
        <p className="flex justify-between font-serif text-xl">
          <span>Subtotal</span>
          <span>{formatPrice(subtotal, marketCode)}</span>
        </p>
        <p className="mt-2 text-[12px] text-cl-muted">
          {market.vatInclusive ? "VAT included." : "Tax calculated at checkout."}{" "}
          {market.shippingNote}
        </p>
        <Link href="/checkout" className="btn-red mt-8 block w-full text-center">
          Proceed to checkout
        </Link>
      </div>
    </main>
  );
}
