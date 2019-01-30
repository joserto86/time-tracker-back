FROM php:7.2-fpm

ARG XDEBUG=false

RUN apt update && apt upgrade --yes
RUN apt autoremove --yes

RUN apt remove --yes mysql* mariadb*
RUN apt autoremove --yes

# Install required dependencies
RUN apt install --yes --no-install-suggests --no-install-recommends \
    curl unzip wget vim tree ccze git gnupg

RUN echo "deb http://repo.mysql.com/apt/debian/ stretch mysql-5.7\n\
deb-src http://repo.mysql.com/apt/debian/ stretch mysql-5.7" >> /etc/apt/sources.list.d/mysql.list

RUN wget -O /tmp/RPM-GPG-KEY-mysql https://repo.mysql.com/RPM-GPG-KEY-mysql
RUN apt-key add /tmp/RPM-GPG-KEY-mysql

RUN apt update && apt --yes upgrade

# Install required dependencies
RUN apt install --yes --no-install-suggests --no-install-recommends \
    openssl sudo apt-utils

# Install dependencies for the image processing
RUN apt install --yes --no-install-suggests --no-install-recommends \
    libfreetype6-dev libjpeg-dev libpng-dev

# Others
RUN apt install --yes --no-install-suggests --no-install-recommends \
    libicu-dev libmcrypt-dev libzip-dev mysql-client

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

# Imagick
#RUN apt install --yes --no-install-suggests --no-install-recommends libmagickwand-dev
#RUN pecl install imagick
#RUN docker-php-ext-enable imagick

# Redis
RUN pecl install redis
RUN docker-php-ext-enable redis

# LDAP
#RUN ???

# Soap
#RUN apt install --yes --no-install-suggests --no-install-recommends libxml2-dev
#RUN docker-php-ext-install soap

# MongoDB
#RUN pecl install mongodb
#RUN docker-php-ext-enable mongodb

# Install apcu
RUN pecl install apcu
RUN docker-php-ext-enable apcu

# Xdebug
RUN if [ "${XDEBUG}" = "true" ] ; then /dev/null ; pecl install xdebug; docker-php-ext-enable xdebug; fi

# Limpiar todo
RUN apt autoremove --yes && apt clean
RUN rm -rf /var/lib/apt/lists/*

# añadir .ini de PHP
ADD docker/php-fpm/ini/exif.ini /usr/local/etc/php/conf.d/exif.ini
ADD docker/php-fpm/ini/iconv.ini /usr/local/etc/php/conf.d/iconv.ini
ADD docker/php-fpm/ini/mbstring.ini /usr/local/etc/php/conf.d/mbstring.ini
ADD docker/php-fpm/ini/session.ini /usr/local/etc/php/conf.d/session.ini
ADD docker/php-fpm/ini/timezone.ini /usr/local/etc/php/conf.d/timezone.ini
ADD docker/php-fpm/ini/various.ini /usr/local/etc/php/conf.d/various.ini
ADD docker/php-fpm/ini/www.conf /usr/local/etc/php-fpm.d/www.conf
ADD docker/php-fpm/ini/www.conf.default /usr/local/etc/php-fpm.d/www.conf.default
ADD docker/php-fpm/ini/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
ADD docker/php-fpm/ini/zlib.ini /usr/local/etc/php/conf.d/zlib.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Install Symfony
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN export PATH="$HOME/.symfony/bin:$PATH" && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

ENV HOME /opt
WORKDIR /opt/symfony
