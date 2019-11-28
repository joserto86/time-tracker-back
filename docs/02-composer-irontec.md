# Composer Irontec

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
