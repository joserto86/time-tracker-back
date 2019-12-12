FROM hub.irontec.com/internet/dockerfiles/php-fpm/7.4.0:ba6f3c5a036fceb1d1632a2fac3648a2f8829ea1

# Xdebug
ARG XDEBUG=false
USER root
RUN if [ "${XDEBUG}" = "true" ] ; then pecl install xdebug; docker-php-ext-enable xdebug; mv /usr/local/etc/php/conf.d/xdebug.disabled /usr/local/etc/php/conf.d/xdebug.ini; mv /usr/local/etc/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.disable; fi

USER docker

ADD --chown=docker:docker ./symfony/ /opt/symfony/

WORKDIR /opt/symfony
