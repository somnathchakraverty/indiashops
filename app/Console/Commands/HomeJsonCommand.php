<?php

namespace indiashopps\Console\Commands;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use indiashopps\Category;
use indiashopps\MobilePriceDiff;

use File;
use indiashopps\Models\AmazonDeal;
use indiashopps\Models\DealsCat;
use indiashopps\Models\HomeProduct;
use indiashopps\Models\MostCompareProducts;
use indiashopps\Support\Loan;
use SolrClient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use indiashopps\Events\HomepageJsonGenerated;

class HomeJsonCommand extends Command
{
    const BANK_LOGO = '//www.indiashopps.com/loan-assets/v1/images/bank_logos/{BANK}.jpg';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:home_json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command generates JSON for home page, Version 3..';

    /**
     * List of all the Home Page products in tabs..
     *
     * @var array
     */
    private $home_products = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getHomePageProducts();
        $this->comparison();
        $this->getGroupDeals();
        $this->blogJson();
        $this->getDeals();
        $this->dealOfTheDay();
        $this->phoneDeals();
        $this->upcomingMobiles();
        $this->dealsGadgets();
        $this->topDeals();
        $this->recentlyLanched();
        //$this->bestCoupons();
        //$this->loans();
        $this->loansAllDetail();

        event(new HomepageJsonGenerated());

