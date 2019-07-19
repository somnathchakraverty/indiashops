<?php
namespace indiashopps\Support\SolrClient;

use indiashopps\Support\SolrClient\Exceptions\Exception;
use indiashopps\Support\SolrClient\Exceptions\InvalidQueryException;
use Guzzle\Http\Client;

Class Solr
{
    private $_url;
    private $_fields          = [];
    private $_previous_fields = [];
    private $_solr_url;
    private $_previous_url;
    private $_client;
    private $_definition;
    private $_file;
    private $_store_filter    = false;
    private $_did_retry       = false;

    public function __construct()
    {
        if (empty(env('SOLR_URL'))) {
            throw new \Exception("Invalid SOLR URL !! Set SOLR_URL={URL} in .env file");
        }

        $this->_url            = env('SOLR_URL');
        $this->_fields['size'] = config('app.listPerPage');
        $this->_definition     = json_decode(file_get_contents(__DIR__ . "/wsdl.json"));
        $this->_client         = new Client();
    }

    public function init()
    {
        return $this;
    }

    public function getInstance()
    {
        return $this;
    }

    public function forLoan()
    {
        if (empty(env('LOAN_SOLR_URL'))) {
            throw new \Exception("Invalid SOLR URL !! Set LOAN_SOLR_URL={URL} in .env file");
        }

        $this->_url = env('LOAN_SOLR_URL');

        return $this;
    }

    public function devServer()
    {
        if (empty(env('SOLR_URL_DEV'))) {
            if (request()->has('debug')) {
                throw new \Exception("Invalid SOLR DEV URL !! Set SOLR_URL_DEV={URL} in .env file");
            }
        } else {
            $this->fromLastFilter();

            if (count($this->_fields) > 0) {
                $this->_url = env('SOLR_URL_DEV');
            } else {
                throw new \Exception("Filters not found...!!");
            }
        }

        $this->_store_filter = false;

        return $this;
    }

    public function request($post = [])
    {
        if ($this->hasRequestCache()) {
            return $this->getCache();
        }

        $url = $this->_solr_url;

        if (collect($post)->isNotEmpty()) {
            $request = $this->_client->post($url, null, $post);
        } else {

            $request = $this->_client->get($url);
            $query   = $request->getQuery();

            if (count($this->_fields) > 0) {
                if ($param = $this->getParam()) {
                    $query->set($param, json_encode($this->_fields));
                } else {
                    foreach ($this->_fields as $field => $value) {
                        $query->set($field, $value);
                    }
                }
            }
        }

        try {

            $this->_previous_url = $request->getUrl();

            if ($this->_store_filter) {
                $this->setLastFilters();
                $this->_store_filter = false;
            }

            $response = (string)$request->send()->getBody();

            $this->cacheRequest($response);
            $this->clearParams();

            return $response;
        }
        catch (\Exception $e) {
            \Log::error("PRIMARY SOLR URL ERROR:: " . $e->getMessage() . ":: " . $e->getTraceAsString());

            return $this->retrySecondServer($e);
        }
    }

    public function hasRequestCache()
    {
        if (!env('ENABLE_PROD_CACHE', false)) {
            return false;
        }

        $cache_key = $this->getRequestCacheKey();

        if (cache()->has($cache_key)) {
            return true;
        }

        return false;
    }

    public function getCache()
    {
        return cache()->get($this->getRequestCacheKey(), false);
    }

    public function cacheRequest($data)
    {
        if (!env('ENABLE_PROD_CACHE', false) && request()->has(['ajax', 'filter'])) {
            return false;
        }

        $cache_key = $this->getRequestCacheKey();

        if ($cache_key !== false) {
            if ($this->isCacheable($data)) {
                cache()->remember($cache_key, 1440, function () use ($data) {
                    return $data;
                });
            }
        }
    }

    private function isCacheable($data)
    {
        try {
            switch ($this->_file) {
                case 'search':
                    $route = request()->route()->getName();

                    if (in_array($route, config('product_cache.categories.routes'))) {
                        $category_id = collect(explode(",", $this->_fields['category_id']))->first();

                        if (in_array($category_id, config('product_cache.categories.ids'))) {
                            $return = true;
                        } else {
                            $return = false;
                        }
                    } else {
                        $return = false;
                    }

                    break;

                case 'compdetail':
                    $data    = json_decode($data);
                    $product = $data->productDetail->hits->hits[0]->_source;

                    if (isset($data->predecessor) && count($data->predecessor->hits->hits) > 0) {
                        return true;
                    }

                    if (in_array($product->category_id, config('product_cache.product')) && $product->rank_points >= 20) {
                        $return = true;
                    } else {
                        $return = false;
                    }

                    break;
            }
        }
        catch (\Exception $e) {
            $return = false;

            if (request()->has('debug')) {
                throw new Exception($e->getMessage());
            }
        }

        return $return;
    }

    private function getRequestCacheKey()
    {
        if (request()->has(['ajax', 'filter']) || request()->ajax() || app()->runningInConsole()) {
            return false;
        }

        if (!in_array(request()->route()->getName(), config('product_cache.categories.routes'))) {
            return false;
        }

        try {

            switch ($this->_file) {

                case 'compdetail':

                    if (isset($this->_fields['_id'])) {
                        $key = 'product_detail_comp_' . $this->_fields['_id'];
                    } else {
                        $key = false;
                    }

                    break;

                case 'search':
                    $route = request()->route()->getName();

                    if (array_key_exists('saleprice_max', $this->_fields) || array_key_exists('saleprice_min', $this->_fields)) {
                        return false;
                    }

                    if (isset($this->_fields['category_id']) && isset($this->_fields['from']) && $this->_fields['from'] == 0) {
                        if (in_array($route, [
                            'brand_category_list_comp_1',
                            'brand_category_list'
                        ])) {
                            if (isset($this->_fields['brand'])) {
                                $key = 'brand_listing_page_' . cs($this->_fields['category_id'] . "_" . $this->_fields['brand']);
                            } else {
                                $key = false;
                            }
                        } elseif ($route == 'upcoming_mobiles') {
                            $key = 'listing_page_upcoming_mobiles';
                        } else {
                            $key = 'listing_page_' . cs($this->_fields['category_id']);
                        }
                    } else {
                        $key = false;
                    }

                    break;

                default:
                    $key = false;
                    break;
            }
        }
        catch (\Exception $e) {
            if (request()->has('debug')) {
                throw new Exception($e->getMessage());
            }
            return false;
        }

        return $key;
    }

    public function storeFilter()
    {
        $this->_store_filter = true;

        return $this;
    }

    public function setFields($values)
    {
        if (isset($values) && !empty($values) && is_array($values)) {
            $this->_fields = $values;
        }

        return $this;
    }

    public function setLastFilters()
    {
        app('session')->put('solr_previous_filter', $this->_fields);
    }

    public function fromLastFilter()
    {
        if (!empty(session('solr_previous_filter'))) {
            $this->_fields = session('solr_previous_filter');
            app('session')->put('solr_previous_filter', []);
        }

        return $this;
    }

    public function where($field, $value)
    {
        $this->_fields[strtolower($field)] = $value;
        return $this;
    }

    public function whereIn($param, $values)
    {
        if (empty($param) || empty($values) || !is_array($values)) {
            throw new InvalidQueryException("Invalid param, or non array..");
        }

        $this->_fields[$param] = implode($values, ",");

        return $this;
    }

    public function params($field, $value)
    {
        $this->_fields[strtolower($field)] = $value;
        return $this;
    }

    /*
     * @var $page = Integer ( Number of pages to skip )
     */
    public function skip($page = 1)
    {
        $page = ($page > 0) ? $page : 0;

        $this->_fields['from'] = $page * config('app.listPerPage');

        return $this;
    }

    public function take($count)
    {
        $count = ($count > 0) ? $count : config('app.listPerPage');

        $this->_fields['size'] = $count;

        return $this;
    }

    public function param($param, $value)
    {
        if (!empty($param) && !empty($value)) {
            $this->_fields[$param] = $value;
        }

        return $this;
    }

    public function __call($name, $arguments)
    {
        $parts = preg_split('/where/', $name);

        if (isset($parts[1]) && !empty($parts[1]) && $this->getCondition($parts[1])) {

            if (isset($arguments[1])) {
                throw new \Exception("Invalid Number of Arguments");
            }


            $this->where($this->getCondition($parts[1]), $arguments[0]);

            return $this;

        }
        $parts = preg_split('/get/', $name);

        if (isset($parts[1]) && !empty($parts[1]) && $file = $this->getMethod($parts[1])) {

            $return_all      = isset($arguments[0]) ? $arguments[0] : false;
            $this->_file     = array_search($file, (array)$this->_definition->methods);
            $this->_solr_url = $this->_url . $file;
            return $this->get($return_all);
        } else {
            //\Log::info("Invalid Where/Function Called. LINE:: " . __LINE__);
        }
    }

    private function clearParams()
    {
        $this->_solr_url = '';
        $this->_fields   = [];
    }

    public function dumpPrevious()
    {
        dd($this->_previous_url);
    }

    public function getFilterFields()
    {
        $this->_fields['size'] = $this->_size;
        $this->_fields['from'] = $this->_from;

        return json_encode($this->_fields);
    }

    public function get($return_all = false)
    {
        if (empty($this->_solr_url)) {
            throw new InvalidQueryException("Invalid Solr Query..");
        } else {

            $response = $this->request();

            if (is_array($response)) {
                return $response;
            }

            $result = json_decode($response);

            if ($return_all) {
                return $result;
            }

            return [
                'data'           => $result->return_txt->hits->hits,
                'filters'        => $result->return_txt->aggregations,
                'filter_applied' => (isset($result->filter_applied)) ? $result->filter_applied : [],
            ];
        }
    }

    private function getMethod($name)
    {
        $methods = $this->_definition->methods;
        $name    = strtolower($name);

        if (array_key_exists($name, $methods)) {
            return $methods->{$name};
        } else {
            return false;
        }
    }

    private function getCondition($where)
    {
        $methods = $this->_definition->params;
        $name    = $this->fromCamelCase($where);

        if (array_key_exists($name, $methods)) {
            return $methods->{$name};
        } else {
            return false;
        }
    }

    private function fromCamelCase($input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    private function getParam()
    {
        $query = $this->_definition->query;

        if (isset($query->{$this->_file})) {
            return $query->{$this->_file};
        }

        return false;
    }

    private function retrySecondServer(\Exception $e)
    {
        if (!empty(env('SECONDARY_SOLR_URL'))) {
            if (!$this->_did_retry) {
                $this->_solr_url = str_replace($this->_url, env('SECONDARY_SOLR_URL'), $this->_solr_url);
                $this->_url      = env('SECONDARY_SOLR_URL');
            } else {
                return ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()];
            }

            $this->_did_retry = true;

            return $this->request();
        } else {
            \Log::error("SOLR Query Failed, Secondary SOLR URL NOT PRESENT");

            return ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()];
        }
    }
}

?>