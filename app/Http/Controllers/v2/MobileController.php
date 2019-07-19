<?php namespace indiashopps\Http\Controllers\v2;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\MessageBag;
use indiashopps\AndUser;
use indiashopps\Http\Requests;
use indiashopps\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use indiashopps\Models\CustomPage;

class MobileController extends Controller
{

    const MOBILE_ROUTES = [
        'home_v2',
        'product_detail_v2',
        'contact',
        'aboutus_v2',
        'login_v2',
        'register_v2',
        'product_detail_non',
        'category_list',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getPage(Request $request)
    {
        if ($request->has('type') && $request->has('page_section') && $request->type == 'mobile_pages') {
            switch ($request->page_section) {
                case 'home_v2':
                    $response = $this->getHomePageContent($request);
                    break;

                case 'product_detail_v2':
                    $response = $this->getComparativeDetailPage($request);
                    break;

                case 'contact':
                    $response = $this->getContactPage($request);
                    break;

                case 'aboutus_v2':
                    $response = $this->getAboutUsPage($request);
                    break;

                case 'login_v2':
                    $response = $this->getLoginPage($request);
                    break;

                case 'register_v2':
                    $response = $this->getLoginPage($request, true);
                    break;

                case 'product_detail_non':
                    $response = $this->getNonComparativeDetailPage($request);
                    break;

                default :
                    $response = '';
                    break;
            }

            if ($response instanceof RedirectResponse && !empty($response->getTargetUrl())) {
                return view('v2.mobile.ajax.redirect', ['redirect_to' => $response->getTargetUrl()]);
            }

            return $response;
        }
    }

    protected function getHomePageContent()
    {
        $data['home']    = getJSONContent('url.mobile_home_json');
        $data['mslider'] = \DB::table('m_slider')
                              ->whereWhichType('home')
                              ->whereActive(1)
                              ->orderBy('sequence', 'ASC')
                              ->get();
        $data['mslider'] = collect($data['mslider'])->keyBy('slider_for');

        return view('v2.mobile.ajax.index', $data);
    }

    public function hasMobilePage($route = '')
    {
        if (empty($route)) {
            return false;
        }

        if (in_array($route, self::MOBILE_ROUTES)) {
            return true;
        }

        return false;
    }

    public function getComparativeDetailPage($request)
    {
        //SOLR URL for getting product detail

        $pController = new ProductController($request);

        if ($request->has('slug') && $request->has('id')) {
            $slug       = $request->slug;
            $product_id = $request->id;
        } else {
            return '';
        }

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

            if ((int)$product->vendor > 0) {
                return redirect(route('product_detail_non',
                    [$product->grp, create_slug($product->name), $product->id, $product->vendor]), 301);
            } else {
                return redirect(route('product_detail_v2', [create_slug($product->name), $product->id]), 301);
            }
        }
        $product = $data['data']->product_detail;

        if ($pController->hasRedirectTo($product)) {
            return $pController->redirectTo($product);
        }

        $key = 'meta.detail.' . $data['data']->product_detail->category_id;
        //List of all the VENDORS for the product i.e Flipkart, Amazon, Snapdeal ETC..
        $data['vendors'] = file_get_contents(composer_url('vendor_details.php?id=' . $product_id));
        $data['vendors'] = json_decode($data['vendors']);
        $data['vendors'] = $data['vendors']->return_txt->hits->hits;

        $execution['vendor_get'] = microtime(true) - LARAVEL_START;
        $data['meta']            = (config($key)) ? $pController->getMeta($key, $data['data']->product_detail) : "";

        if (isset($data['data']->product_detail->seo_title) && !empty($data['data']->product_detail->seo_title)) {
            $data['data']->product_detail->seo_title = $pController->getCustomMeta($data['data']->product_detail->seo_title,
                $data['data']->product_detail);
        }

        if (isset($data['data']->product_detail->meta) && !empty($data['data']->product_detail->meta)) {
            try {
                $data['data']->product_detail->meta = preg_replace('/\r\n/', '', $data['data']->product_detail->meta);
                $meta                               = json_decode($data['data']->product_detail->meta);
                $meta                               = $pController->getCustomMeta($meta, $data['data']->product_detail);
                $data['data']->product_detail->meta = json_encode($meta);
                unset($meta);
            }
            catch (\Exception $e) {
            }
        }
        $execution['meta'] = microtime(true) - LARAVEL_START;

        if ($request->has('debug_time')) {
            $execution['url']    = $request->url();
            $execution['fields'] = $request->all();
            $execution['ip']     = env('SERVER_IP', $request->server('SERVER_ADDR'));
            \Log::warning('Detail Page Execution Details::', $execution);
        }

        $links          = CustomPage::select(['slug', 'meta_data'])
                                    ->whereFeatured(1)
                                    ->whereCategoryId($data['data']->product_detail->category_id)
                                    ->take(20)
                                    ->get()
                                    ->toArray();
        $data['slider'] = \DB::table('m_slider')
                             ->whereWhichType('comparative')
                             ->whereActive(1)
                             ->orderBy('sequence', 'ASC')
                             ->get();

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

        $response['html']     = (string)view('v2.mobile.ajax.product.comp_detail', $data);
        $response['metadata'] = (string)view('v2.mobile.ajax.product.meta.comp_detail', $data);
        return $response;
    }

