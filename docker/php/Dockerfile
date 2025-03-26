FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    curl \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    rm -rf /var/lib/apt/lists/*

# Configure GD and install PHP extensions
RUN docker-php-ext-configure gd --with-jpeg --with-freetype && \
    docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    zip \
    intl \
    gd \
    opcache

# Install XDebug
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    echo "xdebug.mode=develop,debug\n\
    xdebug.client_host=host.docker.internal\n\
    xdebug.start_with_request=yes" > /usr/local/etc/php/conf.d/xdebug.ini

# Configure PHP for development
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" && \
    echo "memory_limit = 512M\n\
    upload_max_filesize = 20M\n\
    post_max_size = 20M\n\
    max_execution_time = 300\n\
    opcache.enable=0" > /usr/local/etc/php/conf.d/custom.ini

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Create proper directory structure
RUN mkdir -p var/cache var/log public/build && \
    chown -R www-data:www-data var public/build

# Fix file update detection by disabling opcache and setting proper permissions
RUN chmod -R 775 var

# Create non-root user
RUN useradd -m -u 1000 -g www-data developer && \
    chown -R developer:www-data /var/www/html

USER developer

EXPOSE 9000

CMD ["php-fpm"]