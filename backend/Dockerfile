FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel permissions
RUN chmod -R 777 storage bootstrap/cache

# ⚠️ Thêm dòng này để tạo symbolic link storage
RUN php artisan storage:link

# Run Laravel server
CMD php artisan serve --host=0.0.0.0 --port=${PORT}