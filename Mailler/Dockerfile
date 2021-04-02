FROM php:8.0.3-alpine3.13

MAINTAINER Murilo Chianfa <github.com/murilochianfa>

# install docker for php
RUN docker-php-ext-install sockets

# install net-tools for heakthcheck
RUN apk update && apk add --no-cache net-tools

# add composer to install all dependencis
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN mkdir /app
COPY . /app/

# RUN cd /app/ && rm -rf vendor/ && composer install && composer update && composer fund

CMD cd /app/ && composer install && php -f /app/Listener.php > /dev/stdout 2> /dev/stdout
