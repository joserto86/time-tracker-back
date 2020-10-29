ARG PHP_IMAGE

FROM ${PHP_IMAGE} AS PHP_FPM

FROM hub.irontec.com/internet/dockerfiles/nginx-symfony:0.0.7

COPY --from=PHP_FPM /opt/symfony/public/ /opt/symfony/public/
