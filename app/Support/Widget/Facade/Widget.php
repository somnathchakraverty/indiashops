<?php

namespace indiashopps\Support\Widget\Facade;

use Illuminate\Support\Facades\Facade;

Class Widget extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'widget';
    }
}