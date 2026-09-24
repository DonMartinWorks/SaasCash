ARG PHP_VERSION=8.5-fpm-alpine
FROM php:${PHP_VERSION}

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apk add --no-cache \
    bash \
    git \
    curl \
    postgresql-client \
    && install-php-extensions \
    gd \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    zip \
    intl \
    bcmath \
    opcache \
    pcntl \
    redis

RUN echo "upload_max_filesize = 32M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 35M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "opcache.enable_cli = 1" >> /usr/local/etc/php/conf.d/opcache.ini

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html/src

EXPOSE 9000
CMD ["php-fpm"]