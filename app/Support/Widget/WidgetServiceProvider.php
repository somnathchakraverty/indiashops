<?php

namespace indiashopps\Support\Widget;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

Class WidgetServiceProvider extends ServiceProvider
{
    public function boot() {
    }

    public function register()
    {
        $this->app->singleton('widget', function ($app) {
            return new Widget();
        });

        $loader = AliasLoader::getInstance();
        $loader->alias('WidgetManager', 'indiashopps\Support\Widget\Facade\Widget');
    }
}