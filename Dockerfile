# ==============================================================================
# Stage 1: Build frontend assets
# ==============================================================================
FROM node:22-alpine AS assets

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY resources/ resources/
COPY public/ public/

RUN npm run build

# ==============================================================================
# Stage 2: PHP application
# ==============================================================================
FROM php:8.4-fpm-alpine AS app

RUN apk add --no-cache \
        curl \
        libpq-dev \
        libzip-dev \
        oniguruma-dev \
        su-exec \
        unzip \
    && apk add --no-cache --virtual .build-deps \
        autoconf \
        g++ \
        gcc \
        make \
    && docker-php-ext-install \
        bcmath \
        mbstring \
        opcache \
        pdo \
        pdo_pgsql \
        pgsql \
        zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps \
    && rm -rf /tmp/pear

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install PHP dependencies (separate layer for caching)
COPY composer.json composer.lock ./
RUN composer install \
    --no-scripts \
    --no-autoloader \
    --prefer-dist

# Copy application source
COPY --chown=www-data:www-data . .

# Copy built frontend assets from node stage
COPY --from=assets --chown=www-data:www-data /app/public/build ./public/build

# Generate optimised autoloader and run post-install discovery
RUN composer dump-autoload --optimize

# Save vendor to a seed location outside the app dir so the named volume
# can be populated from it on first start or after a rebuild
RUN cp -r /var/www/html/vendor /var/www/vendor-seed \
    && md5sum /var/www/html/composer.lock | awk '{print $1}' > /var/www/vendor-seed/.composer-hash

# Ensure correct ownership on writable directories
RUN mkdir -p storage/framework/views storage/framework/cache storage/framework/sessions \
    && chown -R www-data:www-data storage bootstrap/cache \
    && mkdir -p /mnt/public && chmod 777 /mnt/public

COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
