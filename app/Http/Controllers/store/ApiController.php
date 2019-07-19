<?php

namespace indiashopps\Http\Controllers\store;

use Illuminate\Http\Request;
use indiashopps\Http\Controllers\v3\BaseController;
use indiashopps\Jobs\UpcomingPhoneLaunched;
use indiashopps\Models\UpcomingSubscriber;
use indiashopps\Support\SolrClient\Facade\Solr;

class ApiController extends BaseController
{
    public function productLaunched(Request $request, $product_id)
    {
        if (empty($product_id)) {
            return response()->json('Invalid Product ID ..', 400);
        } else {
            $subscriber_count = UpcomingSubscriber::whereProductId($product_id)
                                                  ->whereNotified(UpcomingSubscriber::USER_NOT_NOTIFIED)
                                                  ->count();

            if ($subscriber_count > 0) {
                $solr    = Solr::getInstance();
                $product = $solr->wherePid($product_id)->getProduct(true);
                $product = $product->product_detail;

                if (isComingSoon($product)) {
                    send_slack_alert("Product_ID :: $product_id, Phones has not been launched yet", 'notifications');
                    return response()->json(["Product_ID :: $product_id, Phones has not been launched yet"], 409);
                }

                \Queue::push(new UpcomingPhoneLaunched($product_id));

                return response()->json(['Request Submitted, and subscribers will be notified soon..'], 202);
            } else {
                return response()->json(['No subscriber found for this Product.. :)'], 206);
            }
        }
    }
}
