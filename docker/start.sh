#!/bin/sh
set -e

# Map Clever Cloud MySQL addon vars -> Laravel DB_* vars
if [ -n "$MYSQL_ADDON_HOST" ]; then
    echo "Clever Cloud MySQL addon found. Mapping DB env vars..."
    export DB_CONNECTION=mysql
    export DB_HOST=$MYSQL_ADDON_HOST
    export DB_PORT=$MYSQL_ADDON_PORT
    export DB_DATABASE=$MYSQL_ADDON_DB
    export DB_USERNAME=$MYSQL_ADDON_USER
    export DB_PASSWORD=$MYSQL_ADDON_PASSWORD
fi

# Clever Cloud listens on CC_DOCKER_EXPOSED_HTTP_PORT (default 8080)
APP_PORT=${CC_DOCKER_EXPOSED_HTTP_PORT:-${PORT:-8080}}
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
