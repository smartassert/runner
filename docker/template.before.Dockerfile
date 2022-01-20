ARG php_version=8.1

FROM php:8.1-cli-buster

LABEL org.opencontainers.image.source="https://github.com/smartassert/runner"

ARG proxy_server_version=0.8
ARG php_version

WORKDIR /app

ENV PANTHER_NO_SANDBOX=1

RUN apt-get update \
    && apt-get install -y --no-install-recommends libzip-dev nano zip \
    && docker-php-ext-install pcntl zip > /dev/null \
    && apt-get autoremove -y \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY composer.json phpunit.run.xml /app/
COPY bin /app/bin
COPY src /app/src

RUN composer install --prefer-dist --no-dev \
    && composer clear-cache \
    && rm composer.json \
    && curl -L https://raw.githubusercontent.com/webignition/tcp-cli-proxy-server/${proxy_server_version}/composer.json --output composer.json \
    && curl -L https://github.com/webignition/tcp-cli-proxy-server/releases/download/${proxy_server_version}/composer-${php_version}.lock --output composer.lock \
    && composer check-platform-reqs --ansi \
    && rm composer.json \
    && rm composer.lock \
    && rm /usr/bin/composer \
    && curl -L https://github.com/webignition/tcp-cli-proxy-server/releases/download/${proxy_server_version}/server-${php_version}.phar --output ./server \
    && chmod +x ./server
