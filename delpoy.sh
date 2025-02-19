#!/bin/bash

# Exit on error
set -e

# Function to log messages
log() {
    echo "[$(date +'%Y-%m-%d %H:%M:%S')] $1"
}

# Function to check command status
check_status() {
    if [ $? -eq 0 ]; then
        log "✅ $1 completed successfully"
    else
        log "❌ $1 failed"
        exit 1
    fi
}

log "Starting deployment process..."

# Remove existing containers and volumes
log "Removing existing containers and volumes..."
sudo docker compose -f docker-compose.prod.yml down
check_status "Container cleanup"

# Rebuild and start containers
log "Rebuilding and starting containers..."
sudo docker compose -f docker-compose.prod.yml up -d --build
check_status "Container startup"

# Wait for containers to be ready
log "Waiting for containers to be ready..."
sleep 10

# Install production dependencies
log "Installing Composer dependencies..."
sudo docker compose -f docker-compose.prod.yml exec -T php composer install --no-dev --optimize-autoloader
check_status "Composer install"

# Clear cache and warm up
log "Clearing and warming up cache..."
sudo docker compose -f docker-compose.prod.yml exec -T php php bin/console cache:clear --env=prod
sudo docker compose -f docker-compose.prod.yml exec -T php php bin/console cache:warmup --env=prod
check_status "Cache operations"

# Build assets
log "Building assets..."
sudo docker compose -f docker-compose.prod.yml exec -T php bash -c 'cd /var/www/html/src && NODE_ENV=production npm run build'
check_status "Asset build"

log "Compiling asset map..."
sudo docker compose -f docker-compose.prod.yml exec -T php php bin/console asset-map:compile --env=prod
check_status "Asset map compilation"

# Setup database
log "Running database migrations..."
sudo docker compose -f docker-compose.prod.yml exec -T php php bin/console doctrine:migrations:migrate --no-interaction --env=prod
check_status "Database migration"

# Setup Elasticsearch
log "Setting up Elasticsearch..."
sudo docker compose -f docker-compose.prod.yml exec -T php php bin/console fos:elastica:create --env=prod
sudo docker compose -f docker-compose.prod.yml exec -T php php bin/console fos:elastica:populate --env=prod
check_status "Elasticsearch setup"

log "🎉 Deployment completed successfully!"