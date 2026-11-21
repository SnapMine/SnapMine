FROM dunglas/frankenphp:1.14.0-php8.5

RUN install-php-extensions \
    parallel \
    sockets \
    gmp \
    zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json ./

RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY . .

RUN composer dump-autoload --optimize --no-dev

ENTRYPOINT ["frankenphp"]
CMD ["php-cli", "server.php"]