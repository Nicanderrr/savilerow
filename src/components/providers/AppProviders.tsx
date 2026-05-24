"use client";

import { CartProvider } from "@/lib/cart-context";
import { MarketProvider } from "@/lib/market-context";
import { UiProvider } from "@/lib/ui-context";
import { WishlistProvider } from "@/lib/wishlist-context";
import { RouteTheme } from "@/components/layout/RouteTheme";

export function AppProviders({ children }: { children: React.ReactNode }) {
  return (
    <MarketProvider>
      <UiProvider>
        <WishlistProvider>
          <CartProvider>
            <RouteTheme />
            {children}
          </CartProvider>
        </WishlistProvider>
      </UiProvider>
    </MarketProvider>
  );
}
