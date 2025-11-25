# ---- Build Stage ----
FROM php:8.2-fpm AS build

RUN apt-get update && apt-get install -y \
    libpq-dev \
    pkg-config \
    libzip-dev \
    git \
    unzip \
    && docker-php-ext-install pdo_pgsql pgsql bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN composer install --optimize-autoloader --no-dev --no-interaction

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install && npm run build \
    && rm -rf node_modules

# ---- Production Stage ----
FROM php:8.2-apache AS production

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    libpq-dev \
    pkg-config \
    && docker-php-ext-install pdo_pgsql pgsql bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=build /var/www /var/www/html

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]