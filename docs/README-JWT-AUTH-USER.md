# Instalación
| Package | Description |
| - | - |
| friendsofsymfony/user-bundle | Bundle para ayudar a gestionar campos y funciones de autenticación de los usuarios |
| jms/serializer | Bundle para gestionar la serialización de JWT |
| lexik/jwt-authentication-bundle | Bundle para gestionar la autenticación por JWT |

````bash
composer require friendsofsymfony/user-bundle jms/serializer lexik/jwt-authentication-bundle
````

## fos_user.yaml

Si no se crea automaticamente, es necesario crear el fichero "**config/packages/fos_user.yaml**" con este contenido:

````yaml
fos_user:
    db_driver: orm
    firewall_name: main
    user_class: App\Entity\User
    from_email:
        address:     '%env(resolve:FOS_USER_EMAIL_ADDRESS)%'
        sender_name: '%env(resolve:FOS_USER_EMAIL_NAME)%'
````

## framework.yaml

En el fichero "**config/packages/framework.yaml**" agregar:

````yaml
framework:
    # ... other stuff ...

    templating:
        engines: ['twig', 'php']
````

## User Entity

````php
<?php

use \Doctrine\ORM\Mapping as ORM;
use \FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @Assert\NotBlank(message="user.username.not_blank")
     * @Assert\Length(min = 5, max = 255, minMessage = "user.username.min", maxMessage = "user.username.max")
     */
    protected $username;

    /**
     * @Assert\NotBlank(message="user.email.not_blank")
     * @Assert\Length(min = 5, max = 255, minMessage = "user.email.min", maxMessage = "user.email.max")
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     */
    protected $email;


    public function __construct()
    {
        parent::__construct();
    }

}
````

## Routes

Para generar la ruta de login es necesario agregar estas lineas en "**config/routes.yaml**":

````yaml
fos_user_security_login:
  path: "/login"
  methods: ["POST"]
  controller: fos_user.security.controller:loginAction
````

## Security

Configuración generica del security para una API. Contenido del archivo "**config/packages/security.yaml**":

````yaml
security:
    encoders:
        App\Entity\User: 'auto'

    providers:
        fos_userbundle:
            id: fos_user.user_provider.username_email

    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false

        login:
            pattern:  ^/login
            stateless: true
            anonymous: true
            provider: fos_userbundle
            form_login:
                check_path:               /login
                require_previous_session: false
                success_handler:          lexik_jwt_authentication.handler.authentication_success
                failure_handler:          lexik_jwt_authentication.handler.authentication_failure

        api-options:
            pattern:   ^/
            methods: [OPTIONS]
            anonymous: true

        api:
            pattern:   ^/
            stateless: true
            anonymous: false
            guard:
                provider: fos_userbundle
                authenticators:
                    - lexik_jwt_authentication.jwt_token_authenticator

    access_control:
        - { path: ^/,      roles: IS_AUTHENTICATED_ANONYMOUSLY, methods: [OPTIONS] }
        - { path: ^/login, roles: IS_AUTHENTICATED_ANONYMOUSLY, methods: [POST] }
````

## Lexik JWT Authentication

Este bundle genera el token de autenticación. Para su correcto funcionamiento necesita:

* private.pem
* public.pem

Se configuran las rutas en el .env del proyecto o en variables de entorno:

````bash
###> lexik/jwt-authentication-bundle ###
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=4941a405a95829db63d64f6167facbf3
###< lexik/jwt-authentication-bundle ###
````


### JWT

Para la autenticación de la API con jwt se necesita crear un certificado de openssl:

https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#installation

Generate the SSH keys :
````bash
$ mkdir -p config/jwt # For Symfony3+, no need of the -p option
$ openssl genrsa -out config/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
````

In case first openssl command forces you to input password use following to get the private key decrypted

````bash
$ openssl rsa -in config/jwt/private.pem -out config/jwt/private2.pem
$ mv config/jwt/private.pem config/jwt/private.pem-back
$ mv config/jwt/private2.pem config/jwt/private.pem
````

Validation:
````
$ bin/console lexik:jwt:check-config
````
