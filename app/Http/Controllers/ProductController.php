<?php namespace indiashopps\Http\Controllers;

use DB;
use indiashopps\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;
use indiashopps\Helpers\Helper;
use Jenssegers\Agent\Agent as Agent;
use indiashopps\Logs;

class ProductController extends Controller
{
    protected $isMobile;

    public function __construct()
    {
        //$this->middleware('auth');
        $Agent = new Agent();

        // Third Party vendor to check MOBILE Browser.. \Jenssegers\Agent\Agent
        $this->isMobile = $Agent->isMobile();
    }

    /**
     * CATEGORY LISTING PAGE Controllers..
     *
     * @var Category Name
     */
    public function category($cat_name)
    {
        if ($cat_name == 'home') {
            return redirect(url('home-decor'));
        }

        $data['cat_name'] = urldecode($cat_name);
        $cat_data         = DB::table('gc_cat')
                              ->where(DB::raw(" create_slug(name) "), "like", $cat_name)
                              ->where('level', 0)
                              ->select('id', 'seo_title', 'meta')
                              ->first();
        if (!empty($cat_data->seo_title)) {
            $data['title'] = $cat_data->seo_title;
        }
        if (!empty($cat_data->meta)) {
            $data['meta'] = json_decode($cat_data->meta);
        }


        //if(!empty( $cat_data->text))
        //$data['text'] = json_decode($cat_data->text);

        //print_r($data );exit;
        if (empty($cat_data)) {
            return abort(404);
        }
        $data['cat']    = DB::table('gc_cat')->where('parent_id', $cat_data->id)->where('active', 1)->get();
        $data['c_name'] = $data['cat_name'];

        foreach ($data['cat'] as $key => $val) {
            $data['cat'][$key]->children = DB::table('gc_cat')->where('parent_id', $val->id)->where('active', 1)->get();
        }

        if (empty($data['cat'])) {
            return abort(404);
        }

        $data['slider'] = DB::table('slider')
                            ->where('refer_id', $cat_data->id)
                            ->select('image_url', 'refer_url', 'alt')
                            ->get();
        //echo "<pre>";print_r($data['slider']);die;
        return view('v1.category', $data);
    }

    /**
     * ALL Categories Listing Page Controller
     *
     * @var NONE
     */
    public function categories()
    {
        $data['categories'] = Helper::get_categories_tierd(); // \indiashopps\Helpers\helper.php
        return view('v1.categories', $data);
    }

    /**
     * Logs the request for any product, once user clicks on shop now button.
     *
     * @var List Reference..
     */
    protected function getSuggestions(&$list)
    {
        $i = 0;

        if (!empty($list['brand'])) {
            $products = array_slice($list['product'], 0, 5);

            foreach ($products as $p) {
                $suggestion[$i]['title'] = $p->_source->name . " Price";

                if ($p->_source->vendor != 0) {
                    if (@$book) {
                        $proURL = url('product/detail/' . create_slug($p->_source->name . " book") . "/" . $p->_id);
                    } else {
                        $proURL = url('product/detail/' . create_slug($p->_source->name) . "/" . $p->_id);
                    }
                } else {
                    $proURL = url('product/' . create_slug($p->_source->name) . "/" . $p->_source->id);
                }

                $suggestion[$i++]['url'] = $proURL;
            }
        } else {
            $brands = array_slice($list['facet']['lbrand'], 0, 10);

            foreach ($brands as $b) {
                $c = $list['facet']['group'][0]->key;

                if (!empty($list['cname'])) {
                    $c1 = $list['cname'];
                } else {
                    $c1 = $list['facet']['group'][0]->category_id->buckets[0]->category->buckets[0]->key;
                }

                if (isset($list['pcat_name'])) {
                    $pcat = "/" . create_slug($list['pcat_name']);
                } else {
                    $pcat = "";
                }

                $suggestion[$i]['title'] = $b->key . " $c price";
                $suggestion[$i++]['url'] = url(create_slug($c) . $pcat . "/" . seoUrl(create_slug($b->key . "--" . $c1)));
            }
        }

        return @$suggestion;
    }

    /**
     * Trending Product Controllers. Return the list of Product View Instance, from the SHOP NOW Logging.
     *
     * @var None
     */
    public function trending()
    {
        $rows = Logs::select(['_id', DB::raw('count(_id) as max')])
                    ->groupBy('_id')
                    ->take(200)
                    ->orderBy('max', 'DESC')
                    ->get();

        foreach ($rows as $row) {
            $trending[] = $row->_id;
        }
        // Gets Data from SOLR... @composer_url ==> Check image.php file.. \indiashopps\Helpers\image.php
        // echo composer_url( 'query_mget.php?ids='.json_encode($trending) );exit;
        $result          = file_get_contents(composer_url('query_mget.php?ids=' . json_encode($trending)));
        $result          = json_decode($result);
        $data['product'] = $result;

        foreach ($result->docs as $product) {
            if (isset($product->_source)) {
                $products[$product->_source->grp][] = $product;
            }
        }

        // dd($products);
        $data['products'] = $products;

        $data['scat'] = 301;
        // echo "<pre>";print_r($data);exit;
        return view("v1.trending", $data);
    }

    /**
     * Recently Viewed product Based on USER COOKIES...
     *
     * @var \Illuminate\Http\Request
     */
    protected function get_recent_viewed($recently_viewed)
    {
        $r_prods = "";

        if (!empty($recently_viewed)) {
            $r_prods = file_get_contents(composer_url('query_mget.php?ids=' . $recently_viewed));

            if (!empty($r_prods)) {
                $r_prods = json_decode($r_prods);
                $r_prods = $r_prods->docs;

                foreach ($r_prods as $key => $prod) {
                    if (!isset($prod->_source) || empty($prod->_source)) {
                        unset($r_prods[$key]);
                    }
                }

                $r_prods = array_filter($r_prods);
            } else {
                $r_prods = [];
            }
        }

        return $r_prods;
    }

    function product_detail_old($name, $id, Request $request)    //Redirects to product_detail
    {
        $part = explode("-", $id);
        if (empty($part[1]) && !isset($part[1])) {
            return redirect('product/' . $name . "/" . $id);
        }
        return redirect('product/' . $name . "/" . $part[0] . "-" . $part[1]);
    }

    /**
     * Product Detail Controller for NON_COMPARITIVE products.. i.e book, men, women etc category products..
     *
     * @var Product Name
     * @var Product ID
     * @var \Illuminate\Http\Request
     */
    function product_detail($name, $id, $vendor, Request $request)    //Shows product detail
    {
        //echo $name.",".$id.",".$vendor;exit;
        // Redirects to product_detail_new function if product is comparitive product..
        if (empty($vendor) && !isset($vendor)) {
            return redirect('product/' . $name . "/" . $id);
        }
        $bname = explode("-", $name);
        // Checks if the product is BOOK..
        if (end($bname) == "book") {
            $args = "&isBook=true";
        } else {
            $args = "";
        }
        $id = $id . "-" . $vendor;
        //SOLR URL for getting product detail
        $url             = composer_url('ext_prod_detail.php?_id=' . $id . $args);
        $data['product'] = file_get_contents($url);
        $data['product'] = json_decode($data['product']);

        //List of PRODUCTS>
        if (isset($data['product']->return_txt)) {
            $data['product'] = $data['product']->return_txt;
        } else {
            $data['product'] = "";
        }

        if (end($bname) == "book" && is_object($data['product'])) {
            $data['product']->grp = "books";
        }
//echo "<pre>";print_r($data);exit;
        //IF PRODUCT FOUND..
        if (!empty($data['product'])) {
            if ($name !== create_slug($data['product']->name) && ($data['product']->grp != "books")) {
                #if URL name doesn't match to product name
                return redirect("product/" . create_slug($data['product']->name) . "/" . $data['product']->id . "-" . $data['product']->vendor);
            }

            /*****Creating Title***/
            if (isset($data['product']->seo_title) && (!empty($data['product']->seo_title))) {
                $data['title'] = $data['product']->seo_title;
            }
            //// RELATED PRODUCTS list..
            $viewurl            = composer_url('site_view_also.php?info=' . urlencode($data['product']->name) . '&cat=' . urlencode($data['product']->category) . '&pid=' . $id . $args);
            $data['ViewAlso']   = file_get_contents($viewurl);
            $data['ViewAlso']   = json_decode($data['ViewAlso']);
            $data['ViewAlso']   = $data['ViewAlso']->return_txt;
            $data['full']       = false;
            $data['moreimage']  = false;
            $data['page_title'] = "";

            /*** PROCESS RECENTLY VIEWED PRODUCT START *****/
            $recently_viewed = $request->cookie('recently_viewed');

            $r_prods = $this->get_recent_viewed($recently_viewed);

            if (!empty($recently_viewed)) {
                $ids = json_decode($recently_viewed);

                if (!is_array($ids)) {
                    $ids = [];
                }
            } else {
                $ids = [];
            }
            if (!in_array($id, $ids)) {
                array_unshift($ids, $id);
            }
            $ids = array_slice($ids, 0, 12);

            $data['views']['r_prods'] = $r_prods; // LIST OF Recently Viewed Products..

            /*** PROCESS RECENTLY VIEWED PRODUCT ENDS *****/

            if (isset($data['product']->category)) {
                $data['c_name'] = $data['product']->category; // Category name to be used in DETAIL VIEW file..
            }

            $response = new \Illuminate\Http\Response(view("v1.product_detail", $data));
            // SENDS the current product ID to the USER COOKIE...
            $response->withCookie(cookie()->forever('recently_viewed', json_encode($ids)));

            return $response;
        } else {
            return redirect('search?search_text=' . unslug($name) . '&group=all');
            //404 Page, as the product not found..
            abort(404);
        }
    }

