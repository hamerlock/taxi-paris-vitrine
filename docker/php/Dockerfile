FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git unzip zip libicu-dev libonig-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install intl pdo pdo_mysql zip opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Si public/vendor n'a pas été installé, ajoute ici :
RUN php bin/console importmap:install --no-interaction

CMD ["php-fpm"]