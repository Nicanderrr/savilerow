"use client";

import Link from "next/link";
import { useState } from "react";
import { MarketSelector } from "@/components/market/MarketSelector";
import { useUi } from "@/lib/ui-context";

const FOOTER_SECTIONS = [
  {
    id: "help",
    title: "Help",
    links: [
      { label: "Contact us", href: "/policies/faq" },
      { label: "Returns & exchanges", href: "/policies/returns" },
      { label: "Order tracking", href: "/policies/returns" },
      { label: "Visit our boutique", href: "/boutique" },
      { label: "FAQ", href: "/policies/faq" },
    ],
  },
  {
    id: "services",
    title: "Services",
    links: [
      { label: "Book an appointment", href: "/appointments" },
      { label: "Bespoke configurator", href: "/bespoke" },
      { label: "Product care", href: "/policies/shipping" },
    ],
  },
  {
    id: "about",
    title: "About",
    links: [{ label: "Work with us", href: "/policies/faq" }],
  },
  {
    id: "legal",
    title: "Legal",
    links: [
      { label: "Terms of sale", href: "/policies/shipping" },
      { label: "Terms of use", href: "/policies/faq" },
      { label: "Privacy policy", href: "/policies/faq" },
      { label: "Accessibility", href: "/policies/faq" },
      { label: "Sitemap", href: "/collections/all/products" },
    ],
  },
];

const SOCIAL = [
  { label: "Instagram", href: "https://instagram.com" },
  { label: "TikTok", href: "https://tiktok.com" },
  { label: "Facebook", href: "https://facebook.com" },
  { label: "YouTube", href: "https://youtube.com" },
];

export function Footer() {
  const { setA11yOpen } = useUi();
  const [openId, setOpenId] = useState<string | null>(null);

  const toggle = (id: string) => {
    setOpenId((prev) => (prev === id ? null : id));
  };

  return (
    <footer className="mt-auto bg-cl-black text-cl-white">
      <div className="mx-auto max-w-[1600px] px-6 py-10 md:py-12">
        <div className="border-b border-white/15 pb-8">
          <p className="font-serif text-2xl">Savile Row</p>
          <p className="mt-3 max-w-sm text-[12px] leading-relaxed text-white/65">
            Bespoke tailoring and luxury ready-to-wear since 1849. Mayfair, London.
          </p>
        </div>

        <nav className="divide-y divide-white/15" aria-label="Footer">
          {FOOTER_SECTIONS.map((section) => (
            <div key={section.id}>
              <button
                type="button"
                onClick={() => toggle(section.id)}
                className="flex w-full items-center justify-between py-4 text-left"
                aria-expanded={openId === section.id}
              >
                <span className="text-label text-white">{section.title}</span>
                <span className="text-lg text-white/60" aria-hidden>
                  {openId === section.id ? "−" : "+"}
                </span>
              </button>
              <ul
                className={`space-y-2 overflow-hidden pb-4 ${
                  openId === section.id ? "block" : "hidden"
                }`}
              >
                {section.links.map((l) => (
                  <li key={l.href + l.label}>
                    <Link
                      href={l.href}
                      className="text-[12px] text-white/75 hover:text-white"
                    >
                      {l.label}
                    </Link>
                  </li>
                ))}
              </ul>
            </div>
          ))}
        </nav>

        <div className="mt-8 flex flex-wrap items-center gap-4 border-t border-white/15 pt-6">
          <MarketSelector variant="footer" />
          <ul className="flex flex-wrap gap-3">
            {SOCIAL.map((s) => (
              <li key={s.label}>
                <a
                  href={s.href}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="text-[10px] uppercase tracking-widest text-white/70 hover:text-white"
                >
                  {s.label}
                </a>
              </li>
            ))}
          </ul>
          <button
            type="button"
            onClick={() => setA11yOpen(true)}
            className="text-[10px] uppercase tracking-widest text-white/70 hover:text-white"
          >
            Accessibility
          </button>
        </div>

        <p className="mt-6 text-center text-[10px] text-white/45">
          © {new Date().getFullYear()} Savile Row. All rights reserved.
        </p>
      </div>
    </footer>
  );
}