    /**
     * AMP Product Detail Controller for NON_COMPARITIVE products.. i.e book, men, women etc category products..
     *
     * @var Product Name
     * @var Product ID
     * @var \Illuminate\Http\Request
     */
    function product_detail_amp($name, $id, $vendor, Request $request)    //Shows product detail
    {
        //echo $name.",".$id.",".$vendor;exit;
        // Redirects to product_detail_new function if product is comparitive product..
        if (empty($vendor) && !isset($vendor)) {
            return redirect('product/' . $name . "/" . $id . "/amp");
        }
        $bname = explode("-", $name);
        // Checks if the product is BOOK..
        if (end($bname) == "book") {
            $args = "&isBook=true";
        } else {
            $args = "";
        }
        $id = $id . "-" . $vendor;
        //SOLR URL for getting product detail
        $url             = composer_url('ext_prod_detail.php?_id=' . $id . $args);
        $data['product'] = file_get_contents($url);
        $data['product'] = json_decode($data['product']);

        //List of PRODUCTS>
        if (isset($data['product']->product_detail)) {
            $data['product'] = $data['product']->product_detail;
        } else {
            $data['product'] = "";
        }

        if (end($bname) == "book" && is_object($data['product'])) {
            $data['product']->grp = "books";
        }

        //IF PRODUCT FOUND..
        if (!empty($data['product'])) {
            if ($name !== create_slug($data['product']->name) && ($data['product']->grp != "books")) {
                #if URL name doesn't match to product name
                return redirect("product/" . create_slug($data['product']->name) . "/" . $data['product']->id . "-" . $data['product']->vendor . "/amp");
            }
            /*****Creating Title***/
            if (isset($data['product']->seo_title) && (!empty($data['product']->seo_title))) {
                $data['title'] = $data['product']->seo_title;
            }
            //// RELATED PRODUCTS list..
            $viewurl            = composer_url('site_view_also.php?info=' . urlencode($data['product']->name) . '&cat=' . urlencode($data['product']->category) . '&pid=' . $id . $args);
            $data['ViewAlso']   = file_get_contents($viewurl);
            $data['ViewAlso']   = json_decode($data['ViewAlso']);
            $data['ViewAlso']   = $data['ViewAlso']->return_txt;
            $data['full']       = false;
            $data['moreimage']  = false;
            $data['page_title'] = "";

            if (isset($data['product']->category)) {
                $data['c_name'] = $data['product']->category; // Category name to be used in DETAIL VIEW file..
            }

            $response = new \Illuminate\Http\Response(view("v1.amp.product_detail", $data));
            return $response;
        } else {
            //404 Page, as the product not found..
            return $this->productDiscontinued($name);
        }
    }

    /**
     * Product Detail Controller for COMPARITIVE products.. i.e mobile, laptops category products..
     *
     * @var Product Name
     * @var Product ID
     * @var \Illuminate\Http\Request
     */
    function product_detail_red_comp($name, $id, $vendor, Request $request)    //Redirects to real path
    {
        return app()->make('indiashopps\Http\Controllers\v3\BaseController')->productDiscontinued($name);
    }

