<?php

namespace indiashopps\Support\GTM;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;


Class GTMServiceProvider extends ServiceProvider
{
    public function boot() {}

    public function register()
    {
        $this->app->singleton('gtm', function ($app) {
            return new GTM();
        });

        $loader = AliasLoader::getInstance();
        $loader->alias('GTM', 'indiashopps\Support\GTM\Facade\GTM');
    }
}