FROM php:7.4-cli

RUN pecl install -o -f redis && rm -rf /tmp/pear

RUN apt-get update && apt-get install -y libpq-dev unzip mariadb-client libpng-dev libzip-dev zlib1g-dev libxml2-dev libc-client-dev libkrb5-dev  \
    && docker-php-ext-install pdo_mysql gd exif dom zip

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

WORKDIR /app
