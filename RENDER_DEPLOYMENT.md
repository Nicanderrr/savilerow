# Render Deployment Guide

This project is prepared for Render using Docker.

## 1. Push Code

Push this repository to GitHub, then create a new Render web service from that repository.

## 2. Render Service

Use:

- Environment: `Docker`
- Dockerfile path: `./Dockerfile`
- Health check path: `/up`

The included `render.yaml` can also be used as a blueprint.

## 3. Database

For a demo, create a managed MySQL database somewhere Render can reach.

Set these environment variables in Render:

```env
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password
```

Do not use local SQLite for a hosted Render demo.

## 4. Required Environment Variables

Set these in Render:

```env
APP_NAME=Savile Row
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your-existing-app-key
APP_URL=https://your-render-url.onrender.com

LOG_CHANNEL=stderr
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local

PAYSTACK_PUBLIC_KEY=your-public-key
PAYSTACK_SECRET_KEY=your-secret-key
PAYSTACK_CURRENCY=NGN
PAYSTACK_PAYMENT_URL=https://api.paystack.co
RUN_RENDER_SEEDER=false
```

Use your current local `APP_KEY`; do not regenerate it after users/orders exist.

## 5. Paystack Callback

In Paystack, set the callback URL to:

```txt
https://your-render-url.onrender.com/checkout/paystack/callback
```

## 6. Demo Limitations

Render free services may sleep.

Uploaded images/videos stored on local disk may not persist across rebuilds. For production, move uploads to S3, Cloudinary, or DigitalOcean Spaces.

Traffic logs and analytics require the database to remain available.

## 7. Admin Login

After the first deploy and migration/seed, use:

```txt
admin@mail.com
password
```

If the admin user is missing, either temporarily set:

```env
RUN_RENDER_SEEDER=true
```

Deploy once, then set it back to:

```env
RUN_RENDER_SEEDER=false
```

Or run the seeder once from a shell:

```bash
php artisan db:seed --force
```

