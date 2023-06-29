FROM php:8-alpine
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN wget https://phar.phpunit.de/phpunit-10.phar -O /usr/local/bin/phpunit && \
    chmod +x /usr/local/bin/phpunit