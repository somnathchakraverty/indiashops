<?php namespace indiashopps\Http\Controllers\custom;
use DB;
use indiashopps\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;
use indiashopps\Helpers\Helper;

class LinksController extends \indiashopps\Http\Controllers\ListingController {

	/**
	* List of custom links of men and women
	*/
	public function dress( Request $request )
	{
		
		$keyword = "dresses";
		$title = "Dresses in India 2017 | Indiashopps.com";
		$description = "List of all dresses with prices in India. Check out their new designs , latest trends in fashion , discounts and sale on Indiashopps.com";
		
		$group = "women";
		$parent_category = "clothing";
		$request->request->add(["search_text" => $keyword,"group" => $group,"parent_category" => strtolower($parent_category),"title"=>$title,"description"=>$description]);
		return $this->productList( $request, false, false, false, 1 );	
	}


}
