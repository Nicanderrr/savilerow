import type { Market, MarketCode } from "./types";

export const MARKETS: Record<MarketCode, Market> = {
  US: {
    code: "US",
    country: "United States",
    currency: "USD",
    currencySymbol: "$",
    locale: "en-US",
    language: "English",
    vatInclusive: false,
    vatRate: 0,
    shippingNote: "Duties may apply on orders over $800.",
  },
  UK: {
    code: "UK",
    country: "United Kingdom",
    currency: "GBP",
    currencySymbol: "£",
    locale: "en-GB",
    language: "English",
    vatInclusive: true,
    vatRate: 0.2,
    shippingNote: "Prices include VAT. Complimentary UK delivery over £500.",
  },
  EU: {
    code: "EU",
    country: "European Union",
    currency: "EUR",
    currencySymbol: "€",
    locale: "en-EU",
    language: "English",
    vatInclusive: true,
    vatRate: 0.2,
    shippingNote: "Prices include VAT. Express EU delivery 2–4 business days.",
  },
  UAE: {
    code: "UAE",
    country: "United Arab Emirates",
    currency: "AED",
    currencySymbol: "د.إ",
    locale: "en-AE",
    language: "English",
    vatInclusive: true,
    vatRate: 0.05,
    shippingNote: "VAT included. White-glove delivery in Dubai & Abu Dhabi.",
  },
  AU: {
    code: "AU",
    country: "Australia",
    currency: "AUD",
    currencySymbol: "A$",
    locale: "en-AU",
    language: "English",
    vatInclusive: true,
    vatRate: 0.1,
    shippingNote: "GST included. International orders may incur duties.",
  },
};

export const MARKET_LIST = Object.values(MARKETS);

export const FX_TO_USD: Record<string, number> = {
  USD: 1,
  GBP: 0.79,
  EUR: 0.92,
  AED: 3.67,
  AUD: 1.52,
};
