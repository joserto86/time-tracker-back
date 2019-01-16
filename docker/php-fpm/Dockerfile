FROM php:7.2-fpm

RUN apt update && apt -y upgrade

# Install required dependencies
RUN apt install --yes --no-install-suggests --no-install-recommends \
    curl unzip wget vim tree ccze git

# Install required dependencies
RUN apt install --yes --no-install-suggests --no-install-recommends \
    openssl sudo apt-utils

RUN apt install --yes --no-install-suggests --no-install-recommends \
    libfreetype6-dev libjpeg-dev libpng-dev

RUN apt install --yes --no-install-suggests --no-install-recommends \
    libicu-dev libmcrypt-dev mysql-client libzip-dev

RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql
RUN docker-php-ext-install   pdo_mysql

RUN docker-php-ext-configure mbstring --enable-mbstring
RUN docker-php-ext-install   mbstring

RUN docker-php-ext-configure gd --enable-gd-native-ttf --with-jpeg-dir=/usr/lib --with-freetype-dir=/usr/include/
RUN docker-php-ext-install   gd

RUN docker-php-ext-configure intl
RUN docker-php-ext-install   intl

RUN docker-php-ext-install iconv
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install opcache
RUN docker-php-ext-install zip

## Hay que probar que funciona y hacer lo mismo para LDAP
#RUN apt install --yes --no-install-suggests --no-install-recommends libldap2-dev libxml2-dev pkg-config libssl-dev zlib1g-dev libc-client-dev libkrb5-dev
#RUN docker-php-ext-install -j$(nproc) soap

# Imagick
#RUN apt install --yes --no-install-suggests --no-install-recommends libmagickwand-dev
#RUN pecl install imagick
#RUN docker-php-ext-enable imagick

# MongoDB
#RUN pecl install mongodb
#RUN docker-php-ext-enable mongodb

# Redis
RUN pecl install redis
RUN docker-php-ext-enable redis

# Xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# Limpiar todo
RUN apt purge --auto-remove -y g++ && apt autoremove && apt clean
RUN rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Install Symfony
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN export PATH="$HOME/.symfony/bin:$PATH" && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

ENV HOME /opt
WORKDIR /opt/symfony
