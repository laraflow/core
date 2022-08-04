<?php

namespace Laraflow\Core;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{

    public function boot()
    {

        //config
        $this->publishes([
            __DIR__ . '/../config/core.php' => config_path('core.php'),
        ], 'core-config');

        //view
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'core');
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/core'),
        ], 'core-view');

        /*//route
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        //migration
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        //translation
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'core');

        $this->publishes([
            __DIR__ . '/../resources/lang' => $this->app->langPath('vendor/core/lang'),
        ], 'core-lang');


        //asset
        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/core'),
        ], 'core-asset');*/
    }

    public function register()
    {
        //config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/core.php', 'core'
        );
    }

}
