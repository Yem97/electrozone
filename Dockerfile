# syntax=docker/dockerfile:1

# ---------- Stage 1: build front-end assets with Vite ----------
FROM node:20-bullseye-slim AS assets
WORKDIR /app
COPY package.json package-lock.json* ./
# --legacy-peer-deps resolves the @vitejs/plugin-vue@4 / vite@6 peer conflict
RUN npm install --legacy-peer-deps
COPY . .
RUN npm run build

# ---------- Stage 2: PHP application runtime ----------
FROM php:8.2-cli-bullseye AS app

# System libraries + PHP extensions the app needs:
#   pdo_mysql -> MySQL   |   gd, exif -> intervention/image   |   zip -> composer & dompdf
RUN apt-get update && apt-get install -y --no-install-recommends \
        git unzip \
        libpng-dev libjpeg62-turbo-dev libfreetype6-dev libzip-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" pdo_mysql gd zip bcmath exif \
    && rm -rf /var/lib/apt/lists/*

# Composer (pulled from the official Composer image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Install PHP dependencies (production only)
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Bring in the compiled assets from the Node build stage
COPY --from=assets /app/public/build ./public/build

# Laravel needs these writable at runtime
RUN chmod -R ug+rw storage bootstrap/cache

EXPOSE 8000

# Run migrations + (idempotent) seeders, then boot the server.
# Railway injects $PORT. route:cache is intentionally skipped: routes/web.php
# contains a closure route, which cannot be cached.
CMD php artisan migrate --force \
 && php artisan db:seed --force \
 && (php artisan storage:link || true) \
 && php artisan config:cache \
 && php artisan view:cache \
 && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
