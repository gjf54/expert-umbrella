FROM composer:latest

WORKDIR /var/www/laravel_app

# ENTRYPOINT [ "composer", "--ignore-platform-reqs" ]