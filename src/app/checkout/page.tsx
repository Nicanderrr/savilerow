"use client";

import Link from "next/link";
import { PaymentMethods } from "@/components/checkout/PaymentMethods";
import { BackNav } from "@/components/layout/BackNav";
import { MarketSelector } from "@/components/market/MarketSelector";
import { formatPrice } from "@/lib/format";
import { useCart } from "@/lib/cart-context";
import { useMarket } from "@/lib/market-context";

export default function CheckoutPage() {
  const { items, subtotal } = useCart();
  const { marketCode, market } = useMarket();
  const shipping = convertShipping(subtotal);
  const total = subtotal + shipping;

  if (items.length === 0) {
    return (
      <main id="main-content" className="mx-auto max-w-2xl px-4 py-20 text-center">
        <p>Your bag is empty.</p>
        <Link href="/cart" className="mt-4 inline-block text-sr-gold">
          Return to bag
        </Link>
      </main>
    );
  }

  return (
    <main id="main-content" className="mx-auto max-w-5xl px-4 py-10 md:px-6 md:py-14">
      <BackNav href="/cart" label="Back to bag" />
      <h1 className="font-serif text-3xl text-sr-navy">Checkout</h1>
      <div className="mt-10 grid gap-12 lg:grid-cols-2">
        <div className="space-y-8">
          <section>
            <h2 className="text-xs uppercase tracking-[0.2em] text-sr-navy">Market</h2>
            <div className="mt-3">
              <MarketSelector />
            </div>
          </section>
          <section>
            <h2 className="text-xs uppercase tracking-[0.2em] text-sr-navy">Delivery</h2>
            <div className="mt-3 space-y-3">
              <input placeholder="Full name" className="w-full border border-sr-cream-dark bg-transparent px-3 py-2 text-sm" />
              <input placeholder="Address" className="w-full border border-sr-cream-dark bg-transparent px-3 py-2 text-sm" />
              <div className="grid grid-cols-2 gap-3">
                <input placeholder="City" className="border border-sr-cream-dark bg-transparent px-3 py-2 text-sm" />
                <input placeholder="Postcode" className="border border-sr-cream-dark bg-transparent px-3 py-2 text-sm" />
              </div>
            </div>
          </section>
          <PaymentMethods orderTotal={total} currency={market.currency} />
          <button
            type="button"
            className="w-full bg-sr-navy py-4 text-xs uppercase tracking-[0.3em] text-sr-cream"
            onClick={() => alert("Payment integration placeholder — connect Stripe/Adyen.")}
          >
            Place order (demo)
          </button>
        </div>
        <aside className="border border-sr-cream-dark p-6">
          <h2 className="font-serif text-xl text-sr-navy">Order summary</h2>
          <ul className="mt-4 space-y-2 text-sm">
            {items.map((i) => (
              <li key={i.variantId} className="flex justify-between">
                <span>
                  {i.name} × {i.quantity}
                </span>
                <span>{formatPrice(i.unitPrice * i.quantity, marketCode)}</span>
              </li>
            ))}
          </ul>
          <dl className="mt-6 space-y-2 border-t border-sr-cream-dark pt-4 text-sm">
            <div className="flex justify-between">
              <dt>Subtotal</dt>
              <dd>{formatPrice(subtotal, marketCode)}</dd>
            </div>
            <div className="flex justify-between">
              <dt>Shipping</dt>
              <dd>{shipping === 0 ? "Complimentary" : formatPrice(shipping, marketCode)}</dd>
            </div>
            {!market.vatInclusive && (
              <div className="flex justify-between text-sr-navy/60">
                <dt>Est. tax</dt>
                <dd>At payment</dd>
              </div>
            )}
            <div className="flex justify-between font-serif text-lg text-sr-navy">
              <dt>Total</dt>
              <dd>{formatPrice(total, marketCode)}</dd>
            </div>
          </dl>
          <p className="mt-4 text-xs text-sr-navy/60">{market.shippingNote}</p>
        </aside>
      </div>
    </main>
  );
}

function convertShipping(subtotal: number): number {
  if (subtotal > 500) return 0;
  return 25;
}
