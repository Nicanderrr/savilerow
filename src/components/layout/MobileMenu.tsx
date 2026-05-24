"use client";

import Image from "next/image";
import Link from "next/link";
import { useState } from "react";
import { IconChevronRight } from "@/components/icons/LouboutinIcons";
import { MENU_PROMOS, NAV_TREE } from "@/lib/catalog";
import { useUi } from "@/lib/ui-context";

export function MobileMenu() {
  const { menuOpen, setMenuOpen } = useUi();
  const [activePanel, setActivePanel] = useState<string | null>(null);
  const [subPanel, setSubPanel] = useState<string | null>(null);

  const close = () => {
    setMenuOpen(false);
    setActivePanel(null);
    setSubPanel(null);
  };

  const activeItem = NAV_TREE.find((n) => n.label === activePanel);

  return (
    <>
      {menuOpen && (
        <div
          className="fixed inset-0 z-50 bg-black/40 animate-fade-in motion-reduce:animate-none"
          aria-hidden
          onClick={close}
        />
      )}

      <nav
        className={`fixed left-0 top-0 z-[60] flex h-full w-full max-w-[480px] flex-col bg-cl-white shadow-2xl transition-transform duration-menu ease-out motion-reduce:transition-none lg:max-w-[420px] ${
          menuOpen ? "translate-x-0" : "-translate-x-full"
        }`}
        aria-label="Main navigation"
        aria-hidden={!menuOpen}
      >
        <div className="flex items-center justify-between px-6 py-5">
          {activePanel ? (
            <button
              type="button"
              onClick={() => {
                if (subPanel) setSubPanel(null);
                else setActivePanel(null);
              }}
              className="text-[13px] text-black"
            >
              ← Back
            </button>
          ) : (
            <span className="w-8" />
          )}
          <button
            type="button"
            onClick={close}
            className="text-2xl leading-none text-black"
            aria-label="Close menu"
          >
            ×
          </button>
        </div>

        <div className="flex-1 overflow-y-auto px-6 pb-8">
          {!activePanel ? (
            <ul>
              {NAV_TREE.map((item) => (
                <li key={item.label} className="border-b border-cl-gray-mid/60">
                  {item.children ? (
                    <button
                      type="button"
                      onClick={() => setActivePanel(item.label)}
                      className="flex w-full items-center justify-between py-4 text-left text-[15px] text-black"
                    >
                      {item.label}
                      <IconChevronRight />
                    </button>
                  ) : (
                    <Link
                      href={item.href ?? "/"}
                      className="flex py-4 text-[15px] text-black"
                      onClick={close}
                    >
                      {item.label}
                    </Link>
                  )}
                </li>
              ))}
            </ul>
          ) : (
            <div>
              <p className="mb-4 text-label text-cl-muted">{activePanel}</p>
              <ul>
                {activeItem?.children?.map((child) => (
                  <li key={child.href}>
                    <Link
                      href={child.href}
                      className="block border-b border-cl-gray-mid/40 py-3.5 text-[14px] text-black hover:opacity-70"
                      onClick={close}
                    >
                      {child.label}
                    </Link>
                  </li>
                ))}
              </ul>
              {MENU_PROMOS[activePanel] && (
                <Link
                  href={MENU_PROMOS[activePanel].href}
                  className="mt-8 block"
                  onClick={close}
                >
                  <div className="relative aspect-[4/3] overflow-hidden bg-cl-gray">
                    <Image
                      src={MENU_PROMOS[activePanel].image}
                      alt=""
                      fill
                      className="object-cover"
                      sizes="400px"
                    />
                  </div>
                  <span className="mt-3 inline-block text-label underline-offset-4 hover:underline">
                    Discover
                  </span>
                </Link>
              )}
            </div>
          )}
        </div>

        <div className="border-t border-cl-gray-mid px-6 py-6">
          <ul className="space-y-3 text-[14px] text-black">
            <li>
              <Link href="/boutique" onClick={close}>
                Visit our boutique
              </Link>
            </li>
            <li>
              <Link href="/appointments" onClick={close}>
                Book an appointment
              </Link>
            </li>
            <li>
              <Link href="/policies/faq" onClick={close}>
                Contact us
              </Link>
            </li>
          </ul>
          <button
            type="button"
            onClick={() => {
              close();
              document.getElementById("a11y-trigger")?.click();
            }}
            className="mt-6 text-[12px] text-cl-muted underline-offset-2 hover:underline"
          >
            Accessibility
          </button>
        </div>
      </nav>
    </>
  );
}