    public function getNonComparativeDetailPage($request)
    {
        if ($request->has('slug') && $request->has('id') && $request->has('cat_name')) {
            $slug       = $request->slug;
            $product_id = $request->id;
            $vendor     = $request->vendor;
            $group      = $request->cat_name;
        } else {
            return '';
        }

        $pController = new ProductController($request);

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
            $response['html']     = $this->productDiscontinued($slug);
            $response['metadata'] = (string)view('v2.mobile.ajax.product.meta.discontinued', ['name' => unslug($slug)]);
            return $response;
        }

        if ($slug !== create_slug($data['data']->product_detail->name)) {
            #if URL name doesn't match to product name
            return redirect(str_replace("/indiashopps", "",
                newUrl($group . '/' . create_slug($data['data']->product_detail->name) . config('app.detaiPageSlug') . $product_id . "-" . $vendor)),
                301);
        }

        $product = $data['data']->product_detail;

        if ($pController->hasRedirectTo($product)) {
            return $pController->redirectTo($product);
        }

        if ($group == "books" && is_object($data['data'])) {
            $data['data']->product_detail->grp = "books";
            $data['book']                      = true;
        } else {
            $data['book'] = false;
        }

        $key = 'meta.detail.' . $data['data']->product_detail->category_id;

        $meta = (config($key)) ? $pController->getMeta($key, $data['data']->product_detail) : false;

        $data['meta'] = ($meta) ? $meta : false;

        if (!$data['meta']) {
            $key  = 'meta.detail.cat_name.' . $data['data']->product_detail->parent_category;
            $meta = (config($key)) ? $pController->getMeta($key, $data['data']->product_detail) : false;

            $data['meta'] = ($meta) ? $meta : false;

            if (!$data['meta']) {
                $key          = 'meta.detail.non_comp';
                $data['meta'] = (config($key)) ? $pController->getMeta($key, $data['data']->product_detail) : "";
            }
        }

        if ($request->has('debug_time')) {
            $execution['url']    = $request->url();
            $execution['fields'] = $request->all();
            $execution['ip']     = env('SERVER_IP', $request->server('SERVER_ADDR'));
            \Log::warning('Detail Page Execution Details::', $execution);
        }

        if (isset($data['data']->product_detail->seo_title) && !empty($data['data']->product_detail->seo_title)) {
            $data['data']->product_detail->seo_title = $pController->getCustomMeta($data['data']->product_detail->seo_title,
                $data['data']->product_detail);
        }

