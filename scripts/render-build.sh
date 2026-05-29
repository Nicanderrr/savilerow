#!/usr/bin/env bash
set -e

composer install --no-dev --optimize-autoloader
npm ci
npm run build

php artisan config:clear
php artisan route:clear
php artisan view:clear

php artisan storage:link || true
php artisan migrate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache
