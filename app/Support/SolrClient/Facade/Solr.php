<?php

namespace indiashopps\Support\SolrClient\Facade;

use Illuminate\Support\Facades\Facade;
use \indiashopps\Support\SolrClient;

/**
 * @method static \indiashopps\Support\SolrClient\Solr init();
 * @method static \indiashopps\Support\SolrClient\Solr getInstance();
 */

Class Solr extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'solr';
    }
}