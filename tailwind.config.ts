import type { Config } from "tailwindcss";

const config: Config = {
  content: [
    "./src/pages/**/*.{js,ts,jsx,tsx,mdx}",
    "./src/components/**/*.{js,ts,jsx,tsx,mdx}",
    "./src/app/**/*.{js,ts,jsx,tsx,mdx}",
  ],
  theme: {
    extend: {
      colors: {
        "cl-black": "#000000",
        "cl-white": "#ffffff",
        "cl-red": "#ce0e2d",
        "cl-gray": "#f5f5f5",
        "cl-gray-mid": "#e5e5e5",
        "cl-muted": "#666666",
        "sr-navy": "#000000",
        "sr-cream": "#ffffff",
        "sr-cream-dark": "#e5e5e5",
        "sr-gold": "#ce0e2d",
        "sr-ink": "#000000",
      },
      fontFamily: {
        serif: ["var(--font-serif)", "Didot", "Bodoni MT", "Georgia", "serif"],
        sans: [
          "var(--font-sans)",
          "Helvetica Neue",
          "Helvetica",
          "Arial",
          "sans-serif",
        ],
      },
      spacing: {
        "header-promo": "var(--header-promo-h)",
        "header-main": "var(--header-main-h)",
        "header-total": "var(--header-total)",
      },
      transitionDuration: {
        menu: "320ms",
      },
      keyframes: {
        "slide-in-left": {
          from: { transform: "translateX(-100%)" },
          to: { transform: "translateX(0)" },
        },
        "slide-in-right": {
          from: { transform: "translateX(100%)" },
          to: { transform: "translateX(0)" },
        },
        "fade-in": {
          from: { opacity: "0" },
          to: { opacity: "1" },
        },
      },
      animation: {
        "slide-in-left": "slide-in-left 320ms ease-out forwards",
        "slide-in-right": "slide-in-right 320ms ease-out forwards",
        "fade-in": "fade-in 240ms ease-out forwards",
      },
    },
  },
  plugins: [],
};

export default config;
