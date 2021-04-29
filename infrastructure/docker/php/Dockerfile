FROM php:8-fpm

RUN apt-get update && apt-get upgrade -y

RUN apt-get update && apt-get install -y --no-install-recommends git zlib1g-dev libxml2-dev libzip-dev unzip
RUN docker-php-ext-install zip intl mysqli pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN curl -sS https://get.symfony.com/cli/installer | bash && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

COPY / /var/www/symfony
WORKDIR /var/www/symfony/
