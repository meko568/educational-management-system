#!/bin/sh
set -e

echo "Starting application..."

# Use PORT from environment or default to 8080 (PandaStack default)
PORT=${PORT:-8080}
echo "Using PORT: ${PORT}"

# Replace ${PORT} in nginx config template with actual port
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf

# Create log directories if they don't exist
mkdir -p /var/log/nginx /var/log/php-fpm

# Test nginx configuration
nginx -t

echo "Starting supervisor..."
# Start supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
