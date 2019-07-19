<?php

namespace indiashopps\Http\Controllers\v3;

use Carbon\Carbon;
use DaveJamesMiller\Breadcrumbs\Exceptions\InvalidBreadcrumbException;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\MessageBag;
use Illuminate\View\View;
use indiashopps\AndUser;
use indiashopps\Category;
use indiashopps\Console\Commands\HeaderJson;
use indiashopps\Console\Commands\HomeJsonCommand;
use indiashopps\Events\CompanyCreated;
use indiashopps\Helpers\Helper;
use indiashopps\Http\Requests;
use Auth;
use Illuminate\Http\Request;
use indiashopps\Models\CustomPage;
use indiashopps\Models\LandingWidget;
use indiashopps\Support\SEO\SeoData;
use indiashopps\User;

class MobileController extends BaseController
{

    const MOBILE_ROUTES = [
        'home_v2',
        'product_detail_v2',
        'product_detail_non',
        'contact',
        'aboutus_v2',
        'career',
        'login_v2',
        'logout',
        'myaccount',
        'register_v2',
        'category_list',
        'product_list',
        'sub_category',
        'dual_sim',
        'android_phones',
        'windows_phones',
        'bestphones',
        'brand_category_list_comp_1',
        'brand_category_list',
        'brands.listing',
        'custom_page_list_v3',
        'upcoming_mobiles',
        'search_new',
        'all-cat',
        'category_page_v2',
        'coupons_v2',
        'vendor_page_v2',
        'coupon_search',
        'product_detail_non_book',
        'compare-mobiles',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getPage(Request $request)
    {
        if ($request->has('page_type') && $request->has('page_section') && $request->page_type == 'mobile_pages') {
            switch ($request->page_section) {
                case 'home_v2':
                    $response = $this->getHomePageContent($request);
                    break;

                case 'product_detail_v2':
                case 'product_detail_non':
                case 'product_detail_non_book':

                    if (env('ENABLE_AJAX_DETAIL_PAGES', true) === false) {
                        $response = redirect()->route('home_v2', [], 301);
                    } else {
                        $response = $this->getDetailPage($request);
                    }

                    break;

                case 'dual_sim':
                    $response = $this->dual_sim($request);
                    break;

                case 'android_phones':
                    $response = $this->android_phones($request);
                    break;

                case 'windows_phones':
                    $response = $this->windows_phones($request);
                    break;

                case 'bestphones':
                    $response = $this->bestPhones($request);
                    break;

                case 'brand_category_list_comp_1':
                    $response = $this->brandCategoryListComp($request);
                    break;

                case 'brand_category_list':
                    $response = $this->brandCategoryList($request);
                    break;

                case 'brands.listing':
                    $response = $this->categoryBrandList($request);
                    break;

                case 'custom_page_list_v3':
                    $response = $this->customPageListingV3($request);
                    break;

                case 'upcoming_mobiles':
                    $response = $this->upcomingMobiles($request);
                    break;

                case 'search_new':
                    $response = $this->searchList($request);
                    break;

                case 'sub_category':
                case 'product_list':
                    $response = $this->productList($request);
                    break;

                default :
                    $response = '';
                    break;
            }

            if ($response instanceof RedirectResponse && !empty($response->getTargetUrl())) {
                if (env('ENABLE_AJAX_DETAIL_PAGES', true) === false) {
                    return $response;
                } else {
                    return view('v2.mobile.ajax.redirect', ['redirect_to' => $response->getTargetUrl()]);
                }
            }

            if (!empty($response) && app('seo') instanceof SeoData && !($response instanceof View)) {
                $data['page']               = (isset($response['page'])) ? $response['page'] : 1;
                $response['footer_content'] = app('seo')->getContent();
                $response['metadata']       = (string)view('v3.mobile.ajax.metas', $data);
            }

            return $response;
        }
    }

    protected function getHomePageContent()
    {
        $this->seo->setContent(view('v2.footer.description'));

        $data['home'] = '';

        $data['mslider'] = Cache::remember("mobile_home_banners", 3600, function () use ($data) {
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

        $data['home_content'] = HomeJsonCommand::homePageContent();
        $groups               = storageJson("JSON/group_deals.json");
        $data['groups']       = collect($groups)->keys();
        $data['msliders']     = collect($data['mslider']);
        $data['view_file']    = 'v3.mobile.ajax.index';

        return $data;
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

    public function getDetailPage(Request $request)
    {
        /*This function only changes the VIEW file, the actual code is Under v3\ProductController */

        $r           = &$request;
        $params      = $r->route()->parametersWithoutNulls();
        $pController = new ProductController($r);

        $r->request->add(['mobile_page' => true, 'amp_page' => true]);
        $r->request->add(collect($params)->all());

        if ($request->route()->getName() == 'product_detail_v2') {
            $r->request->add(['page' => 'comparative']);
            $response['page_type'] = 'comparative';
        } elseif ($request->route()->getName() == 'product_detail_non') {
            $r->request->add(['page' => 'non-comparative']);
            $response['page_type'] = 'non-comparative';
        } elseif ($r->route()->getName() == 'product_detail_non_book') {
            $r->request->add(['page' => 'non-comparative', 'group' => 'books']);
            $response['page_type'] = 'non-comparative';
        }

        $response = $pController->productDetail($r, $r->slug, $r->id, $r->vendor);

        if ($response instanceof RedirectResponse) {
            return $response;
        }

        if ($response instanceof View) {
            $data = $response->getData();

            if ($response->getName()) {
                return view("v3.mobile.product.discontinued", $data);
            }
        }

        if ($request->route()->getName() == 'product_detail_v2') {
            $response['page_type'] = 'comparative';
        } else {
            $response['page_type'] = 'non-comparative';
        }

        if (isset($response['data'])) {
            $product     = $response['product'];
            $brand_count = $response['brand_count'];

            Breadcrumbs::setCurrentRoute('p_detail', $product, $brand_count);
        }

        if (env("ENABLE_AJAX_DETAIL_PAGES", true) === true) {
            /*Returns false for AJAX based detail page..*/
            $response['html'] = (string)view('v3.mobile.product.index_non_ajax', $response);
        } else {
            $response['view_file'] = 'v3.mobile.product.index_non_ajax';
        }

        if (isset($response['product'])) {
            $product = $response['product'];

            if (isComingSoon($product) || Category::hasSetCategory($response['product'])) {
                $response['view_file'] = 'v3.mobile.product.index_upcoming';
            }
        }
        return $response;
    }

    public function getContactPage($request)
    {
        $data = [];

        if ($request->isMethod('post')) {

            $message = ['g-recaptcha-response.required' => 'Captcha is required..!!'];

            $v = \Validator::make($request->all(), [
                'name'                 => 'required',
                'email'                => 'required|email',
                'subject'              => 'required',
                'msg'                  => 'required',
                'g-recaptcha-response' => 'required',
            ], $message);

            if ($v->fails()) {
                return redirect()->back()->withErrors($v->errors());
            }

            if ($message = isInvalidCaptcha($request->{'g-recaptcha-response'})) {
                $errors = new MessageBag(['invalid_captcha' => [$message]]);

                return redirect()->back()->withErrors($errors);
            }

            \Mail::send('emails.contact', [
                'name'         => $request->input('name'),
                'email'        => $request->input('email'),
                'user_message' => $request->input('msg')
            ], function ($message) {
                //echo "<pre>";print_r($message);exit;
                $message->from('nitish@manyainternational.com', 'contact');
                $message->to('mitul.mehra@manyainternational.com')->subject('Contact Us - Indiashopps');

            });

            $data['message'] = "Thank you for contacting us";
        }

        $this->seo->setTitle("Contact US | IndiaShopps.com");

        $data['view_file'] = 'v3.mobile.static.contact';

        return $data;
    }

    public function getAboutUsPage($request)
    {
        $this->seo->setTitle("About US | IndiaShopps.com");

        $data['view_file'] = 'v3.mobile.static.about-us';

        return $data;
    }

    public function getCareerPage($request)
    {
        $this->seo->setTitle("Career | IndiaShopps.com");

        $data['view_file'] = 'v3.mobile.static.career';

        return $data;
    }

    public function getAccountsPage($request)
    {
        if (!Auth::check()) {
            return redirect()->route('login_v2');
        } else {
            // User save the profile information.
            if ($request->isMethod('post')) {
                $rules = [
                    'name'     => 'required',
                    'gender'   => 'required',
                    'mobile'   => 'required',
                    'password' => 'sometimes|nullable|min:6',
                ];

                if ($request->get('user_type') == 'corporate') {
                    $rules['company_name'] = 'required';
                    $rules['address']      = 'required';
                    if ($request->has('gst') && $request->get('gst')) {
                        $rules['gst'] = 'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/';
                    }
                }

                $validator = \Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    //Validation fails, redirect with Error..
                    $messages = $validator->messages(); // Validation Error Message.
                    return redirect("myaccount")->with("errors", $messages);
                }

                $user = User::find(Auth::user()->id); // Get User information by USER ID..

                $user->gender    = $request->get('gender');
                $user->interests = json_encode($request->get('interests'));
                $user->name      = $request->get('name');
                $user->mobile    = $request->get('mobile');

                if ($request->get('user_type') == 'corporate') {
                    $user->company->company_name = $request->get('company_name');
                    $user->company->address      = $request->get('address');
                    $user->company->gst          = $request->get('gst');
                    $user->company->save();
                }

                if (!empty($request->get('password'))) {
                    $user->password = \Hash::make($request->get('password'));
                    $message[]      = "Password Changed.. !!";
                }

                $message[] = "Profile Updated !!";
                $user->save(); // Save USER information..

                return redirect('myaccount')->with("success", $message);
            }
        }

        if (session()->has('success')) {
            $data['success'] = session("success");
        }

        $data['cats']      = \helper::get_categories();
        $data['user']      = Auth::user();
        $data['view_file'] = 'v3.mobile.auth.myaccount';

        return $data;
    }

    public function logout()
    {
        \Auth::logout();

        Cache::forget('mobile_menu');

        return redirect()->route("home_v2");
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
                    $errors = $validator->messages();
                } elseif (Auth::attempt($request->only(['email', 'password']), $request->has('remember'))) {
                    // Valid Login attempt.....
                    Cache::forget('mobile_menu');
                    return redirect()->route('cashback.earnings');
                } else {
                    //Invalid Login attempt..
                    $errors = ['password' => 'Email and/or password invalid.'];
                }

                if (isset($errors) && !empty($errors)) {
                    return redirect()->back()->withErrors($errors);
                }

                return redirect()->back()->withErrors(['error' => 'Invalid request..!!']);
            } else {
                if (Auth::check()) {
                    //Redirect If already Loggedn in, with Success Message...
                    Cache::forget('mobile_menu');

                    return redirect()->route('cashback.earnings');
                }
                $rules = [
                    'email'    => 'required|email|unique:and_user',
                    'name'     => 'required',
                    'mobile'   => 'nullable|digits:10',
                    'password' => 'required|min:6',
                    'gender'   => 'required',
                ];

                $msg = [];

                if (!empty($request->get('referral_code'))) {
                    $rules['referral_code']      = 'exists:referrals,code';
                    $msg['referral_code.exists'] = 'Invalid Referral Code !';
                }

                if ($request->get('user_type') == 'corporate') {
                    $rules['company_name'] = 'required';
                    $rules['address']      = 'required';
                    if ($request->has('gst') && $request->get('gst')) {
                        $rules['gst'] = 'required|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/';
                    }
                }
                // POST Form Validation
                $validator = \Validator::make($request->all(), $rules, $msg);

                if ($validator->fails()) {
                    //If Validation Fails
                    $errors = $validator->messages();

                    return redirect()->back()->withInput()->withErrors($errors);
                }

                // ELSE create a new User
                $data['email']     = $request->get('email');
                $data['gender']    = $request->get('gender');
                $data['interests'] = json_encode($request->get('interests'));
                $data['password']  = \Hash::make($request->get('password'));
                $data['name']      = $request->get('name');
                $data['mobile']    = $request->get('mobile');
                $data['join_date'] = Carbon::now()->toDateTimeString();

                if (!empty($request->get('referral_code'))) {
                    $referrer            = Referral::whereCode($request->get('referral_code'))->first();
                    $data['referrer_id'] = $referrer->id;
                }

                $user = new User($data);
                $user->save();

                if ($request->get('user_type') == 'corporate') {
                    event(new CompanyCreated($user, $request->all()));
                }

                //Login the user by Default once user Registers..
                if ($user->id) {
                    \Auth::loginUsingId($user->id);

                    auth()->user()->userConditionChecks();

                    if ($request->has('redirect_url')) {
                        return redirect($request->redirect_url);
                    }

                    if (isMobile()) {
                        Cache::forget(HeaderJson::getMenuCacheKey());
                    }

                    return redirect()
                        ->route('cashback.earnings')
                        ->withCookie(cookie()->forever('ext_user_id', auth()->user()->id));;
                }
            }
        }

        $data['cats'] = \helper::get_categories();

        if ($request->route()->getName() == 'login_v2') {
            $this->seo->setTitle("Login to IndiaShopps");

            $data['view_file'] = 'v3.mobile.auth.login';
        } else {
            $this->seo->setTitle("Create Your IndiaShopps Account");

            $data['view_file'] = 'v3.mobile.auth.register';
        }

        return $data;
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

            case 'product_detail_v2':
            case 'product_detail_non':
            case 'product_detail_non_book':

                $response = $this->getDetailPage($request);
                break;

            case 'home_v2':
                $response = $this->getHomePageContent($request);
                break;

            case 'aboutus_v2':
                $response = $this->getAboutUsPage($request);
                break;

            case 'contact':
                $response = $this->getContactPage($request);
                break;

            case 'career':
                $response = $this->getCareerPage($request);
                break;

            case 'login_v2':
                $response = $this->getLoginPage($request);
                break;

            case 'logout':
                $response = $this->logout();
                break;

            case 'register_v2':
                $response = $this->getLoginPage($request, true);
                break;

            case 'myaccount':
                $response = $this->getAccountsPage($request);
                break;

            case 'all-cat':
                $response = $this->getAllCategories($request);
                break;

            case 'sub_category':
            case 'product_list':
                $response = $this->productList($request);
                break;

            case 'brand_category_list_comp_1':
                $response = $this->brandCategoryListComp($request);
                break;

            case 'brand_category_list':
                $response = $this->brandCategoryList($request);
                break;

            case 'brands.listing':
                $response = $this->categoryBrandList($request);
                break;

            case 'custom_page_list_v3':
                $response = $this->customPageListingV3($request);
                break;

            case 'upcoming_mobiles':
                $response = $this->upcomingMobiles($request);
                break;

            case 'search_new':
                $response = $this->searchList($request);
                break;

            case 'coupons_v2':
                $response = $this->couponHome($request);
                break;

            case 'vendor_page_v2':
                $response = $this->couponVendor($request);
                break;

            case 'category_page_v2':
                $response = $this->categoryCoupons($request);
                break;

            case 'coupon_search':
                $response = $this->searchCoupon($request);
                break;

            case 'compare-mobiles':
                $response = $this->compareMobiles($request);
                break;

            case 'android_phones':
                $response = $this->android_phones($request);
                break;

            case 'windows_phones':
                $response = $this->windows_phones($request);
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

    protected function compareMobiles(Request $request)
    {
        $seo = app('seo');

        $prod_id1   = explode("-", $request->route()->parameter('mobile1'));
        $prod_id2   = explode("-", $request->route()->parameter('mobile2'));
        $products[] = end($prod_id1);
        $products[] = end($prod_id2);

        $products_ids = array_filter($products);
        // echo count( $products );exit;
        if (count($products) >= 2) {

            $c_prods  = $this->solrClient->whereIds(json_encode($products_ids))->getCompareList(true);
            $products = $c_prods->docs;


            $data = (new CompareController())->getSpecification($products);

            $seo->setTitle($products[0]->_source->name . " vs " . $products[1]->_source->name . " | Indiashopps");

            $data['has_product']    = true;
            $data['manual_compare'] = true;

            $data['view_file'] = 'v3.mobile.compare_mobiles';

        } else {
            $data['error'] = "No Product Selected..";

            $data['view_file'] = 'v3.mobile.compare_mobiles';
        }

        return $data;
    }

    protected function couponHome(Request $request)
    {
        $coupon_home_id = 829;

        $data['slider'] = Cache::remember('coupon_home_slider_mobile', 360, function () use ($coupon_home_id) {
            return \DB::table('home_slider')->whereCatId($coupon_home_id)->whereFor(2)->first();
        });

        $data['recent_offers'] = Cache::remember('coupon_home_mobile', 1440, function () use ($coupon_home_id) {
            return $this->solrClient->getCoupons()['data'];
        });

        $data['categories']    = storageJson('JSON/coupons_home.json');
        $data['coupons']       = storageJson("JSON/deals.json", 'coupons');
        $data['partner_deals'] = storageJson("JSON/deals.json", 'deals');
        $data['meta']          = (config('coupons_meta.home')) ? $this->getMeta('coupons_meta.home') : "";
        $data['view_file']     = 'v3.mobile.coupons.index';

        $this->seo->setMetaData($data['meta']);

        return $data;
    }

    public function couponVendor(Request $request, $page = 0)
    {
        $data['show'] = true;

        extract($request->route()->parametersWithoutNulls());

        if (empty($vendor)) {
            return redirect()->route('coupons_v2');
        } else {
            $data['vendor_name'] = strtolower(unslug($vendor));
        }

        $this->solrClient->whereVendorName($data['vendor_name']);

        if ($request->has('show')) {
            $data['show'] = false;
        }

        $this->solrClient->take(50);

        if ($request->has('category')) {
            $data['category'] = \helper::decode_url($request->category);
        }

        $token      = $request->session()->get('_token');
        $session_id = preg_replace("/[^0-9,.]/", '', $token);

        if (!empty($session_id) && is_numeric($session_id)) {
            $data['session_id'] = $session_id;
        }

        if ($page > 0) {
            $this->solrClient->skip($page);
        }


        $result = $this->solrClient->getCoupons(true);
        $result = $result->return_txt;

        if (empty($result)) {
            abort(404);
        }

        if (!empty($vendor)) {

            $vendor_meta = \DB::table('deals_meta')
                              ->select(['meta_data', 'description'])
                              ->where('vendor_name', '=', $vendor)
                              ->first();

            if (isset($vendor_meta->meta_data) && !empty($vendor_meta->meta_data)) {
                try {
                    $meta              = json_decode($vendor_meta->meta_data);
                    $data['list_desc'] = $meta;
                    $this->seo->setTitle($meta->title);
                    $this->seo->setDescription(($vendor_meta->description) ? $vendor_meta->description : '');
                }
                catch (\Exception $e) {
                }
            }
        }

        if ($request->has('code') && $request->code) {
            $data['show_code'] = true;
        }

        $data['coupons']       = $result->hits->hits;
        $data['product_count'] = $result->hits->total;
        $facets                = $result->aggregations;
        $data['facets']        = $facets;
        $data['ajax']          = $request->input('ajax');

        $data['coupons'] = collect($data['coupons'])->groupBy(function ($row) {
            return $row->_source->type;
        });

        if ($data['coupons']->count() == 1) {
            if ($data['coupons']->first()->count() > 0) {
                $data['coupons'] = $data['coupons']->first()->take(20)->groupBy(function ($row) {
                    return $row->_source->type;
                });
            }
        }

        $meta_data = (config('coupons_meta.' . strtolower($vendor))) ? $this->getMeta('coupons_meta.' . strtolower($vendor)) : "";

        if (!is_null($meta_data)) {
            $find = ['title' => 'title', 'description' => 'description', 'keyword' => 'keywords', 'text' => 'content'];

            foreach ($find as $k => $key) {
                if (isset($meta_data[$k])) {
                    $function = "set" . ucwords($key);
                    $this->seo->{$function}($meta_data[$k]);
                }
            }
        }
        //Ajax filter and json response..
        if ($request->input('ajax') == "true") {
            $json['coupons'] = (string)view('v2.coupons.list', $data);
            $json['coupons'] = preg_replace('/(\v)+/', '', $json['coupons']);
            $json['coupons'] = str_replace("\t", "", $json['coupons']);
            $json['total']   = $data['product_count'];
            $json['facet']   = $facets->category->buckets;
            $json['vendors'] = $facets->vendor_name->buckets;
            echo json_encode($json);
            exit;
        } else {

            $data['recent_offers'] = Cache::remember('coupon_home_mobile', 1440, function () {
                return $this->solrClient->getCoupons()['data'];
            });

            $data['slider']    = \DB::table('home_slider')->whereCatId(829)->whereBrands($vendor)->whereFor(0)->first();
            $data['scoupons']  = storageJson("JSON/deals.json", 'coupons');
            $data['view_file'] = 'v3.mobile.coupons.detail';

            return $data;
        }
    }

    public function categoryCoupons(Request $request, $page = 0)
    {
        $data['show'] = true;

        extract($request->route()->parametersWithoutNulls());

        if (empty($category)) {
            return redirect()->route('coupons_v2');
        } else {
            $cat = \DB::table('and_deals_cat')
                      ->select(['id', 'name'])
                      ->where(\DB::raw(" create_slug(name) "), $category)
                      ->first();

            if (is_null($cat)) {
                abort(404);
            } else {
                $data['cat_id'] = $cat->id;
            }
        }

        if ($request->has('show')) {
            $data['show'] = false;
        }

        if (!empty($request->input('type')) && $request->input('type') != "all") {
            $data['type'] = urldecode($request->input('type'));
        }

        if (!empty($request->input('vendor_name'))) {
            $vendor_name = str_replace("-", " ", $request->input('vendor_name'));

            if (is_array($vendor_name)) {
                $data['vendor_name'] = implode(",", $vendor_name);
            } else {
                $data['vendor_name'] = $vendor_name;
            }
        }

        $token      = $request->session()->get('_token');
        $session_id = preg_replace("/[^0-9,.]/", '', $token);

        if (!empty($session_id) && is_numeric($session_id)) {
            $data['session_id'] = $session_id;
        }

        if (!empty($category)) {
            //$data['category'] = \helper::decode_url( $category );

            $category = \DB::table('and_deals_cat')
                           ->select(['name', 'meta', 'seo_title', 'id'])
                           ->where(\DB::raw('create_slug(name)'), '=', $category)
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

        if ($page > 0) {
            $this->solrClient->skip($page);
        }

        $result = $this->solrClient->getCoupons(true);

        if (empty($result)) {
            abort(404);
        }

        if ($request->has('code') && $request->code) {
            $data['show_code'] = true;
        }

        $result = $result->return_txt;

        $data['top_categories'] = \DB::table('and_deals_cat')
                                     ->select("name", "image_url", "icon_class")
                                     ->where('show_list', 1)
                                     ->get();

        $data['coupons']       = $result->hits->hits;
        $data['product_count'] = $result->hits->total;
        $facets                = $result->aggregations;
        $data['filters']       = $facets;
        // $facet['left']['cats']	= $facets->category->buckets;
        $facet['left']['vendors'] = $facets->vendor_name->buckets;
        $data['facet']            = $facet;
        $data['ajax']             = $request->input('ajax');
        $data['title']            = $cat->name;
        $data['type']             = "category";


        if (isset($category->seo_title) && !empty($category->seo_title)) {
            $this->seo->setTitle($category->seo_title);
        }

        //Ajax filter and json response..
        if ($request->input('ajax') == "true") {
            $json['coupons'] = (string)view('v2.coupons.list', $data);
            $json['coupons'] = preg_replace('/(\v)+/', '', $json['coupons']);
            $json['coupons'] = str_replace("\t", "", $json['coupons']);
            $json['total']   = $data['product_count'];
            $json['facet']   = $facets->category->buckets;
            $json['vendors'] = $facets->vendor_name->buckets;
            echo json_encode($json);
            exit;
        } else {
            $data['slider']        = \DB::table('home_slider')->whereCouponId($data['cat_id'])->whereFor(2)->first();
            $data['recent_offers'] = Cache::remember('coupon_home_mobile', 1440, function () {
                return $this->solrClient->getCoupons()['data'];
            });

            $data['categories'] = storageJson('JSON/coupons_home.json');
            $data['view_file']  = 'v3.mobile.coupons.category';

            return $data;
        }
    }

    public function searchCoupon(Request $request, $page = 0)
    {
        $data['show']  = true;
        $data['query'] = urldecode($request->input('search_text'));
        $data['type']  = urldecode($request->input('type'));

        if (!$request->has('search_text') && !$request->has('cat_id')) {
            return redirect()->route('coupons_v2');
        }

        if ($request->has('show')) {
            $data['show'] = false;
        }

        if (!empty($request->input('type')) && $request->input('type') != "") {
            $this->solrClient->whereType(urldecode($request->input('type')));
        }

        if (!empty($request->input('cat_id')) && $request->input('cat_id') != "") {
            $this->solrClient->whereCatId(urldecode($request->input('cat_id')));
        }

        $token      = $request->session()->get('_token');
        $session_id = preg_replace("/[^0-9,.]/", '', $token);

        if (!empty($session_id) && is_numeric($session_id)) {
            $data['session_id'] = $session_id;
        }

        if ($page > 0) {
            $this->solrClient->skip($page);
        }

        $result = $this->solrClient->whereSearchText($request->search_text)->getCoupons(true);
        $result = $result->return_txt;

        if (empty($result)) {
            abort(404);
        }

        $data['coupons']       = $result->hits->hits;
        $data['product_count'] = $result->hits->total;
        $facets                = $result->aggregations;
        $data['facets']        = $facets;
        $data['ajax']          = $request->input('ajax');
        $data['vendor_name']   = $request->search_text;

        $data['recent_offers'] = Cache::remember('coupon_home_mobile', 1440, function () {
            return $this->solrClient->getCoupons()['data'];
        });

        $data['view_file'] = 'v3.mobile.coupons.search';

        return $data;
    }

    private function getAllCategories(Request $request)
    {
        app('seo')->setTitle('All Categories List - Indiashopps');

        $data['categories'] = Helper::get_categories_tierd();
        $data['view_file']  = 'v3.mobile.static.categories';

        return $data;
    }

    private function categoryPage(Request $request)
    {
        $seo      = app('seo');
        $category = $request->route()->parameter('category');

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
                                    ->select(['meta', 'seo_title', 'description', 'id', 'name'])
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

            $category             = $cats->first();
            $first                = new \stdClass();
            $first->title         = $category->name;
            $first->category      = $category;
            $data['category_id']  = $cat_data->id;
            $data['first']        = $first;
            $data['widget_count'] = $cats->count();
            $data['childs']       = $cats;
        }

        $data['view_file'] = 'v3.mobile.category';

        return $data;
    }

    public function productList(Request $r)
    {
        $controller = new ListingController();

        $r->request->add(['mobile_page' => true]);
        $route = collect($r->route()->parametersWithoutNulls());
        $route = collect(array_merge($r->all(), $route->all()));

        if ($r->has('search_text')) {
            $response = $controller->productList($r, false, false, false, $route->get('page'));
        } elseif ($route->has('child')) {
            $response = $controller->productList($r, $route->get('parent'), $route->get('category'), $route->get('child'), $route->get('page'));
        } else {
            $response = $controller->productList($r, $route->get('parent'), $route->get('category'), false, $route->get('page'));
        }

        if ($response instanceof RedirectResponse) {
            return $response;
        }


        if ($r->has('mobile_ajax')) {
            $json['products']     = (string)view("v3.mobile.product.ajax.listing", $response);
            $json['products']     = preg_replace('/(\v)+/', '', $json['products']);
            $json['products']     = str_replace("\t", "", $json['products']);
            $json['facet']        = $response['facet'];
            $json['facet']->total = $response['facet']->total;

            if (isset($response->filter_applied)) {
                $json['facet']->filter_applied = $response->filter_applied;
            }

            echo json_encode($json);
            exit;
        }

        if (Schema::hasTable('home_slider')) {
            if (isset($brand) && !empty($brand)) {

                $query = \DB::table('home_slider')
                            ->where('cat_id', $response['category_id'])
                            ->where('brands', $brand)
                            ->whereFor(2);

                $sliders = $query->get();
            } else {
                $category = Category::where('id', $response['category_id'])->with(['parent', 'slider'])->first();

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

            $response['sliders'] = $sliders->first();
        }

        //$data['html'] = (string)view('v3.mobile.product.listing', $response);
        $response['page']      = (isset($response['page'])) ? $response['page'] : 1;
        $response['view_file'] = 'v3.mobile.product.listing';

        return $response;
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
    public function customPageListingV3(Request $request)
    {
        Breadcrumbs::setCurrentRoute('custom_page_list_v3', $request->category_group, $request->get('slug'));

        $CustomPage = CustomPage::with('category.parent')->whereSlug($request->slug)->first();

        if (is_null($CustomPage)) {
            abort(404);
        }

        if ($request->category_group != $CustomPage->category->group_name) {
            return redirect()->route('custom_page_list_v3', [$CustomPage->category->group_name, $request->slug], 301);
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
        $filters['slug'] = $request->slug;

        $request->request->add(['custom_filters' => $filters, "custom_page" => true]);
        $request->request->add(['apply_filters' => true]);

        $cat = $CustomPage->category;

        if (strtolower($cat->group_name) == strtolower($cat->parent->name)) {
            $request->request->add([
                'parent'   => create_slug($cat->group_name),
                'category' => create_slug($cat->name) . "-price-list-in-india.html",
            ]);

            return $this->productList($request);
        }

        $request->request->add([
            'parent'   => create_slug($cat->group_name),
            'child'    => create_slug($cat->parent->name),
            'category' => create_slug($cat->name) . "-price-list-in-india.html",
        ]);

        $request->route()->setParameter('parent', create_slug($cat->group_name));
        $request->route()->setParameter('child', create_slug($cat->parent->name));
        $request->route()->setParameter('category', create_slug($cat->name) . "-price-list-in-india.html");

        return $this->productList($request);
    }

    public function brandCategoryListComp(Request $request)
    {
        $r = collect($request->route()->parametersWithoutNulls());
        if ($r->has('brand')) {
            //Add price to Request Object Manually and enabling price filter for Listing Controller.
            $request->request->add(['brand' => $r->get('brand'), "brand_page" => true]);
            $request->request->add(['price_filter' => true]);
        }

        $pid = $r->get('id');
        if(in_array($r->get('id'),array_keys(config('common.deactivate_ids'))))
        {
            $pid =  config('common.deactivate_ids')[$r->get('id')];
        }

        $cat = $this->getParentName($r->get('category'), 0, $pid, $request);

        if(in_array($r->get('id'),array_keys(config('common.deactivate_ids')))) {
            if (in_array($cat->group_name, config('listing.brand.groups')) && $r->has('brand')) {
                return redirect()->route('brands.listing', [cs($cat->group_name), $r['brand'], cs($cat->category)], 301);
            }
        }

        $request->request->add([
            'parent'   => create_slug($cat->group_name),
            'category' => $cat->category . "-price-list-in-india",
        ]);

        $request->route()->setParameter('parent', create_slug($cat->group_name));
        $request->route()->setParameter('category', $cat->category . "-price-list-in-india");

        return $this->productList($request);
    }

    public function categoryBrandList(Request $request)
    {
        $r = collect($request->route()->parametersWithoutNulls());
        $request->request->add($r->all());

        if (!empty($request->brand)) {
            $brand = preg_replace("/-/", " ", $request->brand);

            $request->request->add(['brand' => $brand, "brand_listing_page" => true]);
            $request->request->add(['price_filter' => true]);
        }

        $cat = $this->getParentName($request->category, $request->group, 0, $request);

        if (cs($cat->name) == cs($cat->group_name)) {

            $Category = Category::where(\DB::raw(" create_slug(group_name) "), 'LIKE', cs($cat->group_name))
                                ->where(\DB::raw(" create_slug(name) "), "LIKE", cs($cat->name))
                                ->first();

            if (!Category::hasThirdLevel($Category)) {
                return redirect(categoryLink([$cat->group_name, $cat->category]), 301);
            }
        }

        if (!in_array(strtolower($cat->group_name), config('listing.brand.groups'))) {
            return redirect()->route('brand_category_list', [
                $request->brand,
                cs($cat->group_name),
                cs($cat->category)
            ], 301);
        }

        if (strtolower(cs($cat->name)) == strtolower($request->group)) {
            $child = false;
            session()->push('first_category_bread', $cat->name);
        } else {
            $child = cs($cat->name);
            session()->push('second_category_bread', $cat->name);
        }

        $request->route()->setParameter('parent', create_slug($cat->group_name));
        $request->route()->setParameter('child', $child);
        $request->route()->setParameter('category', $cat->category . "-price-list-in-india");

        return $this->productList($request);
    }

    public function brandCategoryList(Request $request)
    {
        $r = collect($request->route()->parametersWithoutNulls());
        $request->request->add($r->all());

        if ($r->has('brand')) {
            //Add price to Request Object Manually and enabling price filter for Listing Controller.

            $three_cat = ['-home-decor-', '-beauty-health-', '-sports-fitness-', '-deals-promotion-'];

            foreach ($three_cat as $cat) {
                $uri = $r->get('brand') . '-' . $r->get('group') . '-' . $r->get('category');

                if (stripos($uri, $cat) !== false) {
                    $part     = explode($cat, $uri);
                    $brand    = preg_replace('/[-]+/', ' ', trim($part[0]));
                    $group    = trim($cat, '-');
                    $category = $part[1];

                    $r->put('brand', $brand);
                    $r->put('group', $group);
                    $r->put('category', $category);

                    $request->request->add($r->all());
                }
            }
            $request->request->add(['brand' => $r->get('brand'), "brand_page" => true]);
            $request->request->add(['price_filter' => true]);
        }

        $cat   = $this->getParentName($r->get('category'), $r->get('group'), 0, $request);
        $child = (create_slug($cat->group_name) == create_slug($cat->name)) ? false : create_slug($cat->name);

        if (in_array($r->get('category'), ['mobiles', 'laptops'])) {

            $Category = Cache::remember("category_name_" . $r->get('category'), 3600, function () use ($r) {
                return Category::select('id')
                               ->where(\DB::raw(" create_slug(name) "), "like", $r->get('category'))
                               ->first()
                               ->toArray();
            });

            return redirect()->route('brand_category_list_comp_1', [
                $r->get('brand'),
                $r->get('category'),
                $Category['id']
            ], 301);
        }

        if (in_array($cat->group_name, config('listing.brand.groups'))) {
            $rest  = "-" . implode("-", [cs($cat->group_name), $cat->category]);
            $brand = str_replace($rest, '', $uri);

            return redirect()->route('brands.listing', [cs($cat->group_name), cs($brand), cs($cat->category)], 301);
        }

        $request->request->add([
            'parent'   => create_slug($cat->group_name),
            'category' => $cat->category . "-price-list-in-india",
            'child'    => $child
        ]);

        $request->route()->setParameter('parent', create_slug($cat->group_name));
        $request->route()->setParameter('category', $cat->category . "-price-list-in-india");

        return $this->productList($request);
    }

    /**
     * Upcoming Mobile Phone Listing Page.
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     *
     * @return View
     */
    public function upcomingMobiles(Request $request)
    {
        Breadcrumbs::setCurrentRoute('upcoming_mobiles');

        $request->request->add(['upcoming-mobiles' => true, 'price_filter' => true]);

        $request->request->add([
            'parent'   => "mobile",
            'category' => "mobiles-price-list-in-india",
        ]);

        $request->route()->setParameter('parent', 'mobile');
        $request->route()->setParameter('category', "mobiles-price-list-in-india");

        $uri = route('upcoming_mobiles');

        $this->makeRoute($request, 'upcoming_mobiles', $uri);

        return $this->productList($request);
    }

    /**
     * Mobile phone listing Under a any given Max Price..
     *
     * @var \Illuminate\Http\Request
     * @var Maximum Price..
     * @var Page Number
     * @return View
     */
    public function bestPhones(Request $request, $price = 0, $page = 1)
    {
        if (empty($request->price) || !is_numeric($request->price)) {
            return redirect("/");
        } else {
            if (!$request->has('saleprice_max')) {

                $title = "Best phone under " . $request->price;
                //Add price to Request Object Manually and enabling price filter for Listing Controller.
                $request->request->add(['saleprice_max' => $request->price]);
                $request->request->add(['saleprice_min' => 0]);
                $request->request->add(['price_filter' => 1]);
                $request->request->add(['h1' => $title]);
                $request->request->add(['title' => $title]);
            }

            $request->request->add(['bestphones' => true]);

            $request->route()->setParameter('parent', 'mobile');
            $request->route()->setParameter('category', "mobiles-price-list-in-india");

            return $this->productList($request);
        }
    }

    /**
     * Custom Links
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     * @return View
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

        $request->route()->setParameter('parent', 'mobile');
        $request->route()->setParameter('category', "dual-sim-phones--mobiles-price-list-in-india");

        return $this->productList($request);
    }

    /**
     * Custom Links
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     * @return View
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

        $request->route()->setParameter('parent', 'mobile');
        $request->route()->setParameter('category', "android_phones--mobiles-price-list-in-india");

        if (view()->exists('v3.description.android-mobiles')) {
            $this->seo->setContent(view('v3.description.android-mobiles')->render());
        }

        return $this->productList($request);
    }

    /**
     * Custom Links
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     * @return View
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

        $request->route()->setParameter('parent', 'mobile');
        $request->route()->setParameter('category', "windows_phones--mobiles-price-list-in-india");

        if (view()->exists('v3.description.windows-mobiles')) {
            $this->seo->setContent(view('v3.description.windows-mobiles')->render());
        }

        return $this->productList($request);
    }

    /**
     * Search wise Product Listing..
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     * @return View
     */
    public function searchList(Request $request)
    {
        if ($request->keyword) {
            $cat_id = $request->group;

            if (config('app.searchLogEnable')) {
                /*Logging search text to table*/
                $search_id = \DB::table('gc_search')->insertGetId(['term' => $request->keyword]);
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

            $h1 = unslug($request->keyword) . " Price List in India";
            $request->request->add(["h1" => $h1, 'ajax' => true]);

            $request->request->add(['search_text' => unslug($request->keyword), $key => $value]);

            $request->route()->setParameter('parent', false);
            $request->route()->setParameter('category', false);

            Breadcrumbs::setCurrentRoute('search_new', $request->search_text);

            return $this->productList($request);

        } else {
            abort(404);
        }
    }

    protected function makeRoute(Request &$r, $route_name, $uri)
    {
        if ($r->route()->getName() == "get_mobile_ajax_page") {

            try {
                //to check whether it has a breadcrumb
                Breadcrumbs::current();
            }
            catch (InvalidBreadcrumbException $e) {
                if ($route_name == 'sub_category') {
                    Breadcrumbs::setCurrentRoute('sub_category', $r->parent, $r->category);
                } elseif ($route_name == 'product_list') {
                    Breadcrumbs::setCurrentRoute('product_list', $r->parent, $r->child, $r->category);
                }
            }

            $route = new Route("GET", $uri, [
                'as' => $route_name
            ]);

            $route->bind($r);

            $r->setRouteResolver(function () use ($route) {
                return $route;
            });
        }
    }
}