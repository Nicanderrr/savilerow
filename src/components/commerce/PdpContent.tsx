"use client";

import { useMemo, useState } from "react";
import { ProductGallery } from "./ProductGallery";
import { AddToBagSection } from "./AddToBagSection";
import { ProductDetails } from "./ProductDetails";
import { getImagesForColor } from "@/lib/catalog";
import type { Product } from "@/lib/types";

export function PdpContent({ product }: { product: Product }) {
  const [color, setColor] = useState(product.colors[0]?.value ?? "");
  const galleryImages = useMemo(
    () => getImagesForColor(product, color),
    [product, color]
  );

  return (
    <div className="mx-auto grid max-w-[1600px] lg:grid-cols-2">
      <ProductGallery images={galleryImages} alt={product.name} />
      <div className="px-6 pb-28 lg:px-12 lg:pb-16">
        <AddToBagSection
          product={product}
          color={color}
          onColorChange={setColor}
          showColour
        />
        <ProductDetails
          description={product.description}
          material={product.material}
          care={product.care}
          shippingNote={product.shippingNote}
        />
      </div>
    </div>
  );
}
