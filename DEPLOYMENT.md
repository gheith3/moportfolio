# 🐳 Docker Deployment Guide - Laravel Portfolio

This guide explains how to deploy your Laravel Portfolio application using Docker with SQLite database.

## 📋 Prerequisites

-   Docker installed on your server
-   Docker Compose installed
-   Git installed

## 🚀 Quick Deployment

### 1. Clone the Repository

```bash
git clone <your-repository-url>
cd moportfolio
```

### 2. Generate Application Key

First, you need to generate a unique application key:

```bash
# Generate a key locally (if you have PHP/Laravel installed)
php artisan key:generate --show

# Or generate online at: https://laravel-key-generator.com/
```

### 3. Update Docker Compose

Edit `docker-compose.yml` and replace `your-app-key-here` with your generated key:

```yaml
environment:
    - APP_KEY=base64:YOUR_GENERATED_KEY_HERE
```

### 4. Build and Run

```bash
# Build the Docker image
docker-compose build

# Start the application
docker-compose up -d
```

### 5. Access Your Application

Your portfolio will be available at: `http://your-server-ip:80`

## 🔧 Configuration Options

### Environment Variables

You can customize the application by modifying the environment variables in `docker-compose.yml`:

```yaml
environment:
    - APP_ENV=production
    - APP_DEBUG=false
    - APP_KEY=base64:your-app-key-here
    - APP_URL=https://yourdomain.com
    - DB_CONNECTION=sqlite
    - DB_DATABASE=/var/www/html/database/database.sqlite
```

### Custom Domain Setup

1. Update `APP_URL` in docker-compose.yml
2. Set up your reverse proxy (Nginx/Apache) to point to port 80
3. Configure SSL certificates

### Port Configuration

To use a different port, modify the ports mapping in `docker-compose.yml`:

```yaml
ports:
    - "8080:80" # Maps server port 8080 to container port 80
```

## 🗃️ Database Management

### Backup Database

```bash
# Copy SQLite database from container
docker cp moportfolio:/var/www/html/database/database.sqlite ./backup.sqlite
```

### Restore Database

```bash
# Copy backup to container
docker cp ./backup.sqlite moportfolio:/var/www/html/database/database.sqlite

# Restart container
docker-compose restart
```

### Reset Database

```bash
# Access container shell
docker exec -it moportfolio bash

# Inside container
rm /var/www/html/database/database.sqlite
php artisan migrate:fresh --seed
```

## 📁 File Storage

The application uses local file storage. Uploaded files are stored in:

-   Container: `/var/www/html/storage/app/public`
-   Host: `./storage/app/public` (mounted volume)

## 🔄 Updates and Maintenance

### Update Application

```bash
# Pull latest changes
git pull origin main

# Rebuild and restart
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

### View Logs

```bash
# View application logs
docker-compose logs -f app

# View Apache logs
docker exec -it moportfolio tail -f /var/log/apache2/error.log
```

### Container Management

```bash
# Stop the application
docker-compose down

# Start the application
docker-compose up -d

# Restart the application
docker-compose restart

# View running containers
docker ps
```

## 🛡️ Security Considerations

### Production Settings

1. **Always use HTTPS** in production
2. **Set strong APP_KEY** - never use the default
3. **Regular backups** of SQLite database
4. **Update regularly** - keep Docker images updated
5. **Firewall configuration** - only expose necessary ports

### Recommended Nginx Reverse Proxy

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourdomain.com;

    ssl_certificate /path/to/cert.pem;
    ssl_certificate_key /path/to/key.pem;

    location / {
        proxy_pass http://localhost:80;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

## 🔍 Troubleshooting

### Common Issues

1. **Permission Errors**

    ```bash
    docker exec -it moportfolio chown -R www-data:www-data /var/www/html/storage
    ```

2. **Database Not Found**

    ```bash
    docker exec -it moportfolio php artisan migrate:fresh --seed
    ```

3. **Cache Issues**

    ```bash
    docker exec -it moportfolio php artisan cache:clear
    docker exec -it moportfolio php artisan config:clear
    ```

4. **Storage Link Missing**
    ```bash
    docker exec -it moportfolio php artisan storage:link
    ```

### Health Check

```bash
# Check if container is running
docker ps | grep moportfolio

# Check application status
curl -I http://your-server-ip

# Access container shell
docker exec -it moportfolio bash
```

## 📊 Monitoring

### Resource Usage

```bash
# View container resource usage
docker stats moportfolio

# View disk usage
docker system df
```

### Application Monitoring

The application includes basic logging. Check logs with:

```bash
docker exec -it moportfolio tail -f /var/www/html/storage/logs/laravel.log
```

## 🆘 Support

If you encounter issues:

1. Check the logs: `docker-compose logs app`
2. Verify file permissions
3. Ensure SQLite database exists and is writable
4. Check container resource limits

---

**Happy Deploying! 🎉**
