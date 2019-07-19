<?php namespace indiashopps\Http\Controllers\v2;

use Illuminate\View\View;
use indiashopps\Http\Requests;
use indiashopps\Http\Controllers\Controller;
use Jenssegers\Agent\Agent as Agent;
use Illuminate\Http\Request;

class CompareController extends Controller
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

                if (count(json_decode(@$_COOKIE['compare_product_list'])) < 2) {
                    $error['error'] = "Please select atleast two products to compare";
                    return view('v2.compare.products', $error);
                }

                $c_prods  = file_get_contents(composer_url('query_mget.php?ids=' . $c_products));
                $c_prods  = json_decode($c_prods);
                $products = $c_prods->docs;
                $products = $this->getSpecification($products);

                if (isset($c_prods->docs[0]) && $c_prods->docs[1]) {
                    $products['title'] = "Compare Products " . $c_prods->docs[0]->_source->name . " VS " . $c_prods->docs[1]->_source->name . " | Indiashopps";
                } else {
                    $products['title'] = "Compare Products | Indiashopps";
                }

                return view('v2.compare.products', $products);
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
        $prod_id1   = explode("-", $prod_id1);
        $prod_id2   = explode("-", $prod_id2);
        $products[] = end($prod_id1);
        $products[] = end($prod_id2);

        $products = array_filter($products);
        // echo count( $products );exit;
        if (count($products) >= 2) {

            // $_COOKIE['compare_product_list'] = json_encode( $products );
            // $cookie = CookieJar::make( 'compare_product_list', json_encode( $products ) );

            $c_prods  = file_get_contents(composer_url('query_mget.php?ids=' . json_encode($products)));
            $c_prods  = json_decode($c_prods);
            $products = $c_prods->docs;
            $products = $this->getSpecification($products);

            if( $products instanceof View )
            {
                return $products;
            }
            //echo "<pre>";print_r($products['products'][0]);exit;
            $products['title'] = $products['products'][0]['details']->name . " vs " . $products['products'][1]['details']->name . " | Indiashopps";

            //reset the cookie list..
            return response()
                ->view('v2.compare.products', $products)
                ->withCookie(cookie('compare_mobile_list', "", 1000));
        } else {
            $data['error'] = "No Product Selected..";
            return view('v2.compare.products', $data);
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
            $data['products'][$p->_id] = $p->_source;
        }
        $data["title"]       = "Compare Most Popular Mobile Phones by Price, Features & Specification";
        $data["description"] = "Indiashopps.com is one of the most popular online Mobile Price Comparison store. Enables you to Compare Most Popular Mobile Phones with latest offers, deals & discounts coupons.";
        // Show the mobiles list..
        return view('v2.compare.most-compared', $data);
    }

    /**
     * Compare two mobiles with their Product ID
     *
     * @var Product Specification
     * @var Mobile #1 ID
     * @return HTML Content
     */
    private function getSpecification($products)
    {
        try {
            $p_key = [];
            $i     = 0;
            //Seperate the HTML specification in a format that can be used to compare the same feature.
            foreach ($products as $product) {
                $html = $product->_source->specification;

                $export = [];

                $dom = new \DOMDocument();
                libxml_use_internal_errors(true);

                if (!empty($html)) {
                    $dom->loadHTML($html);
                }

                libxml_clear_errors();

                $xpath = new \DOMXPath($dom);

                $key = "";

                foreach ($xpath->evaluate('//tr') as $sel) {

                    $index = 0;

                    foreach ($sel->childNodes as $node) {
                        if (strtolower($node->tagName) == 'th') {
                            $key = strip_tags($node->ownerDocument->saveHTML($node));
                            // dd( $node );
                        }

                        if (strtolower($node->tagName) == 'td') {

                            $innerHTML = "";

                            foreach ($node->childNodes as $child) {
                                if ($index == 0) {
                                    $td_key               = $node->ownerDocument->saveHTML($child);
                                    $p_key[$key][$td_key] = "";
                                } else {
                                    $innerHTML = $node->ownerDocument->saveHTML($child);
                                }

                                $index++;
                            }

                            $export[$key][$td_key] = $innerHTML;
                        }
                    }
                }

                $return['products'][$i]['features'] = $export;
                $return['products'][$i]['details']  = $product->_source;
                $i++;
            }

            $return['keys'] = $p_key;

            return $return;
        }
        catch (\Exception $e) {
            $request = new \Illuminate\Http\Request();
            $product = new ProductController( $request );
            return $product->productDiscontinued( $products[0]->_source->name );
        };

    }
}
