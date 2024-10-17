
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
    
## Access

to acces the website this is the link : 
http://localhost:8080/

## Tests

to launch tests of phpunit : 

```
sudo docker exec php-container ./vendor/bin/phpunit

```
