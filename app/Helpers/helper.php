<?php
namespace indiashopps\Helpers;
use DB;
use indiashopps\Category;

class Helper
{


 public static function getvendordetail($vendor_name)
 {
	// echo urldecode($vendor_name);exit;
	 $users="";
	 if(!empty($vendor_name))
	 {
		 $users = DB::table('gc_deals')
		         ->select('vendor_logo')
				   ->where('vendor_name', 'like', '%' . urldecode($vendor_name). '%')
				   ->groupBy('vendor_name')
               ->get();
	}

	    return $users[0]->vendor_logo;
 }
 public static function word_limiter($string, $word_limit)
 {
    $words = explode(" ",$string);
    return implode(" ",array_splice($words,0,$word_limit));
  }
public static function wordtruncate ($str, $length=10, $trailing='...')
{
/*
** $str -String to truncate
** $length - length to truncate
** $trailing - the trailing character, default: "..."
*/
      // take off chars for the trailing
      $length-=mb_strlen($trailing);
      if (mb_strlen($str)> $length)
      {
         // string exceeded length, truncate and add trailing dots
         return mb_substr($str,0,$length).$trailing;
      }
      else
      {
         // string was already short enough, return the string
         $res = $str;
      }

      return $res;

}

  public static function encode_url( $url )
  {
      $url = str_replace(" ","-", $url);
      $url = str_replace("&","", $url);

      return $url;
  }

  public static function decode_url( $url )
  {
      $url = str_replace("--"," & ", $url);
      $url = str_replace("-"," ", $url);

      return $url;
  }

   public static function get_categories($parent = false, $level = 2)
   {
      $result  = array();
      if ($parent !== false)
      {
         $result  = DB::table('gc_cat')->where('parent_id',$parent)->where('active',1)->where('level','<',$level)->orderBy('sequence', 'ASC')->lists('id');
      }else{
         $result  = DB::table('gc_cat')->where('active',1)->where('shown',1)->where('parent_id','=',0)->orderBy('sequence', 'ASC')->lists('id');
      }

      $categories = array();

      foreach($result as $cat)
      {
         $categories[]  = self::get_category($cat);
      }
      return $categories;
   }

   //this is for building a menu
   public static function get_categories_tierd($parent=0,$level=2)
   {
      $categories = array();
      $result  = self::get_categories($parent,$level);
      foreach ($result as $category)
      {
         $categories[$category->id]['category'] = $category;
         $categories[$category->id]['children'] = self::get_categories_tierd($category->id,$level);
      }
      return $categories;
   }

   public static function get_category($id)
   {

      //return $this->db->get_where('cat', array('id'=>$id))->row();
       return Category::where('id',$id)->first();
   }

   public static function get_recent_viewed( $recently_viewed )
   {
      $r_prods = "";

      if( !empty( $recently_viewed ) )
      {
         $url = composer_url( 'query_mget.php?ids='.$recently_viewed );
         $r_prods = file_get_contents( $url );
         // $r_prods = json_decode( $r_prods );
         // dd($r_prods);
         // var_dump( $r_prods );exit;
         if( !empty( $r_prods ) )
         {
            $r_prods = json_decode( $r_prods );
            $r_prods = $r_prods->docs;
            // dd($r_prods);

            foreach ( $r_prods as $key => $prod )
            {
               if( !isset( $prod->_source ) || empty( $prod->_source ) )
               {
                  unset( $r_prods[$key] );
               }
            }

            $r_prods = array_filter($r_prods);
         }
         else
         {
            $r_prods = array();
         }
      }

      return $r_prods;
   }
}

function discount( $price, $saleprice )
{
   if( !empty( $price ) && $price > $saleprice )
   {
      $discount = ( ( $price - $saleprice ) / $price ) * 100;
      return $discount."% OFF";
   }

   return false;
}