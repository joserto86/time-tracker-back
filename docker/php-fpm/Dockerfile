FROM hub.irontec.com/internet/dockerfiles/php-fpm/7.4:14cd65a1117d4f38cefe617422da7a4bf94a0ee9

# Xdebug
ARG XDEBUG=false
USER root
RUN if [ "${XDEBUG}" = "true" ] ; then pecl install xdebug; docker-php-ext-enable xdebug; mv /usr/local/etc/php/conf.d/xdebug.disabled /usr/local/etc/php/conf.d/xdebug.ini; fi

ADD docker/php-fpm/opcache.ini /usr/local/etc/php/conf.d/opcache.dev

# Opcache
RUN if [ "${XDEBUG}" = "true" ] ; then mv /usr/local/etc/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.disable; fi
RUN if [ "${XDEBUG}" = "true" ] ; then mv /usr/local/etc/php/conf.d/opcache.dev /usr/local/etc/php/conf.d/opcache.ini; fi

# symfony-cli
RUN wget https://get.symfony.com/cli/installer -O - | bash && \
    export PATH="$HOME/.symfony/bin:$PATH" && \
    mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Image
USER docker

ADD --chown=docker:docker ./symfony/ /opt/symfony/

WORKDIR /opt/symfony

RUN composer install
