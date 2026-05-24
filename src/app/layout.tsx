import type { Metadata } from "next";
import { Inter, Playfair_Display } from "next/font/google";
import { AppProviders } from "@/components/providers/AppProviders";
import { Footer } from "@/components/layout/Footer";
import { Header } from "@/components/layout/Header";
import { SiteChrome } from "@/components/layout/SiteChrome";
import { SkipLink } from "@/components/layout/SkipLink";
import "./globals.css";

const inter = Inter({
  variable: "--font-sans",
  subsets: ["latin"],
  weight: ["300", "400", "500"],
});

const playfair = Playfair_Display({
  variable: "--font-serif",
  subsets: ["latin"],
  weight: ["400", "500", "600"],
});

export const metadata: Metadata = {
  title: {
    default: "Savile Row — Official Website | Luxury tailoring & leather goods",
    template: "%s | Savile Row",
  },
  description:
    "Global luxury e-commerce for bespoke suits, ready-to-wear, shoes, bags, perfumes, and accessories. Mayfair since 1849.",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en">
      <body
        className={`${inter.variable} ${playfair.variable} flex min-h-screen flex-col font-sans antialiased`}
      >
        <AppProviders>
          <SkipLink />
          <Header />
          {children}
          <Footer />
          <SiteChrome />
        </AppProviders>
      </body>
    </html>
  );
}
