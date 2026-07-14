#!/bin/sh
set -e

echo "Starting application..."

# Log environment variables for debugging (without passwords)
echo "Environment check:"
echo "DB_HOST=${DB_HOST:-not set}"
echo "DB_PORT=${DB_PORT:-not set}"
echo "DB_DATABASE=${DB_DATABASE:-not set}"
echo "DB_USERNAME=${DB_USERNAME:-not set}"
echo "APP_ENV=${APP_ENV:-not set}"
echo "APP_DEBUG=${APP_DEBUG:-not set}"

# Create log directories if they don't exist
mkdir -p /var/log/nginx /var/log/php-fpm

echo "Starting supervisor..."
# Start supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
