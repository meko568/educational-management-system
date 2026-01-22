# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Install system dependencies and MySQL client
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    default-mysql-client \
    git \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions needed for Laravel
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy app code
COPY . /var/www/html

# Install Composer (dependency manager)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Expose port 80 for HTTP
EXPOSE 80

# Run migrations & seeders at container start, then start Apache
CMD ["sh", "-c", "php artisan migrate --force && php artisan db:seed --force && apache2-foreground"]
