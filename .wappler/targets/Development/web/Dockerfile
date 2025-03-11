FROM php:8.2-apache

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

RUN a2enmod rewrite

# install the PHP extensions we need
RUN apt-get update && apt-get install -y libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev libzip-dev libpq-dev libonig-dev libfreetype6-dev \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && docker-php-ext-install gd \
    && docker-php-ext-install mbstring zip pdo pdo_mysql && docker-php-ext-enable pdo_mysql \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && docker-php-ext-install pdo_pgsql pgsql

# Install PHP Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
