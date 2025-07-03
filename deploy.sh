#!/bin/bash

echo "🚀 Deploying Laravel Portfolio Application..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo -e "${RED}❌ Docker is not installed. Please install Docker first.${NC}"
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    echo -e "${RED}❌ Docker Compose is not installed. Please install Docker Compose first.${NC}"
    exit 1
fi

echo -e "${GREEN}✅ Docker and Docker Compose are installed${NC}"

# Create required Laravel storage directories
echo -e "${YELLOW}📁 Creating Laravel storage directories...${NC}"
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/testing
mkdir -p storage/logs
mkdir -p storage/app/public

# Create database directory for SQLite
mkdir -p database

# Set proper permissions for storage directories
if command -v chmod &> /dev/null; then
    chmod -R 775 storage/
    chmod -R 775 database/
    echo -e "${GREEN}✅ Storage and database directories created and permissions set${NC}"
else
    echo -e "${GREEN}✅ Storage and database directories created${NC}"
fi

# Stop existing containers
echo -e "${YELLOW}🛑 Stopping existing containers...${NC}"
docker-compose down

# Build the image
echo -e "${YELLOW}🏗️ Building Docker image...${NC}"
docker-compose build --no-cache

# Start the application
echo -e "${YELLOW}🚀 Starting the application...${NC}"
docker-compose up -d

# Wait for container to be ready
echo -e "${YELLOW}⏳ Waiting for application to be ready...${NC}"
sleep 15

# Check if container is running
if docker ps | grep -q "moportfolio"; then
    echo -e "${GREEN}✅ Container is running${NC}"
    
    # Test if application is responding
    echo -e "${YELLOW}🔍 Testing application health...${NC}"
    sleep 5
    
    if curl -f -s http://localhost > /dev/null 2>&1; then
        echo -e "${GREEN}✅ Application deployed successfully!${NC}"
        echo -e "${GREEN}🌐 Your portfolio is available at: http://localhost:8091${NC}"
        echo -e "${GREEN}🔧 Admin panel: http://localhost:8091/admin${NC}"
        echo -e "${GREEN}📊 Default admin credentials:${NC}"
        echo -e "${GREEN}   Email: admin@admin.com${NC}"
        echo -e "${GREEN}   Password: password${NC}"
    else
        echo -e "${YELLOW}⚠️ Application is starting up. Check logs if issues persist.${NC}"
        echo -e "${YELLOW}🌐 Try accessing: http://localhost:8091${NC}"
        echo -e "${YELLOW}📋 Check logs: docker-compose logs -f${NC}"
    fi
else
    echo -e "${RED}❌ Deployment failed. Check logs with: docker-compose logs${NC}"
    exit 1
fi

echo ""
echo -e "${YELLOW}📝 Useful commands:${NC}"
echo -e "${YELLOW}   View logs: docker-compose logs -f${NC}"
echo -e "${YELLOW}   Stop app:  docker-compose down${NC}"
echo -e "${YELLOW}   Restart:   docker-compose restart${NC}"
echo -e "${YELLOW}   Shell:     docker exec -it moportfolio bash${NC}"
echo -e "${YELLOW}   Access:    http://localhost:8091${NC}"
echo ""
echo -e "${GREEN}🎉 Happy coding!${NC}" 