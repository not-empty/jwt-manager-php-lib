ARG PHP_VERSION=8.4-cli
FROM php:${PHP_VERSION}

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    && docker-php-ext-install pdo pdo_mysql

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/xdebug.ini \
 && echo "xdebug.start_with_request=no" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

WORKDIR /var/www/html

CMD ["bash"]