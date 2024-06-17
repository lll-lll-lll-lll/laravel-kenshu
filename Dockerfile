
FROM php:8.3-fpm 
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN apt-get update && apt-get install -y \
    git \
&& docker-php-ext-install pdo_mysql \
