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
sleep 10

# Check if container is running
if docker ps | grep -q "moportfolio"; then
    echo -e "${GREEN}✅ Application deployed successfully!${NC}"
    echo -e "${GREEN}🌐 Your portfolio is available at: http://localhost${NC}"
    echo -e "${GREEN}🔧 Admin panel: http://localhost/admin${NC}"
    echo -e "${GREEN}📊 Default admin credentials:${NC}"
    echo -e "${GREEN}   Email: admin@admin.com${NC}"
    echo -e "${GREEN}   Password: password${NC}"
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
echo ""
echo -e "${GREEN}🎉 Happy coding!${NC}" 