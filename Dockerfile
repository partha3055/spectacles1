FROM php:8.2-cli

WORKDIR /var/www
COPY . .

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y git unzip libsqlite3-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite

# Install Composer [cite: 3]
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

RUN composer install --no-dev --optimize-autoloader

# Ensure storage and cache are writable
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# Run migrations automatically (optional but helpful for SQLite)
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000