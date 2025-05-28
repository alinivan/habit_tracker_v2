FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    gnupg

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Create directory and set permissions
RUN mkdir -p /var/www && \
    chown -R www-data:www-data /var/www

# Switch to www-data user
USER www-data

# Create directories for volumes
RUN mkdir -p /var/www/vendor /var/www/node_modules

# Copy composer files first
COPY --chown=www-data:www-data composer.json composer.lock ./

# Install dependencies without scripts
RUN composer install --no-scripts --no-autoloader

# Copy package files
COPY --chown=www-data:www-data package.json package-lock.json ./

# Install npm dependencies
RUN npm ci

# Copy the rest of the application
COPY --chown=www-data:www-data . .

# Generate autoloader and run scripts
RUN composer dump-autoload --optimize 