# Savile Row — Global Luxury E-Commerce

Custom React storefront (Next.js 15 App Router) for Savile Row bespoke tailoring and ready-to-wear. Inspired by luxury mobile-first patterns (editorial home, deep navigation, PLP filters, PDP gallery, global market selector) with Savile Row navy/gold/cream branding.

## Stack

- **Next.js 15** (App Router) + **TypeScript**
- **Tailwind CSS v4**
- Mock catalog (no Shopify Storefront)
- Client cart + market state (`localStorage`)

## Quick start

```bash
cd C:\Users\leopold\Projects\savile-row
npm install
npm run dev
```

Open [http://localhost:3000](http://localhost:3000).

```bash
npm run build   # production build
npm run start   # serve production build
```

Optional admin mock: copy `.env.example` to `.env.local`, set `ENABLE_ADMIN=true`, visit `/admin`.

## Architecture

```
src/
  app/                    # Routes (RSC + client pages)
  components/             # UI by domain (layout, commerce, plp, bespoke…)
  lib/
    catalog.ts            # Mock products + nav tree
    markets.ts            # US, UK, EU, UAE, AU
    types.ts              # Product, variant, cart, market types
    cart-context.tsx      # Bag state
    market-context.tsx    # Currency / VAT display
```

### Key routes

| Path | Purpose |
|------|---------|
| `/` | Editorial homepage |
| `/collections/[gender]/[category]` | PLP with refine drawer |
| `/products/[slug]` | PDP — swipe gallery, variants, sticky mobile ATC |
| `/cart`, `/checkout` | Bag + checkout UI (payment placeholders) |
| `/bespoke` | Multi-step suit configurator |
| `/appointments` | Fitting / trunk show / virtual booking |
| `/market` | Global market selector |
| `/policies/*` | Shipping, returns, FAQ |

### Global commerce

Markets in `src/lib/markets.ts`: currency, VAT-inclusive flags, shipping copy. Prices converted from USD base via `src/lib/format.ts`.

### Mobile UX

- Hamburger menu with slide-over submenus (`MobileMenu`)
- PLP refine bottom sheet (`FilterDrawer`)
- PDP sticky add-to-bag bar on small screens

### Headless admin

See [docs/admin.md](docs/admin.md). Enable mock admin with `ENABLE_ADMIN=true`.

## Node version

Node **20+** recommended (Tailwind v4 / ESLint warn on Node 18).

## License

Private scaffold — not affiliated with any real Savile Row house.
