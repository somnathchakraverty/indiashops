<?php namespace indiashopps\Providers;

use View;
use Illuminate\Support\ServiceProvider;


class MenuServiceProvider extends ServiceProvider {

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
       // View::composer('common/top', 'indiashopps\Http\ViewComposers\MenuComposer'); 
        View::composer('v1/common/header', 'indiashopps\Http\ViewComposers\MenuComposer');          
        //View::composer('common/coupontop', 'indiashopps\Http\ViewComposers\MenuComposer');          
        //View::composer('common/footer', 'indiashopps\Http\ViewComposers\FooterComposer');
     //   View::composer('home', 'indiashopps\Http\ViewComposers\MenuComposer');      
		 // Using Closure based composers...
      /*  View::composer('home', function($view)
        {

        });*/
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}