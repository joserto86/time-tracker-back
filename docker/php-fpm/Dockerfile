FROM hub.irontec.com/internet/dockerfiles/php-fpm/7.3.3:5a29619b85b93b5eb4982f3e4c145fa6024de5bd

ARG XDEBUG=false

# Xdebug
USER root
RUN if [ "${XDEBUG}" = "true" ] ; then /dev/null ; pecl install xdebug; docker-php-ext-enable xdebug; fi

USER docker

ADD --chown=docker:docker ./symfony/ /opt/symfony/

WORKDIR /opt/symfony

RUN [ -f composer.json ] && composer install || echo ''
