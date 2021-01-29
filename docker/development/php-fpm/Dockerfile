FROM php:7.4-fpm

RUN pecl install -o -f redis && rm -rf /tmp/pear

RUN apt-get update && apt-get install -y libpq-dev libpng-dev zlib1g-dev libfreetype6-dev \
        libwebp-dev libjpeg62-turbo-dev libmcrypt-dev mariadb-client libzip-dev libxml2-dev libgmp-dev libldap2-dev \
        libc-client-dev libkrb5-dev \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-webp=/usr/include/  --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd exif pdo_mysql dom zip

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

WORKDIR /app
