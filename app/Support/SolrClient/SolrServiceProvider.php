<?php

namespace indiashopps\Support\SolrClient;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;


Class SolrServiceProvider extends ServiceProvider
{
    public function boot() { }

    public function register()
    {
        $this->app->singleton('solr', function ($app) {
            return new Solr();
        });

        $loader = AliasLoader::getInstance();
        $loader->alias('SolrClient', 'indiashopps\Support\SolrClient\Facade\Solr');
    }
}