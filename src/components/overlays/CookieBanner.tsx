"use client";

import { useUi } from "@/lib/ui-context";

export function CookieBanner() {
  const { cookieVisible, acceptCookies } = useUi();
  if (!cookieVisible) return null;

  return (
    <div className="fixed bottom-4 left-4 z-[85] max-w-md bg-cl-white p-6 shadow-2xl md:bottom-6 md:left-6">
      <p className="text-[11px] leading-relaxed text-black">
        We use cookies and similar technologies to improve your experience,
        analyse traffic, and personalise content. You can manage your preferences
        or accept all cookies.
      </p>
      <div className="mt-4 flex gap-3">
        <button type="button" className="btn-outline px-5 py-2 text-[10px]">
          Settings
        </button>
        <button
          type="button"
          onClick={acceptCookies}
          className="btn-red px-5 py-2 text-[10px]"
        >
          Accept all
        </button>
      </div>
    </div>
  );
}
