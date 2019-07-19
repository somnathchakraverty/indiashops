<?php

namespace indiashopps\Http\Controllers\v3;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use indiashopps\Console\Commands\HeaderJson;
use indiashopps\Console\Commands\HomeJsonCommand;
use indiashopps\Models\DealsCat;

class HomeController extends BaseController
{
    const HAS_WIDGET = 'widget';

    public function index(Request $request)
    {
        $this->seo->setContent(view('v2.footer.description'));

        $data['home_content'] = HomeJsonCommand::homePageContent();
        $data['sliders']      = storageJson("JSON/slider.json");
        $data['header_menu']  = HeaderJson::headerMenu();

        enqueueWidget('find_lowest', [], '', true);

        return view('v3.home.index', $data);
    }

    public function getHomeAjaxContent(Request $request, $section = '')
    {
        if (empty($section)) {
            return '';
        }

        $data['headers'] = getJSONContent('url.header_json_url');
        $data['section'] = $section;
        $html            = '';

        switch ($section) {
            case 'trending_of_the_day':
            case 'trending_of_the_day_search':

                if ($section == 'trending_of_the_day_search') {
                    request()->request->add(['ajax' => true]);

                    $var  = HomeJsonCommand::searchDealOfTheDay($request);
                    $html = getAjaxWidget('deal_of_the_day', $var, 'products');
                } else {
                    $data['section']  = 'deal_of_the_day';
                    $data['key']      = '';
                    $data['variable'] = 'products';
                    $data['type']     = self::HAS_WIDGET;
                }

                break;

            case 'deals_on_gadgets':
                $data['section']  = 'deal_gadgets';
                $data['key']      = 'tablets';
                $data['variable'] = 'products';
                $data['type']     = self::HAS_WIDGET;

                break;

            case 'deals_on_phone':
                $data['section']  = 'deals_on_phone';
                $data['key']      = 'below_ten';
                $data['type']     = self::HAS_WIDGET;
                $data['variable'] = 'vendors';
                $data['tab']      = '1';

                break;

            case 'trending_comp':
                $data['section']  = 'comparison';
                $data['key']      = 'phone';
                $data['variable'] = 'products';
                $data['type']     = self::HAS_WIDGET;

                break;

            case 'coupons':
            case 'coupons_search':

                if ($section == 'coupons_search') {
                    $data['ajax']    = true;
                    $data['coupons'] = HomeJsonCommand::searchCoupon($request);
                } else {
                    $data['cats']    = DealsCat::select(['id', 'name'])->get();
                    $data['coupons'] = storageJson("JSON/deals.json", 'coupons');
                }

                if (isMobile()) {
                    $html = (string)view('v3.mobile.widget.coupons.content', $data);
                } else {
                    $html = (string)view('v3.home.snippet.coupons', $data);
                }

                break;

            case 'top_deals_acc':
                $data['section']  = 'top_deals';
                $data['key']      = 'headphones';
                $data['type']     = self::HAS_WIDGET;
                $data['variable'] = 'products';

                break;

            case 'group_deals':
                $json             = storageJson("JSON/group_deals.json");
                $data['groups']   = collect($json)->keys();
                $data['section']  = 'group_deals';
                $data['key']      = $data['groups']->first();
                $data['type']     = self::HAS_WIDGET;
                $data['variable'] = 'slides';
                break;

            case 'group_deals_ajax':
                request()->request->add(['ajax' => true]);
                $data['section']  = 'group_deals';
                $data['key']      = create_slug(request()->get('sub_section'));
                $data['type']     = self::HAS_WIDGET;
                $data['variable'] = 'slides';
                break;

            case 'gadget_tips':
                $data['section']  = 'blog';
                $data['key']      = '';
                $data['variable'] = 'blogs';

                if (isMobile()) {
                    $data['view'] = 'v3.home.snippet.mobile.gadget_tips';
                } else {
                    $data['view'] = 'v3.home.snippet.gadget_tips';
                }

                break;

            case 'finance_service':
                $data['section']   = 'loans';
                $data['key']       = 'personal';
                $data['type']      = self::HAS_WIDGET;
                $data['variable']  = 'loans';
                $data['loan_type'] = "personal";

                break;

            case 'partner_deals':
                $data['section']  = 'deals';
                $data['key']      = 'deals';
                $data['type']     = self::HAS_WIDGET;
                $data['variable'] = 'deals';

                break;

            case 'gadget_laptops':
                request()->request->add(['ajax' => true]);

                $data['section']  = 'deal_gadgets';
                $data['key']      = 'laptops';
                $data['type']     = self::HAS_WIDGET;
                $data['variable'] = 'products';

                request()->request->add(['ajax' => true]);

                break;

            case 'gadget_cameras':
                request()->request->add(['ajax' => true]);

                $data['section']  = 'deal_gadgets';
                $data['key']      = 'cameras';
                $data['type']     = self::HAS_WIDGET;
                $data['variable'] = 'products';

                request()->request->add(['ajax' => true]);

                break;

            case 'deal_under_ten':
                request()->request->add(['ajax' => true]);

                $data['section']  = 'deals_on_phone';
                $data['key']      = 'below_fifteen';
                $data['type']     = self::HAS_WIDGET;
                $data['variable'] = 'vendors';
                $data['tab']      = '2';

                break;

            case 'deal_under_twenty':
                request()->request->add(['ajax' => true]);

                $data['section']  = 'deals_on_phone';
                $data['key']      = 'below_twenty';
                $data['type']     = self::HAS_WIDGET;
                $data['variable'] = 'vendors';
                $data['tab']      = '3';

                break;

            case 'deal_under_thirty':
                request()->request->add(['ajax' => true]);

                $data['section']  = 'deals_on_phone';
                $data['key']      = 'below_thirty';
                $data['type']     = self::HAS_WIDGET;
                $data['variable'] = 'vendors';
                $data['tab']      = '4';

                break;

            case 'deal_above_thirty':
                request()->request->add(['ajax' => true]);

                $data['section']  = 'deals_on_phone';
                $data['key']      = 'above_thirty';
                $data['type']     = self::HAS_WIDGET;
                $data['variable'] = 'vendors';
                $data['tab']      = '5';

                break;

            case 'trending_comp_laptops':
                request()->request->add(['ajax' => true]);

                $data['section']  = 'comparison';
                $data['key']      = 'laptops';
                $data['variable'] = 'products';
                $data['type']     = self::HAS_WIDGET;

                break;

            case 'trending_comp_cameras':
                request()->request->add(['ajax' => true]);

                $data['section']  = 'comparison';
                $data['key']      = 'cameras';
                $data['variable'] = 'products';
                $data['type']     = self::HAS_WIDGET;

                break;

            case 'top_deals_acc_speakers':
                request()->request->add(['ajax' => true]);

                $data['section']  = 'top_deals';
                $data['key']      = 'speakers';
                $data['type']     = self::HAS_WIDGET;
                $data['variable'] = 'products';

                break;

            case 'top_deals_acc_memory':
                request()->request->add(['ajax' => true]);
                $data['section']  = 'top_deals';
                $data['key']      = 'memory_card';
                $data['type']     = self::HAS_WIDGET;
                $data['variable'] = 'products';

                break;

            case 'top_deals_acc_smart':
                request()->request->add(['ajax' => true]);
                $data['section']  = 'top_deals';
                $data['key']      = 'smart_watch';
                $data['type']     = self::HAS_WIDGET;
                $data['variable'] = 'products';

                break;

            case 'home_loan':
                request()->request->add(['ajax' => true]);

                $data['section']   = 'loans';
                $data['key']       = 'home';
                $data['type']      = self::HAS_WIDGET;
                $data['variable']  = 'loans';
                $data['loan_type'] = "home";

                break;

            case 'car_loan':
                request()->request->add(['ajax' => true]);

                $data['section']   = 'loans';
                $data['key']       = 'car';
                $data['type']      = self::HAS_WIDGET;
                $data['variable']  = 'loans';
                $data['loan_type'] = "car";

                break;

            default:

                $html = '';
                break;
        }

        if (@$data['type'] == 'widget') {
            $html = $this->getWidgetContent($data);
        }

        if (empty($html) && isset($data['view'])) {
            $html = $this->cacheContent($data, $data['variable']);
        }

        return $html;
    }

    private function getWidgetContent(&$data)
    {
        if (isMobile()) {
            $cache_key = 'home_mobile_' . $data['section'] . "_" . $data['key'];
        } else {
            $cache_key = 'home_' . $data['section'] . "_" . $data['key'];
        }

        if (env('APP_ENV') == 'local' && env('CACHE_SECTIONS') === false) {
            $var = storageJson("JSON/" . $data['section'] . ".json", $data['key']);
            return getAjaxWidget($data['section'], $var, $data['variable'], $data);
        } else {
            $html = Cache::remember($cache_key, 3600, function () use ($data) {
                $var = storageJson("JSON/" . $data['section'] . ".json", $data['key']);
                return getAjaxWidget($data['section'], $var, $data['variable'], $data);
            });

            return $html;
        }
    }

    private function cacheContent(&$data, $variable = 'products')
    {
        $cache_key = 'home_' . $data['section'] . "_" . $data['key'];

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
}
