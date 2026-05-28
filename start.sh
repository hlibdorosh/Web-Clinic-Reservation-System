#!/bin/bash
set -e

PORT=${PORT:-10000}

# Ensure storage and bootstrap directories exist and are writable at runtime
mkdir -p storage/logs \
         storage/framework/sessions \
         storage/framework/views \
         storage/framework/cache/data \
         bootstrap/cache

chmod -R 775 storage bootstrap/cache

# Clear caches
php artisan config:clear
php artisan route:clear

# Run migrations only if explicitly enabled
if [ "$RUN_MIGRATIONS" = "true" ]; then
    php artisan migrate --force --no-interaction
fi

# Cache config and routes
php artisan config:cache
php artisan route:cache

# Start PHP built-in server on PORT
php -S 0.0.0.0:$PORT -t public


