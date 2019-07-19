<?php namespace indiashopps\Http\Controllers\v2;

use Carbon\Carbon;
use DB;
use Illuminate\Http\RedirectResponse;
use indiashopps\Category;
use indiashopps\CategoryMeta;
use indiashopps\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use indiashopps\Http\Controllers\Controller;
use indiashopps\Library\Page\Pagination;
use indiashopps\Models\CustomPage;
use Jenssegers\Agent\Agent;

class ListingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function productList(Request $request, $parent = false, $cname = false, $child = false, $page = 1)
    {
        //Create a unique token from the current user session to send the UNIQUE ID to solr for consistance product listing..
        //print_r($parent);echo "<br>cname - ";print_r($cname);echo "<br>child - ";print_r($child);exit;

        $token      = $request->session()->get('_token');
        $session_id = preg_replace("/[^0-9,.]/", '', $token);
        $parent_id  = false; // Parent ID is made false for the search page, so that it doesn't redirect..
        $cat        = false;

        $c_url = $cname;

        if ($page > 900) {
            if ($child) {
                return redirect(getUrl([$parent, $child, $cname], '.html'), 301);
            } else {
                return redirect(getUrl([$parent, $cname], '.html'), 301);
            }
        }
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
                                return redirect(url($parent . '/mobile-accessories/chargers-price-list-in-india.html'),
                                    301);
                            } else {
                                if ($cname == 'mobile-battery-price-list-in-india') {
                                    return redirect(url($parent . '/mobile-accessories/battery-price-list-in-india.html'),
                                        301);
                                } else {
                                    if ($cname == 'smart-watches-price-list-in-india' and $parent == "mobile") {
                                        return redirect(url('electronics/smart-wearable/smart-watches-price-list-in-india.html'),
                                            301);
                                    } else {
                                        if ($cname == 'smart-bands-price-list-in-india' and $parent == "mobile") {
                                            return redirect(url('electronics/smart-wearable/smart-bands-price-list-in-india.html'),
                                                301);
                                        } else {
                                            if ($cname == 'networking-price-list-in-india' and $parent == "computers") {
                                                return redirect(url('computers/networking-devices-price-list-in-india.html'),
                                                    301);
                                            } else {
                                                if ($cname == 'gear-price-list-in-india' and $parent == "kids") {
                                                    return redirect(url('kids/baby-gear-price-list-in-india.html'),
                                                        301);
                                                } else {
                                                    if ($cname == 'accessories-price-list-in-india' and $parent == "kids") {
                                                        return redirect(url('kids/kid-accessories-price-list-in-india.html'),
                                                            301);
                                                    } else {
                                                        if ($cname == 'sports-price-list-in-india' and $parent == "sports-fitness") {
                                                            return redirect(url('sports-fitness/sports-products-goods-price-list-in-india.html'),
                                                                301);
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
        } elseif ($cname == "lifestyle-price-list-in-india" and $parent == "lifestyle") {
            return redirect(url($parent), 301);
        } elseif ($cname == "lehnga-price-list-in-india") {
            return redirect(url($parent . '/' . $child . "/lehenga-price-list-in-india.html"), 301);
        } elseif ($cname == "fragrances-price-list-in-india") {
            return redirect(url($parent . "/fragrance-price-list-in-india.html"), 301);
        } elseif ($child == "fragrances" && $cname == "perfumes-price-list-in-india") {
            return redirect(url($parent . "/fragrance/perfumes-price-list-in-india.html"), 301);
        } elseif ($child == "fragrances" && $cname == "deodorants-price-list-in-india") {
            return redirect(url($parent . "/fragrance/deodorants-price-list-in-india.html"), 301);
        }

        if ($child) {
            $key = $parent . "/" . $child . "/" . $cname;

            if (array_key_exists($key, config('redirects'))) {
                return redirect(config('redirects.' . $key), 301);
            }
        } else {
            $key = $parent . "/" . $cname;

            if (array_key_exists($key, config('redirects'))) {
                return redirect(config('redirects.' . $key), 301);
            }
        }
        $target = $cname;
        /**********************Redirects SEO Purpose****************************************/
        if ($parent == 'product' || $parent == 'coupon' || $parent == 'cdn-cgi' || $parent == 'category') {
            \Log::notice('Redirects SEO Purpose');
            abort(404);
        }
        //Checks whether SEO URL is enabled or not and redirect according to the listing page.
        if (config('app.seoEnable') && $parent) {
            $cname = explode(config('app.seoURL'), $cname);

            if (!isset($cname[1])) {

                if (isset($child) && !empty($child)) {
                    return redirect('/' . $parent . "/" . $child . "/" . $cname[0] . config('app.seoURL') . ".html",
                        301);
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

            $parts = explode("--", $cname);

            if (isset($parts[1]) && !empty($parts[1])) {

                $cat = $this->getCatIDByName($parts[1], $parent_id);

                return redirect(trim(route('brand_category_list', [$parts[0], $parent, $parts[1]]), '-'), 301);
            }

            $parent_id = $this->getCatIDByName($parent);
            $child_id  = $this->getCatIDByName($child, $parent_id);
            $cat       = $this->getCatIDByName($cname, $child_id);


        } /// GET the category IDs with CATEGORY Name ( Second Level Categories )
        elseif ($parent && $cname) {
            $parts     = explode("--", $cname);
            $parent_id = $this->getCatIDByName($parent);

            if (isset($parts[1]) && !empty($parts[1])) {
                if ($parts[0] == "smartphone") {
                    $data['type'] = "Smartphone";
                } elseif ($parts[0] == "dual-sim-phones") {
                    $data['SIM_type'] = "Dual";
                } elseif ($parts[0] == "android_phones") {
                    $data['OS'] = "Android";
                } elseif ($parts[0] == "windows_phones") {
                    $data['OS'] = "Windows";
                } else {
                    $cat = $this->getCatIDByName($parts[1], $parent_id);

                    return redirect(trim(route('brand_category_list_comp_1', [$parts[0], $parts[1], $cat]), '-'), 301);
                }

                $cname = $parts[1];
            }

            $cat = $this->getCatIDByName($cname, $parent_id);
            $c   = $this->getParentName($cname, $parent, 0, $request);

            if (is_null($cat) && isset($c->name)) {
                $c   = $this->getCatIDByName($c->name, $parent_id);
                $cat = $this->getCatIDByName($cname, $c);
            }
        }

        $data['isSearch'] = true;
        if (in_array($cat, config('vendor.comparitive_category'))) {
            $data['isSearch'] = false;
        }

        if ($request->has('brand')) {
            $brand = $request->brand;
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
        //echo $parent_id.":$child_id:".$cat;exit;
        if (empty($parent_id) && empty($parent_id) && empty($cat) && !in_array($request->route()->getName(),
                ['search_new', 'list_of_men_women', 'list_of_category'])
        ) {
            abort(404);
        }

        if (($parent_id || isset($child_id)) && empty($cat)) {

            if ($request->has('debug')) {
                \Log::error("Error: Category ID Not Found");
            }

            abort(404);
        }


        //Adds all the FILTER FIELDS to an ARRAY to be send to SOLR query..
        if ($request->has('price_filter') || $request->has('ajax') || $request->has('apply_filters')) {

            foreach ($request->all() as $field => $value) {
                if (!in_array($field, ['meta_data', 'custom_filters', 'apply_filters'])) {
                    $data[$field] = $value;
                }
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

        //Create the Category Chain and send it to view for nested Categories
        if ($cat) {
            $controller          = new ProductController();
            $cats                = $controller->createChain($cat);
            $data['category_id'] = $cats;
            $data['c_name']      = $controller->getCatName($cats)[0];
        }

        $data['size'] = 30;
        $data['page'] = $page;
        $data['from'] = ($data['size'] * ($page - 1));

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

        if (isset($data['category_id']) && isPricelist($data['category_id'])) {
            $data['isComparative'] = true;
        } else {
            $data['isComparative'] = false;
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

        $data['sort'] = $request->input('sort');
        $data['term'] = json_encode($data); // Preparing data to be sent to SOLR..

        // GET PRODUCT Data from SOLR..
        //echo $searchAPI.'?query='.urlencode($data['term']);exit;
        if ($request->has('custom_filters')) {
            $data = array_merge($data, $request->custom_filters);
        }

        $result = file_get_contents($searchAPI . '?query=' . urlencode($data['term']));
        //echo "<pre>";print_r($result);exit;
        if (!$request->has('ajax')) {
            /*****Snippet Data******/
            $data['order_by']   = "id";
            $data['sort_order'] = "desc";
            $data['size']       = 10;
            $data['snippet']    = true;
            $data['brand']      = (isset($brand)) ? ucwords($brand) : "";
            //print_r($data);exit;
            $data['term'] = json_encode($data);
            //echo $searchAPI.'?query='.urlencode($data['term']);exit;
            $snippet = file_get_contents($searchAPI . '?query=' . urlencode($data['term']));
            if (json_decode($snippet) != null) {
                $snippet                  = json_decode($snippet);
                $data['snippet']          = $snippet->return_txt->hits->hits;
                $data['sn_numberOfItems'] = $snippet->return_txt->hits->total;
            }
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

        $uri = \Request::route()->uri();
        if ($request->has('custom_group_page') && $request->custom_group_page == 'yes') {
            $params         = [
                'group'       => $request->group,
                'category'    => $request->custom_category,
                'keyword'     => $request->search_text,
                'order_by?'   => '',
                'sort_order?' => ''
            ];
            $data['target'] = $this->getPaginationTarget(url($uri), $params);
        } elseif ($request->has('custom_filters')) {
            $data['custom_filters'] = $request->custom_filters;
            $data['target']         = $this->getPaginationTarget(url($uri),
                ['slug' => $request->custom_filters['slug']]);
        } else {
            if ($request->route()->getName() == 'brand_category_list_comp' || $request->route()
                                                                                      ->getName() == 'brand_category_list_comp_1'
            ) {
                if (!empty($parent) && !empty($cname) && !empty($brand) && $child) {
                    $data['canonical'] = route('brand_category_list', [$brand, $parent, $cname]);
                }
                $parts          = explode(config('app.seoURL'), $c_url);
                $data['target'] = $this->getPaginationTarget(url($uri),
                    ['brand' => create_slug($request->brand), 'category' => $parts[0], 'id' => $cat]);
            } else {
                if ($request->route()->getName() == 'brand_category_list' || $request->route()
                                                                                     ->getName() == 'brand_category_list_1'
                ) {
                    if (stripos($uri, '-price-list-in-india/') === false) {
                        $uri = $uri . "/{page}";
                    }

                    $parts          = explode(config('app.seoURL'), $c_url);
                    $data['target'] = $this->getPaginationTarget(url($uri), [
                        'brand'    => create_slug($request->brand),
                        'group'    => $parent,
                        'category' => $parts[0],
                        'id'       => $cat
                    ]);
                } else {
                    $data['target'] = $this->getPaginationTarget(url($uri),
                        ['parent' => $parent, 'category' => $c_url, 'child' => $child]);
                }
            }
        }
        if (stripos($uri, '{') > -1) {
            $params         = $request->route()->parametersWithoutNulls();
            $data['target'] = $this->getPaginationTarget(url($uri), $params);
        }

        $page       = empty($page) ? 1 : ((int)$page);
        $pagination = new Pagination();
        $pagination->setCurrent($page);
        $pagination->setTotal(($result->hits->total > 29500) ? 29500 : $result->hits->total);
        $pagination->setRPP(30);
        $pagination->setTarget($data['target']);

        $data['total_products'] = ($result->hits->total > 29500) ? 29500 : $result->hits->total;
        // grab rendered/parsed pagination markup
        if (!empty($data['target'])) {
            $data['markup']        = $pagination->parse($request->has('ajax'));
            $data['rel_next_prev'] = implode("\n", $pagination->getRelPrevNextLinkTags());
        } else {
            $data['markup']        = '';
            $data['rel_next_prev'] = '';
        }


        // Pre-defined price filter for price comparition in below funcitons.. bBrandPhone, bbetPhones, bestPhone..
        if (($request->has('price_filter') && isset($result->aggregations->filters_all) || $request->has('apply_filters')) && !$request->has('ajax')) {
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

        if (empty($data['product'])) {
            $response = $this->redirectBackToParent($request, $parent, $cname, $child);

            if ($response instanceof RedirectResponse) {
                return $response;
            }
        }

        if( isset($brand) && !empty($brand) && is_array($data['product']) && count($data['product']) < 5 )
        {
            $response = $this->redirectBackToParent($request, $parent, $cname, $child);

            if ($response instanceof RedirectResponse) {
                return $response;
            }
        }

        if (@$data['group'] != "Books") {
            $facet['group'] = $result->aggregations->grp->buckets;
            $data['book']   = false;
        } else {
            $data['book']     = true;
            $data['isSearch'] = false;
        }
        if ($data['isSearch'] && !$request->has('cat_id') && !$request->has('apply_filters')) {

            $data['facets']->categories = $result->aggregations->grp->buckets;
        }

        $data['isMobile'] = (new Agent())->isMobile();

        $data['c_name'] = isset($data['c_name']) ? $data['c_name'] : '';

        if ($request->has('brand')) {
            $brand_meta = CategoryMeta::where('brand', 'like', $request->brand)->whereCatId($cat)->first();
            if (!is_null($brand_meta)) {
                $meta = (object)$this->getMeta(json_decode($brand_meta->meta));

                $data['meta'] = $meta;

                if (isset($brand_meta->description) && !empty($brand_meta->description)) {
                    $data['text'] = $brand_meta->description;
                }
            } elseif (in_array($cat, config("vendor.comparitive_category"))) {
                $meta = $this->getMeta('meta.list.comp', $brand, unslug($cname));
            } else {
                $meta = $this->getMeta('meta.list.non', $brand, unslug($cname));
            }

            if (isset($meta) && !empty($meta)) {
                $data['description'] = $meta->description;
                $data['title']       = $meta->title;

                if (isset($meta->h1)) {
                    $data['h1'] = $meta->h1;
                } else {
                    $data['h1'] = ucwords($brand) . " " . ucwords(unslug($cname)) . " Price List in India";
                }

                $data['facets']->categories = "";
            }
        } elseif ($request->has('h1')) {
            $data['h1'] = $request->h1;
        } else {
            if ($cname == 'cameras-dslrs-more') {
                $data['h1'] = "Cameras & DSLRs Price List in India";
            } else {
                $data['h1'] = ucwords(unslug($cname)) . " Price List in India";
            }
        }

        if (isset($cat) && !$request->has('price_filter') && !$request->has('apply_filters')) {
            $list_desc = DB::table('gc_cat')->where('id', $cat)->select(['meta', 'seo_title', 'description'])->first();

            if (!empty($list_desc->meta)) {
                $data['list_desc'] = json_decode($list_desc->meta);
            }

            if (isset($data['list_desc']->description) && !empty($data['list_desc']->description)) {
                $data['description'] = $data['list_desc']->description;
            }
            if (!empty($list_desc->seo_title)) {
                if ($page > 1) {
                    $data['title'] = "Page - " . $page . " | " . $list_desc->seo_title;
                } else {
                    $data['title'] = $list_desc->seo_title;
                }

            }

            if (!empty($data['list_desc']->h1)) {
                $data['h1'] = $data['list_desc']->h1;
            }


        }

        $category = Category::parentCategory($parent_id);

        if (is_null($category)) {
            $data['slider'] = asset('assets/v2') . '/images/cat-banner.jpg';
        } else {
            $data['slider'] = $category->parentImage;
        }

        $route = $request->route()->getName();

        if ($request->meta_data) {
            $data = array_merge($data, $request->meta_data);
        }

        if (config('static_meta.routes.' . $route)) {
            $data = array_merge($data, $this->getMeta('static_meta.routes.' . $route, '', ''));
        }

        //if (!isset($brand) && $parent && !isset($data['list_desc']) &&  array_key_exists($parent, config("meta.list.group"))) {
        if (!isset($brand) && $parent &&  array_key_exists($parent, config("meta.list.group"))) {
            $meta = $this->getMeta('meta.list.group.' . $parent, '', unslug($cname));

            $data['title']       = $meta->title;
            $data['description'] = $meta->description;
            $data['keywords']    = $meta->keyword;

            if( isset($meta->h1) )
            {
                $data['h1'] = $meta->h1;
            }
        }

        //Preparing AJAX response once filter is applied.... JSON Response
        if ($request->has('filter') && $request->input('filter') == "true") {

            $json['products'] = (string)view("v2.product.list", $data);
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
            return view("v2.product.list", $data);
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
        $db       = DB::table('gc_cat');

        if (!empty($parent_id)) {
            $db = $db->where('parent_id', $parent_id);
        } else {
            $db = $db->where('parent_id', 0);
        }

        $row = $db->where(DB::raw(" create_slug(name) "), $cat_name)->lists('id');

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

    public function switchWords($array, $keys = [])
    {
        foreach ($array as $key => $field) {
            if ($field instanceof Request) {
                $first  = explode(" ", $field->brand);
                $second = explode(" ", unslug($array[$key + 1]));

                $first[] = strtolower($second[0]);
                unset($second[0]);
                $array[$key]->request->add(['brand' => implode(" ", $first)]);
                $array[$key + 1] = implode(" ", $second);
            } elseif ($key + 1 < count($array)) {
                $first  = explode(" ", $array[$key]);
                $second = explode(" ", unslug($array[$key + 1]));

                $first[] = strtolower($second[0]);
                unset($second[0]);

                $array[$key]     = create_slug(implode(" ", $first));
                $array[$key + 1] = create_slug(implode(" ", $second));
            }
        }

        foreach ($array as $key => $field) {
            $array[$keys[$key]] = $field;
            unset($array[$key]);
        }

        return $array;
    }

    public function getParentName($cat_name, $group, $parent_id = 0, &$request)
    {
        $cat_name = create_slug($cat_name);

        //\DB::enableQueryLog();
        $db = DB::table('gc_cat AS a');

        $db = $db->join('gc_cat AS b', 'a.parent_id', '=', 'b.id');

        if ($parent_id == 0) {
            $db  = $db->select(["b.name AS name", "b.group_name"]);
            $row = $db->where(DB::raw(" create_slug(a.group_name) "), '=', $group)
                      ->where(DB::raw(" create_slug(a.name) "), "like", $cat_name)
                      ->first();
        } else {
            $db  = $db->select(["a.name AS name", "a.group_name"]);
            $row = $db->where('a.id', '=', $parent_id)
                      ->where(DB::raw(" create_slug(a.name) "), "like", $cat_name)
                      ->first();
        }

        if (is_null($row)) {
            if (count(explode(" ", $request->brand)) <= 3) {
                if (!empty($group)) {
                    $data = $this->switchWords([$request, $group, $cat_name], ['request', 'group', 'cat_name']);
                } else {
                    $data = $this->switchWords([$request, $cat_name], ['request', 'cat_name']);
                }


                extract($data);

                return $this->getParentName($cat_name, $group, $parent_id, $request);
            }

            if ($request->has('debug')) {
                \Log::error("Error: Category Not Found");
            }

            abort(404);
        } else {
            $row->category = $cat_name;

            return $row;
        }
    }

    public function brandCategoryList(Request $request, $brand, $group, $category, $page = 1)
    {
        if (!empty($brand)) {
            //Add price to Request Object Manually and enabling price filter for Listing Controller.

            $three_cat = ['-home-decor-', '-beauty-health-', '-sports-fitness-', '-deals-promotion-'];

            foreach ($three_cat as $cat) {
                $uri = $brand . '-' . $group . '-' . $category;

                if (stripos($uri, $cat) !== false) {
                    $part     = explode($cat, $uri);
                    $brand    = preg_replace('/[-]+/', ' ', trim($part[0]));
                    $group    = trim($cat, '-');
                    $category = $part[1];
                }
            }
            $request->request->add(['brand' => $brand]);
            $request->request->add(['price_filter' => true]);
        }
        $cat   = $this->getParentName($category, $group, 0, $request);
        $child = (create_slug($cat->group_name) == create_slug($cat->name)) ? false : create_slug($cat->name);

        return $this->productList($request, create_slug($cat->group_name), $cat->category . "-price-list-in-india",
            $child, $page);
    }

    public function brandCategoryListComp(Request $request, $brand, $category, $parent_id = 0, $page = 1)
    {
        if (!empty($brand)) {
            //Add price to Request Object Manually and enabling price filter for Listing Controller.
            $request->request->add(['brand' => $brand]);
            $request->request->add(['price_filter' => true]);
        }

        $cat = $this->getParentName($category, 0, $parent_id, $request);

        return $this->productList($request, create_slug($cat->group_name), $cat->category . "-price-list-in-india",
            false, $page);
    }

    /**
     * CATEGORY LISTING PAGE Controllers..
     *
     * @var Category Name
     */
    public function categoryList($cat_name)
    {
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
                               ->where('active', 1)
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
            $list_desc = DB::table('gc_cat')
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

        if (view()->exists("v2.category.$cat_name")) {
            return view("v2.category.$cat_name", $data);
        }

        return view('v2.category', $data);
    }

    public function topBrands()
    {
        set_time_limit(-1);

        $categories = \DB::table('gc_cat')->select('id')->where('level', '=', '2')->orWhere('level', '=', '3')->get();
        $cat_brands = [];

        foreach ($categories as $key => $category) {
            $aggr_api = composer_url('category_agg.php?category_id=' . $category->id);
            $result   = json_decode(file_get_contents($aggr_api))->return_txt->aggregations->brand;
            $brands   = [];

            foreach ($result->buckets as $brand) {
                $brands[] = ucwords($brand->key);
            }
            if (count($brands) > 0) {
                $cat_brands[$category->id] = $brands;
            }
        }

        file_put_contents("json/category_brands.json", json_encode($cat_brands));
    }

    public function getMeta($string, $brand = '', $category = '')
    {
        if (is_string($string)) {
            $metas = (object)config($string);
        } else {
            $metas = $string;
        }

        foreach ($metas as $key => $meta) {
            $search  = ['{DATE}', '{YEAR}', '{BRAND}', '{GROUP}', '{CATEGORY}'];
            $replace = [
                Carbon::now()->format('F, Y'),
                Carbon::now()->format('Y'),
                ucwords($brand),
                ucwords($category),
                ucwords($category)
            ];

            foreach ($search as $k => $s) {
                $metas->{$key} = preg_replace('/' . $s . '/', $replace[$k], $metas->{$key});
                $metas->{$key} = preg_replace('/\s\s+/', ' ', $metas->{$key});
                $metas->{$key} = preg_replace('/' . $s . '/', $replace[$k], $metas->{$key});
            }
        }

        if (empty($brand) && empty($category)) {
            return (array)$metas;
        } else {
            return $metas;
        }
    }

    public function redirectOldListingPage(Request $request, $parent, $cat_id)
    {
        $category = \DB::table('gc_cat')
                       ->select(['name', 'id', 'group_name', 'level', 'parent_id'])
                       ->whereId($cat_id)
                       ->first();

        if (!is_null($category)) {
            if ($category->level == 2) {
                $cat = \DB::table('gc_cat')
                          ->select(['name', 'id', 'group_name'])
                          ->whereId($category->parent_id)
                          ->first();
                return redirect(route('product_list',
                    [create_slug($cat->group_name), create_slug($cat->name), create_slug($category->name)]), 301);
            } elseif ($category->level == 1) {
                return redirect(route('sub_category',
                    [create_slug($category->group_name), create_slug($category->name)]), 301);
            }
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
    public function subCategoryList(Request $request, $parent = false, $cname = false, $page = 1)
    {
        //print_r($parent);print_r($cname);exit;
        return $this->productList($request, $parent, $cname, false, $page);
    }

    public function getPaginationTarget($url, $array)
    {
        foreach ($array as $field => $value) {
            if ($field != 'page') {
                $url = str_replace('{' . $field . '}', create_slug($value), $url);
            }
        }
        if (strpos($url, '{page?}') === false && strpos($url, '{page}') === false) {
            $url = str_replace(".html", '-{page?}.html', $url);
            $url = str_replace('-90001', '-90001-{page}', $url);
        }
        if (strpos($url, 'html') === false && strpos($url, '{page?}') == false && strpos($url, '{page}') == false) {
            $url = $url . "-{page}";
        }

        return trim($url, "/");
    }

    /**
     * Search wise Product Listing..
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     */
    public function searchList(Request $request, $cat_id, $keyword, $page = 1)
    {
        if ($keyword) {
            if (config('app.searchLogEnable')) {
                /*Logging search text to table*/
                DB::table('gc_search')->insert(['term' => $keyword]);
                /*Logging search text to table*/
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

            $h1 = unslug($keyword) . " Price List in India";
            $request->request->add(["h1" => $h1]);

            $request->request->add(['search_text' => unslug($keyword), $key => $value]);
            return $this->productList($request, false, false, false, $page);

        } else {
            abort(404);
        }

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
    public function childCategoryList(Request $request, $parent = false, $child = false, $cname = false, $page = 1)
    {
        return $this->productList($request, $parent, $cname, $child, $page);
    }

    /**
     * @author Vishal Singh <vishal@manyainternational.com>
     * CategoryWise ProductListing Page for 3rd Level Category Listing..
     *
     * @var \Illuminate\Http\Request
     * @var $slug String (Slug)
     * @var $page Number
     * @return Response
     */
    public function customPageListing(Request $request, $slug, $page = 1)
    {
        $CustomPage = CustomPage::with('category.parent')->whereSlug($slug)->first();

        if (is_null($CustomPage)) {
            abort(404);
        }

        try {
            foreach (json_decode($CustomPage->filters) as $filter => $value) {
                $request->request->add([$filter => $value]);
            }

            foreach (json_decode($CustomPage->meta_data) as $meta => $value) {
                $meta_data[$meta] = $value;
            }

            if (!empty($meta_data)) {
                $request->request->add(['meta_data' => $meta_data]);
            }

        }
        catch (\Exception $E) {
            \Log::error("Custom Pages::" . $E->getMessage() . " " . $E->getTraceAsString());
        }


        $filters         = $request->all();
        $filters['slug'] = $slug;

        $request->request->add(['custom_filters' => $filters]);
        $request->request->add(['apply_filters' => true]);

        $cat = $CustomPage->category;

        if (strtolower($cat->group_name) == strtolower($cat->parent->name)) {
            return $this->productList($request, create_slug($cat->group_name),
                create_slug($cat->name) . "-price-list-in-india.html", false, $page);
        }

        return $this->productList($request, create_slug($cat->group_name),
            create_slug($cat->name) . "-price-list-in-india.html", create_slug($cat->parent->name), $page);
    }

    /**
     * Upcoming Mobile Phone Listing Page.
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
     */
    public function upcomingMobiles(Request $request, $page = 1)
    {
        $request->request->add(['upcoming-mobiles' => true, 'price_filter' => true]);

        return $this->productList($request, "mobile", "mobiles-price-list-in-india", false, $page);
    }

    /**
     * Mobile phone listing Under a any given Max Price..
     *
     * @var \Illuminate\Http\Request
     * @var Maximum Price..
     * @var Page Number
     */
    public function bestPhones(Request $request, $price = 0, $page = 1)
    {
        if (empty($price) || !is_numeric($price)) {
            return redirect("/");
        } else {
            if (!$request->has('saleprice_max')) {

                $title = "Best phone under " . $price;
                //Add price to Request Object Manually and enabling price filter for Listing Controller.
                $request->request->add(['saleprice_max' => $price]);
                $request->request->add(['saleprice_min' => 0]);
                $request->request->add(['price_filter' => 1]);
                $request->request->add(['h1' => $title]);
                $request->request->add(['title' => $title]);
            }

            $request->request->add(['bestphones' => true]);

            return $this->productList($request, "mobile", "mobiles-price-list-in-india", false, $page);
        }
    }

    /**
     * Custom Links
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
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

        return $this->productList($request, "mobile", "dual-sim-phones--mobiles-price-list-in-india", false, $page);
    }

    /**
     * Custom Links
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
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
        return $this->productList($request, "mobile", "android_phones--mobiles-price-list-in-india", false, $page);
    }

    /**
     * Custom Links
     *
     * @var \Illuminate\Http\Request
     * @var Page Number
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

        return $this->productList($request, "mobile", "windows_phones--mobiles-price-list-in-india", false, $page);
    }

    /**
     * List of custom links of men and women
     */
    public function list_of_men_women(Request $request,
        $group,
        $category,
        $keyword,
        $page = 1,
        $order_by = false,
        $sort_order = false)
    {
        $category        = str_replace("lingerie-", "", $category);
        $parent_category = $this->getParentIDByName($category, 2, $group);
        $keyword         = reverse_slug($keyword);
        $title           = ucwords($keyword) . " prices in India 2017 | Indiashopps.com";
        $description     = "List of all " . $keyword . " with prices in India. Check out their new designs , latest trends in fashion , discounts and sale on Indiashopps.com";

        if (empty($parent_category)) {
            $category .= "s";
            $parent_category = $this->getParentIDByName($category, 2, $group);
            if (empty($parent_category)) {
                abort(404);
            }
        }

        $request->request->add([
            "search_text"     => $keyword,
            "group"           => $group,
            "parent_category" => strtolower($parent_category->name),
            "title"           => $title,
            "description"     => $description
        ]);
        $request->request->add(['custom_group_page' => 'yes', 'custom_category' => $category]);
        return $this->productList($request, false, false, false, $page);
    }

    /**
     * List of custom links of category
     */
    public function list_of_category(Request $request, $category, $keyword, $page = 1)
    {
        $group = "lifestyle";
        $cat   = Category::where(DB::raw(" create_slug(name) "), $category)->first();

        $request->request->add(["cat_id" => $cat->id]);
        $h1 = unslug($keyword) . " Price List in India";
        $request->request->add(["h1" => $h1]);
        return $this->list_of_men_women($request, $group, $category, $keyword, $page);
    }

    protected function redirectBackToParent($request, $parent, $cname, $child)
    {
        if ($request->route()->getName() !== 'product_list' && !empty($parent) && !empty($child) && !empty($cname)) {
            $url = route('product_list', [$parent, $child, $cname]);
            return redirect(seoUrl($url), 301);
        } elseif (!empty($parent) && !empty($child) && !empty($cname)) {
            $url = route('sub_category', [$parent, $child]);
            return redirect(seoUrl($url), 301);
        }
        elseif( !empty($parent) && !empty($cname) && !$child )
        {
            $url = route('sub_category', [$parent, $cname]);
            return redirect($url, 301);
        }
        else
        {
            $url = route('category_list', [$parent]);
            return redirect(seoUrl($url), 301);
        }

        return false;
    }
}
