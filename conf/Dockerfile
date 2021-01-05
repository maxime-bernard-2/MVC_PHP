FROM php:8.0-apache

WORKDIR /site

# PHP Extensions
RUN docker-php-ext-install -j$(nproc) pdo_mysql

# Apache
COPY vhost.conf /etc/apache2/sites-available/000-default.conf
COPY apache.conf /etc/apache2/conf-available/z-app.conf

RUN chmod -R 0777 /site

RUN a2enmod rewrite remoteip && \
    a2enconf z-app