FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxslt-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libxml2-dev

# Install PHP extensions for MySQL, PostgreSQL, and others
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql zip opcache intl gd

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 9000
EXPOSE 9000

CMD ["php-fpm"]
