# Savile Row Laravel Storefront

Laravel storefront converted from the original Next.js implementation. The app keeps the luxury storefront UI, product catalog, image/video assets, Blade routes, and localStorage demo cart.

## Stack

- Laravel 13 / PHP 8.3
- Blade views
- Vite + Tailwind CSS
- Static catalog data in `resources/data/catalog.json`
- Demo cart and checkout UI using browser localStorage

## Run locally

```powershell
cd C:\xampp\htdocs\SavileRow1
composer install
npm install
npm run build
php artisan serve
```

Open `http://127.0.0.1:8000`.

## Key Routes

- `/` homepage
- `/admin` admin dashboard
- `/collections/all/products`
- `/collections/{gender}/{category}`
- `/products/{slug}`
- `/cart`
- `/checkout`
- `/bespoke`
- `/appointments`
- `/boutique`
- `/market`
- `/policies/shipping`
- `/policies/returns`
- `/policies/faq`

## Notes

Checkout is a demo interface. Connect a payment provider such as Stripe or Adyen before accepting real orders.

## Admin Panel

Run migrations and seed the admin data:

```powershell
php artisan migrate --seed
```

Default admin login:

```text
URL: http://127.0.0.1:8000/admin
Email: admin@savilerow.test
Password: password
```

The admin module includes RBAC tables, product/catalog management, inventory, orders, customers, promotions, CMS, analytics, notifications, staff roles, settings, dark mode, and a responsive collapsible sidebar.
