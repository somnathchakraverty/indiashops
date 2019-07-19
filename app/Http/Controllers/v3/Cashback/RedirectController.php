<?php

namespace indiashopps\Http\Controllers\v3\Cashback;

use Illuminate\Http\Request;
use indiashopps\Models\Cashback\AffiliateClick;
use indiashopps\Http\Controllers\v3\BaseController;
use indiashopps\User;

class RedirectController extends BaseController
{
    private $click_id;
    private $vendor_id;
    private $network_id;
    private $cb_enabled = false;

    public function __construct()
    {
        $this->click_id = str_random(3) . uniqid();
        parent::__construct();
    }

    /**
     * Redirect to Store for Comparative Product
     *
     * @return Response
     */
    public function redirectComp($id, $ref_id)
    {
        // $product = $this->solrClient->whereId($id)->getVendors(true);
        $product = $this->solrClient->whereRef_id($ref_id)->getVendor(true);
        // $product = $this->solrClient->getVendors($id);
        // echo "<pre>";print_r($product);exit;
        // $vendors = $product->return_txt->hits->hits;
        if(isset($product->return_txt)){
            $vendor = $product->return_txt;
        }else{
            $product = $this->solrClient->whereRef_id($ref_id)->getVendor(true);
            $vendor = $product->return_txt;
        }
        // echo "<pre>";print_r($vendors);exit;
        if (is_null($product) || is_null($vendor)) {
            abort(404);
        }

        // $vendors = collect($vendors);
        try {
            // $vendors = $vendors->map(function ($vendor) {
            //     return $vendor->_source;
            // })->keyBy('ref_id');

            // $vendor = $vendors->get($ref_id);

            if(isset($vendor->cb_allowed) && empty($vendor->cb_allowed))
            {
                $redirect_url = $vendor->product_url;
            }
            elseif ($this->isCashbackEnabled($vendor->vendor)) {
                $redirect_url = $vendor->original_link;
            } else {
                $redirect_url = $vendor->product_url;
            }

            $vendor = $vendor->vendor;
        }
        catch (\Exception $e) {
            $redirect_url = $vendors->first()->_source->original_url;
            $vendor       = $vendors->first()->_source->vendor;
        }

        return $this->showRedirectPage($redirect_url, $vendor);
    }

    /**
     * Redirect to Store for Non Comparative Product
     *
     * @return Response
     */
    public function redirectNonComp($id, $vendor)
    {
        $product_id = $id . "-" . $vendor;

        $getSession= session()->get('solr_previous_filter');
        if(isset($getSession['isBook']) && !empty($getSession)) {
            $this->solrClient->param("isBook", "true");
        }

        $result  = $this->solrClient->wherePid($product_id)->getProduct(true);
        $product = $result->product_detail;

        if (is_null($product)) {
            abort(404);
        }

        if (isset($product->original_link)) {
            if ($this->isCashbackEnabled($vendor)) {
                $redirect_url = $product->original_link;
            } else {
                $redirect_url = $product->product_url;
            }
        } else {
            $redirect_url = $product->product_url;
        }

        return $this->showRedirectPage($redirect_url, $vendor);
    }

    public function vendorRedirect($vendor_id)
    {
        $url = config('vendor.url.' . $vendor_id);

        if ($this->isCashbackEnabled($vendor_id)) {
            $redirect_url = $url;
        } else {
            abort(404);
        }

        return $this->showRedirectPage($redirect_url, $vendor_id, AffiliateClick::CB_DASHBOARD_OBJECT);
    }

    public function couponRedirect($offerid)
    {
        $coupon = $this->solrClient->whereOfferid($offerid)->getCoupon(true);

        if (count($coupon->return_txt->hits->hits) > 0) {
            $coupon = collect($coupon->return_txt->hits->hits)->first();

            if (isset($coupon->_source)) {
                $coupon = $coupon->_source;
            }

            $data['coupon'] = $coupon;

            if (isset($coupon->original_link)) {
                if ($this->isCashbackEnabled($coupon->vendor)) {
                    $redirect_url = $coupon->original_link;
                } else {
                    $redirect_url = $coupon->offer_page;
                }
            } else {
                $redirect_url = $coupon->offer_page;
            }

            $this->seo->setTitle("Indiashopps - Redirect to " . $coupon->vendor_name . " ...");

            $url = $this->generateAffiliateLink($redirect_url, $coupon->vendor);

            if ($this->cb_enabled) {
                $this->saveClick($url, AffiliateClick::COUPON_OBJECT);
            }

            $data['vendor']       = $coupon->vendor_name;
            $data['vendor_image'] = $coupon->vendor_logo;
            $data['redirect_url'] = $url;

            return view("v3.coupons.redirect", $data);
        } else {
            return redirect('coupon_v2');
        }
    }

    protected function generateAffiliateLink($url, $vendor_id)
    {
        $select = "SELECT `getAffiliateLink`('$url', $vendor_id) AS `affiliate_link`";
        $return = \DB::select(\DB::raw($select));

        if (isset($return[0]) && !empty($return[0])) {
            return str_replace('{#clickid}', $this->click_id, $return[0]->affiliate_link);
        }
    }

    protected function showRedirectPage($redirect_url, $vendor, $object = AffiliateClick::STORE_OBJECT)
    {
        if ($this->cb_enabled) {
            $url = $this->generateAffiliateLink($redirect_url, $vendor);
            $this->saveClick($url, $object);
        }
        else
        {
            $url = $redirect_url;
        }

        $data['vendor']       = config('vendor.name.' . $vendor);
        $data['vendor_image'] = config('vendor.logo.' . $vendor);
        $data['redirect_url'] = $url;

        if (isMobile()) {
            return view('v3.mobile.product.redirect', $data);
        } else {
            return view('v3.product.detail.redirect', $data);
        }
    }

    private function isCashbackEnabled($vendor_id)
    {
        $row = \DB::table('tb_vendor_settings')
                  ->where('vendor_id', $vendor_id)
                  ->where('cashback_enabled', 'Y')
                  ->first();

        if (is_null($row)) {
            return false;
        } else {
            $this->vendor_id  = $vendor_id;
            $this->network_id = $row->network_id;
            $this->cb_enabled = true;

            return true;
        }
    }

    protected function saveClick($url, $object = AffiliateClick::STORE_OBJECT)
    {
        $click = new AffiliateClick;

        $click->click_id    = $this->click_id;
        $click->vendor_id   = $this->vendor_id;
        $click->network_id  = $this->network_id;
        $click->object_type = $object;
        $click->object_id   = AffiliateClick::STORE_ID;
        $click->user_id     = User::getCashbackUserId();
        $click->out_link    = $url;
        $click->ip_address  = $this->getUserIP();
        $click->referral    = request()->server('HTTP_REFERER');
        $click->user_agent  = request()->server('HTTP_USER_AGENT');

        $click->save();
    }

    protected function getUserIP()
    {
        $client  = request()->server('HTTP_CLIENT_IP');
        $forward = request()->server('HTTP_X_FORWARDED_FOR');
        $remote  = request()->server('REMOTE_ADDR');

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }

        return $ip;
    }

    public function extRedirect(Request $request)
    {
        if ($request->has('url')) {
            $url = urldecode($request->get('url'));

            $vendor = ($request->has('vendor')) ? $request->get('vendor') : 0;

            return $this->showRedirectPage($url, $vendor);
        }

        return redirect()->route('home_v2', ['utm_source' => 'extension']);
    }
}
