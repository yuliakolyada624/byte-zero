FROM php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install zip pdo_mysql intl gd mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Set Apache DocumentRoot
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html

# Copy Apache configuration file
# COPY ./php.ini /usr/local/etc/php/php.ini

# Allow Composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Set permissions for the WRITEPATH directory
RUN mkdir -p /var/www/html/writable/debugbar && \
    chown -R www-data:www-data /var/www/html/writable && \
    chmod -R 775 /var/www/html/writable

# Run Composer install
RUN composer install --prefer-dist

# Expose default ports
EXPOSE 80 443