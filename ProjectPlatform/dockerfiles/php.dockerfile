FROM php:8.3-fpm

WORKDIR /var/www/laravel/

RUN docker-php-ext-install mysqli pdo pdo_mysql
