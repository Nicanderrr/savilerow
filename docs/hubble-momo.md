# Hubble Momo integration

Savile Row checkout includes a **Momo / Mobile Money** payment option powered by a Hubble Momo integration seam. In development, payments run in **sandbox mock** mode when API credentials are not set.

## Environment variables

| Variable | Required | Description |
|----------|----------|-------------|
| `HUBBLE_MOMO_API_KEY` | Production | API bearer token from Hubble |
| `HUBBLE_MOMO_MERCHANT_ID` | Production | Merchant identifier |
| `HUBBLE_MOMO_ENV` | No | `sandbox` (default) or `production` |

Add these to `.env.local` for local development:

```env
HUBBLE_MOMO_API_KEY=
HUBBLE_MOMO_MERCHANT_ID=
HUBBLE_MOMO_ENV=sandbox
```

When `HUBBLE_MOMO_API_KEY` and `HUBBLE_MOMO_MERCHANT_ID` are empty, the app uses the sandbox mock (logs intent server-side, shows “Complete payment on your phone” UI with a deep-link placeholder).

## Architecture

- **`src/lib/hubble-momo.ts`** — `initMomoPayment`, `getMomoPaymentStatus`, config helpers
- **`POST /api/momo/init`** — Checkout calls this to create a session (safe for client; no secret in browser)
- **`src/components/checkout/PaymentMethods.tsx`** — Momo radio option, phone field, QR/deep-link placeholder UI

## Checkout flow

1. Customer selects **Momo / Mobile Money** at checkout.
2. Client POSTs `{ amount, currency, orderId, customerPhone? }` to `/api/momo/init`.
3. Server returns `{ sessionId, deepLink?, message, expiresAt, status }`.
4. UI shows QR placeholder and “Complete payment on your phone” with optional **Open Momo app** link.
5. Poll or webhook (production) should call `getMomoPaymentStatus(sessionId)` before fulfilling the order.

## Production wiring

1. Obtain Hubble Momo sandbox/production credentials from Hubble.
2. Set all three env vars on your host (Render, Vercel, etc.).
3. Confirm the live API base URLs in `hubble-momo.ts` match Hubble’s current docs.
4. Replace the QR placeholder with the `qrCodeUrl` returned by the API when available.
5. Add a webhook route for payment confirmation before marking orders paid.

## Testing locally

```bash
npm run dev
```

1. Add items to bag → Checkout.
2. Select **Momo / Mobile Money**.
3. Confirm sandbox UI appears and check the terminal for `[Hubble Momo sandbox]` log output.

```bash
npm run build
```

Ensures API route and types compile for production.
