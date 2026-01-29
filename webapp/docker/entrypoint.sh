#!/bin/sh

# Laravel Docker Entrypoint Script
echo "🚀 Starting Mo Portfolio Backend..."

# Create storage directories FIRST (required for artisan commands)
echo "📁 Setting up storage directories..."
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/app/public
mkdir -p /var/www/html/bootstrap/cache

# Set proper permissions
echo "🔒 Setting permissions..."
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Create .env file from environment variables (not from .env.example)
echo "📝 Creating .env file from environment variables..."
cat > /var/www/html/.env << EOF
APP_NAME="Mo Portfolio"
APP_ENV=${APP_ENV:-production}
APP_KEY=${APP_KEY:-}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-http://localhost}

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=${DB_CONNECTION:-mariadb}
DB_HOST=${DB_HOST:-database}
DB_PORT=${DB_PORT:-3306}
DB_DATABASE=${DB_DATABASE:-mo_portfolio}
DB_USERNAME=${DB_USERNAME:-mo_portfolio_user}
DB_PASSWORD=${DB_PASSWORD:-}

SESSION_DRIVER=${SESSION_DRIVER:-redis}
SESSION_LIFETIME=120

CACHE_STORE=${CACHE_STORE:-redis}
QUEUE_CONNECTION=${QUEUE_CONNECTION:-redis}

REDIS_HOST=${REDIS_HOST:-redis}
REDIS_PASSWORD=${REDIS_PASSWORD:-null}
REDIS_PORT=${REDIS_PORT:-6379}

MAIL_MAILER=log
EOF
chown www-data:www-data /var/www/html/.env

# Wait for database based on connection type
case "$DB_CONNECTION" in
    sqlite)
        echo "📦 Using SQLite database - no connection wait needed"
        if [ -n "$DB_DATABASE" ] && [ ! -f "$DB_DATABASE" ]; then
            echo "📝 Creating SQLite database file..."
            touch "$DB_DATABASE"
            chown www-data:www-data "$DB_DATABASE"
        fi
        ;;
    mysql|mariadb)
        if [ -n "$DB_HOST" ]; then
            echo "⏳ Waiting for MariaDB/MySQL connection..."
            until nc -z "$DB_HOST" "${DB_PORT:-3306}"; do
                echo "Database not ready - sleeping..."
                sleep 2
            done
            echo "✅ MariaDB/MySQL connection established"
        fi
        ;;
    pgsql)
        if [ -n "$DB_HOST" ]; then
            echo "⏳ Waiting for PostgreSQL connection..."
            until nc -z "$DB_HOST" "${DB_PORT:-5432}"; do
                echo "Database not ready - sleeping..."
                sleep 2
            done
            echo "✅ PostgreSQL connection established"
        fi
        ;;
    *)
        echo "⚠️ Unknown database connection type: $DB_CONNECTION"
        ;;
esac

# Create storage symlink for public files
echo "🔗 Creating storage symlink..."
php artisan storage:link --force 2>/dev/null || true



# Run database migrations if requested
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "🗄️ Running database migrations..."
    php artisan migrate --force --no-interaction

    echo "🗄️ Running database seeding..."
    php artisan db:seed --force --no-interaction || true
fi

# Clear and cache configuration (only if not already cached)
echo "⚡ Optimizing application..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan icons:cache

echo "✅ Laravel initialization complete!"

# Ensure Supervisor log directory exists
echo "🎯 Ensuring supervisor log directory exists..."
mkdir -p /var/log/supervisor
chown -R www-data:www-data /var/log/supervisor

# Ensure Nginx log directory exists
echo "📁 Ensuring nginx log directory exists..."
mkdir -p /var/log/nginx
chown -R www-data:www-data /var/log/nginx

# Start supervisor to manage all processes
echo "🎯 Starting services with supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf