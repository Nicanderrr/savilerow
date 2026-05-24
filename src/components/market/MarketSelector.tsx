"use client";

import { MARKET_LIST } from "@/lib/markets";
import { useMarket } from "@/lib/market-context";
import type { MarketCode } from "@/lib/types";

export function MarketSelector({
  variant = "inline",
}: {
  variant?: "inline" | "footer";
}) {
  const { marketCode, market, setMarketCode } = useMarket();

  if (variant === "footer") {
    return (
      <button
        type="button"
        onClick={() => {
          const next = MARKET_LIST[
            (MARKET_LIST.findIndex((m) => m.code === marketCode) + 1) %
              MARKET_LIST.length
          ];
          setMarketCode(next.code);
        }}
        className="text-[12px] text-white/90 underline-offset-2 hover:underline"
        aria-label="Select country and language"
      >
        {market.country} ({market.currencySymbol}) — English
      </button>
    );
  }

  return (
    <label className="text-[12px]">
      <span className="sr-only">Market</span>
      <select
        value={marketCode}
        onChange={(e) => setMarketCode(e.target.value as MarketCode)}
        className="cursor-pointer border-0 bg-transparent text-black underline-offset-4 hover:underline focus:outline-none"
        aria-label="Select country and currency"
      >
        {MARKET_LIST.map((m) => (
          <option key={m.code} value={m.code}>
            {m.country} ({m.currency}) — English
          </option>
        ))}
      </select>
    </label>
  );
}
