FROM hub.irontec.com/internet/symfony/php-fpm-8/8.1

# Xdebug
ARG XDEBUG=false
USER root
RUN if [ "${XDEBUG}" = "true" ] ; then pecl install xdebug; docker-php-ext-enable xdebug; mv /usr/local/etc/php/conf.d/xdebug.disabled /usr/local/etc/php/conf.d/xdebug.ini; fi

ADD docker/php-fpm/opcache.ini /usr/local/etc/php/conf.d/opcache.dev

#LDAP
RUN apt update \
    && apt install libldap2-dev -y \
    && docker-php-ext-install ldap \
    && docker-php-ext-enable  ldap

# Opcache
RUN if [ "${XDEBUG}" = "true" ] ; then mv /usr/local/etc/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.disable; fi
RUN if [ "${XDEBUG}" = "true" ] ; then mv /usr/local/etc/php/conf.d/opcache.dev /usr/local/etc/php/conf.d/opcache.ini; fi

# symfony-cli
RUN wget https://get.symfony.com/cli/installer -O - | bash && \
    export PATH="$HOME/.symfony5/bin:$PATH" && \
    mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Image
USER docker

ADD --chown=docker:docker ./symfony/ /opt/symfony/

WORKDIR /opt/symfony

RUN composer install --no-scripts && \
    php bin/console assets:install
