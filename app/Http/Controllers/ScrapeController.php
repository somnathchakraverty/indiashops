<?php 
namespace indiashopps\Http\Controllers;
use DB;
use indiashopps\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;
use indiashopps\Helpers\Helper;
use Jenssegers\Agent\Agent as Agent;
use indiashopps\Logs;

class ScrapeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| HOME page for IndiaShopps with Slider and Latest Product.. 
	|
	*/

	/*
	 * Create a new controller instance`.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}
	/**
	* Real deal page for real time price generation using scrapy
	*
	* @var \Illuminate\Http\Request
	* @var Page Number
	*/	
	public function real_time_deal(Request $request)
	{
		$data = array();
		if ($request->has('search_url')) 
		{
			$search_url = $request->input('search_url');
			$parse_url = parse_url($search_url);
			//$domain = $parse_url['host'];
			switch($parse_url['host'])
			{
				case "www.amazon.in":						
						if (strpos($parse_url['path'], '/dp/') !== false) {
						    $product_id = explode("/dp/",$parse_url['path']);
						    $product_id = $product_id[(count($product_id)-1)];
						    $product_id = explode("/",$product_id);
						    $product_id = $product_id[0];
						}elseif (strpos($parse_url['path'], '/product/') !== false) {
						    $product_id = explode("/product/",$parse_url['path']);
						    $product_id = $product_id[(count($product_id)-1)];
						    $product_id = explode("/",$product_id);
						    $product_id = $product_id[0];
						}
						$vendor=3;					
					break;
				case 'www.flipkart.com': 
						if (strpos($parse_url['query'], 'pid=') !== false) {
						    $product_id = explode("pid=",$parse_url['query']);
						    $product_id = $product_id[1];
						    $product_id = explode("&",$product_id);
						    $product_id = $product_id[0];
						}
						$vendor=1;
					break;
				case 'www.snapdeal.com':
						if (strpos($parse_url['path'], '/product/') !== false) {
						    $product_id = explode("/",$parse_url['path']);
						    $product_id = $product_id[(count($product_id)-1)];						    
						}
						$vendor=16;						
					break;
				case 'www.myntra.com':
						if (strpos($parse_url['path'], '/buy') !== false) {
						    $product_id = explode("/buy",$parse_url['path']);
						    $product_id = $product_id[0];
						    $product_id = explode("/",$product_id);
						    $product_id = $product_id[(count($product_id)-1)];					    
						}
						$vendor=4;						
					break;
			}
			if(isset($product_id))
			{
				/**************************** WE GOT THE PRODUCT ID. Now Proceed ******************************************/
				$searchAPI 			= composer_url( 'search_by_product_id.php' );
				$result			 	= file_get_contents($searchAPI."?product_id=".$product_id."&vendor=".$vendor);
				$result = json_decode($result);
				//echo "<pre>";print_r($result);exit;
				if($result->hits->total > 0)
				{
					echo "<pre>";
					//if($result->hits->total == 1)
					{
						#Good to go
						$product = $result->hits->hits[0];
						if($product->_type == "vendors")
						{
							#comparitive product							
							return redirect( "product/dntknwname/".$product->_source->id );
						}else{
							#Non-comparitive product
							return redirect( 'product/detail/'.create_slug($product->_source->name)."/".$product->_id );
						}
						//print_r($product);exit;
					//}else{
						#Got more than 1 product
						#http://www.amazon.in/gp/product/B019CK5M0G/
						echo $product_id;
						echo "Got more than one product. Something went wrong.";exit;
					}
					
				}else{
					#curl $search_url and render page using scraped values	
					$details = array();
					switch($vendor)
					{
						case 1:
								$details= file_get_contents("http://data.indiashopps.com/flipkart-api/getDetails.php?pid=".$product_id);
								$data = $this->product_detail($request,$details,1);
								return view("v1.product_detail",$data);
							break;
						case 3:
								$details= file_get_contents("http://data.indiashopps.com/flipkart-api/amz/getDetails.php?pid=".$product_id);
								$data = $this->product_detail($request,$details,3);
								return view("v1.product_detail",$data);
							break;
						case 16:
								$details= $this->scrape($product_id);								
								$data = $this->product_detail($request,$details,16);
								return view("v1.product_detail",$data);
							break;

					}
					echo $vendor;
					//$search_url = urlencode($search_url);
					//$data = file_get_contents(url("scrape-it")."?url=".$search_url."&all=true");
					//print_r($data);
					exit;
				}
				
			}else{
				$data['error_msg'] = "Invalid URL";
			}
			
		}
		return view("v1.custom.real_time_deal",$data);
	}
	/**
	* This controller is used by real_time_deal function of listing controller to curl URLs and update their prices/other details on run time.
	* 
	* @var \Illuminate\Http\Request
	* @var url - URL to scrape
	* @var all - if true return other details along with saleprice
	*/
	public function scrape($product_id )
	{
		if (!empty($product_id)) 
		{
			$headers = array(
	            'Snapdeal-Affiliate-Id:19215',
	            'Snapdeal-Token-Id:d82fe26cca1379eefde9a842924374',	            
	            'Accept:application/json'
	            );
			$url = "affiliate-feeds.snapdeal.com/feed/product?id=".$product_id;
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-ClusterDev-Flipkart/0.1');
	        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	        $result = curl_exec($ch);
	        curl_close($ch);
			return $result;
		}
		
	}

	private function getPage($url)
	{
		$pageData = curl_init($url);
		// user agent is set to Chrome
		$userAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13";
		
		curl_setopt($pageData, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($pageData, CURLOPT_FOLLOWLOCATION, 1);	
		curl_setopt($pageData, CURLOPT_TIMEOUT, 10);
		#curl_setopt($pageData, CURLOPT_SSL_VERIFYPEER, true);
	 	#curl_setopt($pageData, CURLOPT_CAINFO, 'https://curl.haxx.se/ca/cacert.pem');
		curl_setopt($pageData, CURLOPT_USERAGENT, $userAgent);		
		return curl_exec($pageData);
	}
	private function getRawData($xpath, $xpathQuery)
	{
		return $xpath->evaluate($xpathQuery);		
	}
	function product_detail( Request $request,$details,$vendor)	//Shows product detail
	{
		$data['product'] = new \stdClass();	
		
		$details = json_decode($details);		
		//echo "<pre>";print_r($details);exit;
		$data['product']->vendor 			= $vendor;
		$request->request->add(['real_prod' => 'yes']);
		switch($vendor)
		{
			case 1:
				
				//$data['product']->id 				= $details->productBaseInfo->productAttributes->title;
				$data['product']->product_id 		= $details->productBaseInfo->productIdentifier->productId;
				$data['product']->name 				= $details->productBaseInfo->productAttributes->title;
				//$data['product']->category 			= $details->productBaseInfo->productAttributes->title;
				$data['product']->product_url 		= $details->productBaseInfo->productAttributes->productUrl;
				$data['product']->description 		= $details->productBaseInfo->productAttributes->productDescription;
				$data['product']->brand 			= $details->productBaseInfo->productAttributes->productBrand;
				//$data['product']->category_id 		= $details->productBaseInfo->productAttributes->title;
				
				$data['product']->price 			= $details->productBaseInfo->productAttributes->maximumRetailPrice->amount;
				$data['product']->saleprice 		= $details->productBaseInfo->productAttributes->sellingPrice->amount;
				$data['product']->discount 			= $details->productBaseInfo->productAttributes->discountPercentage;		
				$data['product']->image_url 		= ($details->productBaseInfo->productAttributes->imageUrls->{'400x400'});
				
				$data['product']->grp 				= "product";
				$data['product']->track_stock 		= $details->productBaseInfo->productAttributes->inStock;
				$data['product']->size 				= $details->productBaseInfo->productAttributes->size;
				$data['product']->color 			= $details->productBaseInfo->productAttributes->color;
			break;
			case 3:
				if(isset($details->ASIN))
				{
					$data['product']->product_id 		= $details->ASIN;
					if(isset($details->ItemAttributes->Title))
						$data['product']->name 				= $details->ItemAttributes->Title;
					
					$data['product']->product_url 		= urldecode($details->DetailPageURL);
					$description = "<ul>";
					if(isset($details->ItemAttributes->Feature))
					{
						foreach($details->ItemAttributes->Feature as $feature)
						{
							$description .= "<li>".$feature."</li>";
						}
					}
					
					$description .= "</ul>";
					$data['product']->description 		= $description;
					if(isset($details->ItemAttributes->Brand))
						$data['product']->brand 			= $details->ItemAttributes->Brand;			
					
					if(isset($details->ItemAttributes->ListPrice->Amount))
						$data['product']->price 			= ($details->ItemAttributes->ListPrice->Amount/100);
					if(isset($details->OfferSummary->LowestNewPrice->Amount))
						$data['product']->saleprice 		= ($details->OfferSummary->LowestNewPrice->Amount/100);

					if(isset($details->Offers->Offer->OfferListing->PercentageSaved))
					{
						$data['product']->discount 			= $details->Offers->Offer->OfferListing->PercentageSaved;
					}
					if(isset($details->MediumImage->URL))		
						$data['product']->image_url 		= $details->MediumImage->URL;
					
					$data['product']->grp 				= "product";
					if(isset($details->OfferSummary->TotalNew))
						$data['product']->track_stock 		= $details->OfferSummary->TotalNew;
					if(isset($details->ItemAttributes->Size))
						$data['product']->size 				= $details->ItemAttributes->Size;
					if(isset($details->ItemAttributes->Color))
						$data['product']->color 			= $details->ItemAttributes->Color;
				}
			break;
			case 16:
				if(isset($details->id))
				{
					$data['product']->product_id 		= $details->id;
					if(isset($details->title))
						$data['product']->name 				= $details->title;
					
					$data['product']->product_url 		= $details->link;					
					$data['product']->description 		= $details->description;
					if(isset($details->brand))
						$data['product']->brand 			= $details->brand;			
					
					if(isset($details->mrp))
						$data['product']->price 			= ($details->mrp);
					if(isset($details->offerPrice))
						$data['product']->saleprice 		= ($details->offerPrice);

					/*if(isset($details->Offers->Offer->OfferListing->PercentageSaved))
					{
						$data['product']->discount 			= $details->Offers->Offer->OfferListing->PercentageSaved;
					}*/
					if(isset($details->imageLink))		
						$data['product']->image_url 		= $details->imageLink;
					
					$data['product']->grp 				= "product";
					if(isset($details->availability))
						$data['product']->track_stock 		= ($details->availability == "in stock"?1:0);
					if(isset($details->sizes))
						$data['product']->size 				= $details->sizes;
					if(isset($details->colors))
						$data['product']->color 			= $details->colors;
				}
			break;

		}
		

		
		//echo "<pre>";print_r($data);exit;
		//IF PRODUCT FOUND..
		if(!empty($data['product']))
		{ 
			//// RELATED PRODUCTS list.. 
			$viewurl = composer_url( 'site_view_also.php?info='.urlencode($data['product']->name));			
			$data['ViewAlso'] = file_get_contents($viewurl);			
			$data['ViewAlso'] = json_decode($data['ViewAlso']);
			$data['ViewAlso'] = $data['ViewAlso']->return_txt;			
			$data['full'] = false;
			$data['moreimage'] = false;							
			$data['page_title'] = "";			

			if( isset( $data['product']->category ) )
			{
				$data['c_name'] = $data['product']->category; // Category name to be used in DETAIL VIEW file.. 
			}

			return $data;
		}
		else
		{
			return redirect( 'search?search_text='.unslug($name).'&group=all' );
			//404 Page, as the product not found.. 
			abort(404);
		}		
	}
}
