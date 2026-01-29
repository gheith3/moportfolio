# Mo Portfolio - Docker Deployment Guide

This guide will help you deploy the Mo Portfolio Laravel application using Docker.

## Prerequisites

-   Docker installed on your server
-   Docker Compose installed
-   Git (to clone the repository)

## Quick Deployment

### Option 1: Using the Deployment Script (Recommended)

1. **Clone the repository:**

    ```bash
    git clone <your-repo-url>
    cd moportfolio
    ```

2. **Make the deployment script executable:**

    ```bash
    chmod +x deploy.sh
    ```

3. **Run the deployment script:**
    ```bash
    ./deploy.sh
    ```

The script will automatically:

-   Create the `.env` file if it doesn't exist
-   Generate an application key
-   Build the Docker image
-   Start the container
-   Run migrations and seeders
-   Set up proper permissions

### Option 2: Using Docker Compose

1. **Clone and setup:**

    ```bash
    git clone <your-repo-url>
    cd moportfolio
    cp .env.example .env
    ```

2. **Generate application key:**

    ```bash
    # Generate a random base64 key
    APP_KEY=$(openssl rand -base64 32)
    sed -i "s/APP_KEY=/APP_KEY=base64:$APP_KEY/" .env
    ```

3. **Update environment variables in `.env`:**

    ```env
    APP_ENV=production
    APP_DEBUG=false
    APP_URL=http://your-server-ip:7085
    DB_CONNECTION=sqlite
    DB_DATABASE=/var/www/html/database/database.sqlite
    ```

4. **Build and start:**
    ```bash
    docker-compose up -d --build
    ```

## Server Configuration

The application will be available on port **7085** as requested.

### Accessing the Application

-   **Frontend:** `http://your-server-ip:7085`
-   **Admin Panel:** `http://your-server-ip:7085/admin`

### Default Admin Credentials

The application will create a default admin user during seeding:

-   **Email:** `admin@admin.com`
-   **Password:** `password`

**⚠️ Important:** Change the default admin password immediately after first login.

## Database Management

### Running Migrations

If you need to run migrations manually:

```bash
docker exec moportfolio php artisan migrate --force
```

### Running Seeders

To seed the database with sample data:

```bash
docker exec moportfolio php artisan db:seed --force
```

### Database Backup

Since we're using SQLite, the database is stored in a single file. To backup:

```bash
# Copy the database file from the container
docker cp moportfolio:/var/www/html/database/database.sqlite ./backup-$(date +%Y%m%d).sqlite
```

### Database Restore

To restore from a backup:

```bash
# Stop the container
docker stop moportfolio

# Replace the database file
cp your-backup.sqlite ./database/database.sqlite

# Start the container
docker start moportfolio
```

## Container Management

### View Logs

```bash
# Real-time logs
docker logs -f moportfolio

# Last 100 lines
docker logs --tail 100 moportfolio
```

### Restart Container

```bash
docker restart moportfolio
```

### Stop Container

```bash
docker stop moportfolio
```

### Update Application

1. **Pull latest changes:**

    ```bash
    git pull origin main
    ```

2. **Rebuild and restart:**

    ```bash
    docker-compose up -d --build
    ```

    Or using the deployment script:

    ```bash
    ./deploy.sh
    ```

## Pushing to Docker Hub

To push your image to Docker Hub (gheith3/moportfolio):

```bash
# Build the image
docker build -t gheith3/moportfolio:latest .

# Login to Docker Hub
docker login

# Push the image
docker push gheith3/moportfolio:latest
```

## Troubleshooting

### Container Won't Start

1. **Check logs:**

    ```bash
    docker logs moportfolio
    ```

2. **Check if port is already in use:**

    ```bash
    netstat -tulpn | grep 7085
    ```

3. **Verify Docker is running:**
    ```bash
    docker info
    ```

### Database Issues

1. **Reset database:**

    ```bash
    docker exec moportfolio php artisan migrate:fresh --seed --force
    ```

2. **Check database permissions:**
    ```bash
    docker exec moportfolio ls -la /var/www/html/database/
    ```

### Permission Issues

```bash
# Fix storage permissions
docker exec moportfolio chown -R www-data:www-data /var/www/html/storage
docker exec moportfolio chmod -R 775 /var/www/html/storage
```

## File Structure

```
moportfolio/
├── Dockerfile                 # Main Docker configuration
├── docker-compose.yml        # Docker Compose configuration
├── deploy.sh                 # Deployment script
├── .dockerignore             # Files to exclude from Docker build
└── docker/                   # Docker configuration files
    ├── nginx.conf            # Nginx web server configuration
    ├── php-fpm.conf          # PHP-FPM configuration
    ├── supervisord.conf      # Process manager configuration
    └── entrypoint.sh         # Container startup script
```

## Security Considerations

1. **Change default admin password**
2. **Set proper APP_KEY in production**
3. **Use HTTPS in production (configure reverse proxy)**
4. **Regular database backups**
5. **Keep Docker images updated**

## Support

If you encounter any issues during deployment, check the container logs first:

```bash
docker logs moportfolio
```

For additional help, review the Laravel logs inside the container:

```bash
docker exec moportfolio tail -f /var/www/html/storage/logs/laravel.log
```
