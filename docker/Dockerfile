FROM php:8.1.18-apache
LABEL authors="Javier Fuentes"

ADD api.tar.gz /var/www/html

COPY apache2.conf /etc/apache2/apache2.conf
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite; \
    a2enmod headers; \
    chown -R www-data:www-data /var/www/html


