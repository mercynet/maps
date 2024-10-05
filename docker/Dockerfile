# Use the official PHP image as a base
FROM php:8.3-fpm

# Set the working directory
WORKDIR /var/www/html

# Enable debugging and stop on errors
RUN set -x && set -e

# Install dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the composer.json file from the root of the project
COPY ../composer.json ./

# Display the contents of composer.json
RUN cat composer.json

# Validate composer.json
RUN composer validate

# Update Composer to the latest version
RUN composer self-update

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copy the rest of the application code
COPY . .

# Expose port 9000 and start PHP-FPM server
EXPOSE 9000
CMD ["php-fpm"]