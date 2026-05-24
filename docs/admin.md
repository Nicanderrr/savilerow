# Headless admin integration

The Savile Row storefront uses a **mock JSON catalog** (`src/lib/catalog.ts`) for day-one development. A future headless CMS should become the source of truth for products, markets, and editorial content.

## Recommended CMS options

| CMS | Strengths for Savile Row |
|-----|--------------------------|
| **Sanity** | Real-time preview, portable text for editorial homepage, strong variant modeling |
| **Strapi** | Self-hosted option, REST/GraphQL, role-based admin for merchandising |
| **Custom** | Full control over bespoke configurator schemas and appointment metadata |

## Data model sync

Map CMS documents to `Product` in `src/lib/types.ts`:

- `slug`, `name`, `description`, `gender`, `category`
- `images[]` (CDN URLs)
- `variants[]` with `size`, `color`, `material`, `volumeMl`, `priceModifier`, `inStock`
- `tags`, `isNew`, `isBespokeEligible`

Markets (`Market` type) can live in CMS globals or environment config with per-locale overrides.

## Sync patterns

1. **Build-time (SSG/ISR)** — `fetch` all products at build; revalidate on webhook (`revalidatePath` / `revalidateTag`).
2. **Runtime** — Server Components fetch from CMS API with edge caching.
3. **Webhooks** — Sanity `document.published` → Next.js `/api/revalidate` route.

## Mock admin UI

Set `ENABLE_ADMIN=true` in `.env.local` to open `/admin`. This panel demonstrates inline edit UX only; changes are not persisted.

## Bespoke & appointments

- **Bespoke configurator** — Store selections as draft orders or CRM leads; optional Sanity object type `bespokeConfiguration`.
- **Appointments** — Replace `#calendar-integration-hook` in `AppointmentForm` with Booxi or Calendly embed; POST form fallback to Klaviyo/HubSpot.

## Media

Use Shopify CDN, Cloudinary, or Sanity image pipeline. Update `next.config.ts` `images.remotePatterns` for new hostnames.
