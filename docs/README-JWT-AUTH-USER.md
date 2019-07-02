````bash
composer require friendsofsymfony/user-bundle jms/serializer lexik/jwt-authentication-bundle
````

## framework.yaml

En el fichero "**config/packages/framework.yaml**" agregar:

````yaml
framework:
    # ... other stuff ...
    
    templating:
        engines: ['twig', 'php']
````

## request-transformer

````bash
composer require symfony-tools/request-transformer
````

**config/services.yaml**:

````yaml
services:
    Irontec\SymfonyTools\RequestTransformer\RequestTransformer:
        arguments: ["%locale%", "%locales%"]
        tags:
            - { name: kernel.event_listener, event: kernel.request, method: onKernelRequest, priority: 100 }
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
