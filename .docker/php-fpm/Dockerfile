ARG PHP_VERSION=8.4

FROM php:${PHP_VERSION}-fpm

ARG USER_ID=1000
ARG GROUP_ID=1000

COPY ./config/php.ini /usr/local/etc/php/php.ini
COPY ./config/php-fpm.d/* /usr/local/etc/php-fpm.d/

RUN apt update && apt upgrade -y && apt install -y wget curl ca-certificates git zip unzip libzip-dev mc

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync

RUN install-php-extensions @composer zip opcache intl pdo_pgsql pdo_mysql bcmath
RUN install-php-extensions gd exif
RUN install-php-extensions xsl amqp redis excimer

RUN apt update && apt install -y autoconf gcc libc-dev make inotify-tools
RUN pecl install pcov && \
    docker-php-ext-enable pcov

RUN groupadd app -g ${GROUP_ID}
RUN useradd app -u ${USER_ID} -g ${GROUP_ID} -m -s /bin/bash

WORKDIR /var/www/html

USER app:app

#CMD touch /var/www/html/var/cache && chmod go+w -R /var/www/html/var/cache && php-fpm
CMD php-fpm
