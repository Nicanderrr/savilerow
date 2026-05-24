"use client";

import Link from "next/link";
import { MarketSelector } from "@/components/market/MarketSelector";
import { useUi } from "@/lib/ui-context";

const FOOTER = {
  help: [
    { label: "Contact us", href: "/policies/faq" },
    { label: "Returns & exchanges conditions", href: "/policies/returns" },
    { label: "Guest order tracking & returns", href: "/policies/returns" },
    { label: "Visit our boutique", href: "/boutique" },
    { label: "FAQ", href: "/policies/faq" },
  ],
  services: [
    { label: "Book an appointment", href: "/appointments" },
    { label: "Bespoke configurator", href: "/bespoke" },
    { label: "Product care", href: "/policies/shipping" },
  ],
  about: [{ label: "Work with us", href: "/policies/faq" }],
  legal: [
    { label: "Terms of sale", href: "/policies/shipping" },
    { label: "Terms of use", href: "/policies/faq" },
    { label: "Privacy policy", href: "/policies/faq" },
    { label: "Accessibility statement", href: "/policies/faq" },
    { label: "Sitemap", href: "/collections/all/products" },
  ],
};

const SOCIAL = [
  { label: "Instagram", href: "https://instagram.com" },
  { label: "TikTok", href: "https://tiktok.com" },
  { label: "Facebook", href: "https://facebook.com" },
  { label: "YouTube", href: "https://youtube.com" },
  { label: "Pinterest", href: "https://pinterest.com" },
  { label: "LinkedIn", href: "https://linkedin.com" },
];

export function Footer() {
  const { setA11yOpen } = useUi();

  return (
    <footer className="mt-auto bg-cl-black text-cl-white">
      <div className="mx-auto max-w-[1600px] px-6 py-16 md:px-10 md:py-20">
        <div className="grid gap-12 md:grid-cols-2 lg:grid-cols-5">
          <div className="lg:col-span-1">
            <p className="font-serif text-2xl">Savile Row</p>
            <p className="mt-4 max-w-xs text-[12px] leading-relaxed text-white/70">
              Bespoke tailoring and luxury ready-to-wear since 1849. Mayfair,
              London.
            </p>
          </div>
          <FooterColumn title="Help" links={FOOTER.help} />
          <FooterColumn title="Services" links={FOOTER.services} />
          <FooterColumn title="About" links={FOOTER.about} />
          <FooterColumn title="Legal" links={FOOTER.legal} />
        </div>

        <div className="mt-12 flex flex-wrap items-center gap-6 border-t border-white/20 pt-8">
          <MarketSelector variant="footer" />
          <ul className="flex flex-wrap gap-4">
            {SOCIAL.map((s) => (
              <li key={s.label}>
                <a
                  href={s.href}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="text-[11px] uppercase tracking-widest text-white/80 hover:text-white"
                  aria-label={`Follow Savile Row on ${s.label}`}
                >
                  {s.label}
                </a>
              </li>
            ))}
          </ul>
          <button
            type="button"
            onClick={() => setA11yOpen(true)}
            className="text-[11px] uppercase tracking-widest text-white/80 hover:text-white"
          >
            Accessibility
          </button>
        </div>

        <p className="mt-8 text-center text-[10px] text-white/50">
          © {new Date().getFullYear()} Savile Row. All rights reserved.
        </p>
      </div>
    </footer>
  );
}

function FooterColumn({
  title,
  links,
}: {
  title: string;
  links: { label: string; href: string }[];
}) {
  return (
    <div>
      <h3 className="text-label text-white">{title}</h3>
      <ul className="mt-4 space-y-2">
        {links.map((l) => (
          <li key={l.href + l.label}>
            <Link
              href={l.href}
              className="text-[12px] text-white/80 hover:text-white"
            >
              {l.label}
            </Link>
          </li>
        ))}
      </ul>
    </div>
  );
}
