<?php namespace indiashopps\Http\Controllers\v2;

use Carbon\Carbon;
use Guzzle\Http\Client;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\MessageBag;
use indiashopps\Helpers\Helper;
use indiashopps\Http\Controllers\FcmController;
use indiashopps\Http\Requests;
use indiashopps\Http\Controllers\Controller;
use indiashopps\Models\FcmToken;
use Illuminate\Http\Request;
use indiashopps\Models\Subscriber;
use Mail;
use Validator;

class CommonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function aboutUs()
    {
        $data['title'] = "About US | IndiaShopps.com";
        return view('v2.static.about-us', $data);
    }

    public function career()
    {
        $data['title'] = "Career | IndiaShopps.com";
        return view('v2.static.career', $data);
    }

    /**
     * Contact Page Controller for sending mail to the Admin.. and displays the message to the user..
     *
     * @var \Illuminate\Http\Request
     */
    public function contact(Request $request)
    {
        $data = [];

        if ($request->isMethod('post')) {

            $message = [ 'g-recaptcha-response.required' => 'Captcha is required..!!' ];

            $v = Validator::make($request->all(), [
                'name'                 => 'required',
                'email'                => 'required|email',
                'subject'              => 'required',
                'msg'                  => 'required',
                'g-recaptcha-response' => 'required',
            ], $message );

            if ($v->fails()) {
                return redirect()->back()->withErrors($v->errors());
            }

            if( $message = isInvalidCaptcha( $request->{'g-recaptcha-response'}) )
            {
                $errors = new MessageBag(['invalid_captcha' => [$message]]);

                return redirect()->back()->withErrors($errors);
            }

            Mail::send('emails.contact', [
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
        $data['title'] = "Contact US | IndiaShopps.com";
        return view('v2.static.contact', $data);
    }

    /**
     * ALL Categories Listing Page Controller
     *
     * @var NONE
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
     */
    public function sitemap()
    {
        $data['categories'] = Helper::get_categories_tierd(0, 3);

        return view('v2.static.sitemap', $data);
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

                $query['name']        = $product->name;
                $query['size']        = 16;
                $query['id']          = $product->id;
                $query['category_id'] = $product->cat;

                if ($request->has('page') && $request->page == 'non_comp') {
                    $template = 'v2.product.common.exit_popup_non';
                } else {
                    $template = 'v2.product.common.exit_popup';
                }

                $exit_popup = composer_url('exit_popup.php?' . http_build_query($query));
                $result     = json_decode(file_get_contents($exit_popup));

                $data['products'] = $result->result_same_brand->hits->hits;

                return view($template, $data);

            }
            catch (\Exception $e) {
                dd($exit_popup);
            }
        } elseif ($request->has('page')) {
            return view('v2.product.common.subscriber');
        } else {
            return "empty";
        }
    }

    public function subscribe(Request $request)
    {
        if ($request->has('email')) {
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
                    FcmController::addFcmTokenToTopic($device->token);

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
}
