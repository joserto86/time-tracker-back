# Nueva instalación

cd /opt/symfony/

## Skeleton de symfony

````bash
composer create-project symfony/skeleton .
````

## Composer Irontec

Para instalar los bundles o paquetes desarrollados internamente por Irontec:

### auth.json

````json
{
    "http-basic": {
        "git.irontec.com": {
            "username": "composer",
            "password": "c0mp0s3r"
        }
    }
}
````

### composer.json

````json
"repositories": [
    {
        "type" : "composer",
        "url" : "https://git.irontec.com/composer"
    }
]
````

## Paquete oficiales insteresantes

````bash
composer require logger orm maker annotations
composer require sensio/framework-extra-bundle symfony/swiftmailer-bundle symfony/translation symfony/twig-bundle symfony/validator
````

## Paquetes para autenticación JWT de usuarios

Continuar en el archivo "README-AUTH-USER.md".

## Para la gestionar los errores en las respuestas JSON

````bash
composer require irontec/json-exception-response-bundle
````

## Paquetes de multiples funcionalidades de la comunidad

````bash
composer require gedmo/doctrine-extensions
````

## Super cache con redis

````bash
composer require snc/redis-bundle
````
