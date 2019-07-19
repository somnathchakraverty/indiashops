<?php

namespace indiashopps\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\ServiceProvider;

class ListsWorkAround extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {}

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        Builder::macro("lists", function ($column, $key = null) {
            return $this->pluck($column, $key)->all();
        });

        QueryBuilder::macro("lists", function ($column, $key = null) {
            return $this->pluck($column, $key)->all();
        });
    }
}
