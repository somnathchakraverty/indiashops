<?php

namespace indiashopps\Console\Commands;

use Illuminate\Support\Facades\Cache;
use indiashopps\Helpers\Helper;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class HeaderJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:header_json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command generates JSON for Header Section, Version 3..';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->createSlider();
        $this->AppCreateSlider();
        $this->mobileMenuHtml();
    }

    private function mobileMenuHtml()
    {
        $html = self::mobileMenu();

        if (!empty($html)) {
            $html = preg_replace('/[\r\n\t\s]+/s', ' ', $html);
            Storage::disk('local')->put("html/mobile-menu.html", $html);
        }
    }

    public static function headerMenu()
    {
        $category_menu = Cache::remember('categories_header', 43200, function () {
            $data['categories'] = Helper::get_categories_tierd(false, 3);
            $data['menu_brands']['mobiles'] = ["Xiaomi","Samsung","Apple","Vivo","Oppo"];
            $data['menu_brands']['laptops'] = ["Dell","HP","Apple","Acer","Lenovo"];
            $data['menu_brands']['led_tv'] = ["LG","Sony","Samsung","Panasonic","Micromax"];
            $data['menu_brands']['tablets'] = ["Asus","iball","Apple","Samsung","Lenovo"];
            $data['menu_brands']['landline_phones'] = ["Panasonic","Beetel","Binatone","Gigaset","Motorola"];
            $data['banners'] = \DB::connection('backend')->table("menu_banners")->select([
                'image_url',
                'alt',
                'refer_url',
                'category_id'
            ])->whereActive(1)->get()->keyBy('category_id')->toArray();

            return (string)view('v3.common.menu', $data);
        });

        return $category_menu;
    }

    public static function mobileMenu()
    {
        $category_menu = Cache::remember(self::getMenuCacheKey(), 43200, function () {
            $data['categories'] = Helper::get_categories_tierd(false, 3);

            return (string)view('v3.mobile.common.menu', $data);
        });

        return $category_menu;
    }

    public static function ampMenu()
    {

        $amp_menu = Cache::remember(self::getMenuCacheKey(), 43200, function () {
            $data['categories'] = Helper::get_categories_tierd(false, 3);

            return view('v3.amp.menu', $data)->render();
        });

        return $amp_menu;
    }

    public function createSlider()
    {
        Cache::forget('categories_header');
        Cache::forget('mobile_menu');
        Cache::forget('mobile_home_banners');

        $slide_path = '//images.indiashopps.com/v2/slider/';

        $sliders = \DB::connection('backend')
                      ->table("slider")
                      ->select(['image_url', 'alt', 'refer_url'])
                      ->whereApp('0')
                      ->whereHome(1)
                      ->whereActive(1)
                      ->whereVersion('v2')
                      ->orderBy('sequence', "ASC")
                      ->get()
                      ->toArray();

        foreach ($sliders as $key => $slider) {
            $slider->image_url = $slide_path . $slider->image_url;
            $slider->refer_url = $slider->refer_url;
            $slider->alt       = $slider->alt;
            $sliders[$key]     = $slider;
        }

        if (!empty(array_filter($sliders))) {
            Storage::disk('local')->put("JSON/slider.json", json_encode($sliders));
        }
    }

    public function AppCreateSlider()
    {
        $slide_path = '//images.indiashopps.com/v2/slider/';
        $sliders    = \DB::connection('backend')
                         ->table("slider")
                         ->select(['image_url', 'alt', 'refer_url'])
                         ->whereApp('2')
                         ->whereHome(1)
                         ->whereActive(1)
                         ->whereVersion('v2')
                         ->orderBy('sequence', "ASC")
                         ->get()
                         ->toArray();
        foreach ($sliders as $key => $slider) {
            $slider->image_url = $slide_path . $slider->image_url;
            $slider->refer_url = $slider->refer_url;
            $slider->alt       = $slider->alt;
            $sliders[$key]     = $slider;
        }

        if (!empty(array_filter($sliders))) {
            Storage::disk('local')->put("JSON/app_slider.json", json_encode($sliders));
        }
    }

    public static function getMenuCacheKey()
    {
        if (auth()->check()) {
            $key = auth()->user()->id;
        } else {
            $key = "off";
        }

        if (isAmpPage()) {
            return 'amp_menu_' . $key;
        } elseif (isMobile()) {
            return 'mobile_menu_' . $key;
        } else {
            return 'header_menu_' . $key;
        }
    }
}
