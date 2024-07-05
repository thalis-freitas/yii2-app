FROM php:7.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --version=1.10.22 \
    && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www

COPY src/ /var/www

RUN chown -R www-data:www-data /var/www

EXPOSE 9000
CMD ["php-fpm"]
