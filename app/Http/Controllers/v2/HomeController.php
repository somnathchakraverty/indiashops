<?php
namespace indiashopps\Http\Controllers\v2;


use DB;
use helper;
use Illuminate\Http\Request;
use indiashopps\Http\Controllers\Controller;
use Mail;

class HomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | HOME page for IndiaShopps with Slider and Latest Product..
    |
    */

    /*
     * Create a new controller instance`.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * HOME Page.. with Slider and Latest Product..
     * FOR HOT DEAL, TOP BRANDS, NEW PRODUCT and RECENTLY VIEWED PRODUCTS, please check @ajaxContent Function Below
     *
     * Rest of the content is loaded VIA @ajax, and the ajax code is under js/v1/main.js.. with var CONTENT variable
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     */
    public function index(Request $request)
    {
        $data['home']     = getJSONContent('url.home_json_url');
        $data['blogs']    = getJSONContent('url.blog_json_url')->blog;
        $data['headers']  = getJSONContent('url.header_json_url');
        $data['cat_menu'] = getJSONContent('url.menu_json_url');

        $data['title']       = "Compare and Buy Online for Mobiles, Books, Shoes, Bags and Electronics - IndiaShopps";
        $data['description'] = "India's best price comparison shopping platform for mobiles, electronics, laptops, cameras, home décor & more. Find price, model and features online only at Indiashopps.";

        $data['products'] = json_decode(file_get_contents(config('url.home_json_url')));

        return view('v2.index', $data);
    }

    public function getAllProducts($blocks)
    {
        $ids = "";

        foreach ($blocks as $key => $block) {
            if ($key == 'slider') {
                continue;
            }

            foreach ($block as $tkey => $tab) {

//				if (isset($tab->topten)) {
//					$ids .= "," . trim($tab->topten->id, ',');
//				}
//
//				if (isset($tab->others) && isset($tab->others->id)) {
//					$ids .= "," . trim($tab->others->id, ',');
//				}

                if (isset($tab->right_side[0]) && isset($tab->right_side[0]->id)) {
                    $ids .= "," . trim($tab->right_side[0]->id, ',');
                }

//				if (isset($tab->offers)) {
//					$ids .= "," . trim($tab->offers->id, ',');
//				}
            }
        }

        $ids = trim($ids, ",");
// dd($ids);
        $result = json_decode(file_get_contents(composer_url("query_mget.php?ids=[" . $ids . "]")));
        foreach ($result->docs as $product) {

            if ($product->found) {
                unset($product->_source->description);
                unset($product->_source->excerpt);

                $products[] = $product;
            }
        }

        // dd(collect($products)->keyBy("_id")->toArray());
        return collect($products)
            ->keyBy("_id")
            ->toArray();
    }

    /**
     * Ajax Content Controller for HOME page..
     *
     * @var \Illuminate\Http\Requesto
     * @var Section i.e ==> HOT DEAL, TOP BRANDS, NEW PRODUCT and RECENTLY VIEWED PRODUCTS
     */
    public function ajaxContent(Request $request, $section = "")
    {
        if (empty($section)) {
            echo "";
            exit;
        } else {
            if ($section == "all") {
                $url              = composer_url('deals.php?type=promotion');
                $prod             = file_get_contents($url);
                $prod             = json_decode($prod);
                $data['hotDeals'] = $prod->return_txt->hits->hits;

                $response['hotdeals'] = (string)view("v1.template.hotdeals", $data);

                //$trending 			= DB::table('gc_log')->distinct()->take(15)->orderBy('_id', 'desc')->lists('_id');
                $newPro           = file_get_contents(composer_url('new_prod.php?query={"size":12}'));
                $data['trending'] = json_decode($newPro)->return_txt;

                $response['trending'] = (string)view("v1.template.trending", $data);

                $response = json_encode($response);
            } // RECENTLY VIEWED PRODUCTS..
            elseif ($section == "recently_viewed") {
                $data['r_prods'] = helper::get_recent_viewed($request->cookie('recently_viewed'));

                if (!empty($data['r_prods'])) {
                    $response = (string)view("v1.template.recently_viewed", $data);
                } else {
                    $response = "";
                }
            } // HOT DEALS
            elseif ($section == "hotdeals") {
                $url              = composer_url('deals.php?type=Promotion');
                $prod             = file_get_contents($url);
                $prod             = json_decode($prod);
                $data['hotDeals'] = $prod->return_txt->hits->hits;

                $response = (string)view("v1.template.hotdeals", $data);
            } // NEW PRODUCTS..
            elseif ($section == "trending") {
                //$trending 			= DB::table('gc_log')->distinct()->take(15)->orderBy('_id', 'desc')->lists('_id');
                //$result 			= file_get_contents( composer_url( 'query_ids.php?size=10&ids='.json_encode($trending) ) );
                //$data['trending'] 	= json_decode($result);
                $newPro           = file_get_contents(composer_url('new_prod.php?query={"size":15}'));
                $data['trending'] = json_decode($newPro)->return_txt;

                $response = (string)view("v1.template.trending", $data);
            } // MENU CATEGORY ITEMS, which is being fetch by.. main.js..
            elseif ($section == "pt_vmegamenu") {
                $data['navigation'] = helper::get_categories_tierd(false, 3);

                $response = (string)view("v1.template.menu", $data);
            }

            echo $response;
            exit;
        }
    }

    /**
     * Contact Page Controller for sending mail to the Admin.. and displays the message to the user..
     *
     * @var \Illuminate\Http\Request
     */
    public function contact(Request $request)
    {
        $data = [];
        if ($request->has('name')) {

            Mail::send('emails.contact',
                [
                    'name'         => $request->input('name'),
                    'email'        => $request->input('email'),
                    'user_message' => $request->input('msg')
                ], function ($message) {
                    //echo "<pre>";print_r($message);exit;
                    $message->from('nitish@manyainternational.com', 'contact');
                    $message->to('mitul.mehra@manyainternational.com')
                            ->subject('Contact Us - Indiashopps');
                });

            $data['message'] = "Thank you for contacting us";
        }
        $data['title'] = "Contact | IndiaShopps.com";

        return view('v1.contact', $data);
    }

    /**
     * Career Page for JOB posting..
     *
     */
    public function career()
    {
        $data['title'] = "Career | IndiaShopps.com";

        return view('v1.career', $data);
    }

    /**
     * About US Page for JOB posting..
     *
     */
    public function about()
    {
        $data['title'] = "About | IndiaShopps";

        return view('v1.about', $data);
    }

    public function instagram()
    {
        $data['title'] = "Instagram | IndiaShopps";

        return view('v1.instagram', $data);
    }

    /**
     * Live Search Suggestion using Ajax request on each page,
     *
     * @var \Illuminate\Http\Request
     * @return JSON Response..
     */
    public function livesearch(Request $request)
    {
        $result   = [];
        $cat_file = "categories.json";
        // $this->cat_json();
        $categories = @file_get_contents($cat_file);

        $categories = json_decode($categories);
        echo json_encode($categories);
    }

    /**
     * Create the json file for Live Search Auto Suggestion..
     *
     *
     */
    public function cat_json()
    {
        $cat_file = "categories.json";

        $categories = DB::table('gc_cat')
                        ->where('active', 1)
                        ->where('level', '>', 0)
                        ->get();

        foreach ($categories as $c) {

            $cat = new \stdClass();

            if (stripos($c->group_name, $c->name) == -1) {
                $cat->id    = $c->id;
                $cat->title = ucwords($c->group_name) . " " . ucwords($c->name);
                $data[]     = $cat;
            } else {
                $cat->id    = $c->id;
                $cat->title = ucwords($c->name);
                $data[]     = $cat;
            }
        }
        file_put_contents($cat_file, json_encode($data));
        exit;
    }
}
