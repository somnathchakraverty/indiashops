<?php

namespace indiashopps\Http\Controllers\android;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use indiashopps\Http\Controllers\Controller;
use indiashopps\Console\Commands\HomeJsonCommand as Helper;
use DB;
use indiashopps\Models\AppFeedback;

class ApiController extends Controller
{
    public function homeJson()
    {
        try {
            $loan_banners    = [
                ['image_url' => 'https://www.indiashopps.com/loans/public/v1/images/banner.jpg'],
                ['image_url' => 'https://www.indiashopps.com/loans/public/v1/images/banner2.jpg'],
                ['image_url' => 'https://www.indiashopps.com/loans/public/v1/images/banner3.jpg'],
                ['image_url' => 'https://www.indiashopps.com/loans/public/v1/images/banner4.jpg'],
                ['image_url' => 'https://www.indiashopps.com/loans/public/v1/images/banner5.jpg']
            ];
            $coupon_home_id  = 829;
            $coupons_sliders = \DB::table('home_slider')->whereCatId($coupon_home_id)->whereFor(2)->get()->toArray();
            foreach ($coupons_sliders as $key => $slider) {
                $sliderData['image_url'] = $slider->image_url;
                $sliderData['refer_url'] = $slider->refer_url;
                $sliderData['alt']       = $slider->alt;
                $coupons_sliders[$key]   = $sliderData;
            }
            $data['loan_sliders']    = $loan_banners;
            $data['coupon_sliders']  = empty($coupons_sliders) ? null : $coupons_sliders;
            $data['sliders']         = storageJson(Helper::getJsonFile('app_slider'));
            $data['comparison']      = storageJson(Helper::getJsonFile('comparison'));
            $data['group_deals']     = storageJson(Helper::getJsonFile('group_deals'));
            $data['deal_of_the_day'] = storageJson(Helper::getJsonFile('deal_of_the_day'));
            $data['deals_on_phone']  = storageJson(Helper::getJsonFile('deals_on_phone'));
            $data['deal_gadgets']    = storageJson(Helper::getJsonFile('deal_gadgets'));
            $data['top_deals']       = storageJson(Helper::getJsonFile('top_deals'));

            $data['coupons']       = storageJson(Helper::getJsonFile('deals'), 'coupons');
            $data['loans']         = storageJson(Helper::getJsonFile('loans'));
            $data['blog']          = storageJson(Helper::getJsonFile('blog'));
            $data['partner_deals'] = storageJson(Helper::getJsonFile('deals'), 'deals');
            $data['loans_details'] = storageJson(Helper::getJsonFile('loans_all_details'));
            $data['best_coupons']  = storageJson(Helper::getJsonFile('best_coupons'));


            return response()->json($data);
        }
        catch (\Exception $e) {
            \Log::error("Android API error:: " . $e->getMessage());
        }
    }

    public function insertFeedback(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required',
            'feedback'  => 'required|min:10',
        ]);

        if ($validator->fails()) {
            return response($validator->messages(), 422);
        }
        $data               = $request->only(['device_id', 'feedback']);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        AppFeedback::insert($data);

        return response(['Feedback Inserted..!!']);
    }

    public function getToken()
    {
        return response(['_token' => csrf_token()]);
    }
}
