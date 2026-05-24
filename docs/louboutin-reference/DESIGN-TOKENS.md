# Louboutin UX Reference (live capture May 2026)

## Colors
- **Black**: `#000000` — text, footer, editorial sections
- **White**: `#FFFFFF` — backgrounds, menu panel, cards
- **Louboutin red**: `#CE0E2D` — primary CTAs (ACCEPT ALL, REFINE button, accents)
- **Muted text**: `#666666` / `rgba(0,0,0,0.6)`

## Typography
- **Serif (editorial)**: Didot-like high-contrast serif — hero titles ("FALL 2026"), PLP H1
- **Sans (UI)**: Helvetica Neue / Arial — MENU, nav, buttons, body (11–13px, uppercase labels with wide tracking ~0.15–0.25em)
- **Hero label**: 11px uppercase sans, letter-spacing wide
- **Hero title**: 48–72px serif uppercase

## Header
- **Promo bar**: ~32px, white bg, centered 11px text, underline link, X close
- **Main bar**: transparent over hero (white icons/text) → solid white on scroll
- **Height**: ~80px main + promo = ~112–144px total
- **Left**: hamburger + "MENU" (desktop); mobile: hamburger + search only
- **Center**: script/wordmark logo
- **Right**: Search, Account, Wishlist (counter), Bag (counter)

## Mobile menu
- **Slide**: full-height panel from **left**, white bg, black text
- **Width**: 100% mobile
- **Items**: accordion with `>` chevron; sentence case labels
- **Footer links**: Visit boutique, Book appointment, Contact (no chevron)
- **Divider**: thin gray line before service links

## Homepage
- Full-viewport **video hero** with pause + mute controls (bottom-left area)
- "New collection" + large serif title + ghost "DISCOVER" button (white border)
- Editorial blocks: image + "Discover" CTA
- Horizontal product name carousel
- Black editorial sections with white text
- Newsletter modal overlay

## PLP
- Centered serif page title + narrow description
- **REFINE** pill button (red bg, white text, filter icon) — opens right slide-over
- Grid / List toggle + result count
- Product cards: image carousel, wishlist heart, compare icon, name, "As low as $X", color dots

## PDP
- Large image gallery (swipe)
- Minimal product copy
- Size selector grid
- Sticky bottom ATC bar on mobile

## Footer
- Black background, white text
- Columns: HELP, SERVICES, ABOUT, LEGAL
- Market selector: `Country ($) — Language`
- Social icons row
- Accessibility link

## Modals / overlays
- **Geo**: "It appears you are located in..." + two buttons (stay / switch)
- **Cookie**: white box, SETTINGS outline + ACCEPT ALL red
- **Accessibility drawer**: Reduce animations / Improve contrast toggles

## Animations
- Menu: `transform translateX` ~300ms ease
- Overlays: fade backdrop
- Transitions: 200–400ms ease-out
