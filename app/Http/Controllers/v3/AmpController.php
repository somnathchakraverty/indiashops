<?php

namespace indiashopps\Http\Controllers\v3;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use indiashopps\Category;
use indiashopps\Console\Commands\HomeJsonCommand;
use indiashopps\Http\Controllers\ProductController;
use indiashopps\Library\Page\Pagination;
use indiashopps\Support\SolrClient\Facade\Solr as SolrClient;
use Jenssegers\Agent\Agent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use indiashopps\Http\Controllers\v3\ProductController as DetailController;

class AmpController extends BaseController
{
    public function index(Request $request)
    {
        $this->seo->setContent(view('v2.footer.description'));

        $data['home_content'] = HomeJsonCommand::homePageContent();

        $data['sliders'] = Cache::remember("mobile_home_banners", 3600, function () use ($data) {
            $sliders    = \DB::connection('backend')
                             ->table("slider")
                             ->select(['image_url', 'alt', 'refer_url'])
                             ->whereApp('2')
                             ->whereHome(1)
                             ->whereActive(1)
                             ->whereVersion('v2')
                             ->orderBy('sequence', "ASC")
                             ->get()
                             ->toArray();
            $slide_path = 'https://images.indiashopps.com/v2/slider/';

            foreach ($sliders as $key => $slider) {
                $slider->image_url = $slide_path . $slider->image_url;
                $slider->refer_url = $slider->refer_url;
                $slider->alt       = $slider->alt;
                $sliders[$key]     = $slider;
            }

            return $sliders;
        });

        enqueueWidget('find_lowest', [], '', true);

        $data['sliders'] = Cache::remember("amp_home_banners", 3600, function () use ($data) {
            $sliders    = \DB::connection('backend')
                             ->table("slider")
                             ->select(['image_url', 'alt', 'refer_url'])
                             ->whereApp('2')
                             ->whereHome(1)
                             ->whereActive(1)
                             ->whereVersion('v2')
                             ->orderBy('sequence', "ASC")
                             ->get()
                             ->toArray();
            $slide_path = 'https://images.indiashopps.com/v2/slider/';

            foreach ($sliders as $key => $slider) {
                $slider->image_url = $slide_path . $slider->image_url;
                $slider->refer_url = $slider->refer_url;
                $slider->alt       = $slider->alt;
                $sliders[$key]     = $slider;
            }

            return $sliders;
        });

        return view('v3.amp.index', $data);
    }

    public function categoryList(Request $request, $category)
    {
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
            $this->seo->setTitle($cat_data->seo_title);
        }

        if (isset($cat_data->id)) {

            if (!empty($cat_data->meta)) {
                $meta = json_decode($cat_data->meta);
            }

            if (isset($meta->description) && !empty($meta->description)) {
                $this->seo->setDescription($meta->description);
            }

            if (isset($meta->text) && !empty($meta->text)) {
                $this->seo->setContent($meta->text);
            }

            if (isset($meta->keywords) && !empty($meta->keywords)) {
                $this->seo->setKeywords($meta->keywords);
            }

            if (isset($meta->h1) && !empty($meta->h1)) {
                $this->seo->setHeading($meta->h1);
            }

            if (isset($meta->short_description) && !empty($meta->short_description)) {
                $this->seo->setShortDescription($meta->short_description);
            }
        }

        $cats = Category::with(['parent', 'parent.parent'])->whereParentId($cat_data->id)->get();

        $category                 = $cats->first();
        $first                    = new \stdClass();
        $first->title             = $category->name;
        $first->category          = $category;
        $data['category_id']      = $cat_data->id;
        $data['first']            = $first;
        $data['widget_count']     = $cats->count();
        $data['child_categories'] = $data['childs'] = $cats;

