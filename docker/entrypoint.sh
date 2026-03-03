#!/bin/sh
set -e

# Run Laravel bootstrap tasks only for the main PHP-FPM process,
# not for queue workers or one-off artisan commands.
if [ "${1}" = "php-fpm" ]; then
    # Seed vendor volume if empty or if composer.lock changed since last build
    IMAGE_HASH=$(cat /var/www/vendor-seed/.composer-hash)
    VOLUME_HASH=$(cat /var/www/html/vendor/.composer-hash 2>/dev/null || echo "")
    if [ "$IMAGE_HASH" != "$VOLUME_HASH" ]; then
        echo "Syncing vendor (packages changed)..."
        cp -r /var/www/vendor-seed/. /var/www/html/vendor/
    fi

    echo "Fixing storage permissions..."
    chown -R www-data:www-data storage bootstrap/cache
    chmod -R 775 storage bootstrap/cache

    echo "Caching configuration..."
    su-exec www-data php artisan config:cache

    echo "Caching routes..."
    su-exec www-data php artisan route:cache

    echo "Running migrations..."
    su-exec www-data php artisan migrate --force

    echo "Publishing public assets..."
    cp -rf /var/www/html/public/. /mnt/public/

    echo "Bootstrap complete. Starting PHP-FPM..."
fi

exec "$@"