        $this->info("Total Execution Time.. ::" . (microtime(true) - LARAVEL_START));
    }

    private function getHomePageProducts()
    {
        $products = HomeProduct::select(['product_id', 'section'])
                               ->whereEnabled("Y")
                               ->orderBy('updated_at', 'DESC')
                               ->get();
        $products = $products->groupBy('section');

        foreach ($products as $section => $section_products) {
            $this->home_products[$section] = $section_products->map(function ($product) {
                return $product->product_id;
            })->toArray();
        }
    }

    public function getGroupDeals()
    {
        $sliders = \DB::connection('backend')
                      ->table(\DB::raw('home_top_deals as h'))
                      ->select(\DB::raw('gc_cat.name category, h.image_url, h.alt, h.refer_url'))
                      ->leftJoin('gc_cat', 'gc_cat.id', '=', 'h.category_id')
                      ->where('h.active', '=', 1)
                      ->whereNotIn('category_id',[243])
                      ->orderBy('h.sequence')
                      ->get()
                      ->groupBy('category')
                      ->toArray();

        foreach ($sliders as $category => $s) {
            Cache::forget('group_deals_' . create_slug($category));
            $nslider[create_slug($category)] = $s;
        }

        if (!empty(array_filter($sliders))) {
            Storage::disk('local')->put("JSON/group_deals.json", json_encode($nslider));
        }
    }

    public function getDeals()
    {
        $vendors = [
            'domino\'s',
            'myntra',
            'amazon',
            'foodpanda',
            'flipkart',
            'tata cliq',
            'shopclues',
            'bookmyshow',
            'jabong',
            'pepperfry'
        ];

        $d              = SolrClient::whereIn('vendor_name', $vendors)->whereSize(10)->getCoupons(true);
        $deals['deals'] = $d->return_txt->aggregations->vendor_name->buckets;

        $coupons          = SolrClient::whereSize(10)->whereType('coupon')->getCoupons(true);
        $coupons          = $coupons->return_txt->hits->hits;
        $deals['coupons'] = $this->getCouponData($coupons);

        if (!empty(array_filter($deals))) {
            Storage::disk('local')->put("JSON/deals.json", json_encode($deals));
        }
    }

    public static function searchCoupon($request)
    {
        if (empty($request->all())) {
            return storageJson("JSON/deals.json", 'coupons');
        } else {
            $coupons = SolrClient::whereSize(15)->whereType('coupon');

            if ($request->has('search_text')) {
                $coupons = $coupons->whereQuery($request->search_text);
            }

            if ($request->has('cat_id') && $request->cat_id > 0) {
                $coupons = $coupons->where('cat_id', $request->cat_id);
            }

            $coupons = $coupons->getCoupons(true);
            $coupons = $coupons->return_txt->hits->hits;

            return self::getCouponData($coupons);
        }
    }

    public static function getCouponData($coupons)
    {
        $data = [];

        foreach ($coupons as $coupon) {
            $c = product($coupon);

            $coupon              = new \stdClass;
            $coupon->title       = $c->get('title');
            $coupon->offerid     = $c->get('offerid');
            $coupon->promo       = $c->get('promo');
            $coupon->image       = $c->get('image_url');
            $coupon->vendor_name = $c->get('vendor_name');
            $coupon->category    = $c->get('category');
            $coupon->code        = $c->get('code');
            $coupon->offer_page  = $c->get('offer_page');

            $data[] = $coupon;

        }

        return $data;
    }

    public function loans()
    {
        $personal = SolrClient::forLoan()->take(1)->whereType(Loan::PERSONAL_LOAN)->getLoans();
        $home     = SolrClient::forLoan()->take(1)->whereType(Loan::HOME_LOAN)->getLoans();
        $car      = SolrClient::forLoan()->take(1)->whereType(Loan::CAR_LOAN)->getLoans();

        $data['personal'] = $this->getLoanData($personal);
        $data['home']     = $this->getLoanData($home);
        $data['car']      = $this->getLoanData($car);

        if (!empty(array_filter($data))) {
            Storage::disk('local')->put("JSON/loans.json", json_encode($data));
        }
    }

    private function getLoanData($data)
    {
        $loans = [];
        $index = 1;

        if (isset($data['filters']->bank->buckets)) {
            foreach ($data['filters']->bank->buckets as $l) {
                $bank_id        = config('loans.index.' . $l->key);
                $loan           = new \stdClass;
                $loan->name     = config('loans.banks.' . $bank_id);
                $loan->bank     = $l->key;
                $loan->count    = $l->doc_count;
                $loan->logo     = config('loans.logo.' . $bank_id);
                $loan->interest = round($data['filters']->interest_rate_min->value, 2);

                $loans[] = $loan;

                if ($index++ == 6) {
                    break;
                }
            }

        }

        return $loans;
    }

    public function comparison()
    {
        $ids = MostCompareProducts::all();

        $categories = [
            Category::MOBILE      => 'phone',
           // Category::LAPTOPS     => 'laptops',
           // Category::CAMERAS     => 'cameras',
           // Category::CAMERAS_SLR => 'cameras'
        ];

        foreach ($ids->toArray() as $id) {
            $cat_id = collect(json_decode($id['category_id']))->first();

            if (array_key_exists($cat_id, $categories)) {
                $ids                 = json_decode($id['exist_ids']);
                $category            = $categories[$cat_id];
                $groups[$category][] = implode(":", $ids);
            }
        }

        if (empty($groups)) {
            return false;
        }

        $ids = [];

        foreach ($groups as $compare) {
            foreach ($compare as $value) {
                $value = explode(":", $value);

                if (!in_array($value[0], $ids)) {
                    $ids[] = $value[0];
                }

                if (!in_array($value[1], $ids)) {
                    $ids[] = $value[1];
                }
            }
        }

        $response = SolrClient::whereIds(json_encode($ids))->getCompareList(true);

        if (isset($response->docs)) {
            $products = $response->docs;

            $data['products'] = [];

            foreach ($products as $p) {
                $p = product($p);

                $product['id']        = $p->get('id');
                $product['name']      = $p->get('name');
                $product['price']     = $p->get('price');
                $product['saleprice'] = $p->get('saleprice');
                $product['image_url'] = getImageNew($p->get('image_url'), "S");

                $data['products'][$p->get('id')] = (object)$product;
            }

            foreach ($groups as $key => $compare) {
                $products = [];

                foreach ($compare as $combo) {
                    $ids = explode(":", $combo);

                    if (!isset($data['products'][$ids[0]]) || !isset($data['products'][$ids[1]])) {
                        MostCompareProducts::where('exist_ids', json_encode($ids))->delete();
                        continue;
                    }

                    if (!empty($ids) && is_array($ids) && array_key_exists($ids[0], $data['products']) && array_key_exists($ids[1], $data['products'])) {
                        $group   = [];
                        $group[] = $data['products'][$ids[0]];
                        $group[] = $data['products'][$ids[1]];

                        $products[] = $group;
                    }

                    $gproduct[$key] = $products;
                }
            }

            if (!empty(array_filter($gproduct))) {
                Storage::disk('local')->put("JSON/comparison.json", json_encode($gproduct));
            }
        }
    }

    private function topDeals()
    {
        $sections = ['headphones', 'speakers', 'smart_wearables'];

        foreach ($sections as $section) {
            $product_ids    = json_encode($this->home_products[$section]);
            $result         = app('solr')->whereIds($product_ids)->getCompareList(true);
            $data[$section] = $this->getMappedProducts($result->docs, false);
        }

        foreach ($data as $cat => $products) {
            foreach ($products as $key => $product) {
                if (is_array($product)) {
                    $product = (object)$product;
                }

                if (isset($product->price) && $product->price > $product->saleprice) {
                    $product->discount = $product->price - $product->saleprice;
                } else {
                    $product->discount = 0;
                }
            }

            $data[$cat] = $products;
        }

        if (!empty(array_filter($data))) {
            Storage::disk('local')->put("JSON/top_deals.json", json_encode($data));
        }
    }

    private function dealsGadgets()
    {
        $sections = ['tablets', 'laptops', 'cameras'];

        foreach ($sections as $section) {
            $product_ids    = json_encode($this->home_products[$section]);
            $result         = app('solr')->whereIds($product_ids)->getCompareList(true);
            $data[$section] = $this->getMappedProducts($result->docs, false);
        }

        foreach ($data as $cat => $products) {
            foreach ($products as $key => $product) {
                if (isset($product->price) && $product->price > $product->saleprice) {
                    $product->discount = $product->price - $product->saleprice;
                } else {
                    $product->discount = 0;
                }
            }

            $data[$cat] = $products;
        }

        if (!empty(array_filter($data))) {
            Storage::disk('local')->put("JSON/deal_gadgets.json", json_encode($data));
        }
    }

    private function phoneDeals()
    {
        $products_ids = $this->home_products['mobiles'];
        $products     = app('solr')->whereIds(json_encode($products_ids))->getCompareList(true);
        $products     = $this->getMappedProducts($products->docs);

        if (!empty(array_filter($products))) {
            Storage::disk('local')->put("JSON/deals_on_phone.json", json_encode($products));
        }
    }

    private function upcomingMobiles()
    {
        $products_ids = $this->home_products['upcoming_mobiles'];
        $products     = app('solr')->whereIds(json_encode($products_ids))->getCompareList(true);
        $products     = $this->getMappedProducts($products->docs, false);

        if (!empty(array_filter($products))) {
            Storage::disk('local')->put("JSON/upcoming_mobiles.json", json_encode($products));
        }
    }

    private function recentlyLanched()
    {
        $products_ids = $this->home_products['recently_lanched'];
        $products     = app('solr')->whereIds(json_encode($products_ids))->getCompareList(true);
        $products     = $this->getMappedProducts($products->docs, false);

        if (!empty(array_filter($products))) {
            Storage::disk('local')->put("JSON/recently_lanched.json", json_encode($products));
        }
    }

    private function phoneDealsOld()
    {
        $brands = ['apple', 'xiaomi', 'samsung', 'oppo', 'lenovo', 'sony'];

        $data = SolrClient::whereIn('brand', $brands)
                          ->whereCategoryId(Category::MOBILE)
                          ->whereSalepriceMin(0)
                          ->whereSalepriceMax(10000)
                          ->param('total', 8)
                          ->getBrandWise(true);

        $result['below_ten'] = $this->getBrandProducts($data);

        $data = SolrClient::whereIn('brand', $brands)
                          ->whereCategoryId(Category::MOBILE)
                          ->whereSalepriceMin(10001)
                          ->whereSalepriceMax(15000)
                          ->param('total', 8)
                          ->getBrandWise(true);

        $result['below_fifteen'] = $this->getBrandProducts($data);

        $data = SolrClient::whereIn('brand', $brands)
                          ->whereCategoryId(Category::MOBILE)
                          ->whereSalepriceMin(15001)
                          ->whereSalepriceMax(20000)
                          ->param('total', 8)
                          ->getBrandWise(true);

        $result['below_twenty'] = $this->getBrandProducts($data);

        $data = SolrClient::whereIn('brand', $brands)
                          ->whereCategoryId(Category::MOBILE)
                          ->whereSalepriceMin(20001)
                          ->whereSalepriceMax(25000)
                          ->param('total', 8)
                          ->getBrandWise(true);

        $result['below_twentyfive'] = $this->getBrandProducts($data);

        $data = SolrClient::whereIn('brand', $brands)
                          ->whereCategoryId(Category::MOBILE)
                          ->whereSalepriceMin(25000)
                          ->whereSalepriceMax(30000)
                          ->param('total', 8)
                          ->getBrandWise(true);

        $result['below_thirty'] = $this->getBrandProducts($data);

        $data = SolrClient::whereIn('brand', $brands)
                          ->whereCategoryId(Category::MOBILE)
                          ->whereSalepriceMin(30001)
                          ->param('total', 8)
                          ->getBrandWise(true);

        $result['above_thirty'] = $this->getBrandProducts($data);

        if (!empty(array_filter($result))) {
            Storage::disk('local')->put("JSON/deals_on_phone.json", json_encode($result));
        }
    }

    private function getMappedProducts($products, $brands = true)
    {
        $map_products = [];

        foreach ($products as $p) {
            if (isset($p->_source)) {
                $product['id']          = $p->_source->id;
                $product['name']        = $p->_source->name;
                $product['mini_spec']   = isset($p->_source->mini_spec) ? $p->_source->mini_spec : '';
                $product['price']       = $p->_source->price;
                $product['saleprice']   = $p->_source->saleprice;
                $product['category_id'] = $p->_source->category_id;
                $product['category']    = $p->_source->category;
                $product['grp']         = ($p->_source->grp) ? $p->_source->grp : '';
                $product['vendor']      = ($p->_source->vendor) ? $p->_source->vendor : '';
                $product['image_url']   = getImageNew($p->_source->image_url, 'M');
                $product['rating']      =  isset($p->_source->rating) ? $p->_source->rating:0;

                if (array_key_exists($p->_source->category_id, config('product_names.category'))) {
                    $key = 'product_names.category.' . $p->_source->category_id;
                    foreach (config($key) as $attrib => $text) {
                        if (isset($p->_source->{$attrib}) && !empty($p->_source->{$attrib})) {
                            $product[$attrib] = $p->_source->{$attrib};
                        }
                    }
                }

                if ($brands) {
                    $map_products[$p->_source->brand][] = (object)$product;
                } else {
                    $map_products[] = (object)$product;
                }
            }
        }

        return $map_products;
    }

    private function getBrandProducts($result)
    {
        $products = [];

        foreach ($result as $brand => $data) {
            $data = $data->hits->hits;

            foreach ($data as $hits) {
                $product['id']          = $hits->_source->id;
                $product['name']        = $hits->_source->name;
                $product['mini_spec']   = isset($hits->_source->mini_spec) ? $hits->_source->mini_spec : '';
                $product['price']       = $hits->_source->price;
                $product['saleprice']   = $hits->_source->saleprice;
                $product['category_id'] = $hits->_source->category_id;
                $product['category']    = $hits->_source->category;
                $product['grp']         = ($hits->_source->grp) ? $hits->_source->grp : '';
                $product['vendor']      = ($hits->_source->vendor) ? $hits->_source->vendor : '';
                $product['image_url']   = getImageNew($hits->_source->image_url, 'M');

                if (array_key_exists($hits->_source->category_id, config('product_names.category'))) {
                    $key = 'product_names.category.' . $hits->_source->category_id;
                    foreach (config($key) as $attrib => $text) {
                        if (isset($hits->_source->{$attrib}) && !empty($hits->_source->{$attrib})) {
                            $product[$attrib] = $hits->_source->{$attrib};
                        }
                    }
                }

                $products[$brand][] = (object)$product;
            }
        }

        return $products;
    }

    public static function searchDealOfTheDay($request)
    {
        $self = new self();

        return $self->dealOfTheDay($request);
    }

    private function dealOfTheDay($request = '')
    {
        if (Schema::hasTable('amazon_deals')) {

            $deals = AmazonDeal::select(\DB::raw('gc_cat.name cname, gc_cat.group_name as group_name, amazon_deals.*'))
                               ->leftJoin('gc_cat', 'gc_cat.id', '=', 'amazon_deals.category_id')
                               ->take(10)
                               ->orderBy(\DB::raw('RAND()'));

            if ($request instanceof Request && $request->has('search_text')) {
                $products = [];
                if ($request->has('cat_id') && !empty($request->cat_id)) {
                    $deals = $deals->whereGroupId($request->cat_id);
                }

                $deals = $deals->where(\DB::raw('amazon_deals.name'), 'LIKE', '%' . $request->search_text . '%');
            } else {
                $deals = $deals->whereIn('group_id', Category::GROUPS);
            }

            $deals = $deals->get();

            foreach ($deals as $deal) {
                $product['id']          = $deal->ref_id;
                $product['name']        = $deal->name;
                $product['price']       = $deal->price;
                $product['saleprice']   = $deal->saleprice;
                $product['discount']    = $deal->discount;
                $product['group_id']    = $deal->group_id;
                $product['category_id'] = $deal->category_id;
                $product['category']    = $deal->cname;
                $product['grp']         = $deal->group_name;
                $product['product_url'] = $deal->product_url;
                $product['vendor']      = 3;
                $product['image_url']   = getImageNew($deal->image_url, 'M');

                $products[] = (object)$product;
            }

            if ($request instanceof Request && $request->has('search_text')) {
                return $products;
            }

            if (!empty(array_filter($products))) {
                Storage::disk('local')->put("JSON/deal_of_the_day.json", json_encode($products));
            }
        }
    }

    private function blogJson()
    {
        $posts = \DB::connection('blog')
                    ->select("select A.post_name, A.post_title, A.post_title,  C.meta_value as path, U.display_name author, A.post_date from yosfj_posts A,yosfj_postmeta B,yosfj_postmeta C, yosfj_users U where A.ID=B.post_id and B.meta_key like '_thumbnail_id' AND B.meta_value=C.post_id and C.meta_key like '_wp_attached_file' AND A.post_type like 'post' and A.post_status like 'publish' AND A.post_author = U.ID order by post_date desc limit 0,10");

        if (!is_null($posts)) {
            Storage::disk('local')->put("JSON/blog.json", json_encode($posts));
        }
    }

    public static function homePageContent()
    {
        if (isAmpPage()) {
            $cache_key = "home_page_html_amp";
        } elseif (isMobile()) {
            $cache_key = "home_page_html_mobile";
        } else {
            $cache_key = "home_page_html";
        }

        $home_cached_data = Cache::remember($cache_key, 43200, function () {

            $html = [];

            $sections = [
                'trending_of_the_day',
                'deals_on_gadgets',
                'top_deals_acc',
                'trending_comp',
                'group_deals',
                'deals_on_phone',
                'upcoming_mobiles',
                'recently_lanched',
                'coupons',
                'finance_service',
                'gadget_tips',
                'partner_deals'
            ];

            foreach ($sections as $section) {
                switch ($section) {
                    case 'trending_of_the_day':
                        $data['section']  = 'deal_of_the_day';
                        $data['key']      = '';
                        $data['variable'] = 'products';
                        $data['type']     = 'widget';

                        break;

                    case 'deals_on_gadgets':
                        $data['section']  = 'deal_gadgets';
                        $data['key']      = '';
                        $data['variable'] = 'products';
                        $data['type']     = 'widget';

                        break;

                    case 'deals_on_phone':
                        $data['section']  = 'deals_on_phone';
                        $data['key']      = '';
                        $data['type']     = 'widget';
                        $data['variable'] = 'vendors';
                        $data['tab']      = '1';

                        break;

                    case 'upcoming_mobiles':
                        $data['section']  = 'upcoming_mobiles';
                        $data['key']      = '';
                        $data['type']     = 'widget';
                        $data['variable'] = 'products';
                        $data['tab']      = '1';

                        break;

                    case 'recently_lanched':
                        $data['section']  = 'recently_lanched';
                        $data['key']      = '';
                        $data['type']     = 'widget';
                        $data['variable'] = 'products';
                        $data['tab']      = '1';

                        break;

                    case 'trending_comp':
                        $data['section']  = 'comparison';
                        $data['key']      = '';
                        $data['variable'] = 'products';
                        $data['type']     = 'widget';

                        break;

                    case 'top_deals_acc':
                        $data['section']  = 'top_deals';
                        $data['key']      = '';
                        $data['type']     = 'widget';
                        $data['variable'] = 'products';

                        break;

                    case 'group_deals':
                        $json             = storageJson(self::getJsonFile('group_deals'));
                        $data['groups']   = collect($json)->keys();
                        $data['section']  = 'group_deals';
                        $data['key']      = '';
                        $data['type']     = 'widget';
                        $data['variable'] = 'slides';
                        break;

                    case 'partner_deals':
                        $data['section']  = 'deals';
                        $data['key']      = 'deals';
                        $data['type']     = 'widget';
                        $data['variable'] = 'deals';

                        break;

                    case 'coupons':
                        $data['cats']    = DealsCat::select(['id', 'name'])->get();
                        $data['coupons'] = storageJson("JSON/deals.json", 'coupons');
                        $data['type']    = '';

                        if (isAmpPage()) {
                            $html[$section] = (string)view('v3.amp.widget.coupons.content', $data);
                        } elseif (isMobile()) {
                            $html[$section] = (string)view('v3.mobile.widget.coupons.content', $data);
                        } else {
                            $html[$section] = (string)view('v3.home.snippet.coupons', $data);
                        }

                        break;

                    case 'finance_service':
                        $data['section']   = 'loans';
                        $data['key']       = '';
                        $data['type']      = 'widget';
                        $data['variable']  = 'loans';
                        $data['loan_type'] = "personal";

                        break;

                    case 'gadget_tips':
                        $data['section']  = 'blog';
                        $data['key']      = '';
                        $data['variable'] = 'blogs';
                        $data['type']     = '';

                        if (isAmpPage()) {
                            $data['view'] = 'v3.amp.widget.gadget_tips';
                        } elseif (isMobile()) {
                            $data['view'] = 'v3.home.snippet.mobile.gadget_tips';
                        } else {
                            $data['view'] = 'v3.home.snippet.gadget_tips';
                        }

                        break;

                    case 'partner_deals':
                        $data['section']  = 'deals';
                        $data['key']      = 'deals';
                        $data['type']     = 'widget';
                        $data['variable'] = 'deals';

                        break;

                    default:

                        $html = '';
                        break;
                }

                if (@$data['type'] == 'widget') {
                    $html[$section] = self::getWidgetContent($data);
                }

                if (isset($data['view']) && $data['type'] != 'widget') {
                    $html[$section] = self::cacheContent($data, $data['variable']);
                }
            }

            if (isAmpPage()) {
                $cached_html = view('v3.amp.home.cache', $html)->render();
            } elseif (isMobile()) {
                $groups         = storageJson("JSON/group_deals.json");
                $html['groups'] = collect($groups)->keys();
                $cached_html    = view('v3.mobile.home.cache', $html)->render();
            } else {
                $cached_html = view('v3.home.cache', $html)->render();
            }

            return $cached_html;
        });

        return $home_cached_data;
    }

    public static function getJsonFile($name)
    {
        return "JSON/" . $name . ".json";
    }

    private static function getWidgetContent(&$data)
    {
        $var = storageJson(self::getJsonFile($data['section']), $data['key']);

        if ($var) {
            return getAjaxWidget($data['section'], $var, $data['variable'], $data);
        } else {
            return false;
        }
    }

    private static function cacheContent(&$data, $variable = 'products')
    {
        if (isAmpPage()) {
            $cache_key = 'home_' . $data['section'] . "_" . $data['key'] . "_amp";
        } elseif (isMobile()) {
            $cache_key = 'home_' . $data['section'] . "_" . $data['key'] . "_mobile";
        } else {
            $cache_key = 'home_' . $data['section'] . "_" . $data['key'];
        }

        if (env('APP_ENV') == 'local' && env('CACHE_SECTIONS') === false) {
            $data[$variable] = storageJson("JSON/" . $data['section'] . ".json", $data['key']);
            $html            = (string)view($data['view'], $data);

            return $html;
        } else {
            $html = Cache::remember($cache_key, 3600, function () use ($data, $variable) {
                $data[$variable] = storageJson("JSON/" . $data['section'] . ".json", $data['key']);
                $html            = (string)view($data['view'], $data);

                return $html;
            });

            return $html;
        }
    }

    public function loansAllDetail()
    {
        $personal = SolrClient::forLoan()->whereType(Loan::PERSONAL_LOAN)->getLoans();
        $home     = SolrClient::forLoan()->whereType(Loan::HOME_LOAN)->getLoans();
        $car      = SolrClient::forLoan()->whereType(Loan::CAR_LOAN)->getLoans();

        $data['personal'] = $this->getLoanDataAll($personal);
        $data['home']     = $this->getLoanDataAll($home);
        $data['car']      = $this->getLoanDataAll($car);

        if (!empty(array_filter($data))) {
            Storage::disk('local')->put("JSON/loans_all_details.json", json_encode($data));
        }
    }

    private function getLoanDataAll($data)
    {
        $loans_detail = [];
        if (isset($data['data'])) {
            foreach ($data['data'] as $row) {
                $loan['bank']        = $row->_source->bank;
                $loan['bank_id']     = $row->_source->bank_id;
                $loan['type']        = $row->_source->type;
                $loan['features']    = $row->_source->features;
                $loan['eligibility'] = $row->_source->eligibility;
                $loan['document']    = $row->_source->document;
                $loan['key_note']    = $row->_source->key_note;
                $loans_detail[]      = $loan;
            }
        }
        return $loans_detail;
    }

    public function bestCoupons()
    {
        $recharge      = SolrClient::whereCategory('recharge')->getCoupons();
        $fashion       = SolrClient::whereCategory('fashion')->getCoupons();
        $recent_offers = SolrClient::getCoupons();

        $deals['coupons']['recharge'] = $this->getBestCouponsRecharge($recharge);
        $deals['coupons']['fashion']  = $this->getBestCouponsFashion($fashion);

        $deals['coupons']['recent_offers'] = $this->getRecentOffers($recent_offers);

        if (!empty(array_filter($deals))) {
            Storage::disk('local')->put("JSON/best_coupons.json", json_encode($deals));
        }
    }

    public static function getBestCouponsRecharge($data)
    {
        $best_coupons = [];
        if (isset($data['data'])) {
            foreach ($data['data'] as $row) {
                $coupons['title']       = $row->_source->title;
                $coupons['image_url']   = $row->_source->image_url;
                $coupons['vendor_name'] = $row->_source->vendor_name;
                $coupons['category']    = $row->_source->category;
                $coupons['code']        = $row->_source->code;
                $coupons['offer_page']  = $row->_source->offer_page;
                $best_coupons[]         = $coupons;
            }
        }
        return $best_coupons;
    }

    public static function getBestCouponsFashion($data)
    {
        $best_coupons = [];
        if (isset($data['data'])) {
            foreach ($data['data'] as $row) {
                $coupons['offerid']     = $row->_source->offerid;
                $coupons['offer_name']  = $row->_source->offer_name;
                $coupons['title']       = $row->_source->title;
                $coupons['description'] = $row->_source->description;
                $coupons['offer_page']  = $row->_source->offer_page;
                $coupons['vendor_name'] = $row->_source->vendor_name;
                $coupons['image_url']   = $row->_source->image_url;
                $best_coupons[]         = $coupons;
            }
        }
        return $best_coupons;
    }

    public static function getRecentOffers($data)
    {
        $recent_offers = [];
        if (isset($data['data'])) {
            foreach ($data['data'] as $row) {
                $coupons['offerid']     = $row->_source->offerid;
                $coupons['offer_name']  = $row->_source->offer_name;
                $coupons['title']       = $row->_source->title;
                $coupons['description'] = $row->_source->description;
                $coupons['offer_page']  = $row->_source->offer_page;
                $coupons['vendor_name'] = $row->_source->vendor_name;
                $coupons['code']        = $row->_source->code;
                $coupons['image_url']   = $row->_source->image_url;
                $recent_offers[]        = $coupons;
            }
        }
        return $recent_offers;
    }
}