        $this->setupProductListJsonLD($data);
        return view('v3.amp.category', $data);
    }

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

            if ($category->level == 2) {
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
                $field = ["p" => "saleprice", "d" => "discount"];
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
            $solrObject->skip($request->page);
        } else {
            $solrObject->skip(($page - 1));
        }

        if ($request->has('custom_filters')) {
            $data = array_merge($data, $request->custom_filters);
        }

        $solrObject->take(32);

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
        $pagination->setRPP(30);
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
        if (($request->has('price_filter') && isset($result->aggregations->filters_all) || ($request->has('apply_filters')) && !$request->has('ajax'))) {
            unset($result->aggregations->filters_all->doc_count);
            $data['facets'] = $result->aggregations->filters_all;

            if (!isset($data['facets']->price_ranges) && isset($result->aggregations->price_ranges)) {
                $data['facets']->price_ranges = $result->aggregations->price_ranges;
            }
        } else {
            $data['facets'] = $result->aggregations;
        }

        //Sending Product data to VIEWS.....
        $data['product']  = $result->hits->hits;
        $data['minPrice'] = $result->aggregations->saleprice_min->value;
        $data['maxPrice'] = $result->aggregations->saleprice_max->value;
        $data['scat']     = $cat;

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
        $data['css_file'] = "product_list";

        $data['c_name'] = isset($data['c_name']) ? $data['c_name'] : '';

        /*Setup SEO Meta Da ta, and assign it to '$data' variable, passed as reference.*/
        $this->processSeoMetaData($request, $data, get_defined_vars());

        //Preparing AJAX response once filter is applied.... JSON Response
        if ($request->has('filter') && $request->input('filter') == "true") {

            $json['products']     = (string)view("v3.listing.ajax", $data);
            $json['products']     = preg_replace('/(\v)+/', '', $json['products']);
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

            $this->processMetaByRoute();
            $this->setupProductListJsonLD($data);

            return view('v3.amp.listing.index', $data);
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

    public function brandCategoryListComp(Request $request, $brand, $category, $parent_id = 0, $page = 1)
    {
        if (!empty($brand)) {
            //Add price to Request Object Manually and enabling price filter for Listing Controller.
            $request->request->add(['brand' => $brand]);
            $request->request->add(['price_filter' => true]);
        }

        $cat = $this->getParentName($category, 0, $parent_id, $request);

        if (in_array($cat->group_name, config('listing.brand.groups'))) {
            return redirect()->route('amp.brands.listing', [$cat->group_name, $brand, $cat->category], 301);
        }

        return $this->productList($request, cs($cat->group_name), $cat->category . "-price-list-in-india", false, $page);
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
            $request->request->add(['brand' => $brand]);
            $request->request->add(['price_filter' => true]);
        }
        $cat   = $this->getParentName($category, $group, 0, $request);
        $child = (create_slug($cat->group_name) == cs($cat->name)) ? false : cs($cat->name);

        if (in_array($category, ['mobiles', 'laptops'])) {

            $Category = Cache::remember("category_name_" . $category, 3600, function () use ($category) {
                return Category::select('id')
                               ->where(\DB::raw(" create_slug(name) "), "like", $category)
                               ->first()
                               ->toArray();
            });

            return redirect()->route('brand_category_list_comp_1', [$brand, $category, $Category['id']], 301);
        }

        if (in_array($cat->group_name, config('listing.brand.groups'))) {
            $rest  = "-" . implode("-", [$cat->group_name, $cat->category]);
            $brand = str_replace($rest, '', $uri);

            return redirect()->route('amp.brands.listing', [$cat->group_name, $brand, $cat->category], 301);
        }

        return $this->productList($request, cs($cat->group_name), $cat->category . "-price-list-in-india", $child, $page);
    }

    public function categoryBrandList(Request $request, $group, $brand, $category, $page = 1)
    {
        if (!empty($brand)) {
            $brand = preg_replace("/-/", " ", $brand);

            $request->request->add(['brand' => $brand, "brand_page" => true]);
            $request->request->add(['price_filter' => true]);
        }

        $cat = $this->getParentName($category, $group, 0, $request);

        if (cs($cat->name) == cs($cat->group_name)) {

            $Category = Category::where(\DB::raw(" create_slug(group_name) "), 'LIKE', cs($cat->group_name))
                                ->where(\DB::raw(" create_slug(name) "), "LIKE", cs($cat->name))
                                ->first();

            if (!Category::hasThirdLevel($Category)) {
                return redirect(categoryLink([$cat->group_name, $cat->category]), 301);
            }
        }

        if (!in_array($cat->group_name, config('listing.brand.groups'))) {
            return redirect()->route('amp.brand_category_list', [$brand, $cat->group_name, $cat->category], 301);
        }

        if (strtolower($cat->name) == strtolower($group)) {
            $child = false;
            session()->push('first_category_bread', $cat->name);
        } else {
            $child = cs($cat->name);
            session()->push('second_category_bread', $cat->name);
        }

        return $this->productList($request, cs($group), $cat->category . "-price-list-in-india", $child, $page);
    }

    public function comparative(Request $request, $slug, $product_id, $vendor = 0)
    {
        $productController = new DetailController();

        $request->request->add(['page' => 'comparative', 'mobile_page' => true, 'amp_page' => true]);

        $data = $productController->productDetail($request, $slug, $product_id, $vendor);

        if ($data instanceof RedirectResponse || $data instanceof View) {
            return $data;
        }

        $data['css_file']  = "product_detail";
        $data['reviews']   = getMobileReviews($data['product']->id);
        $data['page_type'] = 'comparative';

        if (isset($data['product']->meta) && !empty($data['product']->meta)) {
            $data['product']->meta = json_decode($data['product']->meta);
        }

        if (isset($data['product'])) {
            $product = $data['product'];

            if (isComingSoon($product) || Category::hasSetCategory($product)) {
                return view("v3.amp.product.detail_upcoming", $data);
            }
        }

        return view("v3.amp.product.detail", $data);
    }

    public function books(Request $request, $slug, $product_id, $vendor = 0)
    {
        $productController = new DetailController();

        $request->request->add([
            'page'        => 'non-comparative',
            'mobile_page' => true,
            'amp_page'    => true,
            'group'       => 'books'
        ]);

        $data = $productController->productDetail($request, $slug, $product_id, $vendor);

        if ($data instanceof RedirectResponse || $data instanceof View) {
            return $data;
        }

        $data['css_file'] = "product_detail";
        $data['reviews']  = [];

        if (isset($data['product']->meta) && !empty($data['product']->meta)) {
            $data['product']->meta = json_decode($data['product']->meta);
        }

        return view("v3.amp.product.detail", $data);
    }

    public function nonComparative(Request $request, $slug, $product_id, $vendor = 0)
    {
        $productController = new DetailController();

        $request->request->add(['page' => 'non-comparative', 'mobile_page' => true, 'amp_page' => true]);
        $request->request->add($request->route()->parametersWithoutNulls());

        $data = $productController->productDetail($request, $slug, $product_id, $vendor);

        if ($data instanceof RedirectResponse || $data instanceof View) {
            return $data;
        }

        $data['css_file'] = "product_detail";

        return view("v3.amp.product.detail", $data);
    }
}
