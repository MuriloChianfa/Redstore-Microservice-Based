# PHP 7.2 docker apache image
FROM php:7.2-apache

MAINTAINER Murilo Chianfa <github.com/murilochianfa>

# Adicionar extenções PDO
RUN docker-php-ext-install mysqli pdo pdo_mysql pcntl

RUN apt-get update && apt-get -o Acquire::ForceIPv4=true -y install net-tools zip && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN ln -s /etc/apache2/mods-available/ssl.load  /etc/apache2/mods-enabled/ssl.load

# Adicionar certificados auto assinados
RUN mkdir -p /var/run/apache2/ssl/
COPY ./ssl.key /etc/apache2/ssl/ssl.key
COPY ./ssl.crt /etc/apache2/ssl/ssl.crt

# Copiar conf com ssl habilitado
COPY ./000-default.conf /etc/apache2/sites-enabled/000-default.conf 

# Habilitar portas de acesso
COPY ./ports.conf /etc/apache2/ports.conf

# Adicionar php.ini de produção!
COPY ./php.ini "$PHP_INI_DIR/php.ini"

# Habilitar log do container
RUN rm -rf /var/log/apache2/access.log
RUN sed -i 's/error_log = syslog/error_log = \/var\/log\/apache2\/error.log/g' "$PHP_INI_DIR/php.ini"
RUN ln -sf /dev/stdout /var/log/apache2/error.log

# Set all front files
# WORKDIR /var/www/html/
# ADD ./api.zip /var/www/html/
# RUN unzip api.zip && mv /var/www/html/api/* /var/www/html/ && rm api.zip

# removing bins
# RUN rm -rf /usr/bin/wget /usr/bin/curl /usr/bin/apt-get /usr/bin/apt /usr/bin/unzip /usr/bin/which /usr/bin/whereis /usr/bin/whoami
# RUN for entry in $(ls /usr/sbin/ | grep -v apache2); do rm -rf "/usr/sbin/$entry"; done

# COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# ssl port
EXPOSE 443

