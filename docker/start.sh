#!/bin/sh
set -e

# Use the PORT environment variable if provided by PandaStack, default to 8080
APP_PORT=${PORT:-8080}
echo "Configuring Nginx to listen on port $APP_PORT..."
sed -i "s/listen 8080; # This will be replaced by start.sh/listen ${APP_PORT};/g" /etc/nginx/nginx.conf

# Ensure storage and cache are writable
chmod -R 775 /var/www/storage /var/www/bootstrap/cache
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Generate APP_KEY if it's missing (preventing 500 errors on first boot)
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY is not set. Generating one for this session..."
    php artisan key:generate --force --show > /tmp/app_key
    export APP_KEY=$(cat /tmp/app_key)
fi

# Run migrations and optimizations in the background to prevent startup timeout
(
    sleep 10
    echo "Running background tasks..."
    php artisan migrate --force || echo "Migration failed, check your DB credentials."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
) &

echo "Starting supervisor (PHP-FPM and Nginx)..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
