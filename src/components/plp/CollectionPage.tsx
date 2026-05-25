"use client";

import { useMemo, useState } from "react";
import { ProductCard } from "@/components/commerce/ProductCard";
import { BackNav } from "@/components/layout/BackNav";
import { FilterDrawer } from "./FilterDrawer";
import { IconGrid, IconList } from "@/components/icons/LouboutinIcons";
import {
  CATEGORY_DESCRIPTIONS,
  CATEGORY_LABELS,
  GENDER_LABELS,
  SUBCATEGORY_LABELS,
  getAllProducts,
  getProductsByCollection,
  getSubcategoriesFor,
} from "@/lib/catalog";
import type { Gender, ProductCategory } from "@/lib/types";

type ViewMode = "grid" | "list";

export function CollectionPage({
  gender: resolvedGender,
  category: resolvedCategory,
}: {
  gender?: Gender;
  category?: ProductCategory;
}) {

  const [filters, setFilters] = useState({
    sort: "featured",
    onlyNew: false,
    inStock: false,
  });
  const isAllProducts = !resolvedGender && !resolvedCategory;
  const [view, setView] = useState<ViewMode>(
    isAllProducts ? "grid" : resolvedCategory === "shoes" ? "list" : "grid"
  );
  const [activeSub, setActiveSub] = useState<string>("all");

  const subcategories = useMemo(
    () => getSubcategoriesFor(resolvedGender, resolvedCategory),
    [resolvedGender, resolvedCategory]
  );

  const products = useMemo(() => {
    let list =
      resolvedGender || resolvedCategory
        ? getProductsByCollection(resolvedGender, resolvedCategory)
        : getAllProducts();
    if (activeSub !== "all") list = list.filter((p) => p.subcategory === activeSub);
    if (filters.onlyNew) list = list.filter((p) => p.isNew);
    if (filters.inStock) {
      list = list.filter((p) => p.variants.some((v) => v.inStock));
    }
    if (filters.sort === "price-asc") list = [...list].sort((a, b) => a.price - b.price);
    if (filters.sort === "price-desc") list = [...list].sort((a, b) => b.price - a.price);
    if (filters.sort === "new") list = [...list].sort((a, b) => (b.isNew ? 1 : 0) - (a.isNew ? 1 : 0));
    return list;
  }, [resolvedGender, resolvedCategory, filters, activeSub]);

  const title = resolvedCategory
    ? CATEGORY_LABELS[resolvedCategory]
    : "All Savile Row products";

  const genderLabel = resolvedGender ? GENDER_LABELS[resolvedGender] : null;

  const description = resolvedCategory
    ? CATEGORY_DESCRIPTIONS[resolvedCategory]
    : "Discover the full collection of tailoring, shoes, bags, perfumes, and accessories.";

  const backHref = "/collections/all/products";

  return (
    <main id="main-content" className="bg-cl-white pb-20">
      <div className="mx-auto max-w-[1600px] px-6 pt-8">
        <BackNav href={backHref} />
      </div>
      <div className="mx-auto max-w-[1600px] px-6 pb-6 pt-4 text-center md:pt-8">
        {genderLabel && (
          <p className="text-label text-cl-muted">{genderLabel}</p>
        )}
        <h1 className="mt-2 font-serif text-3xl uppercase md:text-5xl">{title}</h1>
        <p className="mx-auto mt-6 max-w-2xl text-[13px] leading-relaxed text-cl-muted">
          {description}
        </p>
      </div>

      {resolvedCategory && subcategories.length > 0 && (
        <nav
          aria-label="Subcategories"
          className="mx-auto max-w-[1600px] px-2 pb-6 md:px-6"
        >
          <ul className="flex gap-2 overflow-x-auto whitespace-nowrap px-4 scrollbar-hide md:justify-center md:px-0">
            <li>
              <button
                type="button"
                onClick={() => setActiveSub("all")}
                className={`rounded-full px-5 py-2.5 text-[11px] uppercase tracking-[0.18em] transition ${
                  activeSub === "all"
                    ? "border border-black bg-black text-white"
                    : "border border-cl-gray-mid text-black hover:border-black"
                }`}
                aria-pressed={activeSub === "all" ? "true" : "false"}
              >
                All
              </button>
            </li>
            {subcategories.map((sub) => (
              <li key={sub}>
                <button
                  type="button"
                  onClick={() => setActiveSub(sub)}
                  className={`rounded-full px-5 py-2.5 text-[11px] uppercase tracking-[0.18em] transition ${
                    activeSub === sub
                      ? "border border-black bg-black text-white"
                      : "border border-cl-gray-mid text-black hover:border-black"
                  }`}
                  aria-pressed={activeSub === sub ? "true" : "false"}
                >
                  {SUBCATEGORY_LABELS[sub] ?? sub}
                </button>
              </li>
            ))}
          </ul>
        </nav>
      )}

      <div className="sticky top-header-total z-30 border-y border-cl-gray-mid bg-cl-white">
        <div className="mx-auto flex max-w-[1600px] items-center justify-between px-6 py-4">
          <FilterDrawer filters={filters} onChange={setFilters} />
          <div className="flex items-center gap-4 text-[12px] text-cl-muted">
            <span>{products.length} results</span>
            <button
              type="button"
              onClick={() => setView("grid")}
              className={view === "grid" ? "text-black" : "text-cl-muted"}
              aria-label="Grid view"
              aria-current={view === "grid"}
            >
              <IconGrid />
            </button>
            <button
              type="button"
              onClick={() => setView("list")}
              className={view === "list" ? "text-black" : "text-cl-muted"}
              aria-label="List view"
              aria-current={view === "list"}
            >
              <IconList />
            </button>
          </div>
        </div>
      </div>

      <div className="mx-auto max-w-[1600px] px-4 py-10 md:px-6">
        {products.length === 0 ? (
          <p className="py-20 text-center text-cl-muted">
            No pieces match your filters.
          </p>
        ) : (
          <div
            className={
              isAllProducts
                ? "grid grid-cols-2 gap-x-4 gap-y-10 md:grid-cols-3 lg:grid-cols-4 lg:gap-x-6"
                : view === "grid"
                  ? "grid grid-cols-2 gap-x-4 gap-y-12 md:grid-cols-3 lg:grid-cols-4 lg:gap-x-6"
                  : "grid grid-cols-1 gap-8 md:flex md:flex-col"
            }
          >
            {products.map((p) => (
              <ProductCard
                key={p.id}
                product={p}
                layout={isAllProducts ? "grid" : view}
                framed={isAllProducts}
              />
            ))}
          </div>
        )}
      </div>
    </main>
  );
}