        if (isset($data['data']->product_detail->meta) && !empty($data['data']->product_detail->meta)) {
            try {
                $meta                               = json_decode($data['data']->product_detail->meta);
                $meta                               = $pController->getCustomMeta($meta, $data['data']->product_detail);
                $data['data']->product_detail->meta = json_encode($meta);
                unset($meta);
            }
            catch (\Exception $e) {
            }
        }
        $data['slider'] = \DB::table('m_slider')
                             ->whereActive(1)
                             ->whereWhichType('non-comparative')
                             ->orderBy('sequence', 'ASC')
                             ->get();

        $execution['meta'] = microtime(true) - LARAVEL_START;

        return view('v2.mobile.ajax.product.non_comp_detail', $data);
        $response['metadata'] = view('v2.mobile.ajax.product.meta.non_comp_detail', $data);

        return $response;
    }

    public function getContactPage($request)
    {
        if ($request->isMethod('post')) {
            \Mail::send('emails.contact', [
                'name'         => $request->input('name'),
                'email'        => $request->input('email'),
                'user_message' => $request->input('message')
            ], function ($message) {
                $message->from('nitish@manyainternational.com', 'contact');
                $message->to('mitul.mehra@manyainternational.com')->subject('Contact Us - Indiashopps - Mobile');

            });
        }

        return view('v2.mobile.ajax.contact_us');
    }

    public function getAboutUsPage($request)
    {
        return view('v2.mobile.ajax.about_us');
    }

    public function getLoginPage($request, $register = false)
    {
        if ($request->isMethod('post')) {

            if (!$register) {
                $validator = \Validator::make($request->all(), [
                    'email'    => 'required|email',
                    'password' => 'required',
                ]);

                // Validation Failed..
                if ($validator->fails()) {
                    $response['errors'] = $validator->messages();
                } elseif (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')],
                    $request->has('remember'))
                ) {
                    // Valid Login attempt.....
                    $response['success']     = "Login Succesfull, Redirecting..";
                    $response['redirect_to'] = route('home_v2');
                } else {
                    //Invalid Login attempt..
                    $response['errors'] = ['password' => 'Email and/or password invalid.'];
                }

                return $response;
            } else {
                if (Auth::check()) {
                    //Redirect If already Loggedn in, with Success Message...
                    return ["success" => "Already Logged in.. !", 'redirect_to' => route('home_v2')];
                }
                // POST Form Validation
                $validator = \Validator::make($request->all(), [
                    'email'    => 'required|email|unique:and_user',
                    'name'     => 'required',
                    'password' => 'required|min:6',
                    'confirm'  => 'same:password',
                ]);

                if ($validator->fails()) {
                    //If Validation Fails
                    $response['errors'] = $validator->messages();

                    return $response;
                }

                // ELSE create a new User
                $data['email']     = $request->get('email');
                $data['gender']    = '';
                $data['interests'] = '';
                $data['password']  = \Hash::make($request->get('password'));
                $data['name']      = $request->get('name');
                $data['join_date'] = Carbon::now()->toDateTimeString();

                $user = new AndUser($data);
                $user->save();

                //Login the user by Default once user Registers..
                if ($user->id) {
                    Auth::loginUsingId($user->id);

                    return ["success" => "Registration Done Success.!", 'redirect_to' => route('home_v2')];
                }
            }
        }

        $data['route'] = ($request->page_section == 'login_v2') ? 'login' : 'register';

        return view('v2.mobile.ajax.login', $data);
    }

    public function getAjaxContent(Request $request, $section)
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

                        default:
                            return response(['Invalid Section'], 403);
                            break;

                    }

                    try {
                        $url = composer_url('prod_suggest.php?' . http_build_query($data));

                        $result = file_get_contents($url);

                        $data['products'] = json_decode($result)->return->hits->hits;
                        $products         = $this->generateNonCompAjaxContent($data, $section);

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

    public function getMetaData($route = '')
    {
        $data = [];

        if (!empty($route)) {

            switch ($route) {
                case 'home_v2':
                    $data['title']       = "Compare and Buy Online for Mobiles, Books, Shoes, Bags and Electronics - IndiaShopps";
                    $data['description'] = "India's best price comparison shopping platform for mobiles, electronics, laptops, cameras, home décor & more. Find price, model and features online only at Indiashopps.";
                    break;
            }
        }

        return $data;
    }

    private function generateNonCompAjaxContent($data, $view)
    {
        switch ($view) {
            case "by-saleprice":
                $view = (string)view("v2.product.detail.common.coupons", $data);
                break;

            default:
                return view("v2.mobile.ajax.product.brand_products", $data);
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

    public function productDiscontinued($name)
    {
        $query['name'] = unslug($name);
        $query['size'] = 16;

        $handle_404 = composer_url('handle_404.php?' . http_build_query($query));
        $result     = json_decode(file_get_contents($handle_404));

        $data['products'] = $result->prod->hits->hits;

        return (string)view('v2.mobile.ajax.product.discontinued', $data);
    }

    /**
     * @return string
     */
    public function hasNonAjaxContent($route, $request)
    {
        switch ($route) {
            case 'category_list':
                $response = $this->categoryPage($request);
                break;

            default :
                $response = [];
                break;
        }

        if (!empty($response)) {
            return $response;
        }

        return [];
    }

    private function categoryPage(Request $request)
    {
        $cat_name = $request->route()->parameter('category');

        if ($cat_name == 'home') {
            return redirect(url('home-decor'), 301);
        }

        if (substr(trim($cat_name), -1) == '-') {
            return redirect(trim($cat_name, '-'), 301);
        }

        $data['cat_name'] = urldecode($cat_name);
        $cat_data         = \DB::table('gc_cat')
                               ->where(\DB::raw(" create_slug(name) "), "like", $cat_name)
                               ->where('level', 0)
                               ->select('id', 'seo_title', 'meta')
                               ->first();
        if (!empty($cat_data->seo_title)) {
            $data['title'] = $cat_data->seo_title;
        }
        if (!empty($cat_data->meta)) {
            $data['meta'] = json_decode($cat_data->meta);
        }

        if (empty($cat_data)) {
            return abort(404);
        }

        $data['categories'] = \DB::table('gc_cat')->where('parent_id', $cat_data->id)->where('active', 1)->get();
        $data['c_name']     = $data['cat_name'];

        if (isset($cat_data->id)) {
            $list_desc = \DB::table('gc_cat')
                            ->where('id', $cat_data->id)
                            ->select(['meta', 'seo_title', 'description'])
                            ->first();

            if (!empty($list_desc->meta)) {
                $data['list_desc'] = json_decode($list_desc->meta);
            }

            if (isset($data['list_desc']->description) && !empty($data['list_desc']->description)) {
                $data['description'] = $data['list_desc']->description;
            }
            if (!empty($list_desc->seo_title)) {
                $data['title'] = $list_desc->seo_title;
            }

        }

        foreach ($data['categories'] as $key => $val) {
            $data['categories'][$key]->children = \DB::table('gc_cat')
                                                     ->where('parent_id', $val->id)
                                                     ->where('active', 1)
                                                     ->get();
        }

        if (empty($data['categories'])) {
            \Log::error("Error: Empty Categories");

            return abort(404);
        }

        if (file_exists('json/category_brands.json')) {
            $data['cat_brands'] = json_decode(file_get_contents('json/category_brands.json'));
        }

        $data['slider'] = \DB::table('slider')
                             ->where('refer_id', $cat_data->id)
                             ->select('image_url', 'refer_url', 'alt')
                             ->get();
        if (view()->exists("v2.mobile.category.$cat_name")) {
            $response['page_content'] = (string)view("v2.mobile.category.$cat_name", $data);
        } else {
            $response['page_content'] = (string)view('v2.mobile.category', $data);
        }

        return $response;
    }
}
