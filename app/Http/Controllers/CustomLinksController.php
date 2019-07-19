<?php namespace indiashopps\Http\Controllers;
use DB;
use indiashopps\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;
use indiashopps\Helpers\Helper;

class CustomLinksController extends ListingController {

	
	/**
	* List all custom links on a HTML page
	*/
	public function listing(Request $request,$group,$category)
	{
		$data["title"] = "List of ".ucwords($group)." ".ucwords(reverse_slug($category))." prices 2017 | Indiashopps.com";
		$data["description"] = "Looking for ".strtolower($group)." ".strtolower(reverse_slug($category)).". We will help you find what other people are mostly searching for ".strtolower($group)." ".strtolower(reverse_slug($category));
		$data["group"] = $group;
		$data["category"] = reverse_slug($category);
		$data["break_point"] = 30;
		$data["i"] = 0;
		$data["list"] = DB::table("custom_link")->where("group_name","like",$group)->where(DB::raw(" create_slug(category) "),"like",$category)->get();
		$data["break_point"] = count($data["list"])/3;
		//echo "<pre>";print_r($data["break_point"]);exit;
		return view("v1.custom.listing",$data);
	}
	/**
	* List of custom links of men and women
	*/
	public function list_of_men_women( Request $request,$group,$category,$keyword, $page=0,$order_by=false,$sort_order=false )
	{
		$category = str_replace("lingerie-", "", $category);
		$parent_category = $this->getParentIDByName($category,2,$group);
		$keyword = reverse_slug($keyword);
		$title = ucwords($keyword)." prices in India 2017 | Indiashopps.com";
		$description = "List of all ".$keyword." with prices in India. Check out their new designs , latest trends in fashion , discounts and sale on Indiashopps.com";
		//echo $category."<br>";
		//print_r($parent_category);
		//echo ",".$group.",".$keyword;
		//exit;
		if(empty($parent_category))
		{
			$category .= "s";
			$parent_category = $this->getParentIDByName($category,2,$group);
			if(empty($parent_category))
				abort(404);
		}
		
		$request->request->add(["search_text" => $keyword,"group" => $group,"parent_category" => strtolower($parent_category->name),"title"=>$title,"description"=>$description]);
		return $this->productList( $request, false, false, false, $page );		
	}


	/**
	* List of custom links of category
	*/
	public function list_of_category( Request $request,$category,$keyword, $page=0,$order_by=false,$sort_order=false )
	{
		$group = "lifestyle";
		if($category == "frames")
			$category = "photo-frames";
		elseif($category == "toys")
			$category = "soft-toys";
		$parent_category = $this->getParentIDByName($category,2,$group);
		$keyword = reverse_slug($keyword);
		$title = "List of ".$keyword." prices in India 2017 | Indiashopps.com";
		$description = "List of all ".$keyword." with prices in India. Check out their new designs , latest trends in fashion , discounts and sale on Indiashopps.com";
		// echo $category."<br>";
		// print_r($parent_category);
		// echo ",".$group.",".$keyword;
		// exit;
		if(empty($parent_category))
		{
			$category .= "s";
			$parent_category = $this->getParentIDByName($category,2,$group);
			if(empty($parent_category))
				abort(404);
		}
		
		$request->request->add(["search_text" => $keyword,"group" => $group,"parent_category" => strtolower($parent_category->name),"title"=>$title,"description"=>$description]);
		return $this->productList( $request, false, false, false, $page );		
	}
}
