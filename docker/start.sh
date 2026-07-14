#!/bin/sh
set -e

echo "Starting application..."

# Create log directories if they don't exist
mkdir -p /var/log/nginx /var/log/php-fpm

echo "Starting supervisor..."
# Start supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
