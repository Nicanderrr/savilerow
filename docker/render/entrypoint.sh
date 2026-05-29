#!/usr/bin/env bash
set -e

if [ -n "$RENDER_EXTERNAL_URL" ] && [ -z "$APP_URL" ]; then
  export APP_URL="$RENDER_EXTERNAL_URL"
fi

# Render containers can create files as root during boot commands.
# Ensure Laravel writable paths stay writable for apache/www-data.
mkdir -p storage/logs storage/framework/{cache,sessions,views} bootstrap/cache database
chown -R www-data:www-data storage bootstrap/cache database || true
chmod -R ug+rwx storage bootstrap/cache database || true

# Prefer stderr on hosted containers unless explicitly overridden.
if [ -z "$LOG_CHANNEL" ]; then
  export LOG_CHANNEL=stderr
fi

# For sqlite demo mode, create database file if missing.
if [ "$DB_CONNECTION" = "sqlite" ] && [ -n "$DB_DATABASE" ]; then
  touch "$DB_DATABASE" || true
  chown www-data:www-data "$DB_DATABASE" || true
  chmod ug+rw "$DB_DATABASE" || true
fi

php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

php artisan storage:link || true
php artisan migrate --force || true

if [ "$RUN_RENDER_SEEDER" = "true" ]; then
  php artisan db:seed --force || true
fi

php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

exec "$@"
