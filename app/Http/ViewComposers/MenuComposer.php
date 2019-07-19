<?php namespace indiashopps\Http\ViewComposers;
use DB;
use Illuminate\Contracts\View\View;
//use Illuminate\Users\Repository as UserRepository;
use indiashopps\Models\MenuModel as menu;
class MenuComposer {

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
       // $this->users = $users;
    }

   function get_categories($parent = false)
	{
		$result	= array();
		if ($parent !== false)
		{
			//->where('parent_id',$parent_id)->get();
			$result	= DB::table('gc_cat')->where('parent_id',$parent)->where('active',1)->where('level','<',1)->orderBy('sequence', 'ASC')->lists('id');
		}else{
			$result	= DB::table('gc_cat')->where('active',1)->lists('id')->where('level','<',3)->order_by('sequence', 'ASC');
		}
		//print_r($result);exit;
		$categories	= array();		
		foreach($result as $cat)
		{			
			$categories[]	= $this->get_category($cat);
		}		
		return $categories;		
	}	
	//this is for building a menu
	function get_categories_tierd($parent=0)
	{
		$categories	= array();
		$result	= $this->get_categories($parent);
		foreach ($result as $category)
		{
			$categories[$category->id]['category']	= $category;
			$categories[$category->id]['children']	= $this->get_categories_tierd($category->id);
		}
		return $categories;
	}
	function get_category($id)
	{
		
		//return $this->db->get_where('cat', array('id'=>$id))->row();
		 return DB::table('gc_cat')->where('id',$id)->first();
	}
    public function compose(View $view)
    {		
		//$cat = DB::table('gc_cat')->where('level',0)->get();
		$nav 		= $this->get_categories_tierd();	
		$action 	= app('request')->route()->getAction();
		$controller = class_basename($action['controller']);

		list($controller, $action) = explode('Controller@', $controller);
		
        $view->with(array('navigation' => $nav, 'controller' => $controller ) );
    }

}