    private function productDiscontinued($name)
    {
        $query['name'] = unslug($name);
        $query['size'] = 12;

        $handle_404 = composer_url('handle_404.php?' . http_build_query($query));
        $result     = json_decode(file_get_contents($handle_404));

        $data['name']     = unslug($name);
        $data['products'] = $result->prod->hits->hits;

        return view('v2.product.common.discontinued_amp', $data);
    }

    /**
     * Product Detail Controller for COMPARITIVE products.. i.e mobile, laptops category products..
     *
     * @var Product Name
     * @var Product ID
     * @var \Illuminate\Http\Request
     */
    function product_detail_red($name, $id, Request $request)    //Redirects to real path
    {
        // return redirect( 'product/'.$name."/".$id );
        return redirect(str_replace("/indiashopps", "", newUrl(create_slug($name) . config('app.detaiPageSlug') . $id)), 301);
    }

    /**
     * Product Detail Controller for COMPARITIVE products.. i.e mobile, laptops category products..
     *
     * @var Product Name
     * @var Product ID
     * @var \Illuminate\Http\Request
     */
    function product_detail_new($name, $id, Request $request)    //Show a product detail
    {
        //echo $name.",".$id;exit;
        $part = explode("-", $id);

        //IF non comparitive then REDIRECT...
        if (!empty($part[1]) && isset($part[1])) {
            return redirect('product/' . $name . "/" . $id);
        }

        /// Get the product details from SOLR
        $data['product'] = file_get_contents(composer_url('site_prod_detail.php?_id=' . $id));

        $data['product'] = json_decode($data['product']);
        $data['product'] = $data['product']->return_txt;
        // echo "<pre>";print_r($data['product']);exit;
        if (!empty($data['product'])) {
            //Correcting Product name
            if ($name !== create_slug($data['product']->name)) {
                #if URL name doesn't match to product name
                return redirect("product/" . create_slug($data['product']->name) . "/" . $data['product']->id);
            }
            /*****Creating Title***/
            if (isset($data['product']->seo_title) && (!empty($data['product']->seo_title))) {
                $data['title'] = $data['product']->seo_title;
            }
            if (isset($data['product']->meta) && (!empty($data['product']->meta))) {
                $description = json_decode($data['product']->meta)->description;
            }
            // RELATED PRODUCT LIST
            $viewurl = composer_url('site_view_also.php?info=' . urlencode($data['product']->name) . '&cat_id=' . urlencode($data['product']->category_id) . '&cat=' . urlencode($data['product']->category) . '&pid=' . $id);

            $data['ViewAlso']  = file_get_contents($viewurl);
            $data['ViewAlso']  = json_decode($data['ViewAlso']);
            $data['ViewAlso']  = $data['ViewAlso']->return_txt;
            $data['full']      = false;
            $data['moreimage'] = false;

            //List of all the VENDORS for the product i.e Flipkart, Amazon, Snapdeal ETC..
            $data['vendor'] = file_get_contents(composer_url('vendor_details.php?id=' . $id));
            $data['vendor'] = json_decode($data['vendor']);
            $data['vendor'] = $data['vendor']->return_txt;

            if (!empty($data['vendor']->hits->hits)) {
                $data['hasVendor'] = true;
            }

            $pop['show']            = true;
            $pop['size']            = 1;
            $pop['from']            = 0;
            $pop['brand_size']      = 32;
            $pop['brand_min_count'] = 10;
            $pop['category_id']     = $data['product']->category_id;
            $pop['term']            = json_encode($pop);
            $searchAPI              = composer_url('search.php');
            $result                 = file_get_contents($searchAPI . '?query=' . urlencode($pop['term']));
            $result                 = json_decode($result);

            //POPULAR Brand suggestion on Poplular Brands Tabs on detail page..
            $data['bsuggests'] = $result->return_txt->aggregations->brand->buckets;

            $recently_viewed = $request->cookie('recently_viewed');

            $r_prods = "";

            /******** RECENTLY VIEWED PRODUCTS START *******/
            if (!empty($recently_viewed)) {
                $r_prods = file_get_contents(composer_url('query_mget.php?ids=' . $recently_viewed));

                if (!empty($r_prods)) {
                    $r_prods = json_decode($r_prods);
                    $r_prods = $r_prods->docs;

                    foreach ($r_prods as $key => $prod) {
                        if (!isset($prod->_source) || empty($prod->_source)) {
                            unset($r_prods[$key]);
                        }
                    }

                    $r_prods = array_filter($r_prods);
                } else {
                    $r_prods = [];
                }
            }

            if (!empty($recently_viewed)) {
                $ids = json_decode($recently_viewed);

                if (!is_array($ids)) {
                    $ids = [];
                }
            } else {
                $ids = [];
            }

            if (!in_array($id, $ids)) {
                array_unshift($ids, $id);
            }

            $ids = array_slice($ids, 0, 12);

            $data['views']['r_prods'] = $r_prods;

            /********RECENTLY VIEWED PRODUCT ENDS************/

            $data['mobile'] = $this->isMobile;

            if (isset($data['product']->category)) {
                $data['c_name'] = $data['product']->category;
            }

            //Prepare response with COOKIES....
            $response = new \Illuminate\Http\Response(view("v1.product_detail_new", $data));
            $response->withCookie(cookie()->forever('recently_viewed', json_encode($ids)));

            return $response;

        } else {
            //// 404, Product NOT found..
            return redirect('search?search_text=' . unslug($name) . '&group=all');
            // dd(unslug($name));
            abort(404);
        }
    }

