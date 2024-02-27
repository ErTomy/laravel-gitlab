<?php
    
    return [
        /*
        * datos de configuración del repositorio de Gitlab
        */
        'branch'=> env('GITLAB_BRANCH', 'master'),
        'repository'=> env('GITLAB_REPOSITORY', 123456789),
        'token'=> env('GITLAB_TOKEN', '123456789'),

        // usuarios de la tabla users que van a poder hacer los despliegues
        'users_id' => explode(',', env('GITLAB_DEPLOY_USERS_ID', '1')),

        // url base de los servicios de gitlab
        'base_url' => 'https://gitlab.com/api/v4/projects/',
        
    ];
