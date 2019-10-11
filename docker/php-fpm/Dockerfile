FROM hub.irontec.com/internet/dockerfiles/php-fpm/7.3.3:f18965b5b9f781de6dbe1849019abc540e440acd
ARG XDEBUG=false

USER root
# Xdebug
RUN if [ "${XDEBUG}" = "true" ] ; then pecl install xdebug; docker-php-ext-enable xdebug; fi
USER docker

ADD --chown=docker:docker ./symfony/ /opt/symfony/

WORKDIR /opt/symfony

RUN [ -f composer.json ] && composer install || echo ''
