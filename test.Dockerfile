FROM php:8.1-fpm

ARG PHP_UID
ARG PHP_GID

USER root

RUN apt-get update -y
RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev && \
  docker-php-ext-install pdo pdo_mysql bcmath

COPY . .

RUN addgroup --gid ${PHP_GID} www || :

RUN adduser --no-create-home --disabled-password --uid ${PHP_UID} --ingroup www www || :

RUN chown -R www:www /var/www

USER www

COPY --from=composer:2.6.5 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

ENTRYPOINT [ "bash", "test.entrypoint.sh" ]