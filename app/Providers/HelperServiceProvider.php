<?php namespace indiashopps\Providers;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider {

   protected $helpers = [
        // Add your helpers in here
		'image','helper'
    ];

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        foreach ($this->helpers as $helper) {
            $helper_path = app_path().'/Helpers/'.$helper.'.php';
           // $helper_path = app_path().'\\Helpers\\'.$helper.'.php';
	
            if (\File::isFile($helper_path)) {
				//echo $helper_path;exit;
                require_once $helper_path;
            }
        }
    }

}