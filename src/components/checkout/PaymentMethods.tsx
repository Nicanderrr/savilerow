"use client";

import { useState } from "react";

const methods = [
  { id: "card", label: "Credit / Debit Card", detail: "Visa · Mastercard · Amex" },
  { id: "paypal", label: "PayPal", detail: "Redirect to PayPal" },
  { id: "apple", label: "Apple Pay", detail: "Touch ID or Face ID" },
  { id: "momo", label: "Momo / Mobile Money", detail: "Pay with Momo via Hubble" },
] as const;

type MomoSession = {
  sessionId: string;
  deepLink?: string;
  message: string;
  expiresAt: string;
};

export function PaymentMethods({
  orderTotal,
  currency = "USD",
  onMomoReady,
}: {
  orderTotal?: number;
  currency?: string;
  onMomoReady?: (session: MomoSession | null) => void;
}) {
  const [selected, setSelected] = useState<string>("card");
  const [momoLoading, setMomoLoading] = useState(false);
  const [momoSession, setMomoSession] = useState<MomoSession | null>(null);
  const [momoError, setMomoError] = useState<string | null>(null);
  const [phone, setPhone] = useState("");

  const selectMethod = async (id: string) => {
    setSelected(id);
    setMomoError(null);
    if (id !== "momo") {
      setMomoSession(null);
      onMomoReady?.(null);
      return;
    }

    if (!orderTotal || orderTotal <= 0) return;

    setMomoLoading(true);
    try {
      const res = await fetch("/api/momo/init", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          amount: orderTotal,
          currency,
          orderId: `sr_${Date.now()}`,
          customerPhone: phone || undefined,
          description: "Savile Row order",
        }),
      });
      const data = await res.json();
      if (!res.ok) throw new Error(data.error ?? "Failed to start Momo payment");
      const session: MomoSession = {
        sessionId: data.sessionId,
        deepLink: data.deepLink,
        message: data.message,
        expiresAt: data.expiresAt,
      };
      setMomoSession(session);
      onMomoReady?.(session);
    } catch (e) {
      const msg = e instanceof Error ? e.message : "Momo unavailable";
      setMomoError(msg);
      onMomoReady?.(null);
    } finally {
      setMomoLoading(false);
    }
  };

  return (
    <fieldset className="space-y-3">
      <legend className="mb-2 text-xs uppercase tracking-[0.2em] text-sr-navy">
        Payment method
      </legend>
      {methods.map((m) => (
        <label
          key={m.id}
          className={`flex cursor-pointer items-start gap-4 border p-4 transition-colors ${
            selected === m.id
              ? "border-sr-navy bg-sr-cream-dark/50"
              : "border-sr-cream-dark hover:border-sr-navy/40"
          }`}
        >
          <input
            type="radio"
            name="payment"
            value={m.id}
            checked={selected === m.id}
            onChange={() => selectMethod(m.id)}
            className="mt-1"
          />
          <span>
            <span className="block font-medium text-sr-navy">{m.label}</span>
            <span className="text-sm text-sr-navy/70">{m.detail}</span>
          </span>
        </label>
      ))}
      {selected === "card" && (
        <div className="mt-4 space-y-3 border border-sr-cream-dark p-4">
          <p className="text-xs text-sr-navy/60">
            Card fields are placeholders — integrate Stripe or Adyen in production.
          </p>
          <input
            placeholder="Card number"
            className="w-full border border-sr-cream-dark bg-transparent px-3 py-2 text-sm"
            disabled
          />
          <div className="grid grid-cols-2 gap-3">
            <input
              placeholder="MM / YY"
              className="border border-sr-cream-dark bg-transparent px-3 py-2 text-sm"
              disabled
            />
            <input
              placeholder="CVC"
              className="border border-sr-cream-dark bg-transparent px-3 py-2 text-sm"
              disabled
            />
          </div>
        </div>
      )}
      {selected === "momo" && (
        <div className="mt-4 space-y-4 border border-sr-cream-dark p-4">
          <p className="text-xs text-sr-navy/60">
            Mobile money via Hubble Momo. Enter your number to receive a payment prompt.
          </p>
          <input
            type="tel"
            placeholder="Mobile number (e.g. +233…)"
            value={phone}
            onChange={(e) => setPhone(e.target.value)}
            className="w-full border border-sr-cream-dark bg-transparent px-3 py-2 text-sm"
          />
          {momoLoading && (
            <p className="text-sm text-sr-navy/70">Starting Momo session…</p>
          )}
          {momoError && (
            <p className="text-sm text-red-700">{momoError}</p>
          )}
          {momoSession && !momoLoading && (
            <div className="space-y-4 text-center">
              <div
                className="mx-auto flex h-40 w-40 items-center justify-center border border-dashed border-sr-navy/30 bg-sr-cream-dark/30"
                aria-hidden
              >
                <span className="px-4 text-[10px] uppercase tracking-widest text-sr-navy/50">
                  QR placeholder
                </span>
              </div>
              <p className="font-serif text-lg text-sr-navy">{momoSession.message}</p>
              <p className="text-xs text-sr-navy/60">
                Session {momoSession.sessionId.slice(0, 20)}… · expires{" "}
                {new Date(momoSession.expiresAt).toLocaleTimeString()}
              </p>
              {momoSession.deepLink && (
                <a
                  href={momoSession.deepLink}
                  className="inline-block text-xs uppercase tracking-[0.2em] text-sr-navy underline"
                >
                  Open Momo app
                </a>
              )}
              <button
                type="button"
                className="w-full border border-sr-navy py-3 text-xs uppercase tracking-[0.2em] text-sr-navy"
                onClick={() => selectMethod("momo")}
              >
                Refresh payment status
              </button>
            </div>
          )}
        </div>
      )}
    </fieldset>
  );
}
