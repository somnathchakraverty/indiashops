<?php

namespace indiashopps\Support\SEO;

use Illuminate\Support\ServiceProvider;

Class SeoServiceProvider extends ServiceProvider
{
    public function boot() {
    }

    public function register()
    {
        $this->app->singleton('seo', function ($app) {
            return new SeoData();
        });
    }
}