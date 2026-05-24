"use client";

import { AccessibilityDrawer } from "@/components/overlays/AccessibilityDrawer";
import { BagDrawer } from "@/components/overlays/BagDrawer";
import { CookieBanner } from "@/components/overlays/CookieBanner";
import { GeoModal } from "@/components/overlays/GeoModal";
import { NewsletterModal } from "@/components/overlays/NewsletterModal";
import { SearchOverlay } from "@/components/overlays/SearchOverlay";

export function SiteChrome() {
  return (
    <>
      <SearchOverlay />
      <BagDrawer />
      <GeoModal />
      <NewsletterModal />
      <CookieBanner />
      <AccessibilityDrawer />
    </>
  );
}
