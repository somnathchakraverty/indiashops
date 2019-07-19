<?php namespace indiashopps\Http\ViewComposers;
use DB;
use Illuminate\Contracts\View\View;
//use Illuminate\Users\Repository as UserRepository;
use indiashopps\Models\MenuModel as menu;
class FooterComposer {

    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
       // Dependencies automatically resolved by service container...
       
    }

   	private function getBestSeller()
	{
		$cats = array(147,4);
		$prods = file_get_contents('http://www.indiashopps.com/ext/composer/query_mget.php?ids='.json_encode($cats) );
		$prods = json_decode( $prods );

		return $prods;
	}	
	
    public function compose(View $view)
    {
		$best = $this->getBestSeller();		
        $view->with('best_sellers', $best);
    }

}