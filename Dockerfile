# Gunakan PHP image
FROM php:8.2-fpm

# Install dependency system
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy source code
WORKDIR /var/www
COPY . .

# Install dependency Laravel
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Generate key (opsional, bisa pakai artisan nanti di CapRover hook)
RUN php artisan config:clear && php artisan cache:clear

# Ganti ownership
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose port untuk Nginx/PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
