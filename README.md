
# Car marketplace 

 Car Marketplace

A web application for buying and selling vehicles. Users can list their cars for sale, browse available listings, and communicate with sellers.

## Features

- User registration and authentication
- Create, read, update, and delete (CRUD) listings
- Search and filter car listings
- Upload media (images/videos) for each listing
- User profiles with listing history

## Technologies Used

- **Backend**: Symfony, Doctrine ORM
- **Frontend**: Twig, Tailwind CSS
- **Database**: MySQL
- **Search-engine**: Elastic search
- **Containerization**: Docker


## Installation

to Get started clone the repository : 
```bash
git clone https://github.com/altib1/car-marketplace.git
```

```bash
  docker-compose up --build -d

  docker-compose exec php bash

  php bin/console doctrine:schema:update --force

  php bin/console doctrine:fixtures:load

  php bin/console tailwind:build --watch
```
## Elastic Search 

```bash
  docker-compose exec php bash

  php bin/console fos:elastica:create

  php bin/console fos:elastica:populate
```
notes:
fos_elastica.yaml whould have the env not directly the url, but for some reason its not getting it -> FIXME

## Access

to acces the website this is the link : 
http://localhost:8080/

## Tests

to launch tests of phpunit : 

```
sudo docker exec php-container ./vendor/bin/phpunit

```

## To launch messages

to launch messages on the app : 

```
# For development
php bin/console messenger:consume async -vv

# For production (with supervisor recommended)
php bin/console messenger:consume async --limit=10 --time-limit=3600

```

For production, you should set up Supervisor to keep the consumer running. Here's an example supervisor configuration:

```
[program:messenger-consume]
command=php /path/to/your/project/bin/console messenger:consume async --time-limit=3600 --limit=10
user=www-data
numprocs=2
autostart=true
autorestart=true
process_name=%(program_name)s_%(process_num)02d

```

## Production

```bash
# Copy and configure production environment
cp .env .env.prod
```

Edit `.env.prod` with required variables:
```env
APP_ENV=prod
APP_SECRET=your_secure_secret
DATABASE_URL="mysql://app_user:app_password@db:3306/car_marketplace?serverVersion=8.0"
ELASTICSEARCH_URL="http://elasticsearch:9200"
MYSQL_ROOT_PASSWORD=your_secure_root_password
MYSQL_DATABASE=car_marketplace
MYSQL_USER=app_user
MYSQL_PASSWORD=your_secure_password
ELASTIC_PASSWORD=your_secure_elastic_password
DOCKER_UID=1000
DOCKER_GID=1000
```

### 2. Production Setup Steps

```bash
# Fix host permissions
sudo chown -R $(id -u):$(id -g) src/
sudo chmod -R 775 src/
sudo find src/ -type d -exec chmod 777 {} \;

# Remove existing containers and volumes
sudo docker compose -f docker-compose.prod.yml down -v

# Rebuild and start containers
sudo docker compose -f docker-compose.prod.yml up -d --build

# Install production dependencies
sudo docker compose -f docker-compose.prod.yml exec php composer install --no-dev --optimize-autoloader
sudo docker compose -f docker-compose.prod.yml exec php bash -c 'cd /var/www/html/src && npm install'

# Clear cache and warm up
sudo docker compose -f docker-compose.prod.yml exec php php bin/console cache:clear --env=prod
sudo docker compose -f docker-compose.prod.yml exec php php bin/console cache:warmup --env=prod

# Build assets
sudo docker compose -f docker-compose.prod.yml exec php bash -c 'cd /var/www/html/src && NODE_ENV=production npm run build'
sudo docker compose -f docker-compose.prod.yml exec php php bin/console asset-map:compile --env=prod

# Setup database
sudo docker compose -f docker-compose.prod.yml exec php php bin/console doctrine:migrations:migrate --no-interaction --env=prod

# Setup Elasticsearch
sudo docker compose -f docker-compose.prod.yml exec php php bin/console fos:elastica:create --env=prod
sudo docker compose -f docker-compose.prod.yml exec php php bin/console fos:elastica:populate --env=prod
```

### 3. Supervisor Setup for Message Queue

Create supervisor configuration:
```ini
[program:messenger-consume]
command=php /var/www/html/src/bin/console messenger:consume async --time-limit=3600 --limit=10 --env=prod
user=www-data
numprocs=2
autostart=true
autorestart=true
process_name=%(program_name)s_%(process_num)02d
```

### 4. Verify Deployment

```bash
# Check application status
sudo docker compose -f docker-compose.prod.yml ps

# View logs
sudo docker compose -f docker-compose.prod.yml logs -f php
sudo docker compose -f docker-compose.prod.yml logs -f nginx

# Test the application
curl -I http://localhost
```

### 5. Troubleshooting

If you see 404 errors:
1. Verify Nginx configuration:
```bash
sudo docker compose -f docker-compose.prod.yml exec nginx nginx -t
```

2. Check PHP-FPM status:
```bash
sudo docker compose -f docker-compose.prod.yml exec php php-fpm -t
```

3. Verify file permissions:
```bash
sudo docker compose -f docker-compose.prod.yml exec php ls -la /var/www/html/src/public
```

4. Check Symfony logs:
```bash
sudo docker compose -f docker-compose.prod.yml exec php tail -f /var/www/html/src/var/log/prod.log
```
