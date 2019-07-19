<?php

namespace indiashopps\Http\Controllers\v3;

use Illuminate\Http\Request;
use indiashopps\Category;
use Jenssegers\Agent\Agent;

class
CompareController extends BaseController
{
    /**
     * Compare Controller for comparing mobiles.. Maximum 4 Mobiles..
     *
     * @var \Illuminate\Http\Request
     * @return Response
     */

    public function index(Request $request)
    {
        $Agent = new Agent();

        if ($Agent->isMobile()) {
            // If accessed from Mobile redirect to home page.
            return redirect("/");
        } else {
            //Get the cookies stored for comparing the product... Product are added in cookie using Javascript.. Add products code resides in /js/compare.js

            $cookie = $request->cookie('compare_mobile_list');

            if (!empty($cookie) && !is_null($cookie)) {

                $c_prods  = file_get_contents(composer_url('query_mget.php?ids=' . $cookie));
                $c_prods  = json_decode($c_prods);
                $products = $c_prods->docs;
                $products = $this->getSpecification($products);

                return response()
                    ->view('compare-products', $products)
                    ->withCookie(cookie('compare_mobile_list', "", 1000));
            } else {
                $c_products = @$_COOKIE['compare_product_list'];

                if (is_array(json_decode($c_products)) && !empty(json_decode($c_products))) {
                    $c_prods  = $this->solrClient->whereIds($c_products)->getCompareList(true);
                    $products = $c_prods->docs;

                    $data = $this->getSpecification($products);

                    if (count($c_prods->docs) > 1 && isset($c_prods->docs[0]) && $c_prods->docs[1]) {
                        $this->seo->setTitle("Compare Products " . $c_prods->docs[0]->_source->name . " VS " . $c_prods->docs[1]->_source->name . " | Indiashopps");
                    } else {
                        $this->seo->setTitle("Compare Products | Indiashopps");
                    }

                    $data['has_product'] = true;
                } else {
                    $data['error'] = "Please select atleast one product to compare";
                }

                return view("v3.compare_products", $data);
            }
        }
    }

    /**
     * Compare two mobiles with their Product ID
     *
     * @var \Illuminate\Http\Request
     * @var Mobile #1 ID
     * @var Mobile #2 ID
     * @return Response
     */
    public function compareMobile($prod_id1 = 0, $prod_id2 = 0)
    {
        $prod_id1     = explode("-", $prod_id1);
        $prod_id2     = explode("-", $prod_id2);
        $products[]   = end($prod_id1);
        $products[]   = end($prod_id2);
        $products_ids = array_filter($products);

        // echo count( $products );exit;
        if (count($products_ids) >= 2) {

            $c_prods  = $this->solrClient->whereIds(json_encode($products_ids))->getCompareList(true);
            $products = $c_prods->docs;


            $data = $this->getSpecification($products);

            if (empty($data)) {
                abort(404);
            }
            
            $this->addAttributesToProductName($products[0]->_source);
            $this->addAttributesToProductName($products[1]->_source);

            $names[] = $products[0]->_source->name;
            $names[] = $products[1]->_source->name;

            if ($products[0]->_source->category_id == Category::MOBILE) {
                $category = 'Mobile Phones';
            } else {
                $category = ucwords($products[0]->_source->category);
            }

            $compare_names = implode(" vs ", $names);

            $this->seo->setTitle("Compare " . $compare_names . " $category @ IndiaShopps");
            $this->seo->setDescription("$compare_names - Compare price, features, specifications and reviews at IndiaShopps. Buy best phone online with in your budget.");
            $this->seo->setKeywords("$compare_names, $compare_names Price, $compare_names Price in India");
            $this->seo->setHeading($compare_names);

            $data['has_product']    = true;
            $data['manual_compare'] = true;

            //reset the cookie list..
            return response()->view('v3.compare_products', $data)->withCookie(cookie('compare_mobile_list', "", 1000));
        } else {
            $data['error'] = "No Product Selected..";
            return view('v3.compare_products', $data);
        }
    }

    /**
     * Most Compared mobiles list... Mobiles are built in pairs i.e mobile1ID:mobile2ID
     *
     * @var \Illuminate\Http\Request
     * @return Response
     */
    public function mostCompared(Request $request)
    {
        $compare = [
            "93651:93557",
            "91633:121674",
            "121678:121696",
            "121679:80345",
            "80706:91633",
            "121743:121487",
            "93651:121723",
            "121692:121675",
            "80820:121694",
            "34:93557",
            "121692:121674",
            "121675:121925",
            "122195:121708",
            "80349:122196",
            "121534:93581",
            "231:121513",
            "121524:121683",
            "80820:93557",
            "122197:121692",
            "80706:121675",
            "80820:121694",
            "93557:121714"
        ];
        $ids     = [];

        foreach ($compare as $value) {
            $value = explode(":", $value);

            if (!in_array($value[0], $ids)) {
                $ids[] = $value[0];
            }

            if (!in_array($value[1], $ids)) {
                $ids[] = $value[1];
            }
        }

        // Get the list of all mobile phone with above mentioned PRODUCT ID
        $c_prods  = file_get_contents(composer_url('query_mget.php?ids=' . json_encode($ids)));
        $c_prods  = json_decode($c_prods);
        $products = $c_prods->docs;

        $data['products'] = [];
        $data['list']     = $compare;

        foreach ($products as $p) {
            if (isset($p->_source)) {
                $data['products'][$p->_id] = $p->_source;
            }
        }

        $this->processMetaByRoute();
        // Show the mobiles list..
        return view('v3.compare.most-compared', $data);
    }

    /**
     * Compare two mobiles with their Product ID
     *
     * @var Product Specification
     * @var Mobile #1 ID
     * @return HTML Content
     */
    public function getSpecification($products)
    {
        try {
            $p_key = [];
            $i     = 0;

            try {
                //Seperate the HTML specification in a format that can be used to compare the same feature.
                foreach ($products as $product) {

                    if (isset($product->_source)) {
                        $product = $product->_source;
                    }

                    $html   = $product->specification;
                    $export = [];

                    $dom = new \DOMDocument();
                    libxml_use_internal_errors(true);

                    if (!empty($html)) {
                        $dom->loadHTML($html);
                    }

                    libxml_clear_errors();

                    $xpath = new \DOMXPath($dom);

                    $key = "";

                    foreach ($xpath->evaluate('//div[@class="spec_box"]') as $sel) {
                        $box = new \DOMDocument();
                        $box->loadHTML($sel->ownerDocument->saveHTML($sel));
                        $box_xpath = new \DOMXPath($box);

                        $key = $box_xpath->evaluate('//span[@class="specHead"]')[0]->textContent;

                        foreach ($box_xpath->evaluate('//table//tr') as $node) {

                            foreach ($node->childNodes as $child_node) {
                                if (strtolower($child_node->nodeName) == 'th') {
                                    $td_key = strip_tags($child_node->textContent);
                                }

                                if (strtolower($child_node->nodeName) == 'td') {
                                    $export[$key][$td_key] = $child_node->textContent;
                                    $p_key[$key][$td_key]  = "";
                                }
                            }
                        }
                    }

                    $return['products'][$i]['features'] = $export;
                    $return['products'][$i]['details']  = $product;
                    $i++;
                }

                $return['keys'] = $p_key;

                return $return;
            }
            catch (\Exception $e) {
                return [];
            }
        }
        catch (\Exception $e) {
            $request = new Request();
            $product = new ProductController($request);
            return $product->productDiscontinued($products[0]->_source->name);
        };

    }
}
