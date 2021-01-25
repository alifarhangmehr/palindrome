FROM php:8.0.1-apache

RUN a2enmod rewrite
RUN a2enmod headers

#Install bare minimum on os
RUN apt-get update \
    && apt-get install -y git \
    && apt-get install -y zip \
    && apt-get install -y unzip \
    && apt-get install -y vim \
    && apt-get install -y nano

RUN docker-php-ext-install pdo pdo_mysql mysqli

#Copy Files and folders
COPY .htaccess /var/www/html/.htaccess
COPY index.php /var/www/html/index.php
COPY composer.json /var/www/html/composer.json

ADD Service /var/www/html/Service
ADD Router /var/www/html/Router
ADD Controller /var/www/html/Controller
ADD Model /var/www/html/Model
ADD Helper /var/www/html/Helper
ADD sql /var/www/html/sql
ADD tests /var/www/html/tests
ADD wrappers /var/www/html/wrappers

#Use production ini file as default
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Install & Run Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer update

EXPOSE 80
