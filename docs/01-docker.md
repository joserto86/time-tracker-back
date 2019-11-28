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
mkdir symfony
docker-compose up -d
docker exec -it id-project bash
composer create-project symfony/skeleton .
exit
vim docker/nginx/Dockerfile
## Descomentar la linea de ADD
````

> Con estos pasos se crea el proyecto symfony y se sincroniza el codigo fuera del contenedor para poder programar

Es necesario parar los contenedores `docker-compose down` y volver a iniciarlo `docker-compose up -d` para que nginx detecte el proyecto

````bash
docker-compose down
docker-compose up -d
````