    /**
     * Product Detail Controller for COMPARITIVE products.. i.e mobile, laptops category products..
     *
     * @var Product Name
     * @var Product ID
     * @var \Illuminate\Http\Request
     */
    function product_detail_new_amp($name, $id, Request $request)    //Show a product detail
    {
        //echo $name.",".$id;exit;
        $part = explode("-", $id);

        //IF non comparitive then REDIRECT...
        if (!empty($part[1]) && isset($part[1])) {
            return redirect('product/' . $name . "/" . $id . "/amp");
        }

        /// Get the product details from SOLR
        $data['product'] = file_get_contents(composer_url('site_prod_detail.php?_id=' . $id));

        $data['product'] = json_decode($data['product']);

        if (isset($data['product']) && !empty($data['product']) && isset($data['product']->return_txt)) {
            $data['product'] = $data['product']->return_txt;
            //Correcting Product name
            if ($name !== create_slug($data['product']->name)) {
                #if URL name doesn't match to product name
                return redirect("product/" . create_slug($data['product']->name) . "/" . $data['product']->id . "/amp");
            }
            /*****Creating Title***/
            if (isset($data['product']->seo_title) && (!empty($data['product']->seo_title))) {
                $data['title'] = $data['product']->seo_title;
            }
            // RELATED PRODUCT LIST
            $viewurl = composer_url('site_view_also.php?info=' . urlencode($data['product']->name) . '&cat_id=' . urlencode($data['product']->category_id) . '&cat=' . urlencode($data['product']->category) . '&pid=' . $id);

            $data['ViewAlso']  = file_get_contents($viewurl);
            $data['ViewAlso']  = json_decode($data['ViewAlso']);
            $data['ViewAlso']  = $data['ViewAlso']->return_txt;
            $data['full']      = false;
            $data['moreimage'] = false;

            //List of all the VENDORS for the product i.e Flipkart, Amazon, Snapdeal ETC..
            $data['vendor'] = file_get_contents(composer_url('vendor_details.php?id=' . $id));
            $data['vendor'] = json_decode($data['vendor']);
            $data['vendor'] = $data['vendor']->return_txt;

            if (!empty($data['vendor']->hits->hits)) {
                $data['hasVendor'] = true;
            }

            $pop['show']            = true;
            $pop['size']            = 1;
            $pop['from']            = 0;
            $pop['brand_size']      = 32;
            $pop['brand_min_count'] = 10;
            $pop['category_id']     = $data['product']->category_id;
            $pop['term']            = json_encode($pop);
            $searchAPI              = composer_url('search.php');
            $result                 = file_get_contents($searchAPI . '?query=' . urlencode($pop['term']));
            $result                 = json_decode($result);


            $data['mobile'] = $this->isMobile;

            if (isset($data['product']->category)) {
                $data['c_name'] = $data['product']->category;
            }

            if (isset($data['product']->meta)) {
                $data['detail_meta'] = json_decode($data['product']->meta);
            }

            //echo "<pre>";print_r($data);exit;
            //echo amp_desc($data['product']->description);exit;
            $response = new \Illuminate\Http\Response(view("v1.amp.product_detail_new", $data));
            return $response;
        } else {
            //// 404, Product NOT found..
            return $this->productDiscontinued($name);
        }
    }

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

