# Use the official PHP image as the base image with PHP 8.1
FROM php:8.1-fpm

# ... Other configurations and installations ...

# Copy the application code to the container
COPY . /var/www/html

# Set the working directory
WORKDIR /var/www/html

# Install Composer and other dependencies
RUN apt-get update \
    && apt-get install -y git zip unzip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions required by Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Expose port 9000
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]

# Run Composer to install the application dependencies
RUN composer install
