## Laravel Gitlab package

Paquete de Laravel para poder hacer despliegues desde repositorios de Gitlab. 

### Instalación

En el fichero `composer.json` añadir el repositorio de la siguiente forma:

```sh
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/ertomy/laravel-gitlab"
        }
    ],
```

Después instalar mediante el comando:

```sh  
composer require ertomy/gitlab
```

En el fichero `.env` deberemos añadir los siguientes parámetros;

- GITLAB_TOKEN que es el token que obtenemos desde Gitlab para poder hacer llamadas a su API
- GITLAB_REPOSITORY es el identificador del repositorio (número que aparece en el detalle del repositorio)
- GITLAB_BRANCH rama a desplegar, si estamos en entorno de test, producción, etc
- GITLAB_DEPLOY_USERS_ID listado de usuarios de la tabla users que pueden usar el panel de despliegues (identificadores separados por comas)

Referenciamos el service provider en el fichero `config\app.php` añadiendolo al array de providers:

```php
Ertomy\Authlog\Ertomy\Gitlab\GitDeployServiceProvider::class,
```

Publicamos los assets:

```sh  
php artisan vendor:publish --provider="Ertomy\Gitlab\GitDeployServiceProvider"
```

Y por ultimo corremos la migración para que cree la tabla donde almacenará los despliegues realizados:

```sh  
php artisan migrate
```



### Modo de empleo

Al instalar el paquete se habrá añadido la ruta */gitlabdeploy* a la que solo podrán acceder los usuarios indicados en el parámetro *GITLAB_DEPLOY_USERS_ID*, aquí se verán directamente los ficheros pendientes de subir, así como un botón para subirlos al servidor y también ver el historial de subidas.