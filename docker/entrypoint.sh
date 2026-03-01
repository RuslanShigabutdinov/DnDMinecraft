#!/bin/sh
set -e

# Run Laravel bootstrap tasks only for the main PHP-FPM process,
# not for queue workers or one-off artisan commands.
if [ "${1}" = "php-fpm" ]; then
    echo "Caching configuration..."
    php artisan config:cache

    echo "Caching routes..."
    php artisan route:cache

    echo "Running migrations..."
    php artisan migrate --force

    echo "Publishing public assets..."
    cp -rf /var/www/html/public/. /mnt/public/

    echo "Bootstrap complete. Starting PHP-FPM..."
fi

exec "$@"
