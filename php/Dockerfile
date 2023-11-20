FROM php:8.2-fpm-alpine

# Install extensions mysql 
RUN docker-php-ext-install mysqli pdo_mysql

WORKDIR /var/www/html

EXPOSE 9000