<?php

namespace indiashopps\Http\Controllers\v3;

use Illuminate\Http\Request;
use indiashopps\Console\Commands\HeaderJson;

class CommonAjaxController extends BaseController
{
    public function index(Request $request, $section)
    {
        if ($request->ajax()) {
            switch ($section) {
                case 'similar_compare':
                    $c_products = @$_COOKIE['compare_product_list'];

                    if (is_array(json_decode($c_products)) && !empty(json_decode($c_products))) {
                        $pid = json_decode($c_products)[0];
                        $this->solrClient->wherePid($pid);

                        $prod                = $this->solrClient->getProduct(true);
                        $prod                = $prod->product_detail;
                        $data['saleprice']   = $prod->saleprice;
                        $data['name']        = $prod->name;
                        $data['image_url']   = getImageNew($prod->image_url, "M");
                        $data['category_id'] = $prod->category_id;
                        $data['id']          = $prod->id;
                        $data['similar']     = 1;

                        $this->solrClient->whereSaleprice($prod->saleprice)
                                         ->whereCategoryId($prod->category_id)
                                         ->whereId($prod->id)
                                         ->whereSimilar(1);
                        $result = $this->solrClient->getSimilar(true);

                        $data['products'] = $result->result_same_brand->hits->hits;

                        return view('v3.common.similar_compare', $data);
                    }

                    return '';

                    break;

                default:

                    return '';
                    break;
            }
        } else {
            return response('', 403);
        }
    }

    public function menuHtml()
    {
        $header_menu = ((isAmpPage()) ? HeaderJson::ampMenu() : ((isMobile()) ? HeaderJson::mobileMenu() : HeaderJson::headerMenu()));
        return $header_menu;
    }
}
