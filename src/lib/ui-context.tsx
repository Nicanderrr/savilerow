"use client";

import {
  createContext,
  useCallback,
  useContext,
  useEffect,
  useMemo,
  useState,
} from "react";

type UiContextValue = {
  menuOpen: boolean;
  setMenuOpen: (open: boolean) => void;
  searchOpen: boolean;
  setSearchOpen: (open: boolean) => void;
  bagOpen: boolean;
  setBagOpen: (open: boolean) => void;
  promoVisible: boolean;
  dismissPromo: () => void;
  heroLight: boolean;
  setHeroLight: (light: boolean) => void;
  geoOpen: boolean;
  setGeoOpen: (open: boolean) => void;
  newsletterOpen: boolean;
  setNewsletterOpen: (open: boolean) => void;
  cookieVisible: boolean;
  acceptCookies: () => void;
  a11yOpen: boolean;
  setA11yOpen: (open: boolean) => void;
  reduceMotion: boolean;
  setReduceMotion: (v: boolean) => void;
  highContrast: boolean;
  setHighContrast: (v: boolean) => void;
};

const UiContext = createContext<UiContextValue | null>(null);

export function UiProvider({ children }: { children: React.ReactNode }) {
  const [menuOpen, setMenuOpen] = useState(false);
  const [searchOpen, setSearchOpen] = useState(false);
  const [bagOpen, setBagOpen] = useState(false);
  const [promoVisible, setPromoVisible] = useState(true);
  const [heroLight, setHeroLight] = useState(true);
  const [geoOpen, setGeoOpen] = useState(false);
  const [newsletterOpen, setNewsletterOpen] = useState(false);
  const [cookieVisible, setCookieVisible] = useState(false);
  const [a11yOpen, setA11yOpen] = useState(false);
  const [reduceMotion, setReduceMotion] = useState(false);
  const [highContrast, setHighContrast] = useState(false);

  useEffect(() => {
    if (typeof window === "undefined") return;
    setPromoVisible(localStorage.getItem("sr-promo-dismissed") !== "1");
    setCookieVisible(localStorage.getItem("sr-cookies") !== "accepted");
    const geoDismissed = sessionStorage.getItem("sr-geo-dismissed");
    if (!geoDismissed) setGeoOpen(true);
    const NEWSLETTER_KEY = "sr-newsletter-dismissed";
    const WEEK_MS = 7 * 24 * 60 * 60 * 1000;
    const dismissedAt = localStorage.getItem(NEWSLETTER_KEY);
    const recentlyDismissed =
      dismissedAt && Date.now() - Number(dismissedAt) < WEEK_MS;
    if (recentlyDismissed) return;

    const nlTimer = setTimeout(() => setNewsletterOpen(true), 8000);
    return () => clearTimeout(nlTimer);
  }, []);

  useEffect(() => {
    document.body.style.overflow =
      menuOpen || searchOpen || bagOpen || geoOpen || newsletterOpen || a11yOpen
        ? "hidden"
        : "";
    return () => {
      document.body.style.overflow = "";
    };
  }, [menuOpen, searchOpen, bagOpen, geoOpen, newsletterOpen, a11yOpen]);

  useEffect(() => {
    document.documentElement.classList.toggle("reduce-motion", reduceMotion);
    document.documentElement.classList.toggle("high-contrast", highContrast);
  }, [reduceMotion, highContrast]);

  const dismissPromo = useCallback(() => {
    setPromoVisible(false);
    localStorage.setItem("sr-promo-dismissed", "1");
  }, []);

  const acceptCookies = useCallback(() => {
    setCookieVisible(false);
    localStorage.setItem("sr-cookies", "accepted");
  }, []);

  const value = useMemo(
    () => ({
      menuOpen,
      setMenuOpen,
      searchOpen,
      setSearchOpen,
      bagOpen,
      setBagOpen,
      promoVisible,
      dismissPromo,
      heroLight,
      setHeroLight,
      geoOpen,
      setGeoOpen,
      newsletterOpen,
      setNewsletterOpen,
      cookieVisible,
      acceptCookies,
      a11yOpen,
      setA11yOpen,
      reduceMotion,
      setReduceMotion,
      highContrast,
      setHighContrast,
    }),
    [
      menuOpen,
      searchOpen,
      bagOpen,
      promoVisible,
      dismissPromo,
      heroLight,
      geoOpen,
      newsletterOpen,
      cookieVisible,
      acceptCookies,
      a11yOpen,
      reduceMotion,
      highContrast,
    ]
  );

  return <UiContext.Provider value={value}>{children}</UiContext.Provider>;
}

export function useUi() {
  const ctx = useContext(UiContext);
  if (!ctx) throw new Error("useUi must be used within UiProvider");
  return ctx;
}
