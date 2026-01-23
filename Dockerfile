FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    nginx

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader --no-scripts

# Copy application
COPY . /var/www

# Generate storage link
RUN php artisan storage:link || true

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Create start script
RUN echo '#!/bin/bash\n\
set -e\n\
echo "Starting application..."\n\
php artisan package:discover --ansi\n\
echo "Running migrations..."\n\
php artisan migrate --force\n\
echo "Running seeders..."\n\
php artisan db:seed --force || true\n\
echo "Clearing caches..."\n\
php artisan config:clear\n\
php artisan cache:clear\n\
php artisan view:clear\n\
echo "Starting server on port ${PORT:-3000}..."\n\
php artisan serve --host=0.0.0.0 --port=${PORT:-3000}\n\
' > /var/www/start.sh && chmod +x /var/www/start.sh

# Expose port
EXPOSE ${PORT:-3000}

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=40s \
  CMD curl -f http://localhost:${PORT:-3000}/ || exit 1

CMD ["/var/www/start.sh"]