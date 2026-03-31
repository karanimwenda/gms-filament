# https://github.com/docker-library/php/issues/797
ARG PHP_EXTS="pdo pdo_mysql pcntl zip gd intl"
ARG PHP_EXT_HOSTS="zip libzip-dev freetype-dev libjpeg-turbo-dev libpng-dev libwebp-dev icu-dev jpegoptim optipng pngquant gifsicle libwebp-tools libavif-apps"


# ========================================
# Install extensions
# ========================================
FROM composer:lts AS build

COPY . /app/

RUN mkdir -p .git/hooks && \
    composer install --prefer-dist --optimize-autoloader --no-interaction --ignore-platform-reqs


# ========================================
# For php artisan cli etc
# ========================================
FROM php:8.4-cli-alpine AS cli

ARG PHP_EXTS
ARG PHP_EXT_HOSTS

WORKDIR /opt/apps/www

RUN apk update && apk add ${PHP_EXT_HOSTS} && \
  docker-php-ext-configure opcache --enable-opcache && \
  docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype && \
  docker-php-ext-configure intl && \
  docker-php-ext-install ${PHP_EXTS}

COPY devops/docker/php/conf.d/php.ini /usr/local/etc/php/conf.d/php.ini
COPY devops/docker/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

COPY --from=build --chown=www-data:www-data /app /opt/apps/www



# ========================================
# FPM server to process requests
# ========================================
FROM php:8.4-fpm-alpine AS fpm_server

ARG PHP_EXTS
ARG PHP_EXT_HOSTS

WORKDIR /opt/apps/www

RUN apk update && apk add ${PHP_EXT_HOSTS} && \
  docker-php-ext-configure opcache --enable-opcache && \
  docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype && \
  docker-php-ext-configure intl && \
  docker-php-ext-install ${PHP_EXTS}

# As FPM uses the www-data user when running our application,
# we need to make sure that we also use that user when starting up,
# so our user "owns" the application when running
USER www-data

COPY devops/docker/php/conf.d/php.ini /usr/local/etc/php/conf.d/php.ini
COPY devops/docker/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

COPY --from=build --chown=www-data:www-data /app /opt/apps/www

RUN php artisan storage:link


# ========================================
# NGINX container
# ========================================
FROM nginx:1.25-alpine AS nginx_server

WORKDIR /opt/apps/www


# We need to add our NGINX template to the container for startup,
# and configuration.
COPY devops/docker/nginx/nginx.conf /etc/nginx/templates/default.conf.template

# Copy in ONLY the public directory of our project.
# This is where all the static assets will live, which nginx will serve for us.
COPY --from=build /app/public /opt/apps/www/public
