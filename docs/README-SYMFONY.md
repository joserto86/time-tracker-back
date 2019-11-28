# Nueva instalación

Clonar el proyecto skeleton en un directorio con el nombre del proyecto y entrar en el directorio

````bash
git clone https://git.irontec.com/symfony-tools/symfony-skeleton.git {project-name}

cd project-name
````

Cambiar la URL del git remote al del proyecto
````bash
git remote set-url origin https://git.irontec.com/clientes/{client}/{projecto}.git
````

Editar y configurar correctamente el archivo de variables **.env**
````bash
vim .env
````

Por la configuración de los volumenes de docker y docker-compose es necesario hacer los siguientes pasos

````bash
docker-compose up -d
docker exec -it id-project bash
composer create-project symfony/skeleton .
exit
````

> Con estos pasos se crea el proyecto symfony y se sincroniza el codigo fuera del contenedor para poder programar

Es necesario parar los contenedores `docker-compose down` y volver a iniciarlo `docker-compose up -d` para que nginx detecte el proyecto

````bash
docker-compose down
docker-compose up -d
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


````yaml
# config/services.yaml
parameters:
    locale: es
    locales: ['es', 'en']

framework:
    default_locale: '%locale%'
````

## Paquetes de multiples funcionalidades de la comunidad

````bash
composer require gedmo/doctrine-extensions
````

## Super cache con redis

````bash
composer require snc/redis-bundle
````
