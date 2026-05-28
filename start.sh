#!/bin/bash
set -e

# Clear caches (important for environment variables to take effect)
php artisan config:clear
php artisan route:clear

# Run migrations
php artisan migrate --force --no-interaction

# Cache config and routes for performance
php artisan config:cache
php artisan route:cache

# Start PHP built-in server
php -S 0.0.0.0:8080 -t public


