# Stage 1: Build frontend assets
FROM node:18-alpine AS frontend

WORKDIR /app

# Copy frontend files
COPY package.json package-lock.json ./
RUN npm ci

# Copy resources for Vite build
COPY resources ./resources
COPY vite.config.js tailwind.config.js postcss.config.js ./

# Build frontend assets
RUN npm run build

# Stage 2: Final PHP application image
FROM php:8.2-cli

# Install essential system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    git \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application (artisan required for composer post-autoload scripts)
COPY . .

# Create storage and bootstrap directories before composer install
RUN mkdir -p storage/logs storage/framework/{sessions,views,cache} bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Install PHP dependencies
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Copy built frontend assets from Stage 1
COPY --from=frontend /app/public/build public/build


# Copy startup script
COPY start.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 8080

CMD ["/usr/local/bin/start.sh"]



