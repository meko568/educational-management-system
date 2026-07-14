FROM php:8.2-fpm-alpine

# Install system packages (including gettext for envsubst)
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    oniguruma-dev \
    libzip-dev \
    gettext

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files
COPY composer.json composer.lock ./

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy application files
COPY . /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Copy your nginx config to a template location
COPY docker/nginx.conf /etc/nginx/nginx.conf.template

# Copy supervisor configuration (Make sure you have this file!)
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose dynamic port fallback
EXPOSE 80

# 1. Replace ${PORT} inside nginx.conf.template with the actual port provided by PandaStack
# 2. Start Supervisor to manage both PHP-FPM and Nginx
CMD ["sh", "-c", "envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf && /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf"]