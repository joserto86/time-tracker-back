FROM php:7.2-fpm

RUN apt update && apt -y upgrade

# Install required dependencies
RUN apt install --yes --no-install-suggests --no-install-recommends \
    curl unzip wget openssl sudo apt-utils

# Install required tools
RUN apt install --yes --no-install-suggests --no-install-recommends \
    vim tree ccze git

# Install dependencies for the image processing
RUN apt install --yes --no-install-suggests --no-install-recommends \
    libfreetype6-dev libjpeg-dev libpng-dev

# Others
RUN apt install --yes --no-install-suggests --no-install-recommends \
    libicu-dev libmcrypt-dev mysql-client libzip-dev

# MySQL PDO
RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql
RUN docker-php-ext-install   pdo_mysql

# Mbstring
RUN docker-php-ext-configure mbstring --enable-mbstring
RUN docker-php-ext-install   mbstring

# GD
RUN docker-php-ext-configure gd --enable-gd-native-ttf --with-jpeg-dir=/usr/lib --with-freetype-dir=/usr/include/
RUN docker-php-ext-install   gd

# intl
RUN docker-php-ext-configure intl
RUN docker-php-ext-install   intl

RUN docker-php-ext-install iconv
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install opcache
RUN docker-php-ext-install zip
RUN docker-php-ext-install bcmath

# LDAP
#RUN ???

# Soap
#RUN apt install --yes --no-install-suggests --no-install-recommends libxml2-dev
#RUN docker-php-ext-install soap

# Imagick
#RUN apt install --yes --no-install-suggests --no-install-recommends libmagickwand-dev
#RUN pecl install imagick
#RUN docker-php-ext-enable imagick

# MongoDB
#RUN pecl install mongodb
#RUN docker-php-ext-enable mongodb

# Install apcu
RUN pecl install apcu
RUN docker-php-ext-enable apcu

# Redis
RUN pecl install redis
RUN docker-php-ext-enable redis

# Xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# Limpiar todo
RUN apt autoremove && apt clean
RUN rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Install Symfony
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN export PATH="$HOME/.symfony/bin:$PATH" && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

ENV HOME /opt
WORKDIR /opt/symfony
