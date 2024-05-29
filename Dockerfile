FROM php:cli-alpine

RUN docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install \
        pcntl