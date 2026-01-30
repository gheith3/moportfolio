# Laravel Docker Deployment Guide with Portainer & GitHub Actions

A complete guide to deploy Laravel applications with Docker, Portainer, and automated CI/CD using GitHub Actions.

## Overview

This setup provides:
- **Docker containerized Laravel app** with Nginx + PHP-FPM
- **PostgreSQL/MariaDB** database with persistent storage
- **Redis** for caching and sessions
- **GitHub Actions** for automated builds
- **GitHub Container Registry (GHCR)** for image storage
- **Portainer** for container management with auto-deploy via webhooks

### Deployment Flow
```
Push to production → GitHub Actions builds image → Push to GHCR → Portainer webhook → Auto redeploy
```

---

## Project Structure

```
your-laravel-app/
├── .github/
│   └── workflows/
│       └── build-and-push.yml      # GitHub Actions workflow
├── webapp/                          # Laravel application
│   ├── Dockerfile                   # Docker build instructions
│   └── docker/
│       ├── entrypoint.sh           # Container startup script
│       ├── nginx.conf              # Nginx configuration
│       └── supervisord.conf        # Process manager config
├── docker-compose.prod.yml          # Production compose file
└── DEPLOYMENT_GUIDE.md              # This file
```

---

## Files

### 1. Dockerfile (`webapp/Dockerfile`)

```dockerfile
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    postgresql-dev \
    oniguruma-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        opcache

# Install Redis extension
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy configuration files
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /entrypoint.sh

# Set permissions
RUN chmod +x /entrypoint.sh \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
```

---

### 2. Entrypoint Script (`webapp/docker/entrypoint.sh`)

```bash
#!/bin/sh

# Laravel Docker Entrypoint Script
echo "🚀 Starting Laravel Application..."

# Create storage directories
echo "📁 Setting up storage directories..."
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/app/public

# Set permissions
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage

# Create .env file from environment variables
echo "📝 Creating .env file from environment variables..."
cat > /var/www/html/.env << EOF
APP_NAME="${APP_NAME:-Laravel}"
APP_ENV=${APP_ENV:-production}
APP_KEY=${APP_KEY:-}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-http://localhost}

LOG_CHANNEL=stack
LOG_LEVEL=error

# Database - PostgreSQL
DB_CONNECTION=${DB_CONNECTION:-pgsql}
DB_HOST=${DB_HOST:-database}
DB_PORT=${DB_PORT:-5432}
DB_DATABASE=${DB_DATABASE:-laravel}
DB_USERNAME=${DB_USERNAME:-laravel_user}
DB_PASSWORD=${DB_PASSWORD:-}

# Redis
REDIS_HOST=${REDIS_HOST:-redis}
REDIS_PASSWORD=${REDIS_PASSWORD:-null}
REDIS_PORT=${REDIS_PORT:-6379}

# Cache & Session
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
EOF

# Wait for database
echo "⏳ Waiting for database connection..."
max_attempts=30
attempt=0

while [ $attempt -lt $max_attempts ]; do
    if php artisan db:monitor --databases="${DB_CONNECTION:-pgsql}" 2>/dev/null; then
        echo "✅ Database is ready!"
        break
    fi
    attempt=$((attempt + 1))
    echo "   Attempt $attempt/$max_attempts - Database not ready, waiting..."
    sleep 2
done

if [ $attempt -eq $max_attempts ]; then
    echo "⚠️ Database connection timeout, continuing anyway..."
fi

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link --force 2>/dev/null || true

# Run migrations (optional - controlled by environment variable)
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "🗄️ Running database migrations..."
    php artisan migrate --force --no-interaction
fi

# Clear and cache configuration
echo "⚡ Optimizing application..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Laravel initialization complete!"

# Ensure log directories exist
mkdir -p /var/log/supervisor
mkdir -p /var/log/nginx
chown -R www-data:www-data /var/log/supervisor
chown -R www-data:www-data /var/log/nginx

# Start supervisor
echo "🎯 Starting services with supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
```

---

### 3. Nginx Configuration (`webapp/docker/nginx.conf`)

```nginx
server {
    listen 80;
    server_name _;
    root /var/www/html/public;
    index index.php;

    client_max_body_size 100M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript application/javascript application/json application/xml;
}
```

---

### 4. Supervisord Configuration (`webapp/docker/supervisord.conf`)

```ini
[supervisord]
nodaemon=true
user=root
logfile=/var/log/supervisor/supervisord.log
pidfile=/var/run/supervisord.pid

[program:php-fpm]
command=/usr/local/sbin/php-fpm -F
autostart=true
autorestart=true
stdout_logfile=/var/log/supervisor/php-fpm.log
stderr_logfile=/var/log/supervisor/php-fpm-error.log

[program:nginx]
command=/usr/sbin/nginx -g "daemon off;"
autostart=true
autorestart=true
stdout_logfile=/var/log/supervisor/nginx.log
stderr_logfile=/var/log/supervisor/nginx-error.log

[program:laravel-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/supervisor/queue.log
stopwaitsecs=3600
```

---

### 5. Docker Compose Production (`docker-compose.prod.yml`)

```yaml
# Laravel Production Environment
# For use with Docker Portainer

services:
  # Laravel Backend
  backend:
    image: ghcr.io/YOUR_GITHUB_USERNAME/YOUR_APP_NAME:latest
    container_name: app-backend
    ports:
      - "${APP_PORT:-8000}:80"
    environment:
      - APP_NAME=${APP_NAME:-Laravel}
      - APP_ENV=${APP_ENV:-production}
      - APP_DEBUG=${APP_DEBUG:-false}
      - APP_URL=${APP_URL:-https://example.com}
      - APP_KEY=${APP_KEY:?APP_KEY is required}
      - DB_CONNECTION=pgsql
      - DB_HOST=database
      - DB_PORT=5432
      - DB_DATABASE=${DB_DATABASE:-laravel}
      - DB_USERNAME=${DB_USERNAME:-laravel_user}
      - DB_PASSWORD=${DB_PASSWORD:?DB_PASSWORD is required}
      - REDIS_HOST=redis
      - REDIS_PASSWORD=${REDIS_PASSWORD:-null}
      - REDIS_PORT=6379
      - SESSION_DRIVER=redis
      - QUEUE_CONNECTION=redis
      - RUN_MIGRATIONS=${RUN_MIGRATIONS:-false}
    volumes:
      - app-storage:/var/www/html/storage
    depends_on:
      database:
        condition: service_healthy
      redis:
        condition: service_healthy
    restart: unless-stopped
    networks:
      - app-network

  # PostgreSQL Database
  database:
    image: postgres:16-alpine
    container_name: app-database
    environment:
      - POSTGRES_DB=${DB_DATABASE:-laravel}
      - POSTGRES_USER=${DB_USERNAME:-laravel_user}
      - POSTGRES_PASSWORD=${DB_PASSWORD:?DB_PASSWORD is required}
    volumes:
      - app-postgres:/var/lib/postgresql/data
    healthcheck:
      test: ["CMD-SHELL", "pg_isready -U ${DB_USERNAME:-laravel_user} -d ${DB_DATABASE:-laravel}"]
      interval: 30s
      timeout: 10s
      retries: 5
      start_period: 30s
    restart: unless-stopped
    networks:
      - app-network

  # Redis Cache
  redis:
    image: redis:7-alpine
    container_name: app-redis
    command: redis-server --appendonly yes ${REDIS_PASSWORD:+--requirepass $REDIS_PASSWORD}
    volumes:
      - app-redis:/data
    healthcheck:
      test: ["CMD", "redis-cli", "ping"]
      interval: 30s
      timeout: 10s
      retries: 3
      start_period: 10s
    restart: unless-stopped
    networks:
      - app-network

networks:
  app-network:
    driver: bridge

volumes:
  app-storage:
    driver: local
  app-postgres:
    driver: local
  app-redis:
    driver: local
```

#### Alternative: MariaDB instead of PostgreSQL

Replace the database service with:

```yaml
  # MariaDB Database
  database:
    image: mariadb:10.11
    container_name: app-database
    environment:
      - MARIADB_ROOT_PASSWORD=${DB_ROOT_PASSWORD:?DB_ROOT_PASSWORD is required}
      - MARIADB_DATABASE=${DB_DATABASE:-laravel}
      - MARIADB_USER=${DB_USERNAME:-laravel_user}
      - MARIADB_PASSWORD=${DB_PASSWORD:?DB_PASSWORD is required}
    volumes:
      - app-mysql:/var/lib/mysql
    healthcheck:
      test: ["CMD", "healthcheck.sh", "--connect", "--innodb_initialized"]
      interval: 30s
      timeout: 10s
      retries: 5
      start_period: 30s
    restart: unless-stopped
    networks:
      - app-network
```

And update volumes:
```yaml
volumes:
  app-storage:
    driver: local
  app-mysql:
    driver: local
  app-redis:
    driver: local
```

---

### 6. GitHub Actions Workflow (`.github/workflows/build-and-push.yml`)

