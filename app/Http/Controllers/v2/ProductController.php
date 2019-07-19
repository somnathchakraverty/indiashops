<?php namespace indiashopps\Http\Controllers\v2;


use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use indiashopps\Http\Controllers\Controller;
use indiashopps\Models\CustomPage;

class ProductController extends Controller
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Product Detail page for NON-Comaparitive Products
     *
     * @return Response
     */
    public function productDetailNonComp($group, $slug, $product_id, $vendor = 0)
    {
        $execution['start'] = LARAVEL_START;

        if (empty($vendor) || !isset($vendor)) {
            return redirect()->route('product_detail_v2', [$slug, $product_id]);
        }

        if ($group != create_slug($group)) {
            return redirect(route('product_detail_non', [create_slug($group), $slug, $product_id, $vendor]), 301);
        }
        // Checks if the product is BOOK..
        if ($group == "books") {
            $args = "&isBook=true";
        } else {
            $args = "";
        }
        $id = $product_id . "-" . $vendor;
        //SOLR URL for getting product detail
        $url          = composer_url('ext_prod_detail.php?_id=' . $id . $args);
        $data['data'] = json_decode(file_get_contents($url));

        $execution['detail'] = microtime(true) - LARAVEL_START;

        if (empty($data['data']->product_detail)) {
            //404 Page, as the product not found..
            return $this->productDiscontinued($slug);
        }

        $check_group = ( $group == 'books' ) ? 'books' : $data['data']->product_detail->grp;

        if ($slug !== create_slug($data['data']->product_detail->name) || create_slug($group) !== create_slug($check_group)) {
            #if URL name doesn't match to product name
            return redirect(str_replace("/indiashopps", "",
                newUrl($check_group . '/' . create_slug($data['data']->product_detail->name) . config('app.detaiPageSlug') . $product_id . "-" . $vendor)),
                301);
        }

        $product = $data['data']->product_detail;

        if ($this->hasRedirectTo($product)) {
            return $this->redirectTo($product);
        }

        if ($group == "books" && is_object($data['data'])) {
            $data['data']->product_detail->grp = "books";
        }

        if (array_key_exists(create_slug($data['data']->product_detail->grp), config('meta.detail.group'))) {
            $key = 'meta.detail.group.' . create_slug($data['data']->product_detail->grp);
        } else {
            $key = 'meta.detail.' . $data['data']->product_detail->category_id;
        }

        $meta = (config($key)) ? $this->getMeta($key, $data['data']->product_detail) : false;

        $data['meta'] = ($meta) ? $meta : false;

        if (!$data['meta']) {
            $key  = 'meta.detail.cat_name.' . $data['data']->product_detail->parent_category;
            $meta = (config($key)) ? $this->getMeta($key, $data['data']->product_detail) : false;

            $data['meta'] = ($meta) ? $meta : false;

            if (!$data['meta']) {
                $key          = 'meta.detail.non_comp';
                $data['meta'] = (config($key)) ? $this->getMeta($key, $data['data']->product_detail) : "";
            }
        }

        if ($this->request->has('debug_time')) {
            $execution['url']    = $this->request->url();
            $execution['fields'] = $this->request->all();
            $execution['ip']     = env('SERVER_IP', $this->request->server('SERVER_ADDR'));
            \Log::warning('Detail Page Execution Details::', $execution);
        }

        if (isset($data['data']->product_detail->seo_title) && !empty($data['data']->product_detail->seo_title)) {
            $data['data']->product_detail->seo_title = $this->getCustomMeta($data['data']->product_detail->seo_title,
                $data['data']->product_detail);
        }

        if (isset($data['data']->product_detail->meta) && !empty($data['data']->product_detail->meta)) {
            try {
                $meta                               = json_decode($data['data']->product_detail->meta);
                $meta                               = $this->getCustomMeta($meta, $data['data']->product_detail);
                $data['data']->product_detail->meta = json_encode($meta);
                unset($meta);
            }
            catch (\Exception $e) {
            }
        }

        $execution['meta'] = microtime(true) - LARAVEL_START;

        return view('v2.product.detail.non_comp', $data);
    }

    public function productDetailComp($slug, $product_id, $vendor = 0)
    {
        //SOLR URL for getting product detail
        $execution['start'] = LARAVEL_START;

        if (!empty($vendor)) {
            $pid = $product_id . "-" . $vendor;
        } else {
            $pid = $product_id;
        }

        $url          = composer_url('ext_prod_detail.php?_id=' . $pid);
        $data['data'] = json_decode(file_get_contents($url));

        if (!empty($vendor) && !empty($data['data']) && isset($data['data']->product_detail) && !empty($data['data']->product_detail)) {
            $p = $data['data']->product_detail;
            return redirect(route('product_detail_non', [create_slug($p->grp), $slug, $product_id, $vendor]), 301);
        }

        $execution['detail'] = microtime(true) - LARAVEL_START;

        if (empty($data['data']->product_detail)) {
            /***Product Not Found**/
            //404 Page, as the product not found..
            return $this->productDiscontinued($slug);
        }
        if ($slug !== create_slug($data['data']->product_detail->name)) {
            $product = $data['data']->product_detail;
            #if URL name doesn't match to product name

            if (!is_array($product->vendor) && (int)$product->vendor > 0) {
                return redirect(route('product_detail_non',
                    [$product->grp, create_slug($product->name), $product->id, $product->vendor]), 301);
            } else {
                return redirect(route('product_detail_v2', [create_slug($product->name), $product->id]), 301);
            }
        }
        $product = $data['data']->product_detail;

        if ($this->hasRedirectTo($product)) {
            return $this->redirectTo($product);
        }

        if (array_key_exists(create_slug($data['data']->product_detail->grp), config('meta.detail.group'))) {
            $key = 'meta.detail.group.' . create_slug($data['data']->product_detail->grp);
        } else {
            $key = 'meta.detail.' . $data['data']->product_detail->category_id;
        }
        //List of all the VENDORS for the product i.e Flipkart, Amazon, Snapdeal ETC..
        $data['vendors'] = file_get_contents(composer_url('vendor_details.php?id=' . $product_id));
        $data['vendors'] = json_decode($data['vendors']);
        $data['vendors'] = $data['vendors']->return_txt->hits->hits;

        $execution['vendor_get'] = microtime(true) - LARAVEL_START;
        $data['meta']            = (config($key)) ? $this->getMeta($key, $data['data']->product_detail) : "";

        if (isset($data['data']->product_detail->seo_title) && !empty($data['data']->product_detail->seo_title)) {
            $data['data']->product_detail->seo_title = $this->getCustomMeta($data['data']->product_detail->seo_title,
                $data['data']->product_detail);
        }

        if (isset($data['data']->product_detail->meta) && !empty($data['data']->product_detail->meta)) {
            try {
                $data['data']->product_detail->meta = preg_replace('/\r\n/', '', $data['data']->product_detail->meta);
                $meta                               = json_decode($data['data']->product_detail->meta);
                $meta                               = $this->getCustomMeta($meta, $data['data']->product_detail);
                $data['data']->product_detail->meta = json_encode($meta);
                unset($meta);
            }
            catch (\Exception $e) {
            }
        }
        $execution['meta'] = microtime(true) - LARAVEL_START;

        if ($this->request->has('debug_time')) {
            $execution['url']    = $this->request->url();
            $execution['fields'] = $this->request->all();
            $execution['ip']     = env('SERVER_IP', $this->request->server('SERVER_ADDR'));
            \Log::warning('Detail Page Execution Details::', $execution);
        }

        $links  = CustomPage::select(['slug', 'meta_data'])
                            ->whereFeatured(1)
                            ->whereCategoryId($data['data']->product_detail->category_id)
                            ->take(20)
                            ->get()
                            ->toArray();
        $custom = [];
        if (!is_null($links)) {
            foreach ($links as $l) {
                $meta              = json_decode($l['meta_data']);
                $custom[$meta->h1] = url($l['slug'] . '-90001');
                unset($meta, $l);
            }
            $data['custom_links'] = $custom;
        } else {
            $data['custom_links'] = [];
        }

        $view = $this->getCategoryWiseView($data['data']->product_detail->category_id);

        return view($view, $data);
    }

    public function redirectTo($p)
    {
        $parts = explode("-", $p->redirect_to);

        if (isset($parts[1]) && !empty($parts[1]) && is_numeric($parts[1])) {
            return redirect(route('product_detail_non', create_slug($p->grp), create_slug($parts[0]), $parts[1]), 301);
        } else {
            return redirect(route('product_detail_v2', [create_slug($p->redirect_name), $p->redirect_to]), 301);
        }
    }

    public function hasRedirectTo($p)
    {
        if (isset($p->redirect_to) && !empty($p->redirect_to) && isset($p->redirect_name) && !empty($p->redirect_name)) {
            return true;
        } else {
            return false;
        }
    }

    public function productDiscontinued($name)
    {
        $query['name'] = unslug($name);
        $query['size'] = 16;

        $handle_404 = composer_url('handle_404.php?' . http_build_query($query));
        $result     = json_decode(file_get_contents($handle_404));

        $data['products'] = $result->prod->hits->hits;
        $data['name']     = unslug($name);

        return view('v2.product.common.discontinued', $data);
    }

    public function getCategoryWiseView($category)
    {
        switch ($category) {
            case 351:
                $view = 'v2.product.detail.mobile';
                break;
            default:
                if (!isPricelist($category)) {
                    $view = 'v2.product.detail_comp';
                } else {
                    $view = 'v2.product.detail.mobile';
                }

        }

        return $view;
    }

    public function getMeta($string, $product)
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
                '{ID}'
            ];
            $replace = [
                Carbon::now()->format('d-m-Y'),
                Carbon::now()->format('Y'),
                $brand,
                ucwords($product->name),
                '',
                number_format($product->saleprice),
                ucwords($product->category),
                ucwords($product->grp),
                $product->id,
            ];

            foreach ($search as $k => $s) {
                $metas->{$key} = preg_replace('/\((.*?)\)/', '', $metas->{$key});
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
                        $product = \Crypt::decrypt($request->content);
                    }
                    if ($request->has('product')) {
                        $product = \Crypt::decrypt($request->product);
                    }

                    $data['_id']         = $product->id;
                    $data['category_id'] = $product->cat;

                    switch ($section) {
                        case 'by-saleprice':
                            $data['saleprice'] = $product->price;
                            break;

                        case 'by-brand':
                            $data['brand'] = $product->brand;
                            break;

                        case 'by-size':
                            $data['size'] = $product->size;
                            break;

                        case 'by-color':
                            $data['color'] = $product->color;
                            break;

                        case 'by-vendor-one':
                            $data['vendor']  = $product->vendor;
                            $data['name']    = $product->name;
                            $data['section'] = 'by-vendor-one';
                            break;

                        case 'by-vendor-two':
                            $data['vendor']  = $product->vendor;
                            $data['name']    = $product->name;
                            $data['section'] = 'by-vendor-two';
                            break;

                        case 'vendor_coupons':
                            $data['vendor_name'] = strtolower(config('vendor.name.' . $product->vendor));
                            $data['size']        = 6;
                            $data['term']        = json_encode($data);
                            $solr_url            = composer_url('deals.php?query=' . $data['term']);
                            $deals               = file_get_contents($solr_url);
                            $data['products']    = json_decode($deals)->return_txt->hits->hits;
                            $data['name']        = $product->name;

                            return $this->generateNonCompAjaxContent($data, $section);

                            break;

                        default:
                            return response(['Invalid Section'], 403);
                            break;

                    }

                    try {
                        $url = composer_url('prod_suggest.php?' . http_build_query($data));

                        $result = file_get_contents($url);

                        $data['products'] = json_decode($result)->return->hits->hits;

                        $products = $this->generateNonCompAjaxContent($data, $section);

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
            //prod_suggest.php?color=red&category_id=21&_id=42122106-1
        } else {
            return response('', 403);
        }
    }

    public function mobileAjaxContent(Request $request, $section = '')
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

            if ($request->has('content') || $request->has('content')) {
                try {
                    if ($request->has('content')) {
                        $product = \Crypt::decrypt($request->content);
                    }
                    if ($request->has('product')) {
                        $product = \Crypt::decrypt($request->product);
                    }

                    $data['id']          = $product->id;
                    $data['category_id'] = $product->cat;

                    switch ($section) {
                        case 'vendor_coupons':
                            $data['vendor_name'] = strtolower(config('vendor.name.' . $product->vendor));
                            $data['size']        = 6;
                            $data['term']        = json_encode($data);
                            $solr_url            = composer_url('deals.php?query=' . $data['term']);
                            $result              = file_get_contents($solr_url);
                            $data['products']    = json_decode($result)->return_txt->hits->hits;
                            $data['name']        = $product->name;
                            break;

                        case 'add_compare_snippets':

                            $data['saleprice'] = $product->price;
                            //$data['brand']     = $product->brand;
                            $data['name']     = $product->name;
                            $data['similar']  = 1;
                            $data['size']     = 12;
                            $solr_url         = composer_url('compare_products.php?' . http_build_query($data));
                            $result           = file_get_contents($solr_url);
                            $data['products'] = json_decode($result)->result_same_brand->hits->hits;

                            break;

                        case 'add_compare':

                            $data['saleprice'] = $product->price;
                            //$data['brand']     = $product->brand;
                            $data['name']     = $product->name;
                            $data['similar']  = 1;
                            $data['size']     = 12;
                            $solr_url         = composer_url('compare_products.php?' . http_build_query($data));
                            $result           = file_get_contents($solr_url);
                            $data['products'] = json_decode($result)->result_same_brand->hits->hits;

                            break;

                        case 'snippets':

                            $data['saleprice'] = $product->price;
                            $data['brand']     = $product->brand;
                            $data['name']      = $product->name;
                            $data['similar']   = 1;
                            $data['size']      = 12;
                            $solr_url          = composer_url('compare_products.php?' . http_build_query($data));
                            $result            = file_get_contents($solr_url);
                            $data['products']  = json_decode($result)->result_same_brand->hits->hits;

                            break;

                        case 'vs_compare':

                            $data['saleprice'] = $product->price;
                            //$data['brand']     = $product->brand;
                            $data['name']     = $product->name;
                            $data['similar']  = 1;
                            $data['size']     = 12;
                            $solr_url         = composer_url('compare_products.php?' . http_build_query($data));
                            $result           = file_get_contents($solr_url);
                            $data['products'] = json_decode($result)->result_same_brand->hits->hits;
                            $data['image']    = $product->image;
                            break;

                        case 'mobile_reviews':

                            $data['name']       = $product->name;
                            $data['product_id'] = $product->id;
                            $data['reviews']    = getMobileReviews($product->id, true);

                            break;

                        case 'mobile_qa':

                            $data['name']      = $product->name;
                            $data['questions'] = getQnA($product->id);

                            break;

                        default:
                            return response(['Invalid Section'], 403);
                            break;

                    }

                    try {

                        $data = $this->generateAjaxContent($data, $section);

                        return $data;
                    }
                    catch (\Exception $e) {
                        \Log::error($e->getMessage() . "\r\n" . $e->getTraceAsString());

                        return response('Invalid Data', 403);
                    }

                }
                catch (DecryptException $e) {
                    return response('', 403);
                }

            } else {
                return response('', 403);
            }
            //prod_suggest.php?color=red&category_id=21&_id=42122106-1
        } else {
            return redirect(route('home_v2'), 301);
        }
    }

    private function generateAjaxContent($data, $view)
    {
        switch ($view) {
            case "vendor_coupons":
                $view = (string)view("v2.product.detail.common.coupons", $data);
                break;

            case "add_compare_snippets":
                $view                = [];
                $view['add_compare'] = (string)view("v2.product.detail.common.add_compare", $data);
                $view['snippets']    = (string)view("v2.product.detail.common.snippets", $data);
                break;

            case "add_compare":
                $view = (string)view("v2.product.detail.common.add_compare", $data);
                break;

            case "snippets":
                $view = (string)view("v2.product.detail.common.snippets", $data);
                break;

            case "vs_compare":
                $view = (string)view("v2.product.detail.common.vs_compare", $data);
                break;

            case "mobile_reviews":
                $view = (string)view("v2.product.detail.common.reviews", $data);
                break;

            case "mobile_qa":
                $view = (string)view("v2.product.detail.common.qa", $data);
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

    private function generateNonCompAjaxContent($data, $view)
    {
        switch ($view) {
            case "vendor_coupons":
                $view = (string)view("v2.product.detail.common.coupons", $data);
                break;

            case "by-vendor-one":
                $view = (string)view("v2.product.owl.item_big", $data);
                break;

            case "by-vendor-two":
                $view = (string)view("v2.product.owl.item_big", $data);
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

    public function mobileReview($slug, $pid)
    {
        $url     = composer_url('ext_prod_detail.php?_id=' . $pid);
        $product = json_decode(file_get_contents($url));

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

        return view('v2.product.detail.common.mobile_review', $data);
    }

    public function mobileReviewAjax(Request $request, $product_id)
    {
        if (!$request->has('vendor')) {
            return [];
        }

        $data           = (array)getMobileReviews($product_id, false, $request->vendor, $request->page);
        $data['vendor'] = $request->vendor;

        return view('v2.product.detail.common.mobile_review_ajax', $data);
    }
}