FROM php:8.3-fpm

WORKDIR /var/www/laravel_app/

RUN docker-php-ext-install mysqli pdo pdo_mysql sockets
# COPY /usr/local/etc/php/php.ini-production /usr/local/etc/php.ini