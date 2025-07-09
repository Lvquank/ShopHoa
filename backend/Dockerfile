# Dockerfile
FROM php:8.2-fpm

# Cài extension
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Workdir
WORKDIR /var/www

# Copy source code
COPY . .

# Cài package
RUN composer install --optimize-autoloader --no-dev

# Chmod
RUN chmod -R 777 storage bootstrap/cache

# Start command
CMD php artisan migrate --force && php-fpm
