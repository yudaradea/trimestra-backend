FROM php:8.2-fpm

# Install dependencies
RUN libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    unzip \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Install Laravel dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Laravel storage link
RUN php artisan storage:link || true

# Set permissions (opsional, supaya storage dan bootstrap writable)
RUN chmod -R 777 storage bootstrap/cache

CMD ["php-fpm"]