```yaml
name: Build and Push Docker Image

on:
  push:
    branches:
      - production

env:
  REGISTRY: ghcr.io
  IMAGE_NAME: YOUR_GITHUB_USERNAME/YOUR_APP_NAME

jobs:
  build-and-push:
    runs-on: ubuntu-latest
    permissions:
      contents: read
      packages: write

    steps:
      - name: Checkout repository
        uses: actions/checkout@v4

      - name: Log in to Container Registry
        uses: docker/login-action@v3
        with:
          registry: ${{ env.REGISTRY }}
          username: ${{ github.actor }}
          password: ${{ secrets.GITHUB_TOKEN }}

      - name: Extract metadata for Docker
        id: meta
        uses: docker/metadata-action@v5
        with:
          images: ${{ env.REGISTRY }}/${{ env.IMAGE_NAME }}
          tags: |
            type=raw,value=latest
            type=sha,prefix=

      - name: Build and push Docker image
        uses: docker/build-push-action@v5
        with:
          context: ./webapp
          file: ./webapp/Dockerfile
          push: true
          tags: ${{ steps.meta.outputs.tags }}
          labels: ${{ steps.meta.outputs.labels }}

      - name: Trigger Portainer webhook
        run: |
          curl -X POST "${{ secrets.PORTAINER_WEBHOOK_URL }}"
```

---

## Setup Steps

### Step 1: Prepare Your Laravel App

1. Create the `webapp/docker/` directory with the config files above
2. Create the `Dockerfile` in `webapp/`
3. Update your Laravel `.env.example` with all required variables

### Step 2: Create GitHub Repository

1. Push your code to GitHub
2. Create a `production` branch:
   ```bash
   git checkout -b production
   git push origin production
   ```

### Step 3: Setup GitHub Actions

1. Create `.github/workflows/build-and-push.yml`
2. Update `IMAGE_NAME` with your GitHub username and app name
3. Push to trigger the first build

### Step 4: Setup Portainer

1. **Install Portainer** on your server:
   ```bash
   docker volume create portainer_data
   docker run -d -p 9000:9000 --name portainer \
     --restart=always \
     -v /var/run/docker.sock:/var/run/docker.sock \
     -v portainer_data:/data \
     portainer/portainer-ce:latest
   ```

2. **Create Stack** in Portainer:
   - Go to Stacks → Add Stack
   - Name: `your-app-name`
   - Build method: **Repository**
   - Repository URL: `https://github.com/YOUR_USERNAME/YOUR_REPO`
   - Repository reference: `refs/heads/production`
   - Compose path: `docker-compose.prod.yml`

3. **Add Environment Variables** in Portainer:
   ```
   APP_KEY=base64:your-generated-key
   APP_URL=https://your-domain.com
   DB_PASSWORD=your-secure-password
   DB_ROOT_PASSWORD=your-root-password  # if using MariaDB
   REDIS_PASSWORD=your-redis-password   # optional
   RUN_MIGRATIONS=true                  # for first deploy only
   ```

4. **Enable GitOps/Webhook**:
   - In Stack settings, enable "GitOps updates"
   - Set mechanism to "Webhook"
   - Copy the webhook URL

### Step 5: Add GitHub Secrets

Go to GitHub → Repository → Settings → Secrets and variables → Actions:

1. **Add secret**: `PORTAINER_WEBHOOK_URL`
   - Value: The webhook URL from Portainer

### Step 6: Deploy

1. Push to `production` branch:
   ```bash
   git checkout production
   git merge main
   git push origin production
   ```

2. GitHub Actions will:
   - Build the Docker image
   - Push to GHCR
   - Trigger Portainer webhook

3. Portainer will:
   - Pull the new image
   - Redeploy the container

---

## Important Notes

### Data Persistence

**Named volumes** are used for persistence:
- `app-storage` → Laravel storage (uploads, logs)
- `app-postgres` / `app-mysql` → Database data
- `app-redis` → Redis data

These persist across container rebuilds.

### Seeders

To prevent seeders from overwriting data on redeploy, add checks:

```php
public function run(): void
{
    if (User::query()->exists()) {
        return;
    }
    
    // Seeding logic...
}
```

### Migrations

- Set `RUN_MIGRATIONS=true` for first deploy
- Set `RUN_MIGRATIONS=false` after initial setup
- Or keep `true` if you want auto-migrations (safe with Laravel's migration tracking)

### Generate APP_KEY

```bash
php artisan key:generate --show
```

Copy the output (including `base64:`) to your environment variables.

---

## Troubleshooting

### Check container logs
```bash
docker logs app-backend
```

### Enter container shell
```bash
docker exec -it app-backend sh
```

### Check if code is updated
```bash
docker exec app-backend head -5 /entrypoint.sh
```

### Force rebuild
```bash
docker compose -f docker-compose.prod.yml build --no-cache backend
docker compose -f docker-compose.prod.yml up -d backend
```

### Clear Laravel cache inside container
```bash
docker exec app-backend php artisan cache:clear
docker exec app-backend php artisan config:clear
docker exec app-backend php artisan view:clear
```

---

## Workflow Summary

```
1. Make changes locally
2. Commit and push to production branch
3. GitHub Actions builds and pushes image (~3-4 min)
4. Portainer auto-pulls and redeploys
5. Your app is updated! ✅
```

---

## License

MIT License - Feel free to use this guide for your projects.
