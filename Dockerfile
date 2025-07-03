FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    curl \
    libzip-dev \
    zip \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    libgd-dev \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite zip intl gd

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project files
COPY . .

# Install PHP dependencies (Laravel)
RUN composer install --no-dev --optimize-autoloader

# Install NPM dependencies and build assets
RUN npm install && npm run build

# Create database directory and SQLite database file
RUN mkdir -p /var/www/html/database && \
    touch /var/www/html/database/database.sqlite && \
    chmod 664 /var/www/html/database/database.sqlite

# Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache database

# Add custom nginx config
COPY ./scripts/nginx.conf /etc/nginx/conf.d/default.conf

# Expose port 9000 for Nginx
EXPOSE 9000

# Cache Laravel configuration
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Start Nginx and PHP-FPM together
CMD service nginx start && php-fpm
