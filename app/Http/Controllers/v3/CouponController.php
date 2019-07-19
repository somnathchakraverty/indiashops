<?php

namespace indiashopps\Http\Controllers\v3;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CouponController extends BaseController
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct();
    }

    /**
     * Display a listing of the Coupons.
     *
     * @return Response
     */
    public function index()
    {
        $coupon_home_id = 829;

        $data['sliders'] = Cache::remember('coupon_home_slider', 360, function () use ($coupon_home_id) {
            return \DB::table('home_slider')->whereCatId($coupon_home_id)->whereFor(0)->get();
        });

        $data['categories']    = storageJson('JSON/coupons_home.json');
        $data['coupons']       = storageJson("JSON/deals.json", 'coupons');
        $data['partner_deals'] = storageJson("JSON/deals.json", 'deals');
        $data['category']      = 'recharge';
        $data['meta']          = (config('coupons_meta.home')) ? $this->getMeta('coupons_meta.home') : "";

        $this->seo->setMetaData($data['meta']);

        return $this->renderView($this->request, 'v3.coupons.index', $data);
    }

    public function category($category, $page = 1)
    {
        $data['show'] = true;

        if (empty($category)) {
            return redirect()->route('coupons_v2');
        } else {
            $cat = \DB::table('and_deals_cat')
                      ->select(['id', 'name'])
                      ->where(DB::raw(" create_slug(name) "), $category)
                      ->first();

            if (is_null($cat)) {
                abort(404);
            } else {
                $data['cat_id'] = $cat->id;
            }
        }

        if ($this->request->has('show')) {
            $data['show'] = false;
        }

        $this->addFilters();

        $token      = $this->request->session()->get('_token');
        $session_id = preg_replace("/[^0-9,.]/", '', $token);

        if (!empty($session_id) && is_numeric($session_id)) {
            $data['session_id'] = $session_id;
        }

        if (!empty($category)) {
            //$data['category'] = \helper::decode_url( $category );

            $category = \DB::table('and_deals_cat')
                           ->select(['name', 'meta', 'seo_title', 'id'])
                           ->where(DB::raw('create_slug(name)'), '=', $category)
                           ->first();

            $data['category'] = $category->name;
            $this->solrClient->whereCatId($category->id);

            if (!is_null($category->meta)) {
                $meta_data = (array)json_decode($category->meta);
                $find      = [
                    'title'             => 'title',
                    'description'       => 'description',
                    'keywords'          => 'keywords',
                    'text'              => 'content',
                    'h1'                => 'heading',
                    'short_description' => 'shortDescription'
                ];

                foreach ($find as $k => $key) {
                    if (isset($meta_data[$k])) {
                        $function = "set" . ucwords($key);
                        $this->seo->{$function}($meta_data[$k]);
                    }
                }
            }
        }

        if ($this->request->has('page') && $this->request->page > 1) {
            $this->solrClient->skip($this->request->page - 1);
            $data['page'] = $this->request->page;
        }
        $return = $this->solrClient->getCoupons(true);
        $result = $return->return_txt;

        if (empty($result)) {
            abort(404);
        }

        if ($this->request->has('code') && $this->request->code) {
            $data['show_code'] = true;
        }

        $data['top_categories'] = DB::table('and_deals_cat')
                                    ->select("name", "image_url", "icon_class")
                                    ->where('show_list', 1)
                                    ->get();

        $data['coupons']       = $result->hits->hits;
        $data['product_count'] = $result->hits->total;
        $facets                = $result->aggregations;
        $data['facets']        = (isset($facets->filters_all)) ? $facets->filters_all : $facets;
        $data['ajax']          = $this->request->input('ajax');
        $data['title']         = $cat->name;
        $data['type']          = "category";

        $this->snippetCoupons($data);

        if (isset($result->filter_applied)) {
            $facets->filter_applied = $result->filter_applied;
        }

        if (isset($category->seo_title) && !empty($category->seo_title)) {
            $this->seo->setTitle($category->seo_title);
        }
        
        //Ajax filter and json response..
        if ($this->request->input('ajax') == "true") {

            if (!isset($facets->filters_all)) {
                $facets->filters_all = clone $facets;
            }

            if (isset($return->filter_applied)) {
                $facets->filter_applied = $return->filter_applied;
            }


            $json['products'] = view('v3.coupons.listing_card', $data)->render();
            $json['products'] = preg_replace('/(\v)+/', '', $json['products']);
            $json['products'] = str_replace("\t", "", $json['products']);
            $json['total']    = $data['product_count'];
            $json['facet']    = $facets;

            echo json_encode($json);
            exit;
        } else {
            $data['sliders'] = \DB::table('home_slider')->whereCouponId($data['cat_id'])->whereFor(0)->get();

            return $this->renderView($this->request, 'v3.coupons.category', $data);
        }
    }

    public function vendor($vendor, $page = 1)
    {
        $data['show'] = true;

        if (empty($vendor)) {
            return redirect()->route('coupons_v2');
        } else {
            $data['vendor_name'] = strtolower(unslug($vendor));
        }

        $this->solrClient->whereVendorName($data['vendor_name']);

        if ($this->request->has('show')) {
            $data['show'] = false;
        }

        if ($this->request->has('category')) {
            $data['category'] = \helper::decode_url($this->request->category);
        }

        $token      = $this->request->session()->get('_token');
        $session_id = preg_replace("/[^0-9,.]/", '', $token);

        if (!empty($session_id) && is_numeric($session_id)) {
            $data['session_id'] = $session_id;
        }

        $this->addFilters();

        if ($this->request->has('page') && $this->request->page > 1) {
            $this->solrClient->skip($this->request->page - 1);
            $data['page'] = $this->request->page;
        }

        $return = $this->solrClient->getCoupons(true);
        $result = $return->return_txt;

        if (empty($result)) {
            abort(404);
        }

        /*DISABLED TEMPORARLY IN ORDER TO APPLY FORMULA BASED MATADATA*/
       // if (false) {
        $metaFlag=1;
        if (!empty($vendor)) {

            $vendor_meta = \DB::table('deals_meta')
                              ->select(['meta_data', 'description'])
                              ->where('vendor_name', '=', $vendor)
                              ->first();

            if (isset($vendor_meta->meta_data) && !empty($vendor_meta->meta_data)) {
                try {
                    $meta              = json_decode($vendor_meta->meta_data);
                    $data['list_desc'] = $meta;
                    $this->seo->setTitle(preg_replace('/{DATE}/', Carbon::now()->format('F, Y'), $meta->title));
                    $this->seo->setDescription(($meta->description) ? $meta->description : '');
                    $this->seo->setKeyword(($meta->keywords) ? $meta->keywords : '');
                    $this->seo->setHeading(($meta->h1) ? $meta->h1 : '');
                    $data['description'] =$vendor_meta->description;
                    $metaFlag=0;
                }
                catch (\Exception $e) {
                }
            }
        }

        if ($this->request->has('code') && $this->request->code) {
            $data['show_code'] = true;
        }

        $facets                = $result->aggregations;
        $data['coupons']       = $result->hits->hits;
        $data['product_count'] = $result->hits->total;
        $data['facets']        = $facets;
        $data['facets']        = (isset($facets->filters_all)) ? $facets->filters_all : $facets;
        $data['ajax']          = $this->request->input('ajax');

        $this->snippetCoupons($data);

        //Ajax filter and json response..
        if ($this->request->input('ajax') == "true") {

            if (!isset($facets->filters_all)) {
                $facets->filters_all = clone $facets;
            }

            if (isset($return->filter_applied)) {
                $facets->filter_applied = $return->filter_applied;
            }

            $json['products'] = view('v3.coupons.listing_card', $data)->render();
            $json['products'] = preg_replace('/(\v)+/', '', $json['products']);
            $json['products'] = str_replace("\t", "", $json['products']);
            $json['total']    = $data['product_count'];
            $json['facet']    = $facets;

            echo json_encode($json);
            exit;
        } else {
            if($metaFlag==1) {
                $meta_data = (config('coupons_meta.vendors')) ? $this->getMeta('coupons_meta.vendors') : "";

                if (!is_null($meta_data)) {
                    $find = [
                        'title' => 'title',
                        'description' => 'description',
                        'keyword' => 'keywords',
                        'text' => 'content'
                    ];

                    foreach ($find as $k => $key) {
                        if (isset($meta_data[$k])) {
                            $meta_data[$k] = preg_replace('/{DATE}/', Carbon::now()->format('F, Y'), $meta_data[$k]);
                            $meta_data[$k] = preg_replace('/{VENDOR}/', ucwords($vendor), $meta_data[$k]);
                            $function = "set" . ucwords($key);
                            $this->seo->{$function}($meta_data[$k]);
                        }
                    }
                }
            }

            $data['sliders'] = \DB::table('home_slider')->whereCatId(829)->whereBrands($vendor)->whereFor(0)->get();

            return $this->renderView($this->request, 'v3.coupons.vendor', $data);
        }
    }

    public function snippetCoupons(&$data)
    {
        $data['snippets'] = collect($data['coupons'])->filter(function ($coupon) {
            return $coupon->_source->type == 'coupon';
        })->take(10);

        if ($data['snippets']->isEmpty()) {
            $data['snippets']  = collect($data['coupons'])->take(10);
            $data['has_codes'] = false;
        } else {
            $data['has_codes'] = true;
        }
    }

    public function addFilters()
    {
        if (request()->has('ajax') && request()->has('filter')) {
            $fields = request()->except(['ajax', 'filter']);

            foreach ($fields as $field => $value) {
                $this->solrClient->where($field, $value);
            }
        }
    }

    /**
     * Coupon Listing page By Search String.... .
     *
     * @var \Illuminate\Http\Request
     * @var Page number..
     * @return Response
     */
    public function search(Request $request, $page = 0, $order_by = "id", $sort_order = "desc")
    {

        $data['show']  = true;
        $data['query'] = urldecode($request->input('search_text'));
        $data['type']  = urldecode($request->input('type'));

        if (!$request->has('search_text') && !$request->has('cat_id')) {
            return redirect()->route('coupons_v2');
        }

        if ($this->request->has('show')) {
            $data['show'] = false;
        }

        if (!empty($this->request->input('type')) && $this->request->input('type') != "") {
            $this->solrClient->whereType(urldecode($this->request->input('type')));
        }

        if (!empty($this->request->input('cat_id')) && $this->request->input('cat_id') != "") {
            $this->solrClient->whereCatId(urldecode($this->request->input('cat_id')));
        }

        if ($this->request->has('category')) {
            $data['category'] = \helper::decode_url($this->request->category);
        }

        $token      = $this->request->session()->get('_token');
        $session_id = preg_replace("/[^0-9,.]/", '', $token);

        if (!empty($session_id) && is_numeric($session_id)) {
            $data['session_id'] = $session_id;
        }

        if ($page > 0) {
            $this->solrClient->skip($page);
        }

        $result = $this->solrClient->whereSearchText($request->search_text)->getCoupons(true);
        $result = $result->return_txt;

        $data['top_categories'] = DB::table('and_deals_cat')
                                    ->select("name", "image_url", "icon_class")
                                    ->where('show_list', 1)
                                    ->get();

        if (empty($result)) {
            abort(404);
        }

        $data['coupons']       = $result->hits->hits;
        $data['product_count'] = $result->hits->total;
        $facets                = $result->aggregations;
        $data['facets']        = $facets;
        $data['ajax']          = $this->request->input('ajax');
        $data['vendor_name']   = $request->search_text;


        //Ajax filter and json response..
        if ($this->request->input('ajax') == "true") {
            $json['coupons'] = (string)view('v2.coupons.list', $data);
            $json['coupons'] = preg_replace('/(\v)+/', '', $json['coupons']);
            $json['coupons'] = str_replace("\t", "", $json['coupons']);
            $json['total']   = $data['product_count'];
            $json['facet']   = $facets->category->buckets;
            $json['vendors'] = $facets->vendor_name->buckets;
            echo json_encode($json);
            exit;
        } else {
            return $this->renderView($this->request, 'v3.coupons.search', $data);
        }
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

            try {

                if ($request->has('content')) {
                    $content = json_decode($request->get('content'));

                    switch ($section) {
                        case 'vendor_coupons':
                            $this->solrClient->whereVendorName($content->vendor)->whereType($content->type);

                            $result          = $this->solrClient->getCoupons();
                            $data['coupons'] = $result['data'];

                            return view('v3.coupons.card', $data);

                            break;

                        case 'recent_offers':

                            $result          = $this->solrClient->getCoupons();
                            $data['coupons'] = $result['data'];

                            return view('v3.coupons.offers', $data);

                            break;

                        default:

                            if (isset($content) && !empty($content)) {
                                $result = $this->solrClient->whereCategory($content->category)->getCoupons();

                                $data['coupons'] = $result['data'];

                                return view('v3.coupons.card2', $data);
                            }

                            return response(['Invalid Section'], 403);
                            break;

                    }
                } else {
                    switch ($section) {
                        case 'recent_offers':

                            $result          = $this->solrClient->getCoupons();
                            $data['coupons'] = $result['data'];

                            return view('v3.coupons.offers', $data);

                            break;

                        default:
                            return response(['Invalid Section'], 403);
                            break;

                    }
                }

            }
            catch (DecryptException $e) {
                return response('', 403);
            }
        } else {
            return response('', 403);
        }
    }

    public function couponRedirect($offerid)
    {
        $coupon = $this->solrClient->whereOfferid($offerid)->getCoupon(true);

        if (count($coupon->return_txt->hits->hits) > 0) {
            $data['coupon'] = collect($coupon->return_txt->hits->hits)->first();

            $this->seo->setTitle("Indiashopps - Redirect to " . $data['coupon']->_source->vendor_name . " ...");

            return view("v3.coupons.redirect", $data);
        } else {
            return redirect('coupon_v2');
        }
    }
}
