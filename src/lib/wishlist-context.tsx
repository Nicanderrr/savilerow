"use client";

import {
  createContext,
  useCallback,
  useContext,
  useEffect,
  useMemo,
  useState,
} from "react";

type WishlistContextValue = {
  ids: Set<string>;
  count: number;
  toggle: (productId: string) => void;
  has: (productId: string) => boolean;
};

const WishlistContext = createContext<WishlistContextValue | null>(null);
const STORAGE_KEY = "savile-row-wishlist";

export function WishlistProvider({ children }: { children: React.ReactNode }) {
  const [ids, setIds] = useState<Set<string>>(new Set());

  useEffect(() => {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      if (raw) setIds(new Set(JSON.parse(raw) as string[]));
    } catch {
      /* ignore */
    }
  }, []);

  useEffect(() => {
    localStorage.setItem(STORAGE_KEY, JSON.stringify([...ids]));
  }, [ids]);

  const toggle = useCallback((productId: string) => {
    setIds((prev) => {
      const next = new Set(prev);
      if (next.has(productId)) next.delete(productId);
      else next.add(productId);
      return next;
    });
  }, []);

  const has = useCallback((productId: string) => ids.has(productId), [ids]);

  const value = useMemo(
    () => ({ ids, count: ids.size, toggle, has }),
    [ids, toggle, has]
  );

  return (
    <WishlistContext.Provider value={value}>{children}</WishlistContext.Provider>
  );
}

export function useWishlist() {
  const ctx = useContext(WishlistContext);
  if (!ctx) throw new Error("useWishlist must be used within WishlistProvider");
  return ctx;
}
