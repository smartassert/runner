FROM php:8.0-cli-buster

LABEL org.opencontainers.image.source="https://github.com/smartassert/runner"

ARG proxy_server_version=0.7

WORKDIR /app

ENV PANTHER_NO_SANDBOX=1

RUN apt-get update \
    && apt-get install -y --no-install-recommends libzip-dev nano zip \
    && docker-php-ext-install pcntl zip > /dev/null \
    && apt-get autoremove -y \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock phpunit.run.xml /app/
COPY bin /app/bin
COPY src /app/src

RUN composer check-platform-reqs --ansi \
    && composer install --prefer-dist --no-dev \
    && composer clear-cache \
    && curl https://raw.githubusercontent.com/webignition/docker-tcp-cli-proxy/${proxy_server_version}/composer.json --output composer.json \
    && curl https://raw.githubusercontent.com/webignition/docker-tcp-cli-proxy/${proxy_server_version}/composer.lock --output composer.lock \
    && composer check-platform-reqs --ansi \
    && rm composer.json \
    && rm composer.lock \
    && rm /usr/bin/composer \
    && curl https://github.com/webignition/docker-tcp-cli-proxy/releases/download/${proxy_server_version}/server.phar -L --output ./server \
    && chmod +x ./server
