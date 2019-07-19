<?php

namespace indiashopps\Http\Controllers\v3;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use indiashopps\Category;
use indiashopps\Models\CustomPage;
use indiashopps\Models\ExpertReview;
use indiashopps\Models\News;
use indiashopps\Models\ProductReview;
use indiashopps\Models\PurchaseOrder;
use indiashopps\Support\SolrClient\Facade\Solr;

class ProductController extends BaseController
{
    public function productDetail(Request $request, $slug, $product_id, $vendor = 0)
    {
        $seo = app('seo');

        $execution['start'] = LARAVEL_START;

        if ($request->has('page') && $request->page != 'comparative') {
            if (!$request->has('amp_page') && (empty($vendor) || !isset($vendor))) {
                return redirect()->route('product_detail_v2', [$slug, $product_id]);
            }

            if (!$request->has('mobile_page') && $request->group != create_slug($request->group)) {
                return redirect(route('product_detail_non', [
                    create_slug($request->group),
                    $slug,
                    $product_id,
                    $vendor
                ]), 301);
            }
        }

        if ($request->has('group') && $request->group == "books") {
            $this->solrClient->param("isBook", "true");
        }
        if (!empty($vendor)) {
            $pid = $product_id . "-" . $vendor;
        } else {
            $pid = $product_id;
        }

        $async_response = $this->asyncProductDetails($request, $slug, $product_id, $vendor);

        if ($async_response instanceof View) {
            return $async_response;
        }

        if (!($async_response instanceof RedirectResponse) && isset($async_response['has_mobile_data']) && $async_response['has_mobile_data'] === true) {
            return $async_response;
        }

        $this->solrClient->wherePid($pid);
        $data['data'] = $this->solrClient->getProduct(true);

        $execution['detail'] = microtime(true) - LARAVEL_START;

        if (empty($data['data']->product_detail)) {
            /***Product Not Found**/
            //404 Page, as the product not found..
            return $this->productDiscontinued($slug);
        }
        $product = $data['data']->product_detail;

        if (!$request->has('mobile_page') && !empty($vendor) && $request->page != 'non-comparative') {
            return redirect()->route('product_detail_non', [cs($product->grp), $slug, $product_id, $vendor], 301);
        }

        if ($slug !== create_slug($data['data']->product_detail->name)) {
            #if URL name doesn't match to product name

            if (!is_array($product->vendor) && (int)$product->vendor > 0) {
                return redirect(route('product_detail_non', [
                    $product->grp,
                    create_slug($product->name),
                    $product->id,
                    $product->vendor
                ]), 301);
            } else {
                return redirect(route('product_detail_v2', [create_slug($product->name), $product->id]), 301);
            }
        }

        $product = $data['data']->product_detail;

        if ($this->hasRedirectTo($product)) {
            return $this->redirectTo($product);
        }

        if (isset($product->group)) {
            $product->grp = $product->group;
        }

        /*### SETTING SEO DESCRIPTIONS ###*/
        if (array_key_exists(create_slug($product->grp), config('meta.detail.group'))) {
            $key = 'meta.detail.group.' . create_slug($product->grp);
        } else {
            $key = 'meta.detail.' . $product->category_id;
        }

        $data['meta'] = (config($key)) ? $this->getProductMeta($key, $product) : "";

        if (isset($product->seo_title) && !empty($product->seo_title)) {
            $data['data']->product_detail->seo_title = $this->getCustomMeta($product->seo_title, $product);
        }

        $execution['meta'] = microtime(true) - LARAVEL_START;

        if ($request->has('debug_time')) {
            $execution['url']    = $request->url();
            $execution['fields'] = $request->all();
            $execution['ip']     = env('SERVER_IP', $request->server('SERVER_ADDR'));
            \Log::warning('Detail Page Execution Details::', $execution);
        }

        $expert_data = ExpertReview::whereVendor($vendor)->whereProId($product_id)->first();

        if (!is_null($expert_data)) {
            $data['expert_data'] = json_decode($expert_data->expert_data)->data;
        }

        $seo->setHeading($product->name);

        if (isset($data['meta']) && is_object($data['meta'])) {
            foreach ($data['meta'] as $key => $value) {
                $function = "set" . ucfirst($key);
                $seo->{$function}($value);
            }

            if (isset($data['meta']->keyword)) {
                $seo->setKeywords($data['meta']->keyword);
            }

            unset($data['meta']);
        }

        if (isset($product->meta) && !empty($product->meta)) {
            try {
                $product->meta = preg_replace('/\r\n/', '', $product->meta);
                $meta          = json_decode($product->meta);
                $meta          = $this->getCustomMeta($meta, $product);

                if (isset($meta->keywords)) {
                    $seo->setKeywords($meta->keywords);
                }

                if (isset($meta->meta)) {
                    $seo->setContent(html_entity_decode($meta->meta));
                }

                unset($meta);
            }
            catch (\Exception $e) {
            }
        }

        $this->seo->setupShortDescription($product);
        $this->getFAQs($product, $data);

        if ($request->has('mobile_page') && $request->input('mobile_page') == true) {
            return $data;
        }

        return view("v3.product.detail.index", $data);
    }

    public function comparative(Request $request, $slug, $product_id, $vendor = 0)
    {
        $request->request->add(['page' => 'comparative']);

        return $this->productDetail($request, $slug, $product_id, $vendor);
    }

    public function nonComparative(Request $request, $group, $slug, $product_id, $vendor = 0)
    {
        $request->request->add(['group' => $group]);
        $request->request->add(['page' => 'non-comparative']);

        return $this->productDetail($request, $slug, $product_id, $vendor);
    }

    public function bookDetail(Request $request, $slug, $product_id, $vendor = 0)
    {
        $request->request->add(['group' => 'books']);
        $request->request->add(['page' => 'non-comparative']);

        return $this->productDetail($request, $slug, $product_id, $vendor);
    }

    public function ajaxContent(Request $request, $section = '')
    {
        if ($request->ajax()) {
            $rules = ['section' => 'required'];
            $input = [
                'section' => $section,
            ];
            $v     = \Validator::make($input, $rules);
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
                    $data['_id']         = $product->id;
                    $data['category_id'] = $product->cat;
                    $this->solrClient->whereCategoryId($product->cat);
                    switch ($section) {
                        case 'product_vendor':
                            abort(404);
                            $this->solrClient->whereId($product->id);
                            $result          = $this->solrClient->getVendors(true);
                            $data['product'] = $product;
                            $data['vendors'] = $result->return_txt->hits->hits;
                            return $this->generateAjaxContent($data, $section);
                            break;
                        case 'deals_on_phone';
                            $this->solrClient->take(1);
                            $result          = $this->solrClient->getSearch();
                            $data['filters'] = $result['filters'];
                            $data['content'] = $request->get('content');
                            $min             = $data['filters']->saleprice_min->value;
                            $max             = $data['filters']->saleprice_max->value;
                            $range           = price_range($min, $max);
                            if (!$range) {
                                return response('');
                            }
                            $data['tabs'] = $range['tabs'];
                            $ranges       = $range['price_range'];
                            foreach ($ranges as $range) {
                                $product->price_range = $range;
                                $contents[]           = \Crypt::encrypt($product);
                            }
                            $data['contents'] = $contents;
                            $ranges           = explode("-", $ranges[0]);
                            $this->solrClient->whereSalepriceMin($ranges[0])
                                             ->whereSalepriceMax($ranges[1])
                                             ->whereCategoryId($product->cat);
                            $result           = $this->solrClient->getSearch();
                            $data['products'] = $result['data'];
                            return $this->generateAjaxContent($data, $section);
                            break;
                        case 'deals_under_two';
                        case "deals_under_three":
                        case "deals_under_four":
                        case "deals_under_five":
                            if (isset($product->price_range)) {
                                $ranges = explode("-", $product->price_range);
                                $this->solrClient->whereSalepriceMin($ranges[0])->whereSalepriceMax($ranges[1]);
                                $data['ajax'] = true;
                            } else {
                                return false;
                            }
                            break;
                        case 'mobile_reviews';
                            $data['product_id'] = $product->id;
                            $data['reviews']    = getMobileReviews($product->id);
                            $data['content']    = $request->get('content');
                            return $this->generateAjaxContent($data, $section);
                            break;
                        case 'by_brand':
                            $data['brand_widget'] = true;
                            $this->solrClient->whereBrand($product->brand);
                            break;
                        case 'by_size':
                            $this->solrClient->whereSize($product->size);
                            break;
                        case 'by_color':
                            $this->solrClient->whereColor($product->color);
                            break;
                        case 'by_vendor_one':
                            $this->solrClient->whereVendor(3);
                            break;
                        case 'by_vendor_two':
                            $this->solrClient->whereVendor(1);
                            break;
                        case 'compare_filters':
                            $this->solrClient->take(12);
                            $data['product'] = $product;
                            $data['ajax']    = true;
                            break;
                        case 'category_accessories':
                            $this->solrClient->take(50)->whereName($product->name)->whereCategoryId($product->cat);
                            $result          = $this->solrClient->getTopDeals(true);
                            $hits            = $result->deals->hits->hits;
                            $data['product'] = $product;

                            foreach ($hits as $product) {
                                $products[] = $product->_source;
                            }

                            if (!isset($products)) {
                                return response('');
                            }

                            $data['tabs'] = collect($products)->groupBy('category');
                            return $this->generateAjaxContent($data, $section);
                            break;
                        case 'video_review';
                            if (isset($product->meta)) {
                                try {
                                    $meta                = json_decode($product->meta);
                                    $data['youtube_url'] = $meta->video_url;
                                }
                                catch (\Exception $e) {
                                    return '';
                                }
                            } else {
                                return '';
                            }
                            return $this->generateAjaxContent($data, $section);
                            break;
                        default:
                            return response(['Invalid Section'], 403);
                            break;
                    }
                    try {
                        $result           = $this->solrClient->getSearch();
                        $data['products'] = $result['data'];
                        $data['facets']   = $result['filters'];
                        if (isPricelist($product->cat) || isset($data['ajax'])) {
                            $products = $this->generateAjaxContent($data, $section);
                        } else {
                            $products = $this->generateNonCompAjaxContent($data, $section);
                        }
                        return $products;
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

    public function compareProductsList(Request $request)
    {
        if ($request->has('product')) {
            $product = \Crypt::decrypt($request->get('product'));
        }

        if (!isset($product) || empty($product)) {
            return response('', 403);
        }

        $params = $request->except(['ajax', 'filter', 'product']);

        $this->solrClient->whereCategoryId($product->cat)->take(10);

        foreach ($params as $param => $value) {
            $function = "where" . ucwords($param);
            $this->solrClient->{$function}($value);
        }

        $result           = $this->solrClient->getSearch();
        $data['products'] = $result['data'];

        $response['products'] = $this->generateAjaxContent($data, 'compare_competitors');
        $response['facet']    = [];

        echo json_encode($response);
        exit;
    }

    private function generateAjaxContent($data, $view)
    {
        switch ($view) {
            case "product_vendor":
                if (isMobile()) {
                    $view_file = "v3.mobile.product.ajax.vendors";
                } else {
                    $view_file = "v3.product.common.vendors";
                }
                break;
            case "mobile_reviews":
                if (isMobile()) {
                    $view_file = "v3.mobile.product.ajax.reviews";
                } else {
                    $view_file = "v3.product.common.review";
                }
                break;
            case "video_review":
                if (isMobile()) {
                    $view_file = "v3.mobile.product.ajax.video_reviews";
                } else {
                    $view_file = "v3.product.common.ajax.video_reviews";
                }
                break;
            case "category_accessories":
                if (isMobile()) {
                    $view_file = "v3.mobile.product.ajax.category_accessories";
                } else {
                    $view_file = "v3.product.common.ajax.category_accessories";
                }
                break;
            case "compare_filters":
                if (isMobile()) {
                    $view_file = "v3.mobile.product.ajax.compare";
                } else {
                    $view_file = "v3.product.common.compare";
                }
                break;
            case "deals_on_phone":
            case "deals_under_two":
            case "deals_under_three":
            case "deals_under_four":
            case "deals_under_five":
                if (isset($data['ajax'])) {
                    if (isMobile()) {
                        $view_file = "v3.mobile.product.ajax.deals_ajax";
                    } else {
                        $view_file = "v3.product.common.ajax.deals";
                    }
                } else {
                    if (isMobile()) {
                        $view_file = "v3.mobile.product.ajax.deals";
                    } else {
                        $view_file = "v3.product.common.deals";
                    }
                }
                break;
            case "compare_competitors":
                $view = view("v3.product.common.ajax.compare", $data)->render();
                $view = preg_replace('/(\v)+/', '', $view);
                $view = str_replace("\t", "", $view);
                break;
            default:
                $view = (string)view("v2.product.owl.item", $data);
        }
        if (!empty($view_file) && view()->exists($view_file)) {
            return view($view_file, $data);
        }
        return $view;
    }

    private function generateNonCompAjaxContent($data, $view)
    {
        switch ($view) {
            case "by_color":
            case "by_brand":
            case "by_size":
            case "by_vendor_one":
            case "by_vendor_two":
                $view = (string)view("v3.product.common.ajax.deals", $data);;
                break;


            default:
                $view = (string)view("v2.product.owl.item_big", $data);
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

    public function getProductMeta($string, $product)
    {
        $metas = (object)config($string);

        foreach ($metas as $key => $meta) {
            $brand   = ($product->vendor == 1) ? ucwords($product->brand) : '';
            $brand   = (stripos($product->name, $brand) === false) ? $brand : '';
            $search  = [
                '{DATE}',
                '{YEAR}',
                '{BRAND}',
                '{MODEL}',
                '{VARIANT}',
                '{PRICE}',
                '{CATEGORY}',
                '{GROUP}',
                '{ID}',
                '{RELEASE_DATE}'
            ];
            $replace = [
                Carbon::now()->format('F, Y'),
                Carbon::now()->format('Y'),
                $brand,
                ucwords($product->name),
                '',
                number_format($product->saleprice),
                ucwords($product->category),
                ucwords($product->grp),
                $product->id,
                isset($product->release_date) ? $product->release_date : Carbon::now()->format('F, Y')
            ];

            foreach ($search as $k => $s) {
                if (isset($product->category_id) && $product->category_id == Category::LAPTOPS) {
                    $metas->{$key} = preg_replace('/\((.*?)\)/', '', $metas->{$key});
                }

                $metas->{$key} = preg_replace('/\s\s+/', ' ', $metas->{$key});
                $metas->{$key} = preg_replace('/' . $s . '/', $replace[$k], $metas->{$key});
            }
        }

        return $metas;
    }

    public function getCustomMeta($metas, $product)
    {
        $search  = [
            '{DATE}',
            '{YEAR}',
            '{PRICE}',
        ];
        $replace = [
            Carbon::now()->format('F, Y'),
            Carbon::now()->format('Y'),
            number_format($product->saleprice),
        ];

        if (is_object($metas)) {
            foreach ($metas as $key => $meta) {
                foreach ($search as $k => $s) {
                    $metas->{$key} = preg_replace('/\((.*?)\)/', '', $metas->{$key});
                    $metas->{$key} = preg_replace('/\s\s+/', ' ', $metas->{$key});
                    $metas->{$key} = preg_replace('/' . $s . '/', $replace[$k], $metas->{$key});
                }
            }
        } else {
            foreach ($search as $k => $s) {
                $metas = preg_replace('/\((.*?)\)/', '', $metas);
                $metas = preg_replace('/\s\s+/', ' ', $metas);
                $metas = preg_replace('/' . $s . '/', $replace[$k], $metas);
            }
        }

        return $metas;
    }

    /**
     * AMP Product Detail Controller for NON_COMPARITIVE products.. i.e book, men, women etc category products..
     *
     * @var Product Name
     * @var Product ID
     * @var \Illuminate\Http\Request
     * @return View
     */
    function product_detail_amp($name, $id, $vendor, Request $request)    //Shows product detail
    {
        // Redirects to product_detail_new function if product is comparitive product..
        if (empty($vendor) && !isset($vendor)) {
            return redirect('product/' . $name . "/" . $id . "/amp");
        }
        $bname = explode("-", $name);
        // Checks if the product is BOOK..
        if (end($bname) == "book") {
            $args = "&isBook=true";
            $this->solrClient->whereBook("true");
        } else {
            $args = '';
        }
        $id = $id . "-" . $vendor;
        //SOLR URL for getting product detail
        $data['product'] = $this->solrClient->wherePid($id)->getProduct(true);
        //List of PRODUCTS>
        if (isset($data['product']->product_detail)) {
            $data['product'] = $data['product']->product_detail;
        } else {
            $data['product'] = "";
        }

        if (end($bname) == "book" && is_object($data['product'])) {
            $data['product']->grp = "books";
        }

        //IF PRODUCT FOUND..
        if (!empty($data['product'])) {
            if ($name !== create_slug($data['product']->name) && ($data['product']->grp != "books")) {
                #if URL name doesn't match to product name
                return redirect("product/" . create_slug($data['product']->name) . "/" . $data['product']->id . "-" . $data['product']->vendor . "/amp");
            }
            /*****Creating Title***/
            if (isset($data['product']->seo_title) && (!empty($data['product']->seo_title))) {
                $data['title'] = $data['product']->seo_title;
            }
            //// RELATED PRODUCTS list..
            $data['ViewAlso'] = $this->solrClient->whereInfo(urlencode($data['product']->name))
                                                 ->whereCat(urlencode($data['product']->category))
                                                 ->where("pid", $id . $args)
                                                 ->getViewAlso(true);

            $data['ViewAlso']   = $data['ViewAlso']->return_txt;
            $data['full']       = false;
            $data['moreimage']  = false;
            $data['page_title'] = "";

            if (isset($data['product']->category)) {
                $data['c_name'] = $data['product']->category; // Category name to be used in DETAIL VIEW file..
            }

            if (isset($data['product']->meta)) {
                $data['detail_meta'] = json_decode($data['product']->meta);

                if (!is_null($data['detail_meta'])) {
                    foreach ($data['detail_meta'] as $key => $value) {
                        $function = "set" . ucfirst($key);
                        $this->seo->{$function}($value);
                    }

                    if (isset($data['detail_meta']->keyword)) {
                        $this->seo->setKeywords($data['detail_meta']->keyword);
                    }
                }
            }

            $this->seo->setupShortDescription($data['product']);

            $response = new \Illuminate\Http\Response(view("v3.amp.product_detail", $data));
            return $response;
        } else {
            //404 Page, as the product not found..
            return $this->productDiscontinued($name);
        }
    }

    /**
     * Product Detail Controller for COMPARITIVE products.. i.e mobile, laptops category products..
     *
     * @var Product Name
     * @var Product ID
     * @var \Illuminate\Http\Request
     * @return View
     */
    function product_detail_new_amp($name, $id, Request $request)    //Show a product detail
    {
        $part = explode("-", $id);

        //IF non comparitive then REDIRECT...
        if (!empty($part[1]) && isset($part[1])) {
            return redirect('product/' . $name . "/" . $id . "/amp");
        }

        $data['product'] = $this->solrClient->wherePid($id)->getAmpProduct(true);

        if (isset($data['product']) && !empty($data['product']) && isset($data['product']->return_txt)) {
            $data['product'] = $data['product']->return_txt;
            //Correcting Product name
            if ($name !== create_slug($data['product']->name)) {
                #if URL name doesn't match to product name
                return redirect("product/" . create_slug($data['product']->name) . "/" . $data['product']->id . "/amp");
            }
            /*****Creating Title***/
            if (isset($data['product']->seo_title) && (!empty($data['product']->seo_title))) {
                $data['title'] = $data['product']->seo_title;
            }
            // RELATED PRODUCT LIST
            $data['ViewAlso'] = $this->solrClient->whereInfo(urlencode($data['product']->name))
                                                 ->whereCatId($data['product']->category_id)
                                                 ->whereCat(urlencode($data['product']->category))
                                                 ->where("pid", $id)
                                                 ->getViewAlso(true);

            $data['ViewAlso']  = $data['ViewAlso']->return_txt;
            $data['full']      = false;
            $data['moreimage'] = false;

            $data['vendor'] = $this->solrClient->whereId($id)->getVendors(true);
            $data['vendor'] = $data['vendor']->return_txt;

            if (!empty($data['vendor']->hits->hits)) {
                $data['hasVendor'] = true;
            }


            $data['mobile'] = isMobile();

            if (isset($data['product']->category)) {
                $data['c_name'] = $data['product']->category;
            }

            if (isset($data['product']->meta)) {
                $data['detail_meta'] = json_decode($data['product']->meta);

                if (!is_null($data['detail_meta'])) {
                    foreach ($data['detail_meta'] as $key => $value) {
                        $function = "set" . ucfirst($key);
                        $this->seo->{$function}($value);
                    }

                    if (isset($data['detail_meta']->keyword)) {
                        $this->seo->setKeywords($data['detail_meta']->keyword);
                    }
                }
            }

            $this->seo->setupShortDescription($data['product']);

            $response = new \Illuminate\Http\Response(view("v3.amp.product_detail_new", $data));
            return $response;
        } else {
            //// 404, Product NOT found..
            return $this->productDiscontinued($name);
        }
    }

    public function asyncProductDetails(Request $request, $slug, $product_id, $vendor = 0)
    {
        /* ASYNC API Data using NODEJS START*/

        if (env("ENABLE_AJAX_DETAIL_PAGES", true) === true) {
            /*Returns false for AJAX based detail page..*/
            return false;
        }

        if ($request->has('page') && $request->page == 'non-comparative') {

            if ($request->has('group') && $request->group == "books") {
                $this->solrClient->param("isBook", "true");
            }

            if (!empty($vendor)) {
                $pid = $product_id . "-" . $vendor;
            } else {
                $pid = $product_id;
            }
            $return = $this->solrClient->wherePid($pid)->storeFilter()->getNonCompDetail(true);

            if (empty($return->productDetail->hits->hits)) {
                return $this->productDiscontinued($slug);
            }

            $data['product']       = collect($return->productDetail->hits->hits)->first()->_source;
            $data['brand_count']   = isset($return->brand_count) ? $return->brand_count : 0;
            $data['by_vendor_two'] = isset($return->by_vendor_two) ? $return->by_vendor_two->hits->hits : '';
            $data['by_vendor_one'] = isset($return->by_vendor_one) ? $return->by_vendor_one->hits->hits : '';
            $data['by_brand']      = isset($return->by_brand) ? $return->by_brand->hits->hits : '';

        } elseif ($request->has('page') && $request->page == 'comparative') {


            $return = $this->solrClient->wherePid($product_id)
                                       ->where("productVendor", 1)
                                       ->storeFilter()
                                       ->getCompDetail(true);

            if (empty($return->productDetail->hits->hits)) {
                return $this->productDiscontinued($slug);
            }

            $data['product']          = collect($return->productDetail->hits->hits)->first()->_source;
            $data['brand_count']      = isset($return->brand_count) ? $return->brand_count : 0;
            $data['vendors']          = $return->productVendor->hits->hits;
            $data['compare_products'] = isset($return->productCompare) ? $return->productCompare->hits->hits : '';
            $data['compare_filters']  = [];
            $data['deals']            = isset($return->popularProducts) ? $return->popularProducts->hits->hits : [];

            if (isset($return->predecessor) && count($return->predecessor->hits->hits) > 0) {
                $compare     = new CompareController();
                $cproducts[] = $data['product'];
                $cproducts[] = collect($return->predecessor->hits->hits)->first()->_source;

                $data['compare_predecessor'] = $compare->getSpecification($cproducts);
            }

            if (isset($data['compare_products']) && !empty($data['compare_products'])) {

                $facets = $return->productCompare->aggregations;
                $brands = [];

                foreach ($data['compare_products'] as $p) {
                    if (!in_array($p->_source->brand, $brands)) {
                        $brands[] = $p->_source->brand;
                    }
                }

                $facets->brand  = $brands;
                $data['facets'] = $facets;
            }

            $this->getFAQs($data['product'], $data);
        } else {
            return false;
        }


        /* ASYNC API Data using NODEJS END */

        $execution['detail'] = microtime(true) - LARAVEL_START;

        $product = $data['product'];

        if (isset($product->meta)) {
            try {
                $meta                = json_decode($product->meta);
                $urls                = explode(",", $meta->video_url);
                $data['youtube_url'] = $urls[0];

                if (isset($urls[1])) {
                    $data['youtube_url_hindi'] = $urls[1];
                }
            }
            catch (\Exception $e) {
            }
        }

        unset($return);
        if (empty($product)) {
            /***Product Not Found**/
            //404 Page, as the product not found..
            return $this->productDiscontinued($slug);
        }

        if (!$request->has('mobile_page') && !empty($vendor) && $request->page != 'non-comparative') {
            return redirect()->route('product_detail_non', [cs($product->grp), $slug, $product_id, $vendor], 301);
        }

        if ($slug !== cs($product->name)) {
            #if URL name doesn't match to product name

            if (!is_array($product->vendor) && (int)$product->vendor > 0) {
                return redirect(route('product_detail_non', [
                    $product->grp,
                    create_slug($product->name),
                    $product->id,
                    $product->vendor
                ]), 301);
            } else {
                return redirect(route('product_detail_v2', [create_slug($product->name), $product->id]), 301);
            }
        }

        if ($this->hasRedirectTo($product)) {
            return $this->redirectTo($product);
        }

        if (isset($product->group)) {
            $product->grp = $product->group;
        }

        $data['original_product'] = clone $product;
        $this->addAttributesToProductName($product);

        /*### SETTING SEO DESCRIPTIONS ###*/
        if (isComingSoon($product)) {
            $key = 'meta.detail.group.upcoming';
        } elseif (array_key_exists($product->category_id, config('meta.detail'))) {
            $key = 'meta.detail.' . $product->category_id;
        } elseif (array_key_exists(create_slug($product->grp), config('meta.detail.group'))) {
            $key = 'meta.detail.group.' . create_slug($product->grp);
        } else {
            $key = 'meta.detail.' . $product->category_id;
        }

        $data['meta'] = (config($key)) ? $this->getProductMeta($key, $product) : "";

        if (isset($product->seo_title) && !empty($product->seo_title)) {
            $product->seo_title = $this->getCustomMeta($product->seo_title, $product);
        }

        $execution['meta'] = microtime(true) - LARAVEL_START;

        if ($request->has('debug_time')) {
            $execution['url']    = $request->url();
            $execution['fields'] = $request->all();
            $execution['ip']     = env('SERVER_IP', $request->server('SERVER_ADDR'));
            \Log::warning('Detail Page Execution Details::', $execution);
        }

        $expert_data = ExpertReview::whereVendor(0)->whereProId($product_id)->first();

        if (!is_null($expert_data)) {
            $expert_data         = json_decode($expert_data->expert_data);
            $data['expert_data'] = $expert_data->data;
            if (isset($expert_data->social)) {
                $data['expert_profile'] = $expert_data->social;
            }
        }

        if ($product->grp == 'Books') {
            $this->seo->setHeading($product->name . " Book");
        } else {
            $this->seo->setHeading($product->name);
        }

        if (isset($data['meta']) && is_object($data['meta'])) {
            foreach ($data['meta'] as $key => $value) {
                $function = "set" . ucfirst($key);
                $this->seo->{$function}($value);
            }

            if (isset($data['meta']->keyword)) {
                $this->seo->setKeywords($data['meta']->keyword);
            }

            unset($data['meta']);
        }

        $data['news']            = News::getProductNews($product);
        $data['product_reviews'] = ProductReview::whereProductId($product->id)
                                                ->whereStatus(ProductReview::ENABLED)
                                                ->orderBy('created_at', 'desc')
                                                ->limit(5)
                                                ->get();

        $this->seo->setupShortDescription($product);
        $this->processDescription($product, $data);

        if (isset($product->meta) && !empty($product->meta)) {
            try {
                $product->meta = preg_replace('/\r\n/', '', $product->meta);
                $meta          = json_decode($product->meta);
                $meta          = $this->getCustomMeta($meta, $product);

                if (isset($meta->keywords)) {
                    $this->seo->setKeywords($meta->keywords);
                }

                if (isset($meta->meta)) {
                    $this->seo->setContent(html_entity_decode($meta->meta));
                }

                if (isset($meta->h1_content)) {
                    $this->seo->setShortDescription(html_entity_decode($meta->h1_content));
                }

                if (isset($meta->h2_content)) {
                    $this->seo->setExcerpt(html_entity_decode($meta->h2_content));
                }

                unset($meta);
            }
            catch (\Exception $e) {
            }
        }
        $this->setProductMeta($product);
        $data['hasOrder'] = PurchaseOrder::hasOpenOrder();

        if ($request->has('mobile_page') && $request->input('mobile_page') == true) {
            $data['has_mobile_data'] = true;
            return $data;
        }

        if (isComingSoon($product) || Category::hasSetCategory($product)) {
            return view("v3.product.detail.index_upcoming", $data);
        } else {
            return view("v3.product.detail.index_non_ajax", $data);
        }
    }

    protected function setProductMeta($product)
    {
        if (isset($product->detail_meta) && !empty($product->detail_meta)) {
            try {
                $meta = json_decode($product->detail_meta);

                $keys = [
                    'h1'       => 'Heading',
                    'h2'       => 'SubHeading',
                    'below_h1' => 'ShortDescription',
                    'below_h2' => 'Excerpt'
                ];

                foreach ($meta as $key => $value) {
                    if (!empty($value)) {
                        $function = 'set' . $keys[$key];
                        $this->seo->{$function}(html_entity_decode($value));
                    }
                }
            }
            catch (\Exception $e) {

            }
        }

        if (!$this->seo->getSubHeading()) {
            if ($product->grp == "Books") {
                $this->seo->setSubHeading($product->name . " Book Price in India");
            } else {
                $this->seo->setSubHeading($product->name . " Price in India");
            }
        }
    }

    protected function processDescription($p, &$data)
    {
        if (isComparativeProduct($p) && isset($p->description)) {
            if (empty($p->track_stock)) {
                $re = '/{{(.*)}}/m';
                preg_match($re, $p->description, $matches);

                if (isset($matches[0]) && !empty($matches[0])) {
                    $p->description = trim(str_replace($matches[0], '', $p->description));
                    $p->description = preg_replace('/<p[^>]*><\\/p[^>]*>/', '', $p->description);
                }
            } else {
                $p->description = str_replace(['{{', '}}'], '', $p->description);
            }


            if (isset($p->lp_vendor)) {
                $p->description = str_replace('{LP_Vendor}', config('vendor.name.' . $p->lp_vendor), $p->description);
            } else {
                $p->description = str_replace('{LP_Vendor}', 'Multiple Sellers', $p->description);
            }

            $p->description = str_replace('{DATE}', Carbon::now()->format('F, Y'), $p->description);
            $p->description = str_replace('{sale price}', number_format($p->saleprice), $p->description);

            $data['product'] = $p;
        }
    }

    protected function getEncyptProduct($product)
    {
        $prod            = new \stdClass;
        $prod->id        = $pid = $product->id;
        $prod->cat       = $product->category_id;
        $prod->name      = $product->name;
        $prod->image     = getImageNew($product->image_url);
        $prod->mini_spec = (isset($product->mini_spec)) ? $product->mini_spec : '';
        $prod->size      = (isset($product->size)) ? $product->size : '';
        $prod->color     = (isset($product->cvariant)) ? $product->cvariant : '';
        $prod->brand     = (isset($product->brand)) ? $product->brand : '';
        $prod->price     = (isset($product->saleprice)) ? $product->saleprice : '1000';
        $prod->old_price = (isset($product->price)) ? $product->price : 0;
        $prod->meta      = (isset($product->meta)) ? $product->meta : '';

        return $prod;
    }

    private function getValue($object, $key)
    {
        if (!is_object($object)) {
            $object = (object)$object;
        }

        if (isset($object->{$key})) {
            return $object->{$key};
        } else {
            return '';
        }
    }

    public function getFAQs($product, &$data)
    {
        if (is_object($product)) {
            if (isset($product->_source)) {
                $product = $product->_source;
            }

            if (isset($product->category_id)) {
                $faqs      = config("faqs.$product->category_id", []);
                $questions = [];

                foreach ($faqs as $faq) {
                    $r           = new \stdClass();
                    $r->question = $this->processName($faq['question'], $product);

                    if (isset($product->{$faq['data']['field']})) {
                        $value = $product->{$faq['data']['field']};

                        if ($faq['data']['json']) {
                            try {
                                $values = json_decode($value);

                                if (isset($values->{$faq['data']['key']})) {
                                    $value = $values->{$faq['data']['key']};
                                } else {
                                    $value     = "NA";
                                    $r->answer = $faq['answers'][1];
                                }
                            }
                            catch (\Exception $e) {
                                $r->answer = $faq['answers'][0];
                            }
                        }

                        if (!empty($faq['data']['search'])) {
                            if (stripos($value, $faq['data']['search']) !== false) {
                                $r->answer = $faq['answers'][0];
                            } else {
                                continue;
                            }
                        } else {
                            $r->answer = $faq['answers'][0];
                        }

                        if (isset($faq['data']['replace'])) {
                            if (isset($value) && !empty($value) && $value != "NA") {
                                $r->answer = str_replace($faq['data']['replace'], $value, $r->answer);
                            } else {
                                if (isset($faq['answers'][1])) {
                                    $r->answer = $faq['answers'][1];
                                } else {
                                    continue;
                                }
                            }
                        }
                    } else {
                        if (isset($faq['data']['replace'])) {
                            continue;
                        }

                        if (isset($faq['answers'][1]) && !empty($faq['answers'][1])) {
                            $r->answer = $faq['answers'][1];
                        } else {
                            continue;
                        }
                    }
                    $r->answer   = $this->processName($r->answer, $product);
                    $questions[] = $r;
                }
            } else {
                return [];
            }
        } else {
            return [];
        }

        if (!empty($questions)) {
            $data['faqs'] = $questions;
        }

        return true;
    }

    private function processName($key, $value)
    {
        if (is_object($value) && isset($value->name)) {
            $key = preg_replace('/{PRODUCT_NAME}/', $value->name, $key);
        } elseif (is_string($value)) {
            $key = preg_replace('/{PRODUCT_NAME}/', $value, $key);
        }

        return $key;
    }

    public function mobileReview($slug, $pid)
    {
        $product = $this->solrClient->wherePid($pid)->getProduct(true);

        if ($slug !== create_slug($product->product_detail->name)) {
            #if URL name doesn't match to product name
            return redirect(route('mobile_review_page', [create_slug($product->product_detail->name), $pid]), 301);
        }


        $reviews = getMobileReviews($pid, false, false);

        if (is_null($reviews)) {
            return redirect()->route('product_detail_v2', [create_slug($product->product_detail->name), $pid]);
        }

        $data['total_reviews']  = $reviews->total;
        $data['reviews']        = $reviews->reviews;
        $rating                 = (array)$reviews->rating;
        $data['rating']         = (object)$rating;
        $data['rating_average'] = round(array_sum($rating) / count($rating), 2);
        $data['product_name']   = unslug($slug);
        $data['pid']            = $pid;
        $data['product']        = $product->product_detail;
        $data['vendors']        = array_keys((array)$data['reviews']);

        return view('v3.product.detail.mobile_review', $data);
    }

    public function mobileReviewAjax(Request $request, $product_id)
    {
        if (!$request->has('vendor')) {
            return [];
        }

        $data           = (array)getMobileReviews($product_id, false, $request->vendor, $request->page);
        $data['vendor'] = $request->vendor;

        return view('v3.product.detail.mobile_review_ajax', $data);
    }

    public function addProductReview(Request $request, $product_id)
    {
        if ($request->isMethod('POST')) {
            $validator = validator($request->all(), [
                'user_review' => 'required',
                'name'        => 'required',
                'rating'      => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->messages());
            }

            $review             = new ProductReview;
            $review->product_id = $product_id;
            $review->user       = $request->get('name');
            $review->review     = $request->get('user_review');
            $review->rating     = $request->get('rating');
            $review->save();

            return response()->json(['success' => true]);
        }

        return response()->json([]);
    }
}
