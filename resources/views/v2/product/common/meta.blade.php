<?php
if(!isset($title))
            {
                if(isset($type) && $type="couponlist")
                {
                    // echo $vendor_name;exit;
                    if(isset($vendor_name) && $vendor_name == "flipkart")                    
                        $title = "Flipkart Coupon Code, Discount Coupons, Promo Codes | Indiashopps";
                    elseif(isset($vendor_name) && $vendor_name == "amazon") 
                        $title = "Latest Amazon Discount Coupon Code & Promo Codes | Indiashopps";
                    elseif(isset($vendor_name) && $vendor_name == "paytm") 
                        $title = "Paytm Mobile Recharge Offers & Coupons, Promo Codes | Indiashopps";
                    else
                        $title = "Compare Online - Shop for Mobiles, Electronics, Books, Men & Women | IndiaShopps";    
                    $cat = "Mobiles";
                }
                elseif( empty($c_name) )
                { 
                    $title = "Compare Mobiles Phones Price, Features, Specification Online in India | Indiashopps";
                    $cat = "Mobiles";
                }
                else
                {
                    if(isset($brand) && !empty($brand))
                   {
                       if( strtolower($brand) == "lg" || strtolower($brand) == "htc" || strtolower($brand) == "hp" )
                       {
                            $title = strtoupper($brand)." ";
                       }else{
                            $title = ucfirst( $brand )." ";
                       }
                    }else{
                        $title="";
                    }                      
                    if(isset($parent) && $parent == 'mobile')
                    {
                        if(empty($child)){
                            if(strtolower($c_name) == "mobiles")
                            {
                                if(isset($brand) && (strtolower($brand) == 'apple'))
                                {
                                    $title = "Apple iPhone Online Price Comparison in India | Indiashopps"; 
                                }elseif(isset($brand) && (strtolower($brand) == 'htc'))
                                {
                                    $title = "HTC Mobiles Price List in India, Compare & Buy Online  | Indiashopps"; 
                                }elseif(isset($brand) && (strtolower($brand) == 'micromax'))
                                {
                                    $title = "Micromax Mobiles Price List in India, Compare & Buy Online  | Indiashopps"; 
                                }elseif(isset($brand) && (strtolower($brand) == 'samsung'))
                                {
                                    $title = "Compare Samsung Smartphone & Mobiles Price List in India | Indiashopps"; 
                                }elseif(isset($brand) && (strtolower($brand) == 'htc'))
                                {
                                    $title = "HTC Mobiles Price List in India, Compare & Buy Online  | Indiashopps"; 
                                }elseif(isset($brand) && !empty($brand))
                                {
                                 $title .= ucfirst($c_name)." Price in India - Compare & Buy Online"; 
                                }else
                                {
                                     $title = "Latest Mobile Phones Price List in India| Compare & Buy Online"; 
                                }
                            }elseif(strtolower($c_name) == "tablets")
                            {
                                if(isset($brand) && (strtolower($brand) == 'apple'))
                                {
                                    $title = "Apple Ipad Online Price Comparison in India | Indiashopps"; 
                                }elseif(isset($brand) && (strtolower($brand) == 'samsung'))
                                {
                                    $title = "Samsung Tablets Price List in India, Compare & Buy Online | Indiashopps"; 
                                }else{
                                 $title .= ucfirst($c_name)." Price in India - Compare & Buy Online"; 
                                }
                            }else{
                                 $title .= ucfirst($c_name)." Price in India - Compare & Buy Online"; 
                            }
                        }
                        else{
                            //echo $child;exit;
                            if($child == "headphones-headsets")
                                $title .= ucfirst($c_name)." Price List in India - Compare Online & Save"; 
                            elseif($child == "tablet-accessories")
                                $title .= ucfirst(str_replace("-"," ",$child))." ".ucfirst($c_name)." Price List in India - Compare Online & Save";                                 
                            elseif(strtolower($child) == "mobile-accessories" && strtolower($c_name) == "microsd memory cards")
                                $title .= "Compare Price Online 32 GB, 64 GB etc. Micro SD Memory Card | Indiashopps";
                            elseif(strtolower($child) == "mobile-accessories" && strtolower($c_name) == "power banks")
                                $title .= "Compare and Buy Online Power Banks at Best Prices in India | Indiashopps";
                            else
                                $title .= ucfirst($parent)." ".ucfirst($c_name)." Price List in India - Compare Online & Save"; 
                        }
                    }
                    else
                    {               
                        if(isset($parent) && ($parent == "men" || $parent == "women"|| ($parent == "kids" && (isset($child) && ($child == "boy-clothing" || $child == "girl-clothing" || $child == "boys-footwear" || $child == "girls-footwear") )) )) 
                        {
                            if($parent == "kids"){
                                $title .= ucfirst( str_replace("-clothing", "",(str_replace("-footwear", "", $child))) )." ".ucfirst($c_name)." Price List in India | Buy | Compare Online";
                            }
                            elseif($parent == "men" && strtolower($c_name) == "casual shoes")
                            {
                                $title .= "Explore Men Casual Shoes Price List in India - Compare & Buy Online";
                            }elseif($parent == "men" && strtolower($c_name) == "formal shoes")
                            {
                                $title .= "Compare Online Formal Shoes Prices for Men in India | Indiashopps";
                            }elseif($parent == "men" && strtolower($c_name) == "sports shoes")
                            {
                                $title .= "Compare Online Sports Shoes Price for Men in India | Indiashopps";
                            }elseif($parent == "women" && strtolower($c_name) == "handbags")
                            {
                                $title .= "Compare Online Handbags Price for Women in India | Indiashopps";
                            }elseif($parent == "women" && strtolower($c_name) == "dresses")
                            {
                                $title .= "Compare Girls Dresses Price Online in India | Indiashopps";
                            }elseif($parent == "women" && strtolower($c_name) == "sandals")
                            {
                                $title .= "Compare Sandals Price for Girls Online in India | Indiiashopps";
                            }
                            else{
                                $title .= ucfirst( $parent )." ".ucfirst($c_name)." Price List in India - Compare & Buy Online";
                            }
                       }elseif (isset($parent) && $parent == "electronics") {
                           # code...
                       // echo strtoupper($c_name);exit;
                            if(isset($child) && !empty($child)){
                                if(strtoupper($c_name) == "LED TV")
                                    $title ="Compare Online 32 inch, 40 inch LED TV Price List in India | IndiaShopps";
                                else
                                    $title ="Compare Online ".ucfirst($c_name)." Price List in India | IndiaShopps";
                            }else{
                                $title ="Compare ".ucfirst($c_name)." Price with Specification Online | IndiaShopps";
                            }
                       } elseif (isset($parent) && $parent == "appliances") {
                           # code...
                            if(isset($child) && !empty($child))
                                $title ="Compare Online ".ucfirst($c_name)." Price with Features & Specification in India | IndiaShopps";
                            else
                                $title ="Compare ".ucfirst($c_name)." Price with Features & Specification Online | IndiaShopps";
                       }elseif (isset($parent) && $parent == "beauty-health") {
                           # code...
                            if(isset($child) && !empty($child))
                                $title ="Compare Online ".ucwords(str_replace("-"," ",$child))." ".ucfirst($c_name)." Price, Features with Latest Deals & Offers | IndiaShopps";
                            else
                                $title ="Buy ".ucfirst($c_name)." Online with Price Comparison | Lowest Price Store - IndiaShopps";
                       }elseif (isset($parent) && $parent == "sports-fitness") {
                           # code...
                            if(isset($child) && !empty($child))
                                $title ="Compare Online ".ucwords(str_replace("-"," ",$child))." ".ucfirst($c_name)." Price, Specification with Latest Deals & Offers | IndiaShopps";
                            else
                                $title ="Buy ".ucfirst($c_name)." Online with Price Comparison | Lowest Price Store - IndiaShopps";
                       }elseif (isset($parent) && $parent == "home-decor") {
                           # code...
                            if(isset($child) && !empty($child))
                                $title ="Buy or Compare Online ".ucfirst($c_name)." Price with Latest Deals & Offers | IndiaShopps";
                            else
                                $title ="Buy or Compare Price ".ucfirst($c_name)." Online | Best Price Only at IndiaShopps";
                       }elseif (isset($parent) && $parent == "computers") {
                           # code...
                            if(isset($child) && !empty($child)){
                                if(strtolower($c_name) == "pen drives")
                                    $title ="Compare Online 16GB, 32GB, 64GB Pen Drives Price List in India | IndiaShopps";
                                else
                                    $title ="Compare Online ".ucfirst($c_name)." Price List in India | IndiaShopps";
                            }else{
                                if(isset($brand) && (strtolower($brand) == 'dell'))
                                {
                                    $title ="Compare Online Dell Laptop Price List in India | Indiashopps";
                                }elseif(isset($brand) && (strtolower($brand) == 'hp'))
                                {
                                    $title ="Compare Online HP Laptop Price List in India | Indiashopps";
                                }elseif(isset($brand) && (strtolower($brand) == 'lenovo'))
                                {
                                    $title ="Compare Online Lenovo Laptop Price List in India | Indiashopps";
                                }else{
                                    //$title ="Compare ".ucfirst($c_name)." Price with Features & Full Specification Online | IndiaShopps";
                                    $title ="Compare and Buy Online ".ucfirst($c_name)." at Best Prices in India | Indiashopps";
                                }
                                
                            }
                       }elseif (isset($parent) && $parent == "kids") {
                           # code...
                            if(isset($child) && !empty($child))
                                $title ="Buy or Compare Online ".ucfirst($c_name)." Price with Latest Deals & Offers | IndiaShopps";
                            else
                                $title =ucfirst($c_name)." Price in India - Compare & Buy Online | Indiashopps";
                       }elseif (isset($parent) && $parent == "camera") {
                           # code...
                            if(isset($child) && !empty($child))
                                $title ="Compare Online ".ucfirst($c_name)." Price, Features &  Full Specification | IndiaShopps";
                            else
                                $title ="Compare ".ucfirst($c_name)." Price with Specification Online | IndiaShopps";
                       }elseif (isset($parent) && $parent == "care") {
                           # code...
                            if(isset($child) && !empty($child))
                                $title ="Compare Online ".ucfirst($c_name)." Price, Features with Latest Deals & Offers | IndiaShopps";
                            else
                                $title ="Buy ".ucfirst($c_name)." Online with Price Comparison | Lowest Price Store - IndiaShopps";
                       }elseif (isset($parent) && $parent == "lifestyle") {
                           # code...
                            if(isset($child) && !empty($child))
                                $title ="Compare Online ".ucfirst($c_name)." Price, Features with Latest Deals & Offers | IndiaShopps";
                            else
                                $title ="Compare Price ".ucfirst($c_name)." Online | Lowest Price Store - IndiaShopps";
                       }elseif (isset($parent) && $parent == "automotive") {
                           # code...
                            if(isset($child) && !empty($child))
                                $title ="Compare Online ".ucfirst($child)." ".ucfirst($c_name)." Price With Features & Full Specification | IndiaShopps";
                            else
                                $title ="Buy & Compare ".ucfirst($c_name)." Essentials Price with Features & Full Specification Online | IndiaShopps";
                       } elseif (isset($parent) && $parent == "books") {
                           # code...
                            if(isset($child) && !empty($child))
                                $title ="Buy or Compare Online ".ucfirst($c_name)." Books Price with Latest Deals & Offers | IndiaShopps ";
                            else
                                $title ="Buy or Compare Price ".ucfirst($c_name)." Books Online | Best Price Only at IndiaShopps ";
                       } 
                       else {                  
                            $title =ucfirst($c_name)." Price List in India | Buy | Compare Online";
                        }                
                    }
                 
                    $cat = ucfirst($c_name);
                }
            }else{
                if( empty($c_name) )
                {                    
                    $cat = "Mobiles";
                }else{
                    $cat = ucfirst($c_name);
                }
            }
?>
@if(isset($page) && !empty($page) && $page > 1)
    <?php $title = "Page - ".$page. " | ".$title; ?>
@endif
<title>{{$title}}</title>
