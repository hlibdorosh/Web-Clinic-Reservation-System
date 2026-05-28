#!/bin/bash
set -e

PORT=${PORT:-10000}

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


