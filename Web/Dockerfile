FROM php:7.4-apache

MAINTAINER Murilo Chianfa <https://github.com/murilochianfa>

RUN chmod -R a+r /var/www/html/

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

EXPOSE 80
