<?php

namespace indiashopps\Http\Controllers\v3;

use DB;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use indiashopps\Models\CustomPage;
use indiashopps\Models\LandingWidget;
use indiashopps\Slider;
use indiashopps\Support\SolrClient\Facade\Solr as SolrClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use indiashopps\Category;
use indiashopps\CategoryMeta;
use indiashopps\Http\Controllers\ProductController;
use indiashopps\Library\Page\Pagination;
use Jenssegers\Agent\Agent;

class ListingController extends BaseController
{
    public function productList(Request $request, $parent = false, $cname = false, $child = false, $page = 1)
    {
        $token      = $request->session()->get('_token');
        $session_id = preg_replace("/[^0-9,.]/", '', $token);
        $parent_id  = false; // Parent ID is made false for the search page, so that it doesn't redirect..
        $cat        = false;
        $redirect   = $this->checkCategoryRedirects($request, $parent, $cname, $child, $page);

        if ($redirect instanceof RedirectResponse) {
            return $redirect;
        } else {
            extract($redirect);
        }

        if ($child === false) {
            $category = Category::find($cat);

            if (!is_null($category) && $category->level == 2) {
                return redirect(getCategoryUrl($category));
            }
        } else {
            $category = Category::find($cat);

            if (!is_null($category) && $category->level == 1) {
                return redirect(getCategoryUrl($category));
            }
        }
        $solrObject = SolrClient::getInstance();

        $c_url = $cname;

        $data['isSearch'] = false;
        if (in_array($cat, config('vendor.comparitive_category'))) {
            $data['isSearch'] = false;
        }

        if ($request->has('brand')) {
            $brand = $request->brand;
        }

        /// GET the category IDs if BRAND name is provided with the CATEGORY Name..
        if (isset($filters) && is_array($filters) && count($filters) > 0) {
            foreach ($filters as $field => $value) {
                $data[$field] = $value;

                $field = camel_case($field);
                $key   = "where" . ucwords($field);
                $solrObject->{$key}($value);
            }
        }

        //Adds all the FILTER FIELDS to an ARRAY to be send to SOLR query..
        if ($request->has('price_filter') || $request->has('ajax') || $request->has('apply_filters')) {

            foreach ($request->all() as $field => $value) {
                if (!in_array($field, ['meta_data', 'custom_filters', 'apply_filters', 'category', 'group'])) {
                    $data[$field] = $value;

                    $field = camel_case($field);
                    $key   = "where" . ucwords($field);
                    $solrObject->{$key}($value);
                }
            }

            $solrObject->where('brand_min_doc_count', 1);
        }

        // Search Page Query fields..
        if ($request->has('search_text')) {
            $data['query'] = urlencode($request->input('search_text'));
            if ($request->has('group')) {
                $data['group'] = ($request->input('group'));
                $solrObject->whereGroup($data['group']);
            }
            if ($request->has('parent_category')) {
                $data['parent_category'] = ($request->input('parent_category'));
                $solrObject->whereParentCategory($data['parent_category']);
            }

            if ($request->has('search_id')) {
                $data['search_id'] = $request->search_id;
            }
            $data['isSearch'] = true;
        }

        if ($request->has('cat_id')) {
            $data['category_id'] = $request->cat_id;
            $solrObject->whereCategoryId($request->cat_id);
        }

        if (!empty($session_id) && is_numeric($session_id)) {
            $data['session_id'] = $session_id;
        }

        //Create the Category Chain and send it to view for nested Categories
        if ($cat) {
            $controller          = new ProductController();
            $cats                = $controller->createChain($cat);
            $data['category_id'] = $cats;
            $data['c_name']      = $controller->getCatName($cats)[0];

            $solrObject->whereCategoryId($data['category_id']);
        }

        $data['page'] = $page;

        //If the CATEGORY belong to books, then change the SOLR index...

        if ($parent == "books" || $request->input('group') == "Books") {
            $data['group'] = "Books";
            $isBook        = true;
            $solrObject->whereGroup('Books');
        } else {
            $isBook = false;
        }

        if ($request->has('upcoming-mobiles')) {
            $solrObject->whereAvailability('Coming Soon')->whereCategoryId(351);
        }

        if (isset($data['category_id']) && isPricelist($data['category_id'])) {
            $data['isComparative'] = true;
        } else {
            $data['isComparative'] = false;
        }

        //Adding the Sorting parameters for PRODUCT LIST..
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            $sort = explode("-", $sort);

            if ($sort[0] != "f" && $sort[0] != "d") {
                $field = ["s" => "saleprice", "p" => "saleprice", "d" => "discount"];
                $order = ["a" => "asc", "d" => "desc"];

                $data['order_by']   = $field[strtolower($sort[0])];
                $data['sort_order'] = $order[strtolower($sort[1])];
            } else {
                if ($sort[0] == "f") {
                    $data['order_by']   = "id";
                    $data['sort_order'] = "desc";
                }
            }
        } else {
            if (!$data['isSearch']) {
            }
        }

        if (isset($data['order_by']) && !empty($data['order_by'])) {
            $solrObject->whereOrderBy($data['order_by']);
        }

        if (isset($data['sort_order']) && !empty($data['sort_order'])) {
            $solrObject->whereSortOrder($data['sort_order']);
        }

