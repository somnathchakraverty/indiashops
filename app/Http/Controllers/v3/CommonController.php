<?php

namespace indiashopps\Http\Controllers\v3;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\MessageBag;
use Illuminate\View\View;
use indiashopps\Category;
use indiashopps\Helpers\Helper;
use indiashopps\Models\Subscriber;
use indiashopps\Models\UpcomingSubscriber;

class CommonController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function aboutUs()
    {
        return view('v3.static.about-us');
    }

    public function career()
    {
        return view('v3.static.career');
    }

    public function flipkartLoyalty()
    {
        return view('v3.static.flipkart.loyalty');
    }

    public function flipkartSale()
    {
        return view('v3.static.flipkart.sale');
    }

    public function bbillionSale()
    {
        return view('v3.static.flipkart.bb_sale');
    }

    /**
     * Contact Page Controller for sending mail to the Admin.. and displays the message to the user..
     *
     * @var \Illuminate\Http\Request
     * @return View
     */
    public function contact(Request $request)
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

        return view('v3.static.contact', $data);
    }

    /**
     * ALL Categories Listing Page Controller
     *
     * @var NONE
     * @return View
     */
    public function categories()
    {
        app('seo')->setTitle('All Categories List - Indiashopps');

        $data['categories'] = Helper::get_categories_tierd(); // \indiashopps\Helpers\helper.php
        return view('v3.static.categories', $data);
    }

    /**
     * ALL Categories Listing Page Controller
     *
     * @var NONE
     * @return View
     */
    public function sitemap()
    {
        $data['categories'] = Helper::get_categories_tierd(0, 3);

        $this->seo->setTitle("Sitemap - Indiashopps");
        $this->seo->setDescription("Complete Indiashopps Sitemap");
        $this->seo->setKeywords("sitemap, indiashopps sitemap, complete indiashopps sitemap");

        if (isMobile()) {
            return view('v3.mobile.static.sitemap', $data);
        } else {
            return view('v3.static.sitemap', $data);
        }
    }

    public function autocomplete()
    {
        \Log::error('Amazon Autocomplete Not working..');
    }

    public function command($name, $param = [])
    {
        if (!empty($name)) {
            try {
                if (!empty($param)) {
                    Artisan::call($name, ['enable' => $param]);
                } else {
                    Artisan::call($name);
                }

                dd(Artisan::output());
            }
            catch (\Exception $e) {
                dd($e->getMessage());
            }
        }
    }

    public function exitPopupHTML(Request $request)
    {
        if ($request->has('product')) {
            try {
                if ($request->has('product')) {
                    $product = \Crypt::decrypt($request->product);
                }

                $query = $this->solrClient->whereName($product->name)
                                          ->take(10)
                                          ->whereId($product->id)
                                          ->whereCategoryId($product->cat);
                if (isset($product->price)) {
                    $query->where('price', $product->price);
                }

                $result = $query->getExitProducts(true);

                $data['product']  = $product;
                $data['products'] = $result->result_same_brand->hits->hits;

                $template = 'v3.common.exit_popup.product_detail';

                return view($template, $data);

            }
            catch (\Exception $e) {
                \Log::error($e->getMessage() . "===" . $e->getTraceAsString());
            }
        } elseif ($request->has('page')) {
            if ($request->page == 'home_v2') {
                //return view('v3.common.exit_popup.subscribe');
                return view('v3.common.exit_popup.extension');
            } else {
                return view('v3.common.exit_popup.offers');
            }
        } else {
            return "empty";
        }
    }

    public function subscribe(Request $request)
    {
        if ($request->has('email') && filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            Subscriber::firstOrCreate(['email' => $request->email]);
            return "success";
        }
    }

    public function getNotifyHtml(Request $request)
    {
        if (!$request->has('type')) {
            return '';
        }

        $notify  = config('notify');
        $type    = array_rand($notify['messages']);
        $message = array_rand($notify['messages'][$type]);

        if (!is_null($message)) {
            $message = $notify['messages'][$type][$message];
        }

        switch ($type) {
            case 'product':
                $html = $this->productHtml($message, $request->id, $request->type, $request);
                break;

            case 'social':
                $html = $this->socialMediaHtml($message);
                break;

            case 'blog':
                $html = $this->blogHtml();
                break;

            default:
                $html = '';
                break;
        }

        return $html;
    }

    private function randomDate()
    {
        // Convert to timetamps
        $min = strtotime(date("Y-m-d H:i:s", strtotime('-2 days')));
        $max = strtotime(date("Y-m-d H:i:s"));

        // Generate random number using above bounds
        $val = mt_rand($min, $max);
        // Convert back to desired date format
        return Carbon::createFromTimestamp($val)->diffForHumans();
    }

    private function productHtml($message, $id = 0, $type = 'product', $request)
    {
        try {
            if (!empty($id)) {
                $time = $this->randomDate();

                if ($type == 'product') {
                    $params['_id'] = $id;

                    if ($request->has('category_id')) {
                        $params['category_id'] = $request->category_id;
                    }

                } elseif ($type == 'category') {
                    $params['category_id'] = $id;
                }

                if (stripos($message, '{THIS}') !== false) {
                    $url     = composer_url('ext_prod_detail.php?_id=' . $id);
                    $data    = json_decode(file_get_contents($url));
                    $product = $data->product_detail;
                }
                if (stripos($message, 'similar') !== false) {
                    $params['total'] = 1;
                    $url             = composer_url('prod_suggest.php?' . http_build_query($params));
                    $result          = file_get_contents($url);
                    $product         = json_decode($result)->return->hits->hits[0]->_source;
                } else {
                    $params['size'] = 1;
                    $url            = composer_url('search.php?query=' . urldecode(json_encode($params)));
                    $data           = json_decode(file_get_contents($url));
                    $product        = $data->return_txt->hits->hits[0]->_source;
                }
                $notify  = config('notify');
                $name    = $notify['names'][rand(0, count($notify['names']) - 1)];
                $city    = $notify['city'][rand(0, count($notify['city']) - 1)];
                $search  = ['{PRODUCT}', '{NAME}', '{CITY}', '{TIME}', '{THIS}'];
                $replace = [$product->name, $name, $city, $time, $product->name];

                $message = str_replace($search, $replace, $message);

                return [
                    'content' => $message,
                    'image'   => getImage($product->image_url, $product->vendor, 'S'),
                    'link'    => product_url($product)
                ];

            } else {
                return '';
            }
        }
        catch (\Exception $e) {
            return [
                'content' => '',
                'image'   => '',
                'link'    => ''
            ];
        }
    }

    private function blogHtml()
    {
        $blog = getJSONContent('url.blog_json_url')->blog;
        $blog = $blog[rand(0, (count($blog) - 1))];

        if (stripos($blog->path, 'cloudinary') !== false) {
            $blog->path = str_replace("/upload/", "/upload/c_scale,w_100,h_100/", $blog->path);
        }

        return [
            'content' => $blog->post_title,
            'image'   => $blog->path,
            'link'    => url("blog/" . $blog->post_name)
        ];
    }

    private function socialMediaHtml($message)
    {
        $notify  = config('notify');
        $name    = $notify['names'][rand(0, count($notify['names']) - 1)];
        $image   = $notify['images']['social'][rand(0, count($notify['images']['social']) - 1)];
        $search  = ['{NAME}', '{IND}'];
        $fb_link = "IndiaShopps";
        $replace = [$name, $fb_link];

        $message = str_replace($search, $replace, $message);
        return [
            'content' => $message,
            'image'   => $image,
            'link'    => 'http://www.facebook.com/indiashopps'
        ];
    }

    public function saveFCMToken(Request $request)
    {
        if ($request->has('fcm_token')) {
            $device = FcmToken::where('token', '=', $request->fcm_token)->first();
            if (is_null($device)) {
                $device         = new FcmToken;
                $device->token  = $request->fcm_token;
                $device->source = ($request->has('user_source')) ? $request->user_source : 'indiashopps';

                if ($request->has('user_source') && $request->user_source == 'extension' && $request->has('source_id')) {
                    $device->identifier  = $request->source_id;
                    $device->gcm_version = FcmToken::EXTENSION_VERSION;
                } else {
                    $device->identifier  = str_random(15);
                    $device->gcm_version = FcmToken::WEBSITE_VERSION;
                }

                if ($device->save()) {
                    return response(['User FCM Token saved successfully..!']);
                }
            } else {
                return response(['User Token Already Registered..!'], 422);
            }
        } else {
            return response(['User FCM Token missing..!!'], 422);
        }
    }

    public function vendorSaveFcmToken(Request $request)
    {
        $auth_token = $request->header('Authorization');

        if (is_null($auth_token) || empty($auth_token)) {
            return response(['Auth Token Missing'], 403);
        }

        if (!in_array($auth_token, config('auth_tokens'))) {
            return response(['Invalid Auth Token'], 403);
        } else {
            $request->request->add(['user_source' => array_search($auth_token, config('auth_tokens'))]);
        }

        return $this->saveFCMToken($request);
    }

    public function privacy_policy()
    {
        $this->seo->setTitle("Privacy Policy | IndiaShopps");

        return view('v3.static.privacy_policy');
    }

    public function log()
    {
        return redirect("/");
    }

    public function pageNotFound()
    {
        return view('v3.errors.404');
    }

    public function clearCache(Request $request, $key = 'upcoming')
    {
        $category_id = ($request->has('category_id')) ? $request->category_id : Category::MOBILE;

        $keys = [
            'upcoming' => 'listing_page_upcoming_mobiles',
            'mobile'   => 'listing_page_' . $category_id,
            'product'  => 'product_detail_comp_'
        ];

        if (array_key_exists($key, $keys)) {
            if ($key == 'product') {
                if ($request->has('id')) {
                    $product_ids = explode(",", $request->get('id'));
                    foreach ($product_ids as $id) {
                        $cache_key = $keys[$key] . $id;
                        Cache::forget($cache_key);
                    }
                } else {
                    return response()->json(['Product ID(s) missing .!!'], 422);
                }
            } else {
                Cache::forget($keys[$key]);
            }

            return response()->json(['Cache purged...!!']);
        } else {
            return response()->json(['Invalid Page key or cache key missing..!!'], 422);
        }
    }

    public function upcomingNotify(Request $request)
    {
        $validator = validator($request->all(), [
            'email'      => 'required',
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response("Invalid Request", 303);
        }

        $subscribe = UpcomingSubscriber::whereEmail($request->email)->whereProductId($request->product_id)->first();

        if (!is_null($subscribe)) {
            return response("Already subscribe for this product..!!", 303);
        }

        $subscribe             = new UpcomingSubscriber;
        $subscribe->email      = $request->email;
        $subscribe->product_id = $request->product_id;
        $subscribe->save();

        return response("Successfully Subscribed, we will notify you...!");
    }
}
