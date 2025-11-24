# ---- Build Stage ----
FROM php:8.2-fpm AS build

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    && docker-php-ext-install pdo_pgsql pgsql bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy code
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Build assets Vite
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install \
    && npm run build \
    && rm -rf node_modules

# ---- Production Stage ----
FROM php:8.2-apache AS production

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install PHP extensions untuk production
RUN docker-php-ext-install pdo_pgsql pgsql bcmath

# Copy hasil build dari stage sebelumnya
COPY --from=build /var/www /var/www/html

# Set permission
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Ganti config Apache biar ngarah ke /public
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]