        if ($request->has('vendor')) {
            $data['vendor'] = $request->vendor;
        }

        if ($request->has('page')) {
            $data['page'] = $request->page;
            $solrObject->skip((int)$request->page - 1);
        } else {
            $solrObject->skip(($page - 1));
        }

        if ($request->has('custom_filters')) {
            $data = array_merge($data, $request->custom_filters);
        }

        if ($request->has('brand')) {
            $solrObject->whereBrand($request->brand);
        }

        if ($isBook) {
            $return = $solrObject->storeFilter()->getBooks(true);
        } else {
            $return = $solrObject->storeFilter()->getSearch(true);
        }

        $result = $return->return_txt;

        $uri = \Request::route()->uri();
        if ($request->has('custom_group_page') && $request->custom_group_page == 'yes') {
            $params         = [
                'group'       => $request->group,
                'category'    => $request->custom_category,
                'keyword'     => $request->search_text,
                'order_by?'   => '',
                'sort_order?' => ''
            ];
            $data['target'] = $this->getPaginationTarget(url($uri), $params);
        } elseif ($request->has('custom_filters')) {
            $data['custom_filters'] = $request->custom_filters;
            $data['target']         = $this->getPaginationTarget(url($uri), ['slug' => $request->custom_filters['slug']]);
        } else {
            if ($request->route()->getName() == 'brand_category_list_comp' || $request->route()
                                                                                      ->getName() == 'brand_category_list_comp_1'
            ) {
                if (!empty($parent) && !empty($cname) && !empty($brand) && $child) {
                    $data['canonical'] = route('brand_category_list', [$brand, $parent, $cname]);
                }
                $parts          = explode(config('app.seoURL'), $c_url);
                $data['target'] = $this->getPaginationTarget(url($uri), [
                    'brand'    => create_slug($request->brand),
                    'category' => $parts[0],
                    'id'       => $cat
                ]);
            } else {
                if ($request->route()->getName() == 'brand_category_list' || $request->route()
                                                                                     ->getName() == 'brand_category_list_1'
                ) {
                    if (stripos($uri, '-price-list-in-india/') === false) {
                        $uri = $uri . "/{page}";
                    }

                    $parts          = explode(config('app.seoURL'), $c_url);
                    $data['target'] = $this->getPaginationTarget(url($uri), [
                        'brand'    => create_slug($request->brand),
                        'group'    => $parent,
                        'category' => $parts[0],
                        'id'       => $cat
                    ]);
                } else {
                    $data['target'] = $this->getPaginationTarget(url($uri), [
                        'parent'   => $parent,
                        'category' => $c_url,
                        'child'    => $child
                    ]);
                }
            }
        }
        if (stripos($uri, '{') > -1) {
            $params         = $request->route()->parametersWithoutNulls();
            $data['target'] = $this->getPaginationTarget(url($uri), $params);
        }

        $page       = empty($page) ? 1 : ((int)$page);
        $pagination = new Pagination();
        $pagination->setCurrent($page);
        $pagination->setTotal(($result->hits->total > 29500) ? 29500 : $result->hits->total);
        $pagination->setRPP(config('app.listPerPage'));
        $pagination->setTarget($data['target']);

        $data['total_products'] = ($result->hits->total > 29500) ? 29500 : $result->hits->total;
        // grab rendered/parsed pagination markup
        if (!empty($data['target'])) {
            $data['markup']        = $pagination->parse($request->has('ajax'));
            $data['rel_next_prev'] = implode("\n", $pagination->getRelPrevNextLinkTags());
        } else {
            $data['markup']        = '';
            $data['rel_next_prev'] = '';
        }

        // Pre-defined price filter for price comparition in below funcitons.. bBrandPhone, bbetPhones, bestPhone..
        if (($request->has('price_filter') && isset($result->aggregations->filters_all) && !empty($result->aggregations->filters_all) || ($request->has('apply_filters')) && !$request->has('ajax'))) {
            unset($result->aggregations->filters_all->doc_count);
            $data['facets'] = $result->aggregations->filters_all;

            if (empty($data['facets']) || !is_object($data['facets'])) {
                $data['facets'] = new \stdClass();
            }

            if (!isset($data['facets']->price_ranges) && isset($result->aggregations->price_ranges)) {
                $data['facets']->price_ranges = $result->aggregations->price_ranges;
            }
        } else {
            $data['facets'] = $result->aggregations;
        }

        //Sending Product data to VIEWS.....
        $data['product']          = $result->hits->hits;
        $data['minPrice']         = $result->aggregations->saleprice_min->value;
        $data['maxPrice']         = $result->aggregations->saleprice_max->value;
        $data['scat']             = $cat;
        $data['child_categories'] = Category::where('parent_id', $cat)->get();

        if (empty($data['product']) && !$request->has('ajax')) {
            $response = $this->redirectBackToParent($request, $parent, $cname, $child);

            if ($response instanceof RedirectResponse) {
                return $response;
            }
        }

        if (!$request->has('custom_page') && !$request->has('ajax') && isset($brand) && !empty($brand) && is_array($data['product']) && count($data['product']) < 5) {
            $response = $this->redirectBackToParent($request, $parent, $cname, $child);

            if ($response instanceof RedirectResponse) {
                return $response;
            }
        }

        if (@$data['group'] != "Books") {
            $facet['group'] = $result->aggregations->grp->buckets;
            $data['book']   = false;
        } else {
            $data['book']     = true;
            $data['isSearch'] = false;
        }
        if ($data['isSearch'] && !$request->has('cat_id') && !$request->has('apply_filters')) {

            $data['facets']->categories = $result->aggregations->grp->buckets;
        }

        if (empty($data['category_id'])) {
            $data['category_id'] = null;
        }

        $data['isMobile'] = (new Agent())->isMobile();

        $data['c_name'] = isset($data['c_name']) ? $data['c_name'] : '';

        /*Setup SEO Meta Da ta, and assign it to '$data' variable, passed as reference.*/
        $this->processSeoMetaData($request, $data, get_defined_vars());
        $this->processMetaByRoute();
        $this->setupProductListJsonLD($data);

        if ($request->has('mobile_page') && $request->input('mobile_page') == true) {
            if ($request->has('filter') && $request->input('filter') == "true") {
                $data['facet']        = $result->aggregations;
                $data['facet']->total = $result->hits->total;

                if (isset($return->filter_applied)) {
                    $data['facet']->filter_applied = $return->filter_applied;
                }
            }

            return $data;
        }

        if ($request->has('custom_page')) {
            $data['custom_pages'] = CustomPage::whereCategoryId($cat)
                                              ->where('id', "!=", $request->custom_page_id)
                                              ->whereFeatured('1')
                                              ->take(10)
                                              ->get();
        }

