"use client";

import Link from "next/link";
import { useMemo, useState } from "react";
import { convertPrice, formatPrice } from "@/lib/format";
import { useMarket } from "@/lib/market-context";

const FABRICS = [
  { id: "super150", label: "Super 150s Wool", add: 0 },
  { id: "super180", label: "Super 180s Wool", add: 400 },
  { id: "cashmere", label: "Cashmere Blend", add: 800 },
  { id: "linen", label: "Irish Linen", add: 200 },
];

const LAPELS: { id: string; label: string; add?: number }[] = [
  { id: "notch", label: "Notch Lapel" },
  { id: "peak", label: "Peak Lapel", add: 150 },
  { id: "shawl", label: "Shawl Lapel", add: 200 },
];

const LININGS = [
  { id: "standard", label: "Standard Bemberg", add: 0 },
  { id: "signature", label: "Signature Print", add: 120 },
  { id: "monogram", label: "Monogrammed", add: 85 },
];

const BASE_PRICE = 3800;

export function BespokeConfigurator() {
  const { marketCode } = useMarket();
  const [step, setStep] = useState(0);
  const [fabric, setFabric] = useState(FABRICS[0].id);
  const [lapel, setLapel] = useState("notch");
  const [lining, setLining] = useState(LININGS[0].id);
  const [measurements, setMeasurements] = useState("");

  const estimate = useMemo(() => {
    let total = BASE_PRICE;
    total += FABRICS.find((f) => f.id === fabric)?.add ?? 0;
    total += LAPELS.find((x) => x.id === lapel)?.add ?? 0;
    total += LININGS.find((l) => l.id === lining)?.add ?? 0;
    return convertPrice(total, marketCode);
  }, [fabric, lapel, lining, marketCode]);

  const steps = ["Fabric", "Lapel", "Lining", "Measurements"];

  return (
    <div className="mx-auto max-w-3xl">
      <ol className="mb-10 flex justify-between gap-2" aria-label="Configuration steps">
        {steps.map((s, i) => (
          <li
            key={s}
            className={`flex-1 border-b-2 pb-2 text-center text-xs uppercase tracking-widest ${
              i <= step ? "border-sr-gold text-sr-navy" : "border-sr-cream-dark text-sr-navy/40"
            }`}
          >
            {s}
          </li>
        ))}
      </ol>

      {step === 0 && (
        <fieldset className="space-y-3">
          <legend className="font-serif text-2xl text-sr-navy">Select fabric</legend>
          {FABRICS.map((f) => (
            <label key={f.id} className="flex cursor-pointer items-center gap-3 border border-sr-cream-dark p-4">
              <input type="radio" name="fabric" checked={fabric === f.id} onChange={() => setFabric(f.id)} />
              <span>{f.label}</span>
              {f.add > 0 && <span className="ml-auto text-sm text-sr-gold">+{formatPrice(convertPrice(f.add, marketCode), marketCode)}</span>}
            </label>
          ))}
        </fieldset>
      )}

      {step === 1 && (
        <fieldset className="space-y-3">
          <legend className="font-serif text-2xl text-sr-navy">Lapel style</legend>
          {LAPELS.map((l) => (
            <label key={l.id} className="flex cursor-pointer items-center gap-3 border border-sr-cream-dark p-4">
              <input type="radio" name="lapel" checked={lapel === l.id} onChange={() => setLapel(l.id)} />
              <span>{l.label}</span>
            </label>
          ))}
        </fieldset>
      )}

      {step === 2 && (
        <fieldset className="space-y-3">
          <legend className="font-serif text-2xl text-sr-navy">Lining</legend>
          {LININGS.map((l) => (
            <label key={l.id} className="flex cursor-pointer items-center gap-3 border border-sr-cream-dark p-4">
              <input type="radio" name="lining" checked={lining === l.id} onChange={() => setLining(l.id)} />
              <span>{l.label}</span>
            </label>
          ))}
        </fieldset>
      )}

      {step === 3 && (
        <div>
          <label className="block font-serif text-2xl text-sr-navy">Measurements note</label>
          <p className="mt-2 text-sm text-sr-navy/70">
            Share any prior measurements, posture notes, or preferred fit. Our cutters will confirm at your fitting.
          </p>
          <textarea
            value={measurements}
            onChange={(e) => setMeasurements(e.target.value)}
            rows={6}
            className="mt-4 w-full border border-sr-cream-dark bg-transparent p-4 text-sm"
            placeholder="e.g. 40 chest, 32 waist, prefer soft shoulder..."
          />
        </div>
      )}

      <p className="mt-8 text-center font-serif text-xl text-sr-navy">
        Estimated from {formatPrice(estimate, marketCode)}
      </p>

      <div className="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-between">
        {step > 0 ? (
          <button
            type="button"
            onClick={() => setStep((s) => s - 1)}
            className="border border-sr-navy px-8 py-3 text-xs uppercase tracking-[0.25em] text-sr-navy"
          >
            Back
          </button>
        ) : (
          <span />
        )}
        {step < steps.length - 1 ? (
          <button
            type="button"
            onClick={() => setStep((s) => s + 1)}
            className="bg-sr-navy px-8 py-3 text-xs uppercase tracking-[0.25em] text-sr-cream"
          >
            Continue
          </button>
        ) : (
          <Link
            href="/appointments?type=fitting&source=bespoke"
            className="bg-sr-gold px-8 py-3 text-center text-xs uppercase tracking-[0.25em] text-sr-navy"
          >
            Request fitting
          </Link>
        )}
      </div>
    </div>
  );
}
