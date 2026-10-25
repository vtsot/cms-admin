# syntax=docker/dockerfile:1

# Production image of the CMS admin / API.
#
# Targets:
#   app   (default) - php-fpm with the application code, vendors and built assets
#   nginx           - nginx serving public/ and proxying PHP to the "php-fpm" host
#
#   docker build -t cms-admin:latest .
#   docker build -t cms-admin-nginx:latest --target nginx .
#
# The local development stack keeps using docker-compose.yaml and .docker/*/Dockerfile.

ARG PHP_VERSION=8.4
ARG NODE_VERSION=24

###############################################################################
# PHP runtime: extensions shared by the build stages and the final image
###############################################################################
FROM php:${PHP_VERSION}-fpm AS php-base

ARG USER_ID=1000
ARG GROUP_ID=1000

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apt-get update \
    && apt-get install -y --no-install-recommends ca-certificates git unzip \
    && install-php-extensions @composer zip opcache intl pdo_mysql bcmath gd exif xsl amqp redis \
    && rm -rf /var/lib/apt/lists/*

RUN groupadd app -g ${GROUP_ID} \
    && useradd app -u ${USER_ID} -g ${GROUP_ID} -m -s /bin/bash

COPY .docker/php-fpm/config/php.ini /usr/local/etc/php/php.ini
COPY .docker/php-fpm/config/php-fpm.d/* /usr/local/etc/php-fpm.d/
COPY .docker/php-fpm/config/php.prod.ini /usr/local/etc/php/conf.d/zz-prod.ini

ENV APP_ENV=prod \
    APP_DEBUG=0 \
    COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_NO_INTERACTION=1

WORKDIR /var/www/html

###############################################################################
# Composer dependencies (cached until composer.json / composer.lock change)
###############################################################################
FROM php-base AS vendor

COPY composer.json composer.lock symfony.lock ./

RUN --mount=type=cache,target=/root/.composer/cache \
    composer install --no-dev --prefer-dist --no-autoloader --no-scripts --no-progress

###############################################################################
# Frontend assets (webpack encore -> public/assets)
###############################################################################
FROM node:${NODE_VERSION}-alpine AS assets

WORKDIR /var/www/html

COPY package.json yarn.lock ./

RUN --mount=type=cache,target=/usr/local/share/.cache/yarn \
    yarn install --frozen-lockfile

COPY webpack.config.js ./
COPY assets ./assets

RUN yarn run build

###############################################################################
# Application image (php-fpm)
###############################################################################
FROM php-base AS app

COPY --from=vendor /var/www/html/vendor ./vendor
COPY . .
COPY --from=assets /var/www/html/public/assets ./public/assets

# composer auto-scripts: cache:clear, assets:install public, ckeditor:install, elfinder:install;
# install-editor: ckeditor/elfinder again + assets:install after them, so public/bundles gets their files
RUN composer dump-autoload --no-dev --classmap-authoritative \
    && composer run-script --no-dev post-install-cmd \
    && composer run-script --no-dev install-editor \
    && rm -rf var/cache/prod \
    && mkdir -p var/cache var/log var/session var/storage var/share public/uploaded \
    && chown -R app:app var public/uploaded

COPY --chmod=0755 .docker/php-fpm/docker-entrypoint.sh /usr/local/bin/docker-entrypoint

USER app:app

# uploaded files, sessions and logs must outlive the container
VOLUME ["/var/www/html/var/storage", "/var/www/html/var/session", "/var/www/html/public/uploaded"]

EXPOSE 9000

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]

###############################################################################
# Web server: static files from the app image + fastcgi to php-fpm:9000
###############################################################################
FROM nginx:mainline-alpine AS nginx

COPY .docker/nginx/config/nginx.conf /etc/nginx/nginx.conf
COPY .docker/nginx/config/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY --from=app /var/www/html/public /var/www/html/public

WORKDIR /var/www/html

###############################################################################
# Keep "app" as the default target of a plain `docker build .`
###############################################################################
FROM app
