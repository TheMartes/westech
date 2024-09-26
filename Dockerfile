FROM php:8.3-alpine3.20

WORKDIR /app

COPY . .

RUN apk add --no-cache curl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer dump-autoload

RUN docker-php-ext-install mysqli pdo pdo_mysql

CMD php -S 0.0.0.0:80