FROM hub.irontec.com/internet/dockerfiles/php-fpm/7.3.3:51d9d55f895124ab17572bca13af5d8850bf0940

# Xdebug
ARG XDEBUG=false
USER root
RUN if [ "${XDEBUG}" = "true" ] ; then /dev/null ; pecl install xdebug; docker-php-ext-enable xdebug; fi

USER docker

ADD --chown=docker:docker ./symfony/ /opt/symfony/

WORKDIR /opt/symfony

RUN [ -f composer.json ] && '' || composer create-project symfony/skeleton .
