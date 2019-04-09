# Nueva instalación

cd /opt/symfony/

## Skeleton de symfony

````bash
composer create-project symfony/skeleton .
````

## Paquete oficiales insteresantes

````bash
composer require logger orm maker annotations
composer require sensio/framework-extra-bundle symfony/swiftmailer-bundle symfony/translation symfony/twig-bundle symfony/validator
````

## Paquetes para autenticación JWT de usuarios

````bash
composer require friendsofsymfony/user-bundle jms/serializer lexik/jwt-authentication-bundle
````

## Paquetes de multiples funcionalidades de la comunidad

````bash
composer require gedmo/doctrine-extensions
````

## Super cache con redis

````bash
composer require snc/redis-bundle
````
