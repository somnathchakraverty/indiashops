<?php namespace indiashopps\Http\ViewComposers;


use DB;
use Illuminate\Contracts\View\View;
use indiashopps\Console\Commands\HeaderJson;
use Jenssegers\Agent\Agent as Agent;

class MenuComposerV2
{

    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository $users
     *
     * @return void
     */

    public function compose(View $view)
    {
        //$cat = DB::table('gc_cat')->where('level',0)->get();
        if (!is_null(request()->route())) {
            $action = request()->route()->getAction();
            $route  = class_basename($action['controller']);
            list($controller) = explode("@", $route);

            $header = (object)config('menu');

            if ($controller == 'CouponController') {
                $header->search = DB::table('and_deals_cat')->get();
                $header->type   = "coupons";
                $header->title  = "Search Best Coupons....";
                $header->url    = secureUrl(url('couponsearch'));
            } else {
                $header->title = "Search Best Prices. Compare Before Your Buy ...";
                $header->url   = secureUrl(url('search'));
                $header->type  = "site";
            }

            $mobile = ((new Agent())->isDesktop()) ? false : true;

            $cat_menu = file_get_contents(config('url.menu_json_url'));

            /*$header_menu = ((isAmpPage()) ? HeaderJson::ampMenu() : (($mobile) ? HeaderJson::mobileMenu() : HeaderJson::headerMenu()));*/
            $header_menu = (isAmpPage()) ? HeaderJson::ampMenu() : '';

            $view->with([
                'headers' => $header, 'cat_menu' => $cat_menu, "is_mobile" => $mobile, "header_menu" => $header_menu
            ]);
        }
    }

}