"use client";

import Link from "next/link";
import { useState } from "react";
import { IconHeart } from "@/components/icons/LouboutinIcons";
import { ColorSwatches } from "./ColorSwatches";
import { SizeSelect } from "./SizeSelect";
import { convertPrice, formatPrice } from "@/lib/format";
import { getImagesForColor } from "@/lib/catalog";
import { useCart } from "@/lib/cart-context";
import { useMarket } from "@/lib/market-context";
import { useWishlist } from "@/lib/wishlist-context";
import { useUi } from "@/lib/ui-context";
import type { Product } from "@/lib/types";

export function AddToBagSection({
  product,
  color: controlledColor,
  onColorChange,
  showColour = false,
}: {
  product: Product;
  color?: string;
  onColorChange?: (c: string) => void;
  /** Colour swatches belong on the product detail page only */
  showColour?: boolean;
}) {
  const { marketCode, market } = useMarket();
  const { addItem } = useCart();
  const { has, toggle } = useWishlist();
  const { setBagOpen } = useUi();
  const [internalColor, setInternalColor] = useState(product.colors[0]?.value ?? "");
  const color = controlledColor ?? internalColor;
  const setColor = onColorChange ?? setInternalColor;
  const [size, setSize] = useState(product.sizes[0]?.value ?? "");
  const [added, setAdded] = useState(false);

  const variant =
    product.variants.find((v) => v.size === size && v.color === color) ??
    product.variants[0];

  const unitPrice = convertPrice(
    product.price + (variant?.priceModifier ?? 0),
    marketCode
  );

  const handleAdd = () => {
    if (!variant) return;
    const images = getImagesForColor(product, color);
    addItem({
      productId: product.id,
      variantId: variant.id,
      slug: product.slug,
      name: product.name,
      image: images[0] ?? product.images[0],
      size: variant.size,
      color: variant.color,
      unitPrice,
    });
    setAdded(true);
    setBagOpen(true);
    setTimeout(() => setAdded(false), 2000);
  };

  const sizesWithStock = product.sizes.map((s) => {
    const match = product.variants.find((v) => v.size === s.value && v.color === color);
    return { ...s, inStock: match?.inStock ?? s.inStock };
  });

  return (
    <div className="space-y-8 lg:sticky lg:top-header-total lg:self-start lg:py-8">
      <div className="flex items-start justify-between gap-4">
        <div>
          <h1 className="font-serif text-2xl uppercase md:text-3xl">{product.name}</h1>
          <p className="mt-2 text-[13px] text-cl-muted">
            {product.category} — {product.gender}
          </p>
        </div>
        <button
          type="button"
          onClick={() => toggle(product.id)}
          aria-label="Add to wishlist"
          className="shrink-0"
        >
          <IconHeart filled={has(product.id)} className="h-6 w-6" />
        </button>
      </div>

      <p className="text-[15px]">
        <span className="text-cl-muted">As low as </span>
        <span className="font-medium">{formatPrice(unitPrice, marketCode)}</span>
        {market.vatInclusive && (
          <span className="ml-2 text-[12px] text-cl-muted">VAT incl.</span>
        )}
      </p>

      <div className="space-y-6">
        {showColour && product.colors.length > 0 && (
          <ColorSwatches
            colors={product.colors}
            colorImages={product.colorImages}
            value={color}
            onChange={setColor}
          />
        )}
        {product.sizes.length > 0 && (
          <SizeSelect
            label="Size"
            options={sizesWithStock}
            value={size}
            onChange={setSize}
          />
        )}
      </div>

      <p className="text-[12px] text-cl-muted">{market.shippingNote}</p>

      <button
        type="button"
        onClick={handleAdd}
        disabled={!variant?.inStock}
        className="btn-red hidden w-full md:block"
      >
        {added ? "Added to bag" : variant?.inStock ? "Add to bag" : "Out of stock"}
      </button>

      <button type="button" className="btn-outline hidden w-full md:block">
        Order by phone
      </button>

      {product.isBespokeEligible && (
        <Link
          href="/bespoke"
          className="block text-center text-[11px] uppercase tracking-[0.2em] underline-offset-4 hover:underline"
        >
          Configure bespoke
        </Link>
      )}

      <div className="fixed bottom-0 left-0 right-0 z-30 border-t border-cl-gray-mid bg-cl-white p-4 md:hidden">
        <button
          type="button"
          onClick={handleAdd}
          disabled={!variant?.inStock}
          className="btn-red w-full py-4"
        >
          {added ? "Added" : variant?.inStock ? "Add to bag" : "Out of stock"}
        </button>
      </div>
    </div>
  );
}
