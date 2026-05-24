"use client";

import { useMarket } from "@/lib/market-context";
import { useUi } from "@/lib/ui-context";

export function GeoModal() {
  const { geoOpen, setGeoOpen } = useUi();
  const { market } = useMarket();

  if (!geoOpen) return null;

  const dismiss = () => {
    sessionStorage.setItem("sr-geo-dismissed", "1");
    setGeoOpen(false);
  };

  return (
    <>
      <div className="fixed inset-0 z-[90] bg-black/50" aria-hidden />
      <div
        role="dialog"
        aria-labelledby="geo-title"
        className="fixed left-1/2 top-1/2 z-[95] w-[min(92vw,440px)] -translate-x-1/2 -translate-y-1/2 bg-cl-white p-8 shadow-2xl"
      >
        <h2 id="geo-title" className="font-serif text-2xl">
          Welcome
        </h2>
        <p className="mt-4 text-[13px] leading-relaxed text-cl-muted">
          It appears you are located in {market.country}. Would you like to
          update your location?
        </p>
        <div className="mt-8 flex flex-col gap-3 sm:flex-row">
          <button type="button" onClick={dismiss} className="btn-red flex-1">
            Stay on {market.country}
          </button>
          <a href="/market" onClick={dismiss} className="btn-outline flex-1 text-center">
            Change country
          </a>
        </div>
      </div>
    </>
  );
}
