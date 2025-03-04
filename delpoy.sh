#!/bin/bash

# Exit on error
set -e

# Load environment variables
if [ -f .env.prod ]; then
    set -a
    source .env.prod
    set +a
fi

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

# Function to wait for Elasticsearch
wait_for_elasticsearch() {
    log "Waiting for Elasticsearch to be ready..."
    for i in {1..30}; do
        if sudo -E docker compose -f docker-compose.prod.yml exec -T elasticsearch curl -s "http://${ELASTIC_USERNAME:-elastic}:${ELASTIC_PASSWORD:-kodi}@localhost:9200" > /dev/null; then
            log "✅ Elasticsearch is ready"
            return 0
        fi
        log "Waiting for Elasticsearch... ($i/30)"
        sleep 5
    done
    log "❌ Elasticsearch did not become ready in time"
    exit 1
}

log "Starting deployment process..."

# Stop containers (without removing volumes)
log "Stopping containers..."
sudo -E docker compose -f docker-compose.prod.yml down
check_status "Container cleanup"

# Rebuild and start containers
log "Rebuilding and starting containers..."
sudo -E docker compose -f docker-compose.prod.yml up -d --build
check_status "Container startup"

# Wait for containers to be ready
log "Waiting for containers to be ready..."
sleep 10

# Updated container verification section
log "Verifying container status..."
nginx_status=$(sudo -E docker compose -f docker-compose.prod.yml ps nginx --format json | grep -o '"State":"[^"]*"' | cut -d'"' -f4)

if [ "$nginx_status" != "running" ]; then
    log "❌ Nginx container is not in running state (current state: $nginx_status)"
    log "Checking Nginx logs..."
    sudo -E docker compose -f docker-compose.prod.yml logs nginx

    # Check Nginx configuration
    log "Verifying Nginx configuration..."
    sudo -E docker compose -f docker-compose.prod.yml exec -T nginx nginx -t

    # Try to restart Nginx
    log "Attempting to restart Nginx container..."
    sudo -E docker compose -f docker-compose.prod.yml restart nginx
    sleep 5

    # Check status again
    nginx_status=$(sudo -E docker compose -f docker-compose.prod.yml ps nginx --format json | grep -o '"State":"[^"]*"' | cut -d'"' -f4)
    if [ "$nginx_status" != "running" ]; then
        log "❌ Nginx container failed to start after restart"
        exit 1
    fi
fi

log "✅ Nginx container is running"

# Function to fix permissions
fix_permissions() {
    log "Fixing permissions..."
    sudo -E docker compose -f docker-compose.prod.yml exec -T php bash -c '
        set -e
        # Create directories with correct permissions
        mkdir -p /var/www/html/src/var/cache/prod \
                 /var/www/html/src/var/log \
                 /var/www/html/src/var/sessions

        # Reset ownership
        find /var/www/html/src/var -type d -exec chmod 0755 {} \;
        find /var/www/html/src/var -type f -exec chmod 0644 {} \;
        chown -R www-data:www-data /var/www/html/src/var

        # Set specific permissions for cache and logs
        chmod -R 777 /var/www/html/src/var/cache
        chmod -R 777 /var/www/html/src/var/log
        chmod -R 777 /var/www/html/src/var/sessions
    '
    check_status "Permission fix"
}

# Update the composer install section
log "Installing Composer dependencies..."
sudo -E docker compose -f docker-compose.prod.yml exec -T -u www-data php bash -c '
    cd /var/www/html/src && \
    composer install --no-dev --optimize-autoloader
'
check_status "Composer install"

# Add this before any cache operations
fix_permissions

# Update cache operations to run as www-data
log "Clearing and warming up cache..."
sudo -E docker compose -f docker-compose.prod.yml exec -T -u www-data php bash -c '
    cd /var/www/html/src && \
    php bin/console cache:clear --env=prod && \
    php bin/console cache:warmup --env=prod
'
check_status "Cache operations"

# Setup NPM
log "Setting up NPM..."
sudo -E docker compose -f docker-compose.prod.yml exec -T php bash -c 'cd /var/www/html/src && npm install'
check_status "NPM install"

# Clear cache and warm up
log "Clearing and warming up cache..."
sudo -E docker compose -f docker-compose.prod.yml exec -T php bash -c 'cd /var/www/html/src && php bin/console cache:clear --env=prod'
sudo -E docker compose -f docker-compose.prod.yml exec -T php bash -c 'cd /var/www/html/src && php bin/console cache:warmup --env=prod'
check_status "Cache operations"

# Build assets
log "Building assets..."
sudo -E docker compose -f docker-compose.prod.yml exec -T php bash -c 'cd /var/www/html/src && NODE_ENV=production npm run build'
check_status "Asset build"

log "Compiling asset map..."
sudo -E docker compose -f docker-compose.prod.yml exec -T php bash -c 'cd /var/www/html/src && php bin/console asset-map:compile --env=prod'
check_status "Asset map compilation"

# Setup database
log "Running database migrations..."
sudo -E docker compose -f docker-compose.prod.yml exec -T php bash -c 'cd /var/www/html/src && php bin/console doctrine:migrations:migrate --no-interaction'
check_status "Database migration"

# Wait for Elasticsearch
wait_for_elasticsearch

# Delete existing indices
log "Deleting existing Elasticsearch indices..."
sudo -E docker compose -f docker-compose.prod.yml exec -T php bash -c 'cd /var/www/html/src && php bin/console fos:elastica:delete --env=prod'
check_status "Elasticsearch indices deletion"

# Create new indices
log "Creating Elasticsearch indices..."
sudo -E docker compose -f docker-compose.prod.yml exec -T php bash -c 'cd /var/www/html/src && php bin/console fos:elastica:create --env=prod'
check_status "Elasticsearch index creation"

# Populate indices
log "Populating Elasticsearch indices..."
sudo -E docker compose -f docker-compose.prod.yml exec -T php bash -c 'cd /var/www/html/src && php bin/console fos:elastica:populate --env=prod'
check_status "Elasticsearch population"

log "🎉 Deployment completed successfully!"