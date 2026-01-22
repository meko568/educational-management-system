FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    default-mysql-client

RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

RUN a2enmod rewrite

WORKDIR /var/www/html
COPY . /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

EXPOSE 80
CMD ["apache2-foreground"]
