<?php

namespace indiashopps\Support\GTM\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \indiashopps\Support\SolrClient\Solr init();
 * @method static \indiashopps\Support\SolrClient\Solr getInstance();
 */

Class GTM extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'gtm';
    }
}