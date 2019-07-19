<?php 
namespace indiashopps\Http\Controllers;
use DB;
use helper;
use indiashopps\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ContestController extends Controller {
	
	/**
	* Shoes listing Under given Min & Max Price	
	*/
	public function index()
	{
		return view("v1.contest.index");
	}
	public function video()
	{
		// echo "<pre>";
		// print_r($_SERVER);die;
		$data['contest_video_image']	= DB::table('contest_photo_video')->where("video_name","not like","")->where("approved",1)->orderBy("id")->get();
		$top_gifted_products			= DB::table('gc_valentine_products_stage')->orderBy("id")->lists('ref_id');
		$top_gifted_products 			= file_get_contents( composer_url( 'query_ids.php?ids='.json_encode($top_gifted_products) ) );
		$data['top_gifted_products'] 	= json_decode($top_gifted_products)->hits->hits;

		$top_popular_gifts			= DB::table('gc_valentine_products_stage')->orderBy("id","desc")->lists('ref_id');
		$top_popular_gifts 			= file_get_contents( composer_url( 'query_ids.php?ids='.json_encode($top_popular_gifts) ) );
		$data['top_popular_gifts'] 	= json_decode($top_popular_gifts)->hits->hits;

		$latest_prod			= DB::table('gc_valentine_products_stage')->orderBy("id","desc")->lists('ref_id');
		$latest_prod 			= file_get_contents( composer_url( 'query_ids.php?ids='.json_encode($latest_prod) ) );
		$data['latest_prod'] 	= json_decode($latest_prod)->hits->hits;




		$top_popular_cake			= DB::table('gc_valentine_products')->where("type","like","cake")->orderBy("id")->lists('pid');
		$top_popular_cake 			= file_get_contents( composer_url( 'query_ids.php?ids='.json_encode($top_popular_cake) ) );
		$data['top_popular_cake'] 	= json_decode($top_popular_cake)->hits->hits;

		$top_teddy_flower			= DB::table('gc_valentine_products')->where("type","like","teddy_flower")->orderBy("id")->lists('pid');
		$top_teddy_flower 			= file_get_contents( composer_url( 'query_ids.php?ids='.json_encode($top_teddy_flower) ) );
		$data['top_teddy_flower'] 	= json_decode($top_teddy_flower)->hits->hits;

		
		// echo "<pre>";print_r($data);exit;
		return view("v1.contest.video",$data);
	}
	
	public function photo()
	{
		// echo "<pre>";
		// print_r($_SERVER);die;
		$data['contest_video_image']	= DB::table('contest_photo_video')->where("image_name","not like","")->where("approved",1)->orderBy("id")->get();
		$top_gifted_products			= DB::table('gc_valentine_products_stage')->orderBy("id")->lists('ref_id');
		$top_gifted_products 			= file_get_contents( composer_url( 'query_ids.php?ids='.json_encode($top_gifted_products) ) );
		$data['top_gifted_products'] 	= json_decode($top_gifted_products)->hits->hits;

		$top_popular_gifts			= DB::table('gc_valentine_products_stage')->orderBy("id","desc")->lists('ref_id');
		$top_popular_gifts 			= file_get_contents( composer_url( 'query_ids.php?ids='.json_encode($top_popular_gifts) ) );
		$data['top_popular_gifts'] 	= json_decode($top_popular_gifts)->hits->hits;

		$latest_prod			= DB::table('gc_valentine_products_stage')->orderBy("id","desc")->lists('ref_id');
		$latest_prod 			= file_get_contents( composer_url( 'query_ids.php?ids='.json_encode($latest_prod) ) );
		$data['latest_prod'] 	= json_decode($latest_prod)->hits->hits;




		$top_popular_cake			= DB::table('gc_valentine_products')->where("type","like","cake")->orderBy("id")->lists('pid');
		$top_popular_cake 			= file_get_contents( composer_url( 'query_ids.php?ids='.json_encode($top_popular_cake) ) );
		$data['top_popular_cake'] 	= json_decode($top_popular_cake)->hits->hits;

		$top_teddy_flower			= DB::table('gc_valentine_products')->where("type","like","teddy_flower")->orderBy("id")->lists('pid');
		$top_teddy_flower 			= file_get_contents( composer_url( 'query_ids.php?ids='.json_encode($top_teddy_flower) ) );
		$data['top_teddy_flower'] 	= json_decode($top_teddy_flower)->hits->hits;

		
		// echo "<pre>";print_r($data);exit;
		return view("v1.contest.photo",$data);
	}
	public function file_upload( Request $request)
	{
		$video= new \stdClass();
	    $video->fname       = $request->input('fname' , "No First name");
	    $video->lname       = $request->input('lname' , "No last name");
	    $video->email       = $request->input('email' , "No email");
	    $video->phone       = $request->input('phone' , "No Phone");
	    $video->message 	= $request->input('message');
	   $video->image_name = '';
	   $video->video_name  = '';
	   $valid_flag = False;
	   
       if($request->hasFile('image')) {   
	        $image = $request->file('image');
	        if(filesize($image) > 10485760)
         	{
         		$valid_flag = False;
         	}else{



         		
         		$valid_flag = True;
		        $filename = time().$image->getClientOriginalName();		       
		     	 $path = upload_path('contest/images/' . $filename);  
			    $img = \Image::make( $image );
				$img->resize( 600, null, function ($constraint) {
				    $constraint->aspectRatio();
				    $constraint->upsize();
				});
				$img->save( $path);	
		        $video->image_name = upload_url('contest/images/').$filename;
		    }	      
	    }
	  /*****Video***/
	 	if($request->hasFile('video'))
	 	{
         	$videoDocument = $request->file('video');
         	if(filesize($videoDocument) > 31457280)
         	{
         		$valid_flag = False;
         	}else{
         		$valid_flag = True;
         		$fileExt = $videoDocument->getClientOriginalExtension();
         		$filename = time().$videoDocument->getClientOriginalName();
		        $pathVideo = upload_path('contest/videos/');
		        $videoDocument->move($pathVideo,$filename);
		        $video->video_name = upload_url('contest/videos/').$filename;	 
         	}
	             
	    }
		$video = (array)$video;
		// echo "<pre>"; 
		// $image_mime = image_type_to_mime_type(exif_imagetype(string $video['image_name']));
		//echo $videoExt;die;

		if(!empty($video['image_name']) && $valid_flag)
		{
			$size = getimagesize($video['image_name']);			
			// print_r($size['mime']);die;
			switch ($size['mime'])
			{ 
				case "image/gif": 
				case "image/jpeg": 
				case "image/jpg": 
				case "image/png": 
				case "image/bmp": 
					$valid_flag = True;
					break; 
			}
		}
		if(!empty($video['video_name']) && $valid_flag)
		{
			switch ($video['video_name'])
			{ 
				case "mp4": 
				case "3gp": 
				case "asf": 			
				case "wmv": 			
				case "mov": 			
				case "divx": 			
				case "dat": 			
				case "mkv": 			
				case "mpe": 			
				case "mpg": 			
				case "mpeg": 			
				case "mpeg4": 			
				case "vob": 			
				case "vob": 			
				case "flv": 			
					$valid_flag = True;
					break; 
			}
		}
		// echo $valid_flag;die;
		if($valid_flag){		 
			DB::table('contest_photo_video')->insert($video);
			if(empty($video['video_name'])){
				$request->session()->flash('alert-success', 'Congratulations! Your photo has been successfully uploaded!');
				return redirect()->action('ContestController@photo');
			}
			else{
				$request->session()->flash('alert-success', 'Congratulations! Your video has been successfully uploaded!');
				return redirect()->action('ContestController@video');
			}
            // return redirect()->action('ContestController@photo_video');					
		}else
		{	
			if(empty($video['video_name'])){
				$request->session()->flash('alert-success', 'Something went wrong please try again!');
				return redirect()->action('ContestController@video');
			}
			else
			{
				$request->session()->flash('alert-success', 'Something went wrong please try again!');
				return redirect()->action('ContestController@photo');
			}			
		}
	}
	public function storyBoard()
	{
		return view("v1.contest.storyboard.index");
		// return view("v1.contest.storyboard.coming_soon");
	}
	public function storyAlbum(Request $request)
	{
		$insertArr['email'] = $request->input('email');
		DB::table('coming_soon')->insert($insertArr);
		$request->session()->flash('alert-success', "Thanks, We'll get back to you" );
		return redirect()->action('ContestController@storyBoard');
	}
	public function storyAlbum_insert(Request $request)
	{
		$data =array();
		$data['profile_id'] 	= $request->input('profile_id');
		if($request->has('email'))
		{
			// $data['profile_id'] 	= $request->input('profile_id');
			$data['name'] 			= $request->input('name');
			$data['email'] 			= $request->input('email');
			$data['picture'] 		= $request->input('picture');
		}
		if($request->has('video')){
			$video = $request->input('video');			
		}
		// echo $update['video'];exit;
		$count = DB::table('storyboard_log')->where('profile_id','like', $data['profile_id'])->count();

		if($count ==0)
		{
			//Insert
			if(isset($data))
			{
				DB::table('storyboard_log')->insert($data);	
			}			
		}else{
			//Update
			if(isset($video))
			{
				DB::table('storyboard_log')->where('profile_id','like', $data['profile_id'] )->update(array('video'=>$video));
			}
		}
		
	}
	





	public function quotation(Request $request)
	{
		return view("v1.contest.quotation");
	}
	public function quotation_insert(Request $request)
	{
		$insertArr =array();
		$insertArr['mobile_number'] = $request->input('mobile_number');
		$insertArr['email'] = $request->input('email');
		$insertArr['message'] = $request->input('message');
		$insertArr['type'] = 'quotation';
		// print_r($insertArr);die('hi');
		DB::table('quotation_love')->insert($insertArr);
		$request->session()->flash('alert-success', 'Congrtulations! Your Quotation has been successfully uploaded!');
		return redirect()->action('ContestController@love_story');
	}
	public function love_story()
	{
		return view("v1.contest.love_story");
	}
	public function love_story_insert(Request $request)
	{
		$insertArr =array();
		$insertArr['mobile_number'] = $request->input('mobile_number');
		$insertArr['email'] = $request->input('email');
		$insertArr['message'] = $request->input('message');
		$insertArr['type'] = 'love_story';
		// print_r($insertArr);die('hi');
		DB::table('quotation_love')->insert($insertArr);
		$request->session()->flash('alert-success', 'Congrtulations! Your Love story has been successfully uploaded!');
		return redirect()->action('ContestController@love_story');				 	 
	}
}