        //Preparing AJAX response once filter is applied.... JSON Response
        if ($request->has('filter') && $request->input('filter') == "true") {

            $json['products'] = (string)view("v3.listing.ajax", $data);
            // $json['products']     = preg_replace('/(\v)+/', '', $json['products']);
            $json['products']     = str_replace("\t", "", $json['products']);
            $json['facet']        = $result->aggregations;
            $json['facet']->total = $result->hits->total;

            if (isset($return->filter_applied)) {
                $json['facet']->filter_applied = $return->filter_applied;
            }

            echo json_encode($json);
            exit;
        } else {

            if (Schema::hasTable('home_slider')) {
                if (isset($brand) && !empty($brand)) {

                    if (isMobile()) {
                        $for = 2;
                    } else {
                        $for = 0;
                    }

                    $query = \DB::table('home_slider')->where('cat_id', $cat)->where('brands', $brand)->whereFor($for);

                    $sliders = $query->get();
                } else {
                    $category = Category::where('id', $cat)->with(['parent', 'slider'])->first();

                    if (isset($category->slider)) {
                        if ($category->slider->isEmpty()) {
                            $sliders = $category->parent->slider;
                        } else {
                            $sliders = $category->slider;
                        }
                    } else {
                        $sliders = collect([]);
                    }
                }

                $data['sliders'] = $sliders;
            }

            return view('v3.listing.index', $data);
        }
    }

    public function subCategoryList(Request $request, $parent = false, $cname = false, $page = 1)
    {
        return $this->productList($request, $parent, $cname, false, $page);
    }

    public function childCategoryList(Request $request, $parent = false, $cname = false, $child = false, $page = 1)
    {
        return $this->productList($request, $parent, $child, $cname, $page);
    }

    public function categoryAllBrands($parent = false, $cname = false)
    {
        if (!array_key_exists($cname, config('all_brands'))) {
            return redirect(categoryLink([$parent, $cname]));
        }

        $parent_id = $this->getCatIDByName($parent);
        $child_id  = $this->getCatIDByName($cname, $parent_id);

        if (isset($child_id) && !empty($child_id)) {
            $solr = SolrClient::getInstance();

            $controller          = new ProductController();
            $cats                = $controller->createChain($child_id);
            $data['category_id'] = $cats;
            $data['c_name']      = $controller->getCatName($child_id)[0];

            $solr->whereCategoryId($data['category_id']);

            $return = $solr->getSearch(true);

            try {
                if (isset($return->return_txt->aggregations->brand->buckets)) {
                    $brands = [];

                    foreach ($return->return_txt->aggregations->brand->buckets as $brand) {
                        $first_letter = strtolower(substr($brand->key, 0, 1));
                        if (!empty($first_letter)) {
                            $brands[$first_letter][] = $brand->key;
                        }
                    }
                    ksort($brands);

                    $data             = [];
                    $data['group']    = $parent;
                    $data['category'] = $cname;
                    $data['brands']   = $brands;

                    if ($child_id == Category::MOBILE) {
                        $pages      = CustomPage::forFeaturedMobiles()->get();
                        $price_keys = ['saleprice_min', 'saleprice_max'];
                        $links      = [];

                        foreach ($pages as $page) {
                            $filter_keys  = array_keys((array)json_decode($page->filters));
                            $filter_count = count($filter_keys);
                            $keys_diff    = array_diff($filter_keys, $price_keys);
                            $count_diff   = count($keys_diff);

                            $link['text'] = unslug($page->slug);
                            $link['link'] = route('custom_page_list_v3', [cs($cname), $page->slug]);

                            if ($count_diff == 0) {
                                $links['price'][] = collect($link);
                            } elseif ($filter_count == $count_diff) {
                                $links['feature'][] = collect($link);
                            } else {
                                $links['mix'][] = collect($link);
                            }
                        }

                        try {
                            if (Cache::has('listing_page_upcoming_mobiles')) {
                                $result = json_decode(Cache::get('listing_page_upcoming_mobiles'));
                                $result = collect($result->return_txt->hits->hits)->take(8);
                            } else {
                                $result = $this->solrClient->whereAvailability('Coming Soon')
                                                           ->whereCategoryId(Category::MOBILE)
                                                           ->take(8)
                                                           ->getSearch(true);
                                $result = collect($result->return_txt->hits->hits);
                            }
                        }
                        catch (\Exception $e) {
                            \Log::error("All brands page upcoming error:: " . $e->getTraceAsString());
                        }

                        if (isset($result) && !empty($result)) {
                            foreach ($result as $res) {
                                if (isset($res->_source)) {
                                    $res = $res->_source;
                                }

                                $product['text'] = $res->name;
                                $product['link'] = product_url($res);

                                $products[] = collect($product);
                            }
                            $links['upcoming'] = $products;
                        }

                        $data['links'] = $links;
                    }

                    if (config('all_brands.' . $cname . ".meta", false) !== false) {
                        $meta = config('all_brands.' . $cname . ".meta");
                        $seo  = app('seo');
                        $seo->setTitle($meta['title']);
                        $seo->setDescription($meta['description']);
                    }

                    if (isMobile()) {
                        return view("v3.mobile.all_brands", $data);
                    } else {
                        return view("v3.listing.all_brands", $data);
                    }
                }
            }
            catch (\Exception $e) {
                \Log::error("All Brand Category Page Error:: " . $e->getMessage());
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function brandCategoryListComp(Request $request, $brand, $category, $parent_id = 0, $page = 1)
    {
        if (!empty($brand)) {
            //Add price to Request Object Manually and enabling price filter for Listing Controller.
            $request->request->add(['brand' => $brand, "brand_page" => true]);
            $request->request->add(['price_filter' => true]);
        }

        if(in_array($parent_id,array_keys(config('common.deactivate_ids'))))
        {
            $parent_id =  config('common.deactivate_ids')[$parent_id];
        }

        $cat = $this->getParentName($category, 0, $parent_id, $request);

        if (in_array($cat->group_name, config('listing.brand.groups'))) {
            return redirect()->route('brands.listing', [cs($cat->group_name), $brand, cs($cat->category)], 301);
        }

        return $this->productList($request, cs($cat->group_name), $cat->category . "-price-list-in-india", false, $page);
    }

    public function categoryBrandList(Request $request, $group, $brand, $category, $page = 1)
    {
        if (!empty($brand)) {
            $brand = preg_replace("/-/", " ", $brand);

            $request->request->add(['brand' => $brand, "brand_listing_page" => true]);
            $request->request->add(['price_filter' => true]);
        }

        $cat = $this->getParentName($category, $group, 0, $request);

        if (cs($cat->name) == cs($cat->group_name)) {

            $Category = Category::where(DB::raw(" create_slug(group_name) "), 'LIKE', cs($cat->group_name))
                                ->where(DB::raw(" create_slug(name) "), "LIKE", $cat->category)
                                ->first();

            if (!Category::hasThirdLevel($Category)) {
                return redirect(categoryLink([$cat->group_name, $cat->category]), 301);
            }
        }

        if (!in_array(strtolower($cat->group_name), config('listing.brand.groups'))) {
            return redirect()->route('brand_category_list', [$brand, cs($cat->group_name), cs($cat->category)], 301);
        }

        if (strtolower(cs($cat->name)) == strtolower($group)) {
            $child = false;
            session()->push('first_category_bread', $cat->name);
        } else {
            $child = cs($cat->name);
            session()->push('second_category_bread', $cat->name);
        }

        return $this->productList($request, cs($group), $cat->category . "-price-list-in-india", $child, $page);
    }

    public function brandCategoryList(Request $request, $brand, $group, $category, $page = 1)
    {
        if (!empty($brand)) {
            //Add price to Request Object Manually and enabling price filter for Listing Controller.

            $three_cat = ['-home-decor-', '-beauty-health-', '-sports-fitness-', '-deals-promotion-'];

            foreach ($three_cat as $cat) {
                $uri = $brand . '-' . $group . '-' . $category;

                if (stripos($uri, $cat) !== false) {
                    $part     = explode($cat, $uri);
                    $brand    = preg_replace('/[-]+/', ' ', trim($part[0]));
                    $group    = trim($cat, '-');
                    $category = $part[1];
                }
            }
            $request->request->add(['brand' => $brand, "brand_page" => true]);
            $request->request->add(['price_filter' => true]);
        }

        $cat   = $this->getParentName($category, $group, 0, $request);
        $child = (cs($cat->group_name) == cs($cat->name)) ? false : cs($cat->name);

        if (in_array($category, ['mobiles', 'laptops'])) {

            $Category = Cache::remember("category_name_" . $category, 3600, function () use ($category) {
                return Category::select('id')
                               ->where(\DB::raw(" create_slug(name) "), "like", $category)
                               ->first()
                               ->toArray();
            });

            return redirect()->route('brand_category_list_comp_1', [$brand, $category, $Category['id']], 301);
        }

        if (in_array(strtolower($cat->group_name), config('listing.brand.groups'))) {
            $rest  = "-" . implode("-", [cs($cat->group_name), $cat->category]);
            $brand = str_replace($rest, '', $uri);

            return redirect()->route('brands.listing', [cs($cat->group_name), cs($brand), cs($cat->category)], 301);
        }

        return $this->productList($request, create_slug($cat->group_name), $cat->category . "-price-list-in-india", $child, $page);
    }

    public function categoryList(Request $request, $category)
    {
        $seo = app('seo');

        if ($category == 'home') {
            return redirect(url('home-decor'), 301);
        }

        if (substr(trim($category), -1) == '-') {
            return redirect(trim($category, '-'), 301);
        }

        $data['cat_name'] = urldecode($category);
        $cat_data         = Category::where(\DB::raw(" create_slug(name) "), "like", $category)
                                    ->with('slider')
                                    ->where('level', 0)
                                    ->where('active', 1)
                                    ->select(['meta', 'seo_title', 'description', 'id', 'name', 'level'])
                                    ->first();

        if (isset($cat_data->slider) && $cat_data->slider->count() > 0) {
            $data['sliders'] = $cat_data->slider;
        } else {
            $data['sliders'] = collect();
        }

        if (empty($cat_data)) {
            return abort(404);
        }

        if (!empty($cat_data->seo_title)) {
            $seo->setTitle($cat_data->seo_title);
        }

        if (isset($cat_data->id)) {

            if (!empty($cat_data->meta)) {
                $meta = json_decode($cat_data->meta);
            }

            if (isset($meta->description) && !empty($meta->description)) {
                $seo->setDescription($meta->description);
            }

            if (isset($meta->text) && !empty($meta->text)) {
                $seo->setContent($meta->text);
            }

            if (isset($meta->keywords) && !empty($meta->keywords)) {
                $seo->setKeywords($meta->keywords);
            }

            if (isset($meta->h1) && !empty($meta->h1)) {
                $seo->setHeading($meta->h1);
            }

            if (isset($meta->short_description) && !empty($meta->short_description)) {
                $seo->setShortDescription($meta->short_description);
            }
        }


        if (Schema::hasTable('landing_widget')) {
            $widgets = LandingWidget::with(['category', 'category.parent'])
                                    ->whereGroupId($cat_data->id)
                                    ->orderBy('sequence', "ASC")
                                    ->get();

            $first = $widgets->shift();
        } else {
            $first = null;
        }

        if (!is_null($first)) {
            $filters = [
                'min_price'   => 'SalepriceMin',
                'max_price'   => 'SalepriceMax',
                'brand'       => 'Brand',
                'category_id' => 'CategoryId'
            ];

            foreach ($filters as $filter => $field) {
                if (isset($first->{$filter}) && !empty($first->{$filter})) {
                    $key = "where" . $field;

                    $this->solrClient->{$key}($first->$filter);
                }
            }

            $result = $this->solrClient->getSearch();

            $data['products']     = $result['data'];
            $data['facets']       = $result['filters'];
            $data['minPrice']     = $data['facets']->saleprice_min->value;
            $data['maxPrice']     = $data['facets']->saleprice_max->value;
            $data['category_id']  = $cat_data->id;
            $data['first']        = $first;
            $data['widget_count'] = $widgets->count();
        } else {
            $cats = Category::whereParentId($cat_data->id)->get();

            $category                 = $cats->first();
            $first                    = new \stdClass();
            $first->title             = $category->name;
            $first->category          = $category;
            $data['category_id']      = $cat_data->id;
            $data['first']            = $first;
            $data['widget_count']     = $cats->count();
            $data['child_categories'] = $data['childs'] = $cats;
        }
        $this->setupProductListJsonLD($data);
        return view('v3.listing.category', $data);
    }

    public function ajaxContent(Request $request, $section = '')
    {
        if ($request->ajax()) {
            $rules = ['section' => 'required'];

            $input = [
                'section' => $section,
            ];

            $v = \Validator::make($input, $rules);

            if ($v->fails()) {
                return response($v->errors(), 422);
            }

            if ($request->has('content') || $request->has('product')) {
                try {
                    if ($request->has('content')) {
                        $product = \Crypt::decrypt($request->get('content'));
                    }
                    if ($request->has('product')) {
                        $product = \Crypt::decrypt($request->get('product'));
                    }

                    $data['category_id'] = $product->cat;

                    switch ($section) {
                        case 'category_widget_1':
                        case 'category_widget_2':
                        case 'category_widget_3':
                        case 'category_widget_4':
                        case 'category_widget_5':
                        case 'category_widget_6':
                        case 'category_widget_7':
                        case 'category_widget_8':
                        case 'category_widget_9':
                        case 'category_widget_10':
                        case 'category_widget_11':
                        case 'category_widget_12':
                        case 'category_widget_13':

                            $parts = explode('category_widget_', $section);

                            if (isset($parts[1]) && is_numeric($parts[1])) {
                                if (Schema::hasTable('landing_widget')) {
                                    $widgets = LandingWidget::with(['category', 'category.parent'])
                                                            ->whereGroupId($data['category_id'])
                                                            ->orderBy('sequence', "ASC")
                                                            ->get();

                                    $widget = $widgets->get($parts[1]);
                                } else {
                                    $widget = null;
                                }

                                if (!is_null($widget)) {
                                    $filters = [
                                        'min_price'   => 'SalepriceMin',
                                        'max_price'   => 'SalepriceMax',
                                        'brand'       => 'Brand',
                                        'category_id' => 'CategoryId'
                                    ];

                                    foreach ($filters as $filter => $field) {
                                        if (isset($widget->{$filter}) && !empty($widget->{$filter})) {
                                            $key = "where" . $field;

                                            $this->solrClient->{$key}($widget->$filter);
                                        }
                                    }

                                    $result           = $this->solrClient->getSearch();
                                    $data['products'] = $result['data'];
                                    $data['facets']   = $result['filters'];
                                    $data['first']    = $widget;

                                } else {

                                    if ($data['category_id'] == 576) {
                                        $order = 'DESC';
                                    } else {
                                        $order = "ASC";
                                    }

                                    $cats = Category::whereParentId($data['category_id'])->orderBy('id', $order)->get();

                                    $category = $cats->get($parts[1]);

                                    $first           = new \stdClass();
                                    $first->title    = $category->name;
                                    $first->category = $category;

                                    if ($category->level < 2) {
                                        $child = Category::whereParentId($category->id)->get()->pluck('id');

                                        if ($child->count() > 0 && $child instanceof Collection) {
                                            $childs      = $child->toArray();
                                            $childs[]    = $category->id;
                                            $childs      = implode(",", $childs);
                                            $category_id = $childs;
                                        } else {
                                            $category_id = $category->id;
                                        }
                                    } else {
                                        $category_id = $category->id;
                                    }

                                    if ($category->group_name == "books") {
                                        $return = $this->solrClient->whereCategoryId($category_id)->getBooks(true);

                                        $result['data']    = $return->return_txt->hits->hits;
                                        $result['filters'] = $return->return_txt->aggregations;
                                    } else {
                                        $result = $this->solrClient->whereCategoryId($category_id)->getSearch();
                                    }

                                    $data['products'] = $result['data'];
                                    $data['facets']   = $result['filters'];
                                    $data['first']    = $first;
                                }

                                return $this->generateAjaxContent($data, $section);

                            } else {
                                return '';
                            }

                            break;

                        case 'listing_snippet':

                            $data['vars'] = (array)$product;

                            if (isset($product->brand) && !empty($product->brand)) {
                                $this->solrClient->whereBrand($product->brand);
                            }

                            $result         = $this->solrClient->whereCategoryId($product->cat)
                                                               ->fromLastFilter()
                                                               ->take(10)
                                                               ->where('order_by', 'id')
                                                               ->where('sort_order', 'desc')
                                                               ->where('snippet', true)
                                                               ->getSearch(true);
                            $data['c_name'] = (isset($data['vars']['c_name'])) ? $data['vars']['c_name'] : '';

                            if (!is_null($result)) {
                                $data['snippet']          = $result->return_txt->hits->hits;
                                $data['sn_numberOfItems'] = $result->return_txt->hits->total;

                                return $this->generateAjaxContent($data, $section);

                            } else {
                                return response('');
                            }

                            break;

                        case 'group_deals':
                            $cat = Category::find($product->cat);

                            $data['slides'] = \DB::connection('backend')
                                                 ->table(\DB::raw('home_top_deals as h'))
                                                 ->select(\DB::raw('gc_cat.name category, h.image_url, h.alt, h.refer_url'))
                                                 ->leftJoin('gc_cat', 'gc_cat.id', '=', 'h.category_id')
                                                 ->where('h.active', '=', 1)
                                                 ->where('gc_cat.group_name', '=', $cat->group_name)
                                                 ->orderBy('h.sequence')
                                                 ->get()
                                                 ->groupBy('category')
                                                 ->toArray();
                            $data['groups'] = collect($data['slides'])->keys();

                            if (!($data['groups'] instanceof Collection) || $data['groups']->count() == 0) {
                                return response('');
                            }

                            $first = $data['groups']->first();

                            return getAjaxWidget($section, $data['slides'][$first], 'slides', $data);

                            break;

                        default:
                            return response(['Invalid Section'], 403);
                            break;

                    }

                    try {
                        $result = $this->solrClient->getSearch();

                        $data['products'] = $result['data'];
                        $data['facets']   = $result['filters'];

                        $html = $this->generateAjaxContent($data, $section);

                        return $html;
                    }
                    catch (\Exception $e) {
                        \Log::error($e->getMessage() . "\r\n" . $e->getTraceAsString());

                        return '';
                    }

                }
                catch (DecryptException $e) {
                    return response('', 403);
                }

            } else {
                return response('', 403);
            }
        } else {
            return response('', 403);
        }
    }

    private function generateAjaxContent($data, $view)
    {
        switch ($view) {
            case 'category_widget_1':
            case 'category_widget_2':
            case 'category_widget_3':
            case 'category_widget_4':
            case 'category_widget_5':
            case 'category_widget_6':
            case 'category_widget_7':
            case 'category_widget_8':
            case 'category_widget_9':
            case 'category_widget_10':
            case 'category_widget_11':
            case 'category_widget_12':
            case 'category_widget_13':
                if (isMobile()) {
                    return view("v3.mobile.ajax.category", $data);
                } else {
                    return view("v3.listing.ajax.category", $data);
                }
                break;

            case 'listing_snippet':
                if (isMobile()) {
                    return view("v3.mobile.product.ajax.snippet", $data);
                } else {
                    return view("v3.listing.ajax.snippet", $data);
                }

                break;

            default:
                $view = (string)view("v2.product.owl.item", $data);
        }

        if (is_array($view)) {
            foreach ($view as $key => $v) {
                $view[$key] = preg_replace('/(\v)+/', '', $view[$key]);
                $view[$key] = str_replace("\t", "", $view[$key]);
            }

            $view = json_encode($view);
        } else {
            $view = preg_replace('/(\v)+/', '', $view);
            $view = str_replace("\t", "", $view);
        }

        return $view;
    }

    /**
     * Search wise Product Listing..
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     */
    public function searchList(Request $request, $cat_id, $keyword, $page = 1)
    {
        if ($keyword) {
            if (config('app.searchLogEnable')) {
                /*Logging search text to table*/
                $search_id = \DB::table('gc_search')->insertGetId(['term' => $keyword]);
                /*Logging search text to table*/

                $request->request->add(['search_id' => $search_id]);
            }

            $key   = 'group';
            $value = $cat_id;

            if ($cat_id != "0") {
                $cat = Category::where(\DB::raw(" create_slug(name) "), "like", $cat_id)->select([
                    'id',
                    'parent_id',
                    'name'
                ])->first();
                if (!is_null($cat)) {
                    if ($cat->parent_id != 0) {
                        $key   = 'cat_id';
                        $value = $cat->id;
                    }
                } else {
                    abort(404);
                }
            }

            $h1 = unslug($keyword) . " Price List in India";
            $request->request->add(["h1" => $h1, 'ajax' => true]);

            $request->request->add(['search_text' => unslug($keyword), $key => $value]);
            return $this->productList($request, false, false, false, $page);

        } else {
            abort(404);
        }

    }

    /**
     * Upcoming Mobile Phone Listing Page.
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     *
     * @return View
     */
    public function upcomingMobiles(Request $request, $page = 1)
    {
        $request->request->add(['upcoming-mobiles' => true, 'price_filter' => true]);

        return $this->productList($request, "mobile", "mobiles-price-list-in-india", false, $page);
    }

    /**
     * @author Vishal Singh <vishal@manyainternational.com>
     * CategoryWise ProductListing Page for 3rd Level Category Listing..
     *
     * @var \Illuminate\Http\Request
     * @var $slug String (Slug)
     * @var $page Number
     * @return Response
     */
    public function customPageListing(Request $request, $slug, $page = 1)
    {
        $CustomPage = CustomPage::with('category.parent')->whereSlug($slug)->first();

        if (is_null($CustomPage)) {
            return redirect()->route('home_v2', [], 301);
        }

        return redirect()->route('custom_page_list_v3', [$CustomPage->category->group_name, $slug], 301);
    }

    /**
     * Mobile phone listing Under a any given Max Price..
     *
     * @var \Illuminate\Http\Request
     * @var Maximum Price..
     * @var Page Number
     */
    public function bestPhones(Request $request, $price = 0, $page = 1)
    {
        if (empty($price) || !is_numeric($price)) {
            return redirect("/");
        } else {
            if (!$request->has('saleprice_max')) {

                $title = "Best phone under " . $price;
                //Add price to Request Object Manually and enabling price filter for Listing Controller.
                $request->request->add(['saleprice_max' => $price]);
                $request->request->add(['saleprice_min' => 0]);
                $request->request->add(['price_filter' => 1]);
                $request->request->add(['h1' => $title]);
                $request->request->add(['title' => $title]);
            }

            $request->request->add(['bestphones' => true]);

            return $this->productList($request, "mobile", "mobiles-price-list-in-india", false, $page);
        }
    }

    /**
     * Custom Links
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     */
    public function dual_sim(Request $request, $page = 1)
    {
        if (isset($description) && isset($title)) {
            $request->request->add(['description' => $description, 'title' => $title]);
        }

        if (isset($page) && !is_numeric($page)) {
            return redirect('mobile/dual-sim-phones', 301);
        }

        $request->request->add(['price_filter' => 1]);

        return $this->productList($request, "mobile", "dual-sim-phones--mobiles-price-list-in-india", false, $page);
    }

    /**
     * Custom Links
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     */
    public function android_phones(Request $request, $page = 1)
    {
        if (isset($description) && isset($title)) {
            $request->request->add(['description' => $description, 'title' => $title]);
        }

        if (isset($page) && !is_numeric($page)) {
            return redirect('mobile/android-phones', 301);
        }

        $request->request->add(['price_filter' => 1]);

        if (view()->exists('v3.description.android-mobiles')) {
            $this->seo->setContent(view('v3.description.android-mobiles')->render());
        }

        return $this->productList($request, "mobile", "android_phones--mobiles-price-list-in-india", false, $page);
    }

    /**
     * Custom Links
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     */
    public function windows_phones(Request $request, $page = 1)
    {
        if (isset($description) && isset($title)) {
            $request->request->add(['description' => $description, 'title' => $title]);
        }

        if (isset($page) && !is_numeric($page)) {
            return redirect('mobile/windows-phones', 301);
        }

        $request->request->add(['price_filter' => 1]);

        if (view()->exists('v3.description.windows-mobiles')) {
            $this->seo->setContent(view('v3.description.windows-mobiles')->render());
        }

        return $this->productList($request, "mobile", "windows_phones--mobiles-price-list-in-india", false, $page);
    }

    /**
     * List of custom links of men and women
     */
    public function list_of_men_women(Request $request, $group, $category, $keyword, $page = 1)
    {
        $category        = str_replace("lingerie-", "", $category);
        $parent_category = $this->getParentIDByName($category, 2, $group);
        $keyword         = reverse_slug($keyword);
        $title           = ucwords($keyword) . " prices in India 2017 | Indiashopps.com";
        $description     = "List of all " . $keyword . " with prices in India. Check out their new designs , latest trends in fashion , discounts and sale on Indiashopps.com";

        if (empty($parent_category)) {
            $category .= "s";
            $parent_category = $this->getParentIDByName($category, 2, $group);
            if (empty($parent_category)) {
                abort(404);
            }
        }

        $request->request->add([
            "search_text"     => $keyword,
            "group"           => $group,
            "parent_category" => strtolower($parent_category->name),
            "title"           => $title,
            "description"     => $description,
            "price_filter"    => true
        ]);

        $re = '/below(.*)/';

        preg_match($re, $keyword, $matches);

        if (isset($matches[1]) && (int)$matches[1] > 0) {
            $request->request->add(['saleprice_max' => (int)$matches[1]]);
        }

        $request->request->add(['custom_group_page' => 'yes', 'custom_category' => $category]);
        return $this->productList($request, false, false, false, $page);
    }

    /**
     * List of custom links of category
     */
    public function list_of_category(Request $request, $category, $keyword, $page = 1)
    {
        $group = "lifestyle";
        $cat   = Category::where(DB::raw(" create_slug(name) "), $category)->first();

        $request->request->add(["cat_id" => $cat->id]);
        $h1 = unslug($keyword) . " Price List in India";
        $request->request->add(["h1" => $h1]);
        return $this->list_of_men_women($request, $group, $category, $keyword, $page);
    }

    /**
     * @author Vishal Singh <vishal@manyainternational.com>
     * CategoryWise ProductListing Page for 3rd Level Category Listing..
     *
     * @var Request
     * @var $group (Category Group) String
     * @var $slug (Slug) String
     * @var $page integer
     * @return View
     */
    public function customPageListingV3(Request $request, $group, $slug, $page = 1)
    {
        $CustomPage = CustomPage::with('category.parent')->whereSlug($slug)->first();

        if (is_null($CustomPage)) {
            abort(404);
        }

        if ($group != $CustomPage->category->group_name) {
            return redirect()->route('custom_page_list_v3', [$CustomPage->category->group_name, $slug], 301);
        }

        try {
            foreach (json_decode($CustomPage->filters) as $filter => $value) {

                if (!$request->has($filter)) {
                    $request->request->add([$filter => $value]);
                }
            }

            foreach (json_decode($CustomPage->meta_data) as $meta => $value) {
                $meta_data[$meta] = $value;
            }

            $meta_data = (array)$this->getMeta((object)$meta_data);

            $request->request->add(['custom_page_meta' => $meta_data]);

            if (!empty($meta_data)) {
                $keys = [
                    'keywords'          => 'keywords',
                    'description'       => 'description',
                    'short_description' => 'shortDescription',
                    'title'             => 'title',
                    'meta'              => 'content',
                    'h1'                => 'heading'
                ];

                foreach ($keys as $key => $value) {
                    if (isset($meta_data[$key])) {
                        $function = "set" . ucfirst($value);

                        $this->seo->{$function}($meta_data[$key]);
                    }
                }
            }

        }
        catch (\Exception $E) {
            \Log::error("Custom Pages::" . $E->getMessage() . " " . $E->getTraceAsString());
        }


        $filters         = $request->all();
        $filters['slug'] = $slug;

        $request->request->add(['custom_filters' => $filters, "custom_page" => true]);
        $request->request->add(['apply_filters' => true, 'custom_page_id' => $CustomPage->id]);

        $cat = $CustomPage->category;

        if (strtolower($cat->group_name) == strtolower($cat->parent->name)) {
            return $this->productList($request, create_slug($cat->group_name), create_slug($cat->name) . "-price-list-in-india.html", false, $page);
        }

        return $this->productList($request, create_slug($cat->group_name), create_slug($cat->name) . "-price-list-in-india.html", create_slug($cat->parent->name), $page);
    }

    public function searchFeedback($search_id, $isGood = 1)
    {
        $search = \DB::table('gc_search')->whereId($search_id)->first();

        if (!is_null($search)) {
            \DB::table('gc_search')->whereId($search_id)->update(['isGood' => $isGood]);
        }

        return response('');
    }
}
