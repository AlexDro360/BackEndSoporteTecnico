FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo_mysql gd

WORKDIR /var/www

COPY composer.json composer.lock ./
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY . .

RUN php artisan package:discover --ansi

RUN chown -R www-data:www-data /var/www