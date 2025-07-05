#!/bin/bash
set -e

echo "Starting Laravel application setup..."

# Wait for services to be ready
sleep 3

# Generate application key if not set
if [ -z "$APP_KEY" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Create storage link
if [ ! -L "/var/www/html/public/storage" ]; then
    echo "Creating storage link..."
    php artisan storage:link
fi

# Clear and cache configuration
echo "Clearing and caching configuration..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run composer dump-autoload to ensure all classes are loaded
echo "Regenerating autoloader..."
composer dump-autoload --optimize

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Run seeders
echo "Running database seeders..."
php artisan db:seed --force || echo "Seeding failed, but continuing..."

# Set proper permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
chmod 664 /var/www/html/database/database.sqlite

echo "Laravel application setup completed!"

# Start supervisord to manage Apache
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf 