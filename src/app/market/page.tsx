import { MarketSelector } from "@/components/market/MarketSelector";
import { MARKET_LIST } from "@/lib/markets";

export const metadata = {
  title: "Market & Currency",
};

export default function MarketPage() {
  return (
    <main id="main-content" className="mx-auto max-w-2xl px-4 py-10 md:px-6 md:py-16">
      <h1 className="font-serif text-3xl text-sr-navy">Global markets</h1>
      <p className="mt-4 text-sm text-sr-navy/80">
        Select your shipping region, currency, and language preference. Prices and
        tax display adjust accordingly.
      </p>
      <div className="mt-8">
        <MarketSelector />
      </div>
      <ul className="mt-12 space-y-4 border-t border-sr-cream-dark pt-8">
        {MARKET_LIST.map((m) => (
          <li key={m.code} className="text-sm">
            <strong>{m.country}</strong> — {m.currency} ·{" "}
            {m.vatInclusive ? `VAT ${(m.vatRate * 100).toFixed(0)}% incl.` : "Tax at checkout"}
            <p className="mt-1 text-sr-navy/60">{m.shippingNote}</p>
          </li>
        ))}
      </ul>
    </main>
  );
}
