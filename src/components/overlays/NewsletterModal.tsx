"use client";

import { useState } from "react";
import { useUi } from "@/lib/ui-context";

const NEWSLETTER_DISMISS_KEY = "sr-newsletter-dismissed";

function dismissNewsletter(setNewsletterOpen: (open: boolean) => void) {
  localStorage.setItem(NEWSLETTER_DISMISS_KEY, String(Date.now()));
  setNewsletterOpen(false);
}

export function NewsletterModal() {
  const { newsletterOpen, setNewsletterOpen } = useUi();
  const [email, setEmail] = useState("");
  const [women, setWomen] = useState(false);
  const [men, setMen] = useState(false);

  if (!newsletterOpen) return null;

  const close = () => dismissNewsletter(setNewsletterOpen);

  const canSubmit = email.includes("@") && (women || men);

  return (
    <>
      <div
        className="fixed inset-0 z-[88] bg-black/50"
        onClick={close}
        aria-hidden
      />
      <div
        role="dialog"
        aria-labelledby="nl-title"
        className="fixed left-1/2 top-1/2 z-[89] w-[min(92vw,520px)] -translate-x-1/2 -translate-y-1/2 bg-cl-white p-8 shadow-2xl md:p-10"
      >
        <button
          type="button"
          onClick={close}
          className="absolute right-4 top-4 flex h-8 w-8 items-center justify-center rounded-full border border-black text-lg"
          aria-label="Close newsletter subscription"
        >
          ×
        </button>
        <p className="text-[10px] text-cl-muted">All fields are required</p>
        <h2 id="nl-title" className="mt-2 font-serif text-3xl">
          Newsletter
        </h2>
        <p className="mt-4 text-[12px] leading-relaxed text-cl-muted">
          Sign up to receive the House&apos;s latest news, exclusive
          pre-launches, and new collection updates.
        </p>
        <label className="mt-6 block">
          <span className="text-[11px] text-cl-muted">Your email address</span>
          <input
            type="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            className="mt-2 w-full border-0 border-b border-black bg-transparent py-2 text-[14px] outline-none"
          />
        </label>
        <div className="mt-6 grid grid-cols-2 gap-4">
          <label className="flex items-center gap-2 text-[12px]">
            <input
              type="checkbox"
              checked={women}
              onChange={(e) => setWomen(e.target.checked)}
            />
            Women collection
          </label>
          <label className="flex items-center gap-2 text-[12px]">
            <input
              type="checkbox"
              checked={men}
              onChange={(e) => setMen(e.target.checked)}
            />
            Men collection
          </label>
        </div>
        <button
          type="button"
          disabled={!canSubmit}
          onClick={close}
          className="mt-8 w-full bg-[#333] py-4 text-[11px] uppercase tracking-[0.2em] text-white disabled:opacity-40"
        >
          Sign up
        </button>
      </div>
    </>
  );
}
