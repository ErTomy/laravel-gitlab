<?php

namespace Ertomy\Gitlab;

use Illuminate\Support\ServiceProvider;


class GitDeployServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Ertomy\Gitlab\Controllers\DeployController');
        $this->mergeConfigFrom(__DIR__.'/../config/gitlab.php', 'gitdeploy');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');            
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'gitdeploy');
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('assets/gitdeploy'),
        ], 'assets');
    }
}
