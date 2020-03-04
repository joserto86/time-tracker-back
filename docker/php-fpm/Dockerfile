FROM hub.irontec.com/internet/dockerfiles/php-fpm/7.4.0:6d4aa47088c38218dc8f8a6cdb6ae8947b9b140b

# Xdebug
ARG XDEBUG=false
USER root
RUN if [ "${XDEBUG}" = "true" ] ; then pecl install xdebug; docker-php-ext-enable xdebug; mv /usr/local/etc/php/conf.d/xdebug.disabled /usr/local/etc/php/conf.d/xdebug.ini; mv /usr/local/etc/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.disable; fi

ADD docker/php-fpm/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN wget https://get.symfony.com/cli/installer -O - | bash && \
    export PATH="$HOME/.symfony/bin:$PATH" && \
    mv /root/.symfony/bin/symfony /usr/local/bin/symfony

USER docker

ADD --chown=docker:docker ./symfony/ /opt/symfony/

WORKDIR /opt/symfony
