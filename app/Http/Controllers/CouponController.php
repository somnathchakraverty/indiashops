<?php namespace indiashopps\Http\Controllers;
use DB;
use indiashopps\Http\Controllers\Controller;
use Illuminate\Http\Request;
use indiashopps\Helpers\helper;
use Mail;

class CouponController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/*
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
	}

	/**
	 * Show the application Coupon Page to the user.
	 *
	 * @return Response
	 */
	public function index($page=0)
	{
		$data['type'] 	    = "Coupon";	   
		$data['term'] 		= json_encode($data);
		$searchAPI 			= composer_url( 'deals.php' );
		$result			 	= file_get_contents($searchAPI.'?query='.urlencode($data['term']));     
		$data1['type'] 	    = "Promotion";
		$data1['term'] 		= json_encode($data1);	  	
		$result1			 	= file_get_contents($searchAPI.'?query='.urlencode($data1['term'])); 
	   
	   	if(empty($result1))
		{
			echo "Server Down";exit;abort(404);
		}

		if(empty($result))
		{
			echo "Server Down";exit;abort(404);
		}

		$result 				= json_decode($result)->return_txt;
		$result1 				= json_decode($result1)->return_txt;		
		$data['top_categories'] = DB::table('and_deals_cat')->select("name","image_url","icon_class")->where('show_list',1)->get();
		$data['product'] 		= $result->hits->hits;
		$data['product_count']	= $result->hits->total;
		$data['product1'] 		= $result1->hits->hits;
		$data['product_count1']	= $result1->hits->total;
		$facets 				= $result->aggregations;
		$facet['left_cat']		= $facets->category->buckets;
		$data['facet']          = $facet;

	    return view('v1.coupons',$data);
	}

	/**
	 * Coupon Listing page By Vendor.. .
	 *
	 * @var \Illuminate\Http\Request
	 * @var Vendor Name
	 * @return Response
	 */

	public function couponlist( Request $request, $vendor, $page=0 )
	{
		return redirect(route('vendor_page_v2',[$vendor]),301);

	    $data['show']       = true;
		if( !empty($request->input('type')) && $request->input('type') != "all" )
		{
			$data['type']       = urldecode($request->input('type'));
		}		
		$data['vendor_name']    = urldecode( $vendor );
		if ($request->has('show')) 
		{ 
			$data['show'] = false;					
		}
		if(!empty($request->input('category')))
		{
			$category   = helper::decode_url($request->input('category'));
			// dd($category);

			if(is_array($category))
			{
				$data['category'] = implode(",",$category);
			}
			else
			{
				$data['category'] = $category;
			}
		}
		$data['rows'] 			= 30;
        $data['page'] 			= $page;
		$data['from'] 			= ( $data['page'] * $data['rows'] );
		$data['term'] 		    = json_encode($data);
		$searchAPI 				= composer_url( 'deals.php' );
		// echo $searchAPI.'?query='.urlencode($data['term']);exit;
		$result			 		= file_get_contents($searchAPI.'?query='.urlencode($data['term']));

		if(empty($result))
		{
			echo "Server Down";exit;abort(404);
		}

		$result 				= json_decode($result)->return_txt;
		$data['product'] 		= $result->hits->hits;
		$data['product_count']	= $result->hits->total;
		$facets 				= $result->aggregations;
		$facet['left']['cats']	= $facets->category->buckets;
		$data['facet']          = $facet;

		// dd($data);
		$data['type'] 			= "couponlist";
		$data['ajax'] 			= $request->input('ajax');
        // dd($data);

        if( $request->input('ajax') == "true" )
        {
        	$json['coupons'] 	= (string)view('v1.coupon_listing',$data);
			$json['coupons'] 	= preg_replace( '/(\v)+/', '', $json['coupons'] );
			$json['coupons'] 	= str_replace("\t", "", $json['coupons']);
			$json['total'] 		= $data['product_count'];
			$json['facet'] 		= $facets->category->buckets;
			
			echo json_encode( $json );exit;
        }
        else
        {
        	return view('v1.coupon_listing',$data);
        }
	}
	
	/**
	 * Coupon Listing page By Category.. .
	 *
	 * @var \Illuminate\Http\Request
	 * @var Category Name
	 * @return Response
	 */

	public function couponlistcategory(Request $request, $category, $page=0 )
	{
		return redirect(route('category_page_v2',[$category]),301);

	    $data['show']       = true;
		// dd($category);
		if ($request->has('show')) 
		{ 
			$data['show'] = false;					
		}

		if(!empty($request->input('type')) && $request->input('type') != "all" )
		{
			$data['type']       = urldecode($request->input('type'));
		}

		if(!empty($category ))
		{
			$category = explode("-coupons.html", $category )[0];
			$data['category'] = helper::decode_url( $category );
			// dd($data);
		}
		
		if(!empty($request->input('vendor_name')))
		{
			$vendor_name   = str_replace("-", " ", $request->input('vendor_name') );

			if(is_array($vendor_name))
			{
				$data['vendor_name'] = implode(",",$vendor_name);
			}
			else
			{
				$data['vendor_name'] = $vendor_name;
			}		
		}
		$token 		= $request->session()->get('_token');
		$session_id = preg_replace("/[^0-9,.]/", '', $token );

		if( !empty( $session_id ) && is_numeric( $session_id ) )
		{
			$data['session_id'] = $session_id;
		}

		$data['rows'] 			= 30;
        $data['page'] 			= $page;
		$data['from'] 			= ( $data['page'] * $data['rows'] );
		$data['term'] 		    = json_encode($data);
		// dd($data);
		$searchAPI 				= composer_url( 'deals.php' );
		$result			 		= file_get_contents($searchAPI.'?query='.urlencode($data['term'])); 	
       	
       	// Category Meta Description..
       	$meta = @file_get_contents("cat_meta.json");
		if( $meta )
		{
			$meta = json_decode( $meta );
			if( isset( $meta->{$data['category']}) )
			{
				$data['catmeta'] = $meta->{$data['category']};
			}
			else
			{
				$data['catmeta'] = "";
			}
		}
		else
		{
			$data['catmeta'] = "";
		}

		if(empty($result))
		{
			echo "Server Down";exit;abort(404);
		}

		$result 				= json_decode($result)->return_txt;
		// dd($result);
		$data['product'] 		= $result->hits->hits;
		$data['product_count']	= $result->hits->total;
		$facets 				= $result->aggregations;
		// $facet['left']['cats']	= $facets->category->buckets;
		$facet['left']['vendors']= $facets->vendor_name->buckets;
		$data['facet']          = $facet;
		$data['ajax'] 			= $request->input('ajax');
        // dd($data);

		//Ajax filter and json response..
        if( $request->input('ajax') == "true" )
        {
        	$json['coupons'] 	= (string)view('v1.coupon_listing',$data);
			$json['coupons'] 	= preg_replace( '/(\v)+/', '', $json['coupons'] );
			$json['coupons'] 	= str_replace("\t", "", $json['coupons']);
			$json['total'] 		= $data['product_count'];
			$json['facet'] 		= $facets->category->buckets;
			$json['vendors']	= $facets->vendor_name->buckets;
			echo json_encode( $json );exit;
        }
        else
        {
        	return view('v1.coupon_listing',$data);
        }
	}

	/**
	 * Coupon Detail Page.
	 *
	 * @var \Illuminate\Http\Request
	 * @var Category Name
	 * @return Response
	 */
	public function couponlistdetail(Request $request, $coupon_name = "", $promo = "" )
	{
		return redirect(route('coupons_v2'), 301);

	    $data['promo']    	= urlencode( $promo );
		$data['term']		= json_encode($data);
		$searchAPI 			= composer_url( 'deals.php' );
		$result			 	= file_get_contents($searchAPI.'?query='.urlencode($data['term']));	
       	$result 			= json_decode($result)->return_txt;

       	$name = ( isset($result->hits->hits[0] ) ) ? create_slug( $result->hits->hits[0]->_source->title ) : "";

       	// NOT FOUND.. 404/ 
		if(empty($result) || empty( $name ))
		{
			abort(404);
		}

		// Redirect to the correct URL if the current name and coupon name is not matching.. 
		if( $name != $coupon_name )
		{
			return redirect("/coupon/$name/$promo");
		}
		$data['title'] = $result->hits->hits[0]->_source->title." | Indiashopps";
		// Report the coupon post message.. send to admin..
		if( $request->input('message') )
		{
			Mail::send('emails.reported',
				array(
					'coupon' => $data['promo'],
					'user_message' => $request->input('message')
				), function($message)
			{		
				//echo "<pre>";print_r($message);exit;
				$message->from('nitish@manyainternational.com', 'coupon');
				$message->to('mitul.mehra@manyainternational.com')->subject('Coupon Reported on Website');
				
			});

			$data['message'] = "Thanks for letting us Know !!!" ;
		}

		// Getting the coupon detail.. 
		$data['product'] 		= $result->hits->hits;
		$data['product_count']	= $result->hits->total;	
		$data['product_detail'] = $data['product'][0]->_source;
		$facets 				= $result->aggregations;
		$facet['left_cat']		= $facets->category->buckets;
		$data['facet']          = $facet;
        
		return view('v1.coupon_detail',$data);
	}

	/**
	 * Coupon Listing page By Search String.... .
	 *
	 * @var \Illuminate\Http\Request
	 * @var Page number.. 
	 * @return Response
	 */
    public function couponsearch(Request $request, $page=0, $order_by="id",$sort_order="desc" )
	{
		
		$data['show']       = true;
		$data['query']      = urldecode($request->input('search_text'));
		$data['type']       = urldecode($request->input('type'));

		if ($request->has('show')) 
		{ 
			$data['show'] = false;					
		}
	

		if(!empty($request->input('type')) && $request->input('type') != "all" )
		{
			$data['type']       = urldecode($request->input('type'));
		}

		if(!empty($request->input('category')))
		{
			$category   = urlencode(helper::decode_url($request->input('category') ) );

			if(is_array($category))
			{
				$data['category'] = implode(",",$category);
			}
			else
			{
				$data['category'] = $category;
			}
		}

		if(!empty($request->input('vendor_name')))
		{
			$vendor_name   = str_replace("-", " ", $request->input('vendor_name') );

			if(is_array($vendor_name))
			{
				$data['vendor_name'] = implode(",",$vendor_name);
			}
			else{
				$data['vendor_name'] = $vendor_name;
			}		
		}
		
		$data['rows'] 		= 30;
        $data['page'] 		= $page;
        $data['from'] 		= ($data['page']*$data['rows']);        
		$data['term'] 		= json_encode($data);
		$searchAPI 			= composer_url( 'deals.php' );
		
		$result			 	= file_get_contents($searchAPI.'?query='.($data['term']));

		if(empty($result))
		{
			echo "Server Down";exit;abort(404);
		}

		$result 				= json_decode($result)->return_txt;
		$data['product'] 		= $result->hits->hits;
		$data['product_count']	= $result->hits->total;
		$data['vendor_name']	= urldecode($request->input('search_text'));
		$data['page'] 			= $page;
		$data['order_by'] 		= $order_by;
		$data['sort_order'] 	= $sort_order;
		$facets 				= $result->aggregations;
		$facet['left']['cats']	= $facets->category->buckets;
		$facet['left']['vendors']= $facets->vendor_name->buckets;
		$data['facet']          = $facet;
		$data['search']			= "Yes";
		$data['ajax'] 			= $request->input('ajax');

		if( $request->input('ajax') == "true" )
        {
        	$json['coupons'] 	= (string)view('v1.coupon_listing',$data);
			$json['coupons'] 	= preg_replace( '/(\v)+/', '', $json['coupons'] );
			$json['coupons'] 	= str_replace("\t", "", $json['coupons']);
			$json['total'] 		= $data['product_count'];
			$json['facet'] 		= $facets->category->buckets;
			$json['vendors']	= $facets->vendor_name->buckets;
			echo json_encode( $json );exit;
        }
        else
        {
        	return view('v1.coupon_listing',$data);
        }
	}

	/**
	 * Coupon Listing Detail in JSON response once using the Coupon Filter.. 
	 *
	 * @var \Illuminate\Http\Request
	 * @var Page number.. 
	 * @return Response
	 */
	public function filter( Request $request, $page = 1 )
	{
		
		if( !empty($request->input('ajax')) )
		{
			$data = array();

			if( !empty($request->input('type')) )
			{
				$data['type']       = urldecode($request->input('type'));
			}

			if(!empty($request->input('category')))
			{
				$category   = helper::decode_url($request->input('category'));

				if(is_array($category))
				{
					$data['category'] = implode(",",$category);
				}
				else
				{
					$data['category'] = $category;
				}	
			}
			$data['session_id'] 	= 9834059;
			$data['term']			= json_encode($data);
			$searchAPI 				= composer_url( 'deals.php' );
			$result					= file_get_contents($searchAPI.'?query='.urlencode($data['term']));
			$result 				= json_decode($result)->return_txt;
			$data['coupons'] 		= $result->hits->hits;
			$data['coupon_count']	= $result->hits->total;
			$data['page'] 			= $page;
			$facets 				= $result->aggregations;
			$facet['left_cat']		= $facets->category->buckets;
			$data['facet']          = $facet;
			$coupons 				= $data['coupons'];
			// dd($data);
			

			$data = array( 
							'coupons' 	=> $coupons,
							'c_count' 	=> $result->hits->total,
							'facet'		=> $data['facet'],
						);
			// echo "<PRE>";print_r( $data );exit;
			return 	json_encode( $data );
		}
		else
		{
			return json_encode( array( 'coupons' => '', 'facet' => '' ) );
		}
	}

	/**
	 * Resize the coupon images which will be stored on our servers.. 
	 *
	 * 
	 */
	public function resizeCouponImages()
	{
		$data['show'] 	= true;
		$data['size'] 	= 4500;
		$data['term']	= json_encode($data);
		$searchAPI		= composer_url( 'deals.php' );
		$result			= file_get_contents($searchAPI.'?query='.urlencode($data['term']));

		$result 		= json_decode($result)->return_txt;
		$coupons 		= $result->hits->hits;

		$base  = base_path()."/images/v1/hot_deals/new/";

		foreach( $coupons as $coupon )
		{
			$url = $coupon->_source->image_url;
			preg_match("/store\/(.*?)\/logo/i", $url, $match);

			if( isset($match[1]) )
			{
				$name = $match[1];
				$img = $name.".jpg";

				if( !file_exists( $base.$img ) )
					file_put_contents( $base.$img, file_get_contents( $url ) );
			}
		}
	}
}
