#!/bin/bash

# Mo Portfolio Server Deployment Script
# This script pulls the image from Docker Hub and runs it on your server

set -e

echo "🚀 Deploying Mo Portfolio from Docker Hub..."

# Configuration
IMAGE_NAME="gheith3/moportfolio:latest"
CONTAINER_NAME="moportfolio"
PORT="7085"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    print_error "Docker is not running. Please start Docker and try again."
    exit 1
fi

# Create application directory
print_status "Creating application directory..."
mkdir -p /opt/moportfolio
cd /opt/moportfolio

# Create database and storage directories
print_status "Creating database and storage directories..."
mkdir -p database storage/app storage/framework/cache storage/framework/sessions storage/framework/views storage/logs
touch database/database.sqlite

# Create .env file if it doesn't exist
if [ ! -f .env ]; then
    print_status "Creating .env file..."
    cat > .env << EOF
APP_NAME="Mo Portfolio"
APP_ENV=production
APP_KEY=base64:$(openssl rand -base64 32)
APP_DEBUG=false
APP_URL=http://$(hostname -I | awk '{print $1}'):${PORT}

DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

LOG_CHANNEL=stack
LOG_LEVEL=error
EOF
    print_status "✅ .env file created"
fi

# Stop and remove existing container if it exists
if [ "$(docker ps -aq -f name=$CONTAINER_NAME)" ]; then
    print_warning "Stopping and removing existing container..."
    docker stop $CONTAINER_NAME || true
    docker rm $CONTAINER_NAME || true
fi

# Pull the latest image from Docker Hub
print_status "Pulling latest image from Docker Hub..."
docker pull $IMAGE_NAME

# Run the container
print_status "Starting container..."
docker run -d \
    --name $CONTAINER_NAME \
    --restart unless-stopped \
    -p $PORT:80 \
    -v /opt/moportfolio/database:/var/www/html/database \
    -v /opt/moportfolio/storage:/var/www/html/storage \
    --env-file /opt/moportfolio/.env \
    $IMAGE_NAME

# Wait for container to be ready
print_status "Waiting for container to be ready..."
sleep 15

# Check if container is running
if [ "$(docker ps -q -f name=$CONTAINER_NAME)" ]; then
    print_status "✅ Deployment successful!"
    print_status "🌐 Application is running at: http://$(hostname -I | awk '{print $1}'):$PORT"
    print_status "📊 Admin panel is available at: http://$(hostname -I | awk '{print $1}'):$PORT/admin"
    print_status ""
    print_status "📋 Container logs:"
    docker logs $CONTAINER_NAME --tail 20
    
    # Set up log rotation
    print_status "Setting up log rotation..."
    cat > /etc/logrotate.d/moportfolio << EOF
/opt/moportfolio/storage/logs/*.log {
    daily
    missingok
    rotate 7
    compress
    notifempty
    create 644 www-data www-data
}
EOF

else
    print_error "❌ Deployment failed!"
    print_error "Container logs:"
    docker logs $CONTAINER_NAME
    exit 1
fi

echo ""
print_status "🎉 Mo Portfolio is now running on your server!"
print_status "📍 Server IP: $(hostname -I | awk '{print $1}')"
print_status "🔗 Application URL: http://$(hostname -I | awk '{print $1}'):$PORT"
print_status ""
print_status "Management commands:"
print_status "  View logs: docker logs -f $CONTAINER_NAME"
print_status "  Stop: docker stop $CONTAINER_NAME"
print_status "  Restart: docker restart $CONTAINER_NAME"
print_status "  Update: docker pull $IMAGE_NAME && docker stop $CONTAINER_NAME && docker rm $CONTAINER_NAME && bash $0"
print_status ""
print_status "Database commands:"
print_status "  Run migrations: docker exec $CONTAINER_NAME php artisan migrate --force"
print_status "  Seed database: docker exec $CONTAINER_NAME php artisan db:seed --force"
print_status "  Reset database: docker exec $CONTAINER_NAME php artisan migrate:fresh --seed --force" 