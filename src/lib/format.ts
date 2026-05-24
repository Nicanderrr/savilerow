import { FX_TO_USD, MARKETS } from "./markets";
import type { MarketCode } from "./types";

export function convertPrice(
  baseUsd: number,
  marketCode: MarketCode
): number {
  const market = MARKETS[marketCode];
  const rate = FX_TO_USD[market.currency] ?? 1;
  return Math.round(baseUsd * rate);
}

export function formatPrice(
  amount: number,
  marketCode: MarketCode
): string {
  const market = MARKETS[marketCode];
  return new Intl.NumberFormat(market.locale, {
    style: "currency",
    currency: market.currency,
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  }).format(amount);
}
