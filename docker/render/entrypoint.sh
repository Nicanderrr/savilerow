#!/usr/bin/env bash
set -e

if [ -n "$RENDER_EXTERNAL_URL" ]; then
  export APP_URL="$RENDER_EXTERNAL_URL"
fi

if [ -n "$RENDER_EXTERNAL_HOSTNAME" ]; then
  export APP_URL="https://$RENDER_EXTERNAL_HOSTNAME"
fi

# Render-safe defaults for demo deployments.
if [ -n "$RENDER_EXTERNAL_URL" ]; then
  export LOG_CHANNEL=stderr
  export SESSION_DRIVER="${SESSION_DRIVER:-file}"
  export CACHE_STORE="${CACHE_STORE:-file}"
  export QUEUE_CONNECTION="${QUEUE_CONNECTION:-sync}"
fi

# If MySQL is left on localhost in Render, auto-fallback to sqlite demo mode.
if [ -n "$RENDER_EXTERNAL_URL" ] && [ "$DB_CONNECTION" = "mysql" ] && { [ -z "$DB_HOST" ] || [ "$DB_HOST" = "127.0.0.1" ] || [ "$DB_HOST" = "localhost" ]; }; then
  export DB_CONNECTION=sqlite
  export DB_DATABASE=/var/www/html/database/database.sqlite
fi

# Render containers can create files as root during boot commands.
# Ensure Laravel writable paths stay writable for apache/www-data.
mkdir -p storage/logs storage/framework/{cache,sessions,views} bootstrap/cache database
chown -R www-data:www-data storage bootstrap/cache database || true
chmod -R ug+rwx storage bootstrap/cache database || true

# For sqlite demo mode, create database file if missing.
if [ "$DB_CONNECTION" = "sqlite" ] && [ -n "$DB_DATABASE" ]; then
  touch "$DB_DATABASE" || true
  chown www-data:www-data "$DB_DATABASE" || true
  chmod ug+rw "$DB_DATABASE" || true
fi

php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
rm -f public/hot || true

php artisan storage:link || true
php artisan migrate --force || true
php artisan app:ensure-default-admin || true
php artisan app:purge-demo-catalog || true

if [ "$RUN_RENDER_SEEDER" = "true" ]; then
  php artisan db:seed --force || true
fi

php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

exec "$@"