    /**
     * Get the list of all the child categories under one category..
     *
     * @var Category ID
     */
    function get_categoryParent($id)
    {
        //Get the list of all the child categories under one category..
        return DB::table('gc_cat')->where('parent_id', $id)->lists('id');
    }

    function createChain1($id, $except = null)
    {
        $cc     = "";
        $result = $this->get_categoryParent1($id);
        if (count($result)) {
            foreach ($result as $key => $val) {
                $cc .= $val . "_" . $key . ",";
            }
        }
        $cc = substr($cc, 0, -1);
        return $cc;
    }

    function get_categoryParent1($id)
    {
        return DB::table('gc_cat')->where('parent_id', $id)->lists('id', 'name');

    }

    function getCatName($id)
    {
        return DB::table('gc_cat')->where('id', $id)->lists('name');

    }

    /**
     * GENERATE Sitemap for all the categories and PRODUCTS...
     *
     * @var NONE
     */
    function sitemap()
    {
        //$this->category_sitemap();
        $this->product_sitemap();
        //$this->image_sitemap();
//		$this->custom_sitemap();
        echo "done";
    }

    function custom_sitemap()
    {
        $list = DB::table("custom_link")->distinct()->select('group_name', 'category')->get();
        //echo "<pre>";print_r($list);exit;
        $url      = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $priority = 0.8;
        foreach ($list as $l) {
            if (!empty($l->group_name) && !empty($l->category)) {
                $purl = url(create_slug("list of " . $l->group_name . " " . $l->category));
                $url .= '<url>
					      <loc>' . $purl . '</loc>
					      <lastmod>' . date("Y-m-d") . '</lastmod>
					      <priority>' . $priority . '</priority>
					    </url>';
            }
        }

        $url .= "</urlset>";
        //echo "<pre>";print_r($url);exit;
        file_put_contents("custom-sitemap.xml", $url);
    }

    function category_sitemap()
    {
        $cats = $this->get_categories_tierd();
        // dd($cats);
        $priority = 0.9;
        $url      = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($cats as $parent) {
            $purl = url(create_slug($parent['category']->name));
            $url .= '<url>
				      <loc>' . $purl . '</loc>
				      <lastmod>' . date("Y-m-d") . '</lastmod>
				      <priority>' . $priority . '</priority>
				    </url>';

            foreach ($parent['children'] as $child) {
                $curl = $purl . "/" . create_slug($child['category']->name);
                $url .= '<url>
				      <loc>' . seoUrl($curl) . '</loc>
				      <lastmod>' . date("Y-m-d") . '</lastmod>
				      <priority>' . $priority . '</priority>
				    </url>';

                foreach ($child['children'] as $cat) {
                    $c_url = $curl . "/" . create_slug($cat['category']->name);
                    $url .= '<url>
				      <loc>' . seoUrl($c_url) . '</loc>
				      <lastmod>' . date("Y-m-d") . '</lastmod>
				      <priority>' . $priority . '</priority>
				    </url>';
                }
            }
        }

        $url .= "</urlset>";
        file_put_contents("category-sitemap.xml", $url);
    }

    function product_sitemap()
    {
        //$cats	= $this->get_categories_tierd();
        // dd($cats);
        $priority   = 0.8;
        $url        = '';
        $from       = 0;
        $limit      = 0;
        $file_index = 1;

        do {
            $url1   = "http://209.126.127.240:9200/shopping/_search?q=track_stock:1%20vendor:0&size=500&from=" . $from . "&default_operator=AND";
            $result = file_get_contents($url1);
            $result = json_decode($result);

            foreach ($result->hits->hits as $pro) {
                $pro = $pro->_source;

                $proURL = route('product_detail_v2', [create_slug($pro->name), $pro->id]);
                $url .= '<url><loc>' . $proURL . '</loc><lastmod>' . date("Y-m-d") . '</lastmod><priority>' . $priority . '</priority></url>';
            }

            $products = count($result->hits->hits);
            $from += $products;
            $limit = $from;

            if ($limit >= 40000) {
                file_put_contents("product-sitemap-" . $file_index . ".xml", $this->generateProductXml($url));
                $url = "";
                $file_index++;
            }
        } while ($products > 0);

        file_put_contents("product-sitemap-" . $file_index . ".xml", $this->generateProductXml($url));
    }

