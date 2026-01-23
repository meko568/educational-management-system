#!/bin/sh
set -e

echo "=== Application Starting ==="
echo "Clearing config cache..."
php artisan config:clear

echo "Running migrations..."
php artisan migrate --force

echo "Running seeders..."
php artisan db:seed --class=DatabaseSeeder || echo "Seeder warning - continuing..."

echo "Starting Laravel development server..."
echo "Server will be available on port 3000"
exec php artisan serve --host=0.0.0.0 --port=3000