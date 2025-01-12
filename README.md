
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