    private function generateProductXml($urls)
    {
        $url = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $url .= $urls;
        $url .= "</urlset>";

        return $url;
    }

    function image_sitemap()
    {
        $priority = 0.6;
        $url      = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
        $from     = 20500;
        #file_put_contents("image-sitemap.xml", $url);
        do {
            $url1   = "http://209.126.127.240:9200/shopping/_search?q=track_stock:1%20vendor:0&size=500&from=" . $from . "&pretty=true&default_operator=AND";
            $result = file_get_contents($url1);
            $result = json_decode($result);

            foreach ($result->hits->hits as $pro) {
                $pro = $pro->_source;
                $url = "";
                //$proURL = url('product/'.create_slug($pro->name)."/".$pro->id );
                $proURL = ('http://www.indiashopps.com/product/' . create_slug($pro->name) . "/" . $pro->id);
                $url .= '<url><loc>' . $proURL . '</loc>';
                if (json_decode($pro->image_url) != null) {
                    $image = json_decode($pro->image_url);
                    foreach ($image as $img) {
                        $url .= '<image:image>';
                        $url .= '<image:loc>' . $img . '</image:loc>';
                        $url .= '</image:image>';
                    }
                } else {
                    $url .= '<image:image>';
                    $url .= '<image:loc>' . $pro->image_url . '</image:loc>';
                    $url .= '</image:image>';
                }

                $url .= '</url>';
                file_put_contents("image-sitemap.xml", $url, FILE_APPEND | LOCK_EX);
            }

            $products = count($result->hits->hits);
            $from += $products;


        } while ($products > 0);

        $url = "</urlset>";
        //file_put_contents("image-sitemap.xml", $url );
        file_put_contents("image-sitemap.xml", $url, FILE_APPEND | LOCK_EX);
    }


    /**
     * GET the list of all the categories in Parent and Child Order..
     *
     * @var Parent ID
     */
    function get_categories($parent = false)
    {
        $result = [];
        if ($parent !== false) {
            //->where('parent_id',$parent_id)->get();
            $result = DB::table('gc_cat')
                        ->where('parent_id', $parent)
                        ->where('active', 1)
                        ->where('level', '<', 3)
                        ->orderBy('sequence', 'ASC')
                        ->lists('id');
        } else {
            $result = DB::table('gc_cat')
                        ->where('active', 1)
                        ->lists('id')
                        ->where('level', '<', 3)
                        ->order_by('sequence', 'ASC');
        }

        $categories = [];

        foreach ($result as $cat) {
            $categories[] = $this->get_category($cat);
        }
        return $categories;
    }

    function get_categories_tierd($parent = 0)
    {
        $categories = [];
        $result     = $this->get_categories($parent);
        foreach ($result as $category) {
            $categories[$category->id]['category'] = $category;
            $categories[$category->id]['children'] = $this->get_categories_tierd($category->id);
        }
        return $categories;
    }

    function get_category($id)
    {

        //return $this->db->get_where('cat', array('id'=>$id))->row();
        return DB::table('gc_cat')->where('id', $id)->first();
    }

    /**
     * Listing the product for OLD URLs, which were already cached by GOOGLE to avoid Page Not Found request..
     *
     * @var Product Name
     */
    public function list_products(Request $request,
        $brand = false,
        $cat = false,
        $order_by = "null",
        $sort_order = "null",
        $page = 0)
    {
        $child = $this->get_category($cat);
        if (empty($child)) {
            abort(404);
        }
        $parent = $this->get_category($child->parent_id);

        if (!empty($parent)) {
            if (create_slug($parent->name) != create_slug($parent->group_name)) {
                $url = create_slug($parent->group_name) . "/" . create_slug($parent->name) . "/" . seoUrl(create_slug($child->name));
            } else {
                $url = create_slug($parent->name) . "/" . seoUrl(create_slug($child->name));
            }
        } else {
            $url = create_slug($child->name);
        }

        return redirect($url);

    }
}