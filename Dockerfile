FROM php:8.2-fpm-alpine

# Install system packages (including gettext for envsubst and wget for healthcheck)
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    wget \
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

# Copy startup script
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Expose dynamic port (PandaStack will set PORT env var)
EXPOSE 8080

# Healthcheck - verify nginx is responding
HEALTHCHECK --interval=30s --timeout=10s --start-period=40s --retries=3 \
    CMD wget --no-verbose --tries=1 --spider http://localhost:${PORT:-8080} || exit 1

# Start application using startup script
CMD ["/usr/local/bin/start.sh"]