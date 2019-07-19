<?php namespace indiashopps\Http\Controllers\v2;


use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use indiashopps\Http\Controllers\Controller;

class CouponController extends Controller
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Display a listing of the Coupons.
     *
     * @return Response
     */
    public function index()
    {
        $data['type']  = "Coupon";
        $data['term']  = json_encode($data);
        $searchAPI     = composer_url('deals.php');
        $result        = file_get_contents($searchAPI . '?query=' . urlencode($data['term']));
        $data1['type'] = "Promotion";
        $data1['term'] = json_encode($data1);
        $result1       = file_get_contents($searchAPI . '?query=' . urlencode($data1['term']));

        if (empty($result1) || empty($result)) {
            echo "Server Down";
            exit;
            abort(404);
        }

        $result                 = json_decode($result)->return_txt;
        $result1                = json_decode($result1)->return_txt;
        $data['top_categories'] = DB::table('and_deals_cat')
                                    ->select("name", "image_url", "icon_class")
                                    ->where('show_list', 1)
                                    ->get();

        $data['product']  = $result->hits->hits;
        $data['product1'] = $result1->hits->hits;

        shuffle($result1->hits->hits);

        $data['recent'] = $result1->hits->hits;

        shuffle($result1->hits->hits);

        $data['most']      = $result1->hits->hits;
        $facets            = $result->aggregations;
        $facet['left_cat'] = $facets->category->buckets;
        $data['facet']     = $facet;

        if ($this->request->has('code') && $this->request->code) {
            $data['show_code'] = true;
        }

        $filter['saleprice_max'] = 15000;
        $filter['saleprice_min'] = 0;
        $filter['category_id']   = 351;
        $filter['session_id']    = 121212;
        $filter['size']          = 5;

        $searchAPI        = composer_url('search.php');
        $result           = file_get_contents($searchAPI . '?query=' . urlencode(json_encode($filter)));
        $result           = json_decode($result);
        $data['products'] = $result->return_txt->hits->hits;

        $data['meta'] = (config('coupons_meta.home')) ? $this->getMeta('coupons_meta.home') : "";

        return view('v2.coupons.home', $data);
    }

    public function getMeta($string)
    {
        $metas = (object)config($string);

        foreach ($metas as $key => $meta) {
            $search        = ['{DATE}', '{YEAR}'];
            $replace       = [
                Carbon::now()->format('d-m-Y'),
                Carbon::now()->format('Y')
            ];
            $metas->{$key} = str_replace($search, $replace, $meta);
        }

        return $metas;
    }

    public function category($category, $page = 0)
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

        if (!empty($this->request->input('type')) && $this->request->input('type') != "all") {
            $data['type'] = urldecode($this->request->input('type'));
        }

        if (!empty($this->request->input('vendor_name'))) {
            $vendor_name = str_replace("-", " ", $this->request->input('vendor_name'));

            if (is_array($vendor_name)) {
                $data['vendor_name'] = implode(",", $vendor_name);
            } else {
                $data['vendor_name'] = $vendor_name;
            }
        }

        $token      = $this->request->session()->get('_token');
        $session_id = preg_replace("/[^0-9,.]/", '', $token);

        if (!empty($session_id) && is_numeric($session_id)) {
            $data['session_id'] = $session_id;
        }

        if (!empty($category)) {
            //$data['category'] = \helper::decode_url( $category );

            $category = \DB::table('and_deals_cat')
                           ->select(['name', 'meta', 'seo_title'])
                           ->where(DB::raw('create_slug(name)'), '=', $category)
                           ->first();

            $data['category'] = $category->name;
        }

        $data['rows'] = 30;
        $data['page'] = $page;
        $data['from'] = ($data['page'] * $data['rows']);
        $data['term'] = json_encode($data);
        $searchAPI    = composer_url('deals.php');
        $result       = file_get_contents($searchAPI . '?query=' . urlencode($data['term']));

        if (!empty($category)) {
            $category = \DB::table('and_deals_cat')
                           ->select(['name', 'meta', 'seo_title'])
                           ->where(DB::raw('create_slug(name)'), '=', $category)
                           ->first();

            $data['category'] = $category->name;

            if (isset($category->meta) && !empty($category->meta)) {
                try {
                    $data['list_desc'] = json_decode($category->meta);
                }
                catch (\Exception $e) {
                }
            }
        }
        // Category Meta Description..
        $meta = @file_get_contents("cat_meta.json");
        if ($meta) {
            $meta = json_decode($meta);
            if (isset($meta->{$data['category']})) {
                $data['catmeta'] = $meta->{$data['category']};
            } else {
                $data['catmeta'] = "";
            }
        } else {
            $data['catmeta'] = "";
        }

        if (empty($result)) {
            abort(404);
        }

        if ($this->request->has('code') && $this->request->code) {
            $data['show_code'] = true;
        }

        $result = json_decode($result)->return_txt;

        $data['top_categories'] = DB::table('and_deals_cat')
                                    ->select("name", "image_url", "icon_class")
                                    ->where('show_list', 1)
                                    ->get();

        $data['product']       = $result->hits->hits;
        $data['product_count'] = $result->hits->total;
        $facets                = $result->aggregations;
        // $facet['left']['cats']	= $facets->category->buckets;
        $facet['left']['vendors'] = $facets->vendor_name->buckets;
        $data['facet']            = $facet;
        $data['ajax']             = $this->request->input('ajax');
        $data['title']            = $cat->name;
        $data['type']             = "category";

        if (isset($category->seo_title) && !empty($category->seo_title)) {
            $data['title'] = $category->seo_title;
        }

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
            return view('v2.coupons.list', $data);
        }
    }

    public function vendor($vendor, $page = 0)
    {
        $data['show'] = true;

        if (empty($vendor)) {
            return redirect()->route('coupons_v2');
        } else {
            if ($vendor == 'dominos') {
                $data['vendor_name'] = "domino's pizza";
            } else {
                $data['vendor_name'] = strtolower(unslug($vendor));
            }
        }

        if ($this->request->has('show')) {
            $data['show'] = false;
        }

        if (!empty($this->request->input('type')) && $this->request->input('type') != "all") {
            $data['type'] = urldecode($this->request->input('type'));
        }

        if ($this->request->has('category')) {
            $data['category'] = \helper::decode_url($this->request->category);
        }

        $token      = $this->request->session()->get('_token');
        $session_id = preg_replace("/[^0-9,.]/", '', $token);

        if (!empty($session_id) && is_numeric($session_id)) {
            $data['session_id'] = $session_id;
        }

        $data['rows'] = 30;
        $data['page'] = $page;
        $data['from'] = ($data['page'] * $data['rows']);
        $data['term'] = json_encode($data);

        $searchAPI = composer_url('deals.php');
        $result    = file_get_contents($searchAPI . '?query=' . urlencode($data['term']));

        $data['top_categories'] = DB::table('and_deals_cat')
                                    ->select("name", "image_url", "icon_class")
                                    ->where('show_list', 1)
                                    ->get();

        // Category Meta Description..
        $meta = @file_get_contents("cat_meta.json");
        if ($meta) {
            $meta = json_decode($meta);
            if (isset($meta->{$data['vendor_name']})) {
                $data['catmeta'] = $meta->{$data['vendor_name']};
            } else {
                $data['catmeta'] = "";
            }
        } else {
            $data['catmeta'] = "";
        }

        if (empty($result)) {
            abort(404);
        }

        if (!empty($vendor)) {
            //$data['category'] = \helper::decode_url( $category );

            $vendor_meta = \DB::table('deals_meta')
                              ->select(['meta_data', 'description'])
                              ->where('vendor_name', '=', $vendor)
                              ->first();

            if (isset($vendor_meta->meta_data) && !empty($vendor_meta->meta_data)) {
                try {
                    $meta                    = json_decode($vendor_meta->meta_data);
                    $data['list_desc']       = $meta;
                    $data['seo_title']       = $meta->title;
                    $data['list_desc']->text = ($vendor_meta->description) ? $vendor_meta->description : '';
                }
                catch (\Exception $e) {
                }
            }
        }
        //dd($data);
        if ($this->request->has('code') && $this->request->code) {
            $data['show_code'] = true;
        }

        $result = json_decode($result)->return_txt;

        $data['product']       = $result->hits->hits;
        $data['product_count'] = $result->hits->total;
        $facets                = $result->aggregations;
        // $facet['left']['cats']	= $facets->category->buckets;
        $facet['left']['category'] = $facets->category->buckets;
        $data['facet']             = $facet;
        $data['ajax']              = $this->request->input('ajax');
        $data['title']             = (isset($data['seo_title'])) ? $data['seo_title'] : unslug($vendor);
        $data['type']              = "vendor";

        $data['meta'] = (config('coupons_meta.' . strtolower($vendor))) ? $this->getMeta('coupons_meta.' . strtolower($vendor)) : "";

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
            return view('v2.coupons.list', $data);
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
            $data['type'] = urldecode($this->request->input('type'));
        }

        if (!empty($this->request->input('cat_id')) && $this->request->input('cat_id') != "") {
            $data['cat_id'] = urldecode($this->request->input('cat_id'));
        }

        if ($this->request->has('category')) {
            $data['category'] = \helper::decode_url($this->request->category);
        }

        $token      = $this->request->session()->get('_token');
        $session_id = preg_replace("/[^0-9,.]/", '', $token);

        if (!empty($session_id) && is_numeric($session_id)) {
            $data['session_id'] = $session_id;
        }

        $data['rows'] = 30;
        $data['page'] = $page;
        $data['from'] = ($data['page'] * $data['rows']);
        $data['term'] = json_encode($data);

        $searchAPI = composer_url('deals.php');
        $result    = file_get_contents($searchAPI . '?query=' . urlencode($data['term']));

        $data['top_categories'] = DB::table('and_deals_cat')
                                    ->select("name", "image_url", "icon_class")
                                    ->where('show_list', 1)
                                    ->get();

        if (empty($result)) {
            abort(404);
        }

        if ($this->request->has('code') && $this->request->code) {
            $data['show_code'] = true;
        }

        $result = json_decode($result)->return_txt;

        $data['product']       = $result->hits->hits;
        $data['product_count'] = $result->hits->total;
        $facets                = $result->aggregations;
        // $facet['left']['cats']	= $facets->category->buckets;
        $facet['left']['category'] = $facets->category->buckets;
        $data['facet']             = $facet;
        $data['ajax']              = $this->request->input('ajax');
        $data['title']             = "Search";
        $data['type']              = "vendor";

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
            return view('v2.coupons.list', $data);
        }
    }
}
