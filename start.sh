#!/bin/bash
set -e

echo "Clearing configuration cache..."
php artisan config:clear

echo "Running migrations..."
php artisan migrate --force

echo "Seeding database..."
php artisan db:seed --force

echo "Starting server on port 3000..."
exec php artisan serve --host=0.0.0.0 --port=3000