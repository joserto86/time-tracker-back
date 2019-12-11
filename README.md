# Skeleton

Este es un proyecto base para proyectos con Symfony

> Borrar este README.md y el directorio docs al terminar la instalación

* [Required](#required)
* [.env](#env)
* [php-fpm](#php-fpm)
* [Nginx](#nginx)
* [MySQL](#mysql)
* [Redis](#redis)
* [Symfony](docs/README-SYMFONY.md)

# Required

- gnu/linux
- git
- docker
- docker-compose


> Configuración recomendada para las redes
````json
// /etc/docker/daemon.json
{
  "default-address-pools": [
    {
      "base": "10.188.255.0/16",
      "size": 24
    }
  ]
}
````

## .env

En la raíz del proyecto hay un archivo de configuración .env para el docker-compose.yaml

````bash
NAME=Skeleton

NGINX_V=1.15.7
NGINX_PORT=9187

MYSQL_ROOT_PASSWORD=123456
MYSQL_DATABASE=Skeleton
MYSQL_USER=Skeleton
MYSQL_PASSWORD=123456

XDEBUG=true
````

* **NAME** Nombre del proyecto (de forma simple sin espacios en blanco o caracteres raros)
* **NGINX_V** Versión de Nginx que se quiera usar (y este validada por Google ya que uso una tocada por ellos)
* **NGINX_PORT** Puerto para acceder a Nginx desde el PC de desarrollo
* **MYSQL_ROOT_PASSWORD** Password del usuario root
* **MYSQL_DATABASE** Nombre de la base de datos
* **MYSQL_USER** Nombre de usaurio
* **MYSQL_PASSWORD** Password de usuario
* **XDEBUG** true / false para instalar o no el modulo de XDEBUG

## php-fpm

La versión que se usa es la **7.3** ya que es la que actualmente tiene soporte para todo lo que normalmente se usa.

> En los archivos .ini se prepararon las configuraciones que más usamos
> Se instalan muchas cosas, si hay curiosidad ver el Dockerfile
> La sessión se guarda en Redis (db 10)

## Nginx

La versión de Nginx se puede definir en el **.env** ya que se instala ua versión tocada por Google para dar soporte al modulo de Pagespped ssl y h2
> Se puede deshabilitar el modulo de pagespeed desde su archivo de configuración o comentando la linea de include en el **nginx.conf**

## MySQL

La imagen es de 8.0.14


Para que funcione correctamente con el modulo actual de PHP es necesario inicializar MySQL con este parametro **--default-authentication-plugin=mysql_native_password**

````conf
#/~/my.conf
[mysqld]

default-authentication-plugin=mysql_native_password
````

> En el **utf8.conf** se tiene una configuración global para usar **utf8mb4**

## Redis

Imagen sin tocar de Redis 5.0.4
