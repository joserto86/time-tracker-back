## Paquete oficiales insteresantes

| Package | Description |
| - | - |
| logger | Bundle para gestionar los logs del proyecto |
| orm | pack de Bundles para la conexión con bases de datos - doctrine |
| maker | Bundle para crear diferentes entidades (Entity, Controller, ...) |
| annotations | Bundle para usar anotaciones en la definición de acciones |
| sensio/framework-extra-bundle | Bundle para configuraciones extras por anotaciones en los controllers |
| symfony/swiftmailer-bundle | Bundle para el envio de emails |
| symfony/translation | Bundle para gestionar las traducciones |
| symfony/twig-bundle | Bundle para usar templates |
| symfony/validator | Bundle para gestionar las validaciones, en entidades de doctrine |
| symfony/expression-language | Bundle para gestionar expresiones en otros bundles |

````bash
composer require logger orm maker annotations sensio/framework-extra-bundle symfony/swiftmailer-bundle symfony/translation symfony/twig-bundle symfony/validator symfony/expression-language
````

````yaml
# config/services.yaml
parameters:
    locale: es
    locales: ['es', 'en']

framework:
    default_locale: '%locale%'
````

## Paquetes para autenticación JWT de usuarios

Continuar en el archivo "README-AUTH-USER.md".

## Para la gestionar los errores en las respuestas JSON

````bash
composer require irontec/json-exception-response-bundle
````

## request-transformer

Este paquete gestiona las requests RAW/JSON para usarlas como parametros

````bash
composer require symfony-tools/request-transformer
````

## Paquetes de multiples funcionalidades de la comunidad

````bash
composer require gedmo/doctrine-extensions
````

## Super cache con redis

````bash
composer require snc/redis-bundle
````
