"use client";

import {
  createContext,
  useCallback,
  useContext,
  useEffect,
  useMemo,
  useState,
} from "react";
import { MARKETS } from "./markets";
import type { MarketCode } from "./types";

type MarketContextValue = {
  marketCode: MarketCode;
  market: (typeof MARKETS)[MarketCode];
  setMarketCode: (code: MarketCode) => void;
};

const MarketContext = createContext<MarketContextValue | null>(null);
const STORAGE_KEY = "savile-row-market";

export function MarketProvider({ children }: { children: React.ReactNode }) {
  const [marketCode, setMarketCodeState] = useState<MarketCode>("UK");

  useEffect(() => {
    try {
      const stored = localStorage.getItem(STORAGE_KEY) as MarketCode | null;
      if (stored && MARKETS[stored]) setMarketCodeState(stored);
    } catch {
      /* ignore */
    }
  }, []);

  const setMarketCode = useCallback((code: MarketCode) => {
    setMarketCodeState(code);
    localStorage.setItem(STORAGE_KEY, code);
  }, []);

  const value = useMemo(
    () => ({
      marketCode,
      market: MARKETS[marketCode],
      setMarketCode,
    }),
    [marketCode, setMarketCode]
  );

  return (
    <MarketContext.Provider value={value}>{children}</MarketContext.Provider>
  );
}

export function useMarket() {
  const ctx = useContext(MarketContext);
  if (!ctx) throw new Error("useMarket must be used within MarketProvider");
  return ctx;
}
