<?php namespace indiashopps\Http\Controllers;

use DB;
use indiashopps\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;
use indiashopps\Helpers\Helper;
use Jenssegers\Agent\Agent as Agent;
use indiashopps\Logs;

class ListingController extends Controller
{

    /**
     * PRODUCT LISTING Page.... for Comparitive and Non-comparitive categories..
     *
     * @var \Illuminate\Http\Request
     * @var Parent Category Name
     * @var Middle Category Name
     * @var Child Category Name
     * @var Page Number
     */

    public function productList(Request $request, $parent = false, $cname = false, $child = false, $page = 0)
    {
        //Create a unique token from the current user session to send the UNIQUE ID to solr for consistance product listing..
        //print_r($parent);echo "<br>cname - ";print_r($cname);echo "<br>child - ";print_r($child);exit;

        $token      = $request->session()->get('_token');
        $session_id = preg_replace("/[^0-9,.]/", '', $token);
        $parent_id  = false; // Parent ID is made false for the search page, so that it doesn't redirect..
        $cat        = false;

        /**********************Redirects SEO Purpose****************************************/
        if ($parent == 'home') {
            return redirect(url('home-decor/' . $cname), 301);
        }
        if ($cname == 'sports-shoe-price-list-in-india') {
            return redirect(url($parent . '/shoes/sports-shoes-price-list-in-india.html'), 301);
        } else {
            if ($cname == 'led-price-list-in-india') {
                return redirect(url($parent . '/lcd-led-tvs/led-tv-price-list-in-india.html'), 301);
            } else {
                if ($cname == 'plasma-price-list-in-india') {
                    return redirect(url($parent . '/lcd-led-tvs/led-tv-price-list-in-india.html'), 301);
                } else {
                    if ($cname == 'lcd-price-list-in-india') {
                        return redirect(url($parent . '/lcd-led-tvs/led-tv-price-list-in-india.html'), 301);
                    } else {
                        if ($cname == 'security-systems-price-list-in-india') {
                            return redirect(url($parent . '/security-system-gadgets-price-list-in-india.html'), 301);
                        } else {
                            if ($cname == 'mobile-chargers-price-list-in-india') {
                                return redirect(url($parent . '/mobile-accessories/chargers-price-list-in-india.html'), 301);
                            } else {
                                if ($cname == 'mobile-battery-price-list-in-india') {
                                    return redirect(url($parent . '/mobile-accessories/battery-price-list-in-india.html'), 301);
                                } else {
                                    if ($cname == 'smart-watches-price-list-in-india' and $parent == "mobile") {
                                        return redirect(url('electronics/smart-wearable/smart-watches-price-list-in-india.html'), 301);
                                    } else {
                                        if ($cname == 'smart-bands-price-list-in-india' and $parent == "mobile") {
                                            return redirect(url('electronics/smart-wearable/smart-bands-price-list-in-india.html'), 301);
                                        } else {
                                            if ($cname == 'networking-price-list-in-india' and $parent == "computers") {
                                                return redirect(url('computers/networking-devices-price-list-in-india.html'), 301);
                                            } else {
                                                if ($cname == 'gear-price-list-in-india' and $parent == "kids") {
                                                    return redirect(url('kids/baby-gear-price-list-in-india.html'), 301);
                                                } else {
                                                    if ($cname == 'accessories-price-list-in-india' and $parent == "kids") {
                                                        return redirect(url('kids/kid-accessories-price-list-in-india.html'), 301);
                                                    } else {
                                                        if ($cname == 'sports-price-list-in-india' and $parent == "sports-fitness") {
                                                            return redirect(url('sports-fitness/sports-products-goods-price-list-in-india.html'), 301);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($child == "networking" and $parent == "computers") {
            return redirect(url($parent . '/networking-devices/' . $cname . ".html"), 301);
        } elseif ($child == "gear" and $parent == "kids") {
            return redirect(url($parent . '/baby-gear/' . $cname . ".html"), 301);
        } elseif ($child == "accessories" and $parent == "kids") {
            return redirect(url($parent . '/kid-accessories/' . $cname . ".html"), 301);
        } elseif ($child == "sports" and $parent == "sports-fitness") {
            return redirect(url($parent . '/sports-products-goods/' . $cname . ".html"), 301);
        }

        /**********************Redirects SEO Purpose****************************************/
        if ($parent == 'product' || $parent == 'coupon' || $parent == 'cdn-cgi' || $parent == 'category') {
            abort(404);
        }
        //Checks whether SEO URL is enabled or not and redirect according to the listing page.
        if (config('app.seoEnable') && $parent) {
            $cname = explode(config('app.seoURL'), $cname);

            if (!isset($cname[1])) {
                $parent_id = $this->getCatIDByName($parent);

                if ($child !== false) {
                    $parent_id = $this->getCatIDByName($child, $parent_id);
                }

                $child_id = $this->getCatIDByName($cname[0], $parent_id);

                if (empty($parent_id) || empty($child_id)) {
                    abort(404);
                }

                if ($child !== false) {
                    return redirect('/' . $parent . "/" . $child . "/" . $cname[0] . config('app.seoURL') . ".html", 301);
                } else {
                    return redirect('/' . $parent . "/" . $cname[0] . config('app.seoURL') . ".html", 301);
                }
            } else {
                $cname = $cname[0];
            }
        } else {
            $cname = explode(config('app.seoURL'), $cname);

            if (isset($cname[1])) {
                return redirect('/' . $parent . "/" . $cname[0], 301);
            }

            $cname = $cname[0];
        }
        $data['parent'] = $parent;
        $data['child']  = $child;
        //print_r($parent);echo "<br>cname - ";print_r($cname);echo "<br>child - ";print_r($child);exit;

        /// GET the category IDs with CATEGORY Name ( Third Level Categories )
        if ($parent && $child && $cname) {
            $parent_id = $this->getCatIDByName($parent);
            $child_id  = $this->getCatIDByName($child, $parent_id);
            $cat       = $this->getCatIDByName($cname, $child_id);
        } /// GET the category IDs with CATEGORY Name ( Second Level Categories )
        elseif ($parent && $cname) {
            $parent_id = $this->getCatIDByName($parent);
            $cat       = $this->getCatIDByName($cname, $parent_id);
        }
        $data['isSearch'] = true;
        if (in_array($cat, config('vendor.comparitive_category'))) {
            $data['isSearch'] = false;
        }

        /// GET the category IDs if BRAND name is provided with the CATEGORY Name..
        if (empty($cat) && $parent_id) {
            $cname = str_replace("---", "--", $cname);
            $parts = explode("--", $cname);
            if ($parts[0] == "smartphone") {
                $data['type'] = "Smartphone";
            } elseif ($parts[0] == "dual-sim-phones") {
                $data['SIM_type'] = "Dual";
            } elseif ($parts[0] == "android_phones") {
                $data['OS'] = "Android";
            } elseif ($parts[0] == "windows_phones") {
                $data['OS'] = "Windows";
            } elseif (!$request->has('ajax')) {
                $brand = str_replace("-", " ", $parts[0]);

                if (isset($parts[1])) {
                    $category = $this->getGroupName($parts[1]);
                    if (in_array($category->id, config('vendor.comparitive_category'))) {
                        return redirect(route('brand_category_list_comp', [
                            create_slug($brand),
                            $parts[1],
                            $category->id
                        ]), 301);
                    } else {
                        return redirect(route('brand_category_list', [
                            create_slug($brand),
                            create_slug($category->group_name),
                            $parts[1]
                        ]), 301);
                    }
                }
            }
            //echo $brand;exit;
            unset($parts[0]);
            $part = implode("-", $parts);
            if ($part == "mobile-battery") {
                return redirect(url($parent . '/mobile-accessories/' . $brand . '--battery-price-list-in-india.html'));
            } elseif ($part == "mobile-chargers") {
                return redirect(url($parent . '/mobile-accessories/' . $brand . '--chargers-price-list-in-india.html'));
            } elseif ($part == 'sports-shoe') {
                return redirect(url($parent . '/shoes/' . $brand . '--sports-shoes-price-list-in-india.html'));
            } else {
                if ($part == 'smart-watches' and $parent == "mobile") {
                    return redirect(url('electronics/smart-wearable/' . $brand . '--smart-watches-price-list-in-india.html'));
                } else {
                    if ($part == 'smart-bands' and $parent == "mobile") {
                        return redirect(url('electronics/smart-wearable/' . $brand . '--smart-bands-price-list-in-india.html'));
                    }
                }
            }
            if (!empty($child_id)) {
                $cat = $this->getCatIDByName($part, $child_id);
            } else {
                $cat = $this->getCatIDByName($part, $parent_id);
            }
        }

        if (($parent_id || isset($child_id)) && empty($cat)) {
            abort(404);
        }


        //Adds all the FILTER FIELDS to an ARRAY to be send to SOLR query..
        if ($request->has('price_filter') || $request->has('ajax')) {
            $data['isSearch'] = true;
            foreach ($request->all() as $field => $value) {
                $data[$field] = $value;
            }
        }

        // Search Page Query fields..
        if ($request->has('search_text')) {
            $data['query'] = urlencode($request->input('search_text'));
            if ($request->has('group')) {
                $data['group'] = ($request->input('group'));
            }
            if ($request->has('parent_category')) {
                $data['parent_category'] = ($request->input('parent_category'));
            }


            //print_r($data);exit;
        }


        if ($request->has('cat_id')) {
            $data['category_id'] = $request->cat_id;
        }

        if (!empty($session_id) && is_numeric($session_id)) {
            $data['session_id'] = $session_id;
        }
        //dd($cat);
        //Create the Category Chain and send it to view for nested Categories
        if ($cat) {
            $controller          = new ProductController;
            $cats                = $controller->createChain($cat);
            $data['category_id'] = $cats;
            $data['c_name']      = $controller->getCatName($cats)[0];
        }

        $data['size'] = 30;
        $data['page'] = $page;
        $data['from'] = ($data['size'] * $page);

        //If the CATEGORY belong to books, then change the SOLR index...

        if ($parent == "books" || $request->input('group') == "Books") {
            $searchAPI     = composer_url('books.php');
            $data['group'] = "Books";
        } else {
            $searchAPI = composer_url('search.php');
        }

        if ($request->has('upcoming-mobiles')) {
            $data['availability'] = 'Coming Soon';
            $data['category_id']  = '351';
        }

        //Adding the Sorting parameters for PRODUCT LIST..
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            $sort = explode("-", $sort);

            if ($sort[0] != "f" && $sort[0] != "d") {
                $field = ["s" => "saleprice", "d" => "discount"];
                $order = ["a" => "asc", "d" => "desc"];

                $data['order_by']   = $field[$sort[0]];
                $data['sort_order'] = $order[$sort[1]];
            } else {
                if ($sort[0] == "f") {
                    $data['order_by']   = "id";
                    $data['sort_order'] = "desc";
                }
            }
        } else {
            if (!$data['isSearch']) {
                $data['order_by']   = "id";
                $data['sort_order'] = "desc";
            }
        }

        if ($request->has('vendor')) {
            $data['vendor'] = $request->vendor;
        }

        if (!$child && (strpos($cname, 'mobiles') === false) && (strpos($cname, 'tablets') === false) && (strpos($cname, 'laptops') === false)) {
            $data['brand_min_doc_count'] = 500;
        }
        $data['sort'] = $request->input('sort');
        $data['term'] = json_encode($data); // Preparing data to be sent to SOLR..

        // GET PRODUCT Data from SOLR..
        //print_r($data);exit;
        // echo $searchAPI.'?query='.urlencode($data['term']);exit;
        $result = file_get_contents($searchAPI . '?query=' . urlencode($data['term']));
        //echo "<pre>";print_r($result);exit;
        if (!$request->has('ajax')) {
            /*****Snippet Data******/
            $data['order_by']   = "id";
            $data['sort_order'] = "desc";
            $data['size']       = 10;
            $data['snippet']    = true;
            $data['brand']      = (isset($brand)) ? $brand : "";
            //print_r($data);exit;
            $data['term'] = json_encode($data);
            //echo $searchAPI.'?query='.urlencode($data['term']);exit;
            $snippet = file_get_contents($searchAPI . '?query=' . urlencode($data['term']));
            if (json_decode($snippet) != null) {
                $snippet                  = json_decode($snippet);
                $data['snippet']          = $snippet->return_txt->hits->hits;
                $data['sn_numberOfItems'] = $snippet->return_txt->hits->total;
            }

            //echo "<pre>";print_r($snippet);exit;
            /*****Snippet Data******/
        }
        $return = json_decode($result);
        $result = $return->return_txt;
        if ($request->has('description') || $request->has('title')) {
            $data['description'] = $request->input('description');
            $data['title']       = $request->input('title');
            $data['text']        = $request->input('text');
            $data['keyword']     = $request->input('keyword');
            $data['h1']          = $request->input('h1');
        }
        // Pre-defined price filter for price comparition in below funcitons.. bBrandPhone, bbetPhones, bestPhone..
        if ($request->has('price_filter') && isset($result->aggregations->filters_all) && !$request->has('ajax')) {
            unset($result->aggregations->filters_all->doc_count);
            $data['facets'] = $result->aggregations->filters_all;
        } else {
            $data['facets'] = $result->aggregations;
        }

        //Sending Product data to VIEWS.....
        $data['product']  = $result->hits->hits;
        $data['minPrice'] = $result->aggregations->saleprice_min->value;
        $data['maxPrice'] = $result->aggregations->saleprice_max->value;
        $data['scat']     = $cat;

        if (@$data['group'] != "Books") {
            $facet['group'] = $result->aggregations->grp->buckets;
            $data['book']   = false;
        } else {
            $data['book']     = true;
            $data['isSearch'] = false;
        }
        if ($data['isSearch'] && !$request->has('cat_id')) {

            $data['facets']->categories = $result->aggregations->grp->buckets;
        } else {
            $data['facets']->categories = "";
        }

        if (isset($cat)) {
            $list_desc = DB::table('gc_cat')->where('id', $cat)->select('meta', 'seo_title')->first();
            //dd($list_desc);
            if (!empty($list_desc->meta)) {
                $data['list_desc'] = json_decode($list_desc->meta);
            }
            //echo "<pre>";print_r($data);exit;
            if (isset($data['list_desc']->description) && !empty($data['list_desc']->description)) {
                $data['description'] = $data['list_desc']->description;
            }
            if (!empty($list_desc->seo_title)) {
                $data['title'] = $list_desc->seo_title;
            }

        }
        //Preparing AJAX response once filter is applied.... JSON Response
        if ($request->has('filter') && $request->input('filter') == "true") {

            $json['products'] = (string)view("v1.productlist", $data);
            $json['products'] = preg_replace('/(\v)+/', '', $json['products']);
            $json['products'] = str_replace("\t", "", $json['products']);
            $json['facet']    = $result->aggregations;

            if (isset($return->filter_applied)) {
                $json['facet']->filter_applied = $return->filter_applied;
            }
            echo json_encode($json);
        } else {
            // echo "<pre>";print_r($data);exit;
            // Render the product listing page..
            return view("v1.productlist", $data);
        }
    }

    /**
     * Custom Snippets..
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     */
    public function brandwise_sports_shoes_for(Request $request, $brand = false, $group = false, $page = 0)
    {
        return redirect()->route('brands.listing', [
            cs($group),
            cs($brand),
            cs('sports shoes')
        ], 301);
    }

    /**
     * Custom Links
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     */
    public function smartphone(Request $request, $page = 0)
    {
        return redirect(route('sub_category', ['mobile', 'mobiles']), 301);

        if (isset($description) && isset($title)) {
            $request->request->add(['description' => $description, 'title' => $title]);
        } else {
            $title = "SmartPhone";
            $request->request->add(['title' => $title]);
        }
        return $this->productList($request, "mobile", "smartphone--mobiles-price-list-in-india", false, $page);
    }

    /**
     * Custom Links
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     */
    public function dual_sim(Request $request, $page = 0)
    {
        if (isset($description) && isset($title)) {
            $request->request->add(['description' => $description, 'title' => $title]);
        } else {
            $title = "Dual SIM Phones";
            $request->request->add(['title' => $title]);
        }
        return $this->productList($request, "mobile", "dual-sim-phones--mobiles-price-list-in-india", false, $page);
    }

    /**
     * Custom Links
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     */
    public function android_phones(Request $request, $page = 0)
    {
        if (isset($description) && isset($title)) {
            $request->request->add(['description' => $description, 'title' => $title]);
        } else {
            $title = "Android Phones";
            $request->request->add(['title' => $title]);
        }
        return $this->productList($request, "mobile", "android_phones--mobiles-price-list-in-india", false, $page);
    }

    /**
     * Custom Links
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     */
    public function windows_phones(Request $request, $page = 0)
    {
        if (isset($description) && isset($title)) {
            $request->request->add(['description' => $description, 'title' => $title]);
        } else {
            $title = "Windows Phones";
            $request->request->add(['title' => $title]);
        }
        return $this->productList($request, "mobile", "windows_phones--mobiles-price-list-in-india", false, $page);
    }

    /**
     * Flipkart big billionSale Page..
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     */
    public function bbillionSale(Request $request, $page = 0)
    {
        $data['title'] = "Flipkart | The Big Billion Day Sale is back. Itne mein Itnaa.";

        return view("v1.sale.bbillion-sale", $data);
    }

    /**
     * Amazon The Great Indian Festival Sale Page..
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     */
    public function amazonfestivalSale(Request $request, $page = 0)
    {
        $data['title'] = "Amazon | The Great Indian Festival Sale";

        return view("v1.sale.amazonfestival-sale", $data);
    }

    /**
     * Flipkart Sale Page..
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     */
    public function flipkartSale(Request $request, $page = 0)
    {
        $data['title'] = "Flipkart Freedom Sale | Great offers and Extra 10% Discount Via HDFC Credit & Debit Cards on all the shopping offers at IndiaShopps.com";

        return view("v1.flipkart-sale", $data);
    }

    /**
     * Amazon The Great Indian Sale Page..
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     */
    public function amazonSale(Request $request, $page = 0)
    {
        $token      = $request->session()->get('_token');
        $session_id = preg_replace("/[^0-9,.]/", '', $token);
        $cat        = false;

        if ($request->has('autojs') || $request->has('ajax')) {
            foreach ($request->all() as $field => $value) {
                $data[$field] = $value;
            }
        }

        $data['isSearch'] = false;

        if (!empty($session_id) && is_numeric($session_id)) {
            $data['session_id'] = $session_id;
        }

        $data['size']        = 30;
        $data['from']        = ($data['size'] * $page);
        $data['category_id'] = 351;
        $searchAPI           = composer_url('amz_sale.php');

        $data['term'] = json_encode($data);
        $result       = file_get_contents($searchAPI . '?query=' . urlencode($data['term']));
        $return       = json_decode($result);
        $result       = $return->return_txt;

        $data['facets']   = $result->aggregations;
        $data['product']  = $result->hits->hits;
        $data['minPrice'] = $result->aggregations->saleprice_min->value;
        $data['maxPrice'] = $result->aggregations->saleprice_max->value;
        $data['scat']     = $cat;
        $data['brand']    = "";
        $data['book']     = false;

        $data['facets']->categories = "";

        $data['isSearch'] = true;
        // dd($result);
        if ($request->has('filter') && $request->input('filter') == "true") {

            $json['products'] = (string)view("v1.amazon-productlist", $data);
            $json['products'] = preg_replace('/(\v)+/', '', $json['products']);
            $json['products'] = str_replace("\t", "", $json['products']);
            $json['facet']    = $result->aggregations;

            if (isset($return->filter_applied)) {
                $json['facet']->filter_applied = $return->filter_applied;
            }

            echo json_encode($json);
        } else {
            return view("v1.amazon-productlist", $data);
        }
    }

    /**
     * CategoryWise ProductLisint Page for Two Level Category Lisint..
     *
     * @var \Illuminate\Http\Request
     * @var Parent Category
     * @var 2nd Level Category
     * @var Page Number
     */
    public function subCategoryList(Request $request, $parent = false, $cname = false, $page = 0)
    {
        //print_r($parent);print_r($cname);exit;
        return $this->productList($request, $parent, $cname, false, $page);
    }

    /**
     * CategoryWise ProductListing Page for 3rd Level Category Listing..
     *
     * @var \Illuminate\Http\Request
     * @var Parent Category
     * @var 2nd Level Category
     * @var 3rd Level Category
     * @var Page Number
     */
    public function categoryList(Request $request, $parent = false, $child = false, $cname = false, $page = 0)
    {
        return $this->productList($request, $parent, $cname, $child, $page);
    }

    /**
     * Search wise Product Listing..
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     */
    public function searchList(Request $request, $page = 0)
    {
        if ($request->has('search_text') && !is_null($request->search_text)) {
            $query  = $request->search_text;
            $cat_id = ($request->has('cat_id')) ? $request->cat_id : 0;

            return redirect(route('search_new', [create_slug($cat_id), create_slug($query)]));
        } else {
            return redirect()->back();
        }

    }

    /**
     * Mobile phone listing Under a given Price & Brand..
     *
     * @var \Illuminate\Http\Request
     * @var Mobile Brand..
     * @var Maximum Price..
     * @var Page Number
     */
    public function bBrandPhones(Request $request, $brand, $price = 0, $page = 0)
    {
        if (empty($price) || !is_numeric($price)) {
            return redirect("/");
        } else {
            if (!$request->has('saleprice_max')) {
                //Add price to Request Object Manually and enabling price filter for Listing Controller.
                $request->request->add(['saleprice_max' => $price]);
                $request->request->add(['saleprice_min' => 0]);
                $request->request->add(['price_filter' => 1]);
            }

            if ($request->has('brand')) {
                //Add brand to Request Object Manually.
                $request->request->add(['brand' => implode(",", [$brand, $request->get('brand')])]);
            } else {
                //Add brand to Request Object Manually.
                $request->request->add(['brand' => $brand]);
            }

            $request->request->add(['bbphones' => true]);

            // Specifies Parent, and 2nd Level Category name for MOBILES..
            return $this->productList($request, "mobile", "mobiles-price-list-in-india", false, $page);
        }
    }

    /**
     * Mobile phone listing Under given Min & Max Price
     *
     * @var \Illuminate\Http\Request
     * @var Minimum Price..
     * @var Maximum Price..
     * @var Page Number
     */
    public function bbetPhones(Request $request, $minprice = 0, $maxprice = 0, $page = 0)
    {

        return redirect(route('home_v2'), 301);

        if (empty($maxprice) || !is_numeric($maxprice)) {
            return redirect("/");
        } else {
            if (!$request->has('saleprice_max')) {
                //Add price to Request Object Manually and enabling price filter for Listing Controller.
                $request->request->add(['saleprice_min' => $minprice]);
                $request->request->add(['saleprice_max' => $maxprice]);
                $request->request->add(['price_filter' => 1]);
            }

            $request->request->add(['bbetphones' => true]);

            return $this->productList($request, "mobile", "mobiles-price-list-in-india", false, $page);
        }
    }

    /**
     * Upcoming Mobile Phone Listing Page.
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     */
    public function upcomingMobiles(Request $request, $page = 0)
    {
        $request->request->add([
            'description' => "List of all upcoming mobiles in India " . date('Y') . " with expected launch dates, expected prices, specifications and based on popularity.",
            'title'       => "Upcoming Mobiles in India " . date('Y') . " with Expected Price, Launch Date, Specifications and More | IndiaShopps.com",
            "text"        => "There are a huge number of mobile phones going to come in market in the upcoming days and a lot have already made their presence.  The brands of upcoming mobile include Samsung, Apple, Oppo, Vivo, OnePlus, Xiaomi, LG, and many others.Here at IndiaShopps, we try to keep you updated with the upcoming mobiles of every brand through our blogs and new mobile entries. You can find the latest mobiles expected to be launched on our website.Comparison being the forte of our brand, you will get the prices of all e-commerce platforms at one place be it any mobile of any brand. The complete information about our mobiles which include features, specifications and price is well displayed at IndiaShopps to let you have a clear information and crisp experience about the product.We have a special feature of customized notification of price alerts of all mobiles, where you can submit your e-mail id and get informed by us whenever the price goes down or up.If you want to know about any upcoming mobile just go to our mobiles section and you will get the full information about each and every upcoming mobile.Check out our already existing list of upcoming mobiles of brands like Xiaomi, One Plus, Apple, Samsung etc. 
",
            "h1"          => "Upcoming Mobiles Price List in India",
            "keyword"     => "Upcoming Mobiles Price List in India,Upcoming Mobiles in India,Upcoming Mobiles Price List,Upcoming Mobiles Price List in India"
        ]);

        $request->request->add(['upcoming-mobiles' => true]);

        return $this->productList($request, "mobile", "mobiles-price-list-in-india", false, $page);
    }


    /**
     * Mobile phone listing Under a any given Max Price..
     *
     * @var \Illuminate\Http\Request
     * @var Maximum Price..
     * @var Page Number
     */
    public function bestPhones(Request $request, $price = 0, $page = 0)
    {
        return redirect(route('home_v2'), 301);

        if (empty($price) || !is_numeric($price)) {
            return redirect("/");
        } else {
            if (!$request->has('saleprice_max')) {
                //Add price to Request Object Manually and enabling price filter for Listing Controller.
                $request->request->add(['saleprice_max' => $price]);
                $request->request->add(['saleprice_min' => 0]);
                $request->request->add(['price_filter' => 1]);
            }

            $request->request->add(['bestphones' => true]);

            return $this->productList($request, "mobile", "mobiles-price-list-in-india", false, $page);
        }
    }

    /**
     * Get category ID by name and Category ID
     *
     * @var Category Name
     * @var Parent Category ID
     */
    public function getCatIDByName($cat_name, $parent_id = 0)
    {
        $cat_name = create_slug($cat_name);

        // DB::enableQueryLog();
        $db = DB::table('gc_cat');

        if (!empty($parent_id)) {
            $db = $db->where('parent_id', $parent_id);
        } else {
            $db = $db->where('parent_id', 0);
        }

        $row = $db->where(DB::raw(" create_slug(name) "), $cat_name)->lists('id');
        // echo "<PRE>";
        // print_r(DB::getQueryLog());
        return @$row[0];
    }

    public function getParentIDByName($cat_name, $level = false, $group = false)
    {
        $cat_name = create_slug($cat_name);

        // DB::enableQueryLog();
        $db = DB::table('gc_cat AS a')->select("b.name AS name");

        if ($level) {
            $db = $db->where('a.level', $level);
        }
        if ($group) {
            $db = $db->where('a.group_name', 'like', $group);
        }
        $db  = $db->join('gc_cat AS b', 'a.parent_id', '=', 'b.id');
        $row = $db->where(DB::raw(" create_slug(a.name) "), "like", $cat_name)->get();
        // echo "<PRE>";
        // print_r(DB::getQueryLog());
        return @$row[0];
    }

    /**
     * Create Category Chain..
     *
     * @var Category ID
     */
    function createChain($id, $except = null)
    {
        $cats    = [];
        $cc      = $id . ",";
        $result1 = [];
        $result  = $this->get_categoryParent($id);

        if (count($result) > 0) {
            foreach ($result as $val) {
                $cc .= $val . ",";
                $result1[] = $this->createChain($val);
            }
        }

        $imm = implode(",", $result1);
        $cc  = substr($cc, 0, -1);

        return $cc;
    }

    function error_404($parent, $category)
    {
        $key = $parent . '/pricelist/' . $category;

        if (array_key_exists($key, config('redirects'))) {
            return redirect(config('redirects.' . $key), 301);
        }

        abort(404);
    }

    public function getGroupName($cat_name)
    {
        $cat_name = create_slug($cat_name);

        // DB::enableQueryLog();
        $db = DB::table('gc_cat AS a')->select(["a.group_name", 'a.id']);

        $row = $db->where(DB::raw(" create_slug(a.name) "), "like", $cat_name)->first();

        if (is_null($row)) {
            abort(404);
        } else {
            return $row;
        }
    }

}
