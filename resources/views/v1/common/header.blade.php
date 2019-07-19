<!DOCTYPE HTML>
<html lang="en-us">
    <head>
        <meta charset="utf-8" />
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
        
        @if ( array_key_exists( 'title', View::getSections() ) )
            @yield('title')
        @else
            <title><?=$title?></title>
        @endif
        <!-- ********* META KEYWORDS START ************** -->
        <link rel="icon" href="<?=newUrl()?>images/v1/favicon.png" type="image/png" sizes="16x16">
        @if(isset($meta) && !empty($meta->keyword))
            <meta name="keywords" content="<?=$meta->keyword?>">
        @elseif(isset($keyword))
            <meta name="keywords" content="{{$keyword}}">
        @else
            <meta name="keywords" content="online, <?=$cat?>, list, compare, quality, prices, store, india, cheap,brand, search, buy, website, shopping, lowest, best deals">
        @endif
        <meta name="theme-color" content="#d70d00">
        <meta name="msapplication-navbutton-color" content="#d70d00">
        <meta name="apple-mobile-web-app-status-bar-style" content="#d70d00">  
        <meta name="ROBOTS" content="noindex,nofollow" />
        <meta name="ROBOTS" content="ALL" />
        <meta name="googlebot" content="noindex,nofollow" />
        <meta name="msnbot" content="noindex,nofollow" />
        <meta name="Slurp" content="noindex,nofollow" />
        <meta name="language" content="English" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <link rel="canonical" href="{{canonical_url()}}" />
        @if ( array_key_exists( 'description', View::getSections() ) )
            @yield('description')
        @else
            @if(isset($brand) && !empty($brand))
                @if(isset($parent) && $parent == "computers")
                    @if(strtolower($brand) == "dell")
                        <meta name="description" content="Compare Online Dell Laptop Prices and Specifications insight from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews at Indiashopps.">
                    @elseif(strtolower($brand) == "hp")
                        <meta name="Compare Online HP Laptop Prices and Specifications insight from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews at Indiashopps.">
                    @elseif(strtolower($brand) == "lenovo")
                        <meta name="Compare Online Lenovo Laptop Prices and Specifications insight from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews at Indiashopps.">
                    @else
                        <meta name="description" content="IndiaShopps is the most reputed affiliate online shopping website which helps to buy, search, explore the quality & branded <?php echo $brand." ".$cat; ?> at most comparative prices">
                    @endif
                @elseif(isset($parent) && $parent == "mobile")
                    @if((isset($c_name)) && (strtolower($c_name) == "mobiles" ))
                        @if(strtolower($brand) == "apple")
                            <meta name="description" content="Compare Online Apple iPhone Prices and Specifications insight from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews at Indiashopps. Buy Now!">
                        @elseif(strtolower($brand) == "micromax")
                            <meta name="description" content="Compare Online Micromax Mobile Prices and Specifications insight from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews at Indiashopps.">
                        @elseif(strtolower($brand) == "samsung")
                            <meta name="description" content="Compare Online Samsung Smartphone & Mobiles Prices, Specifications & Feature insight from Flipkart, Snapdeal, Amazon and many more with latest offersat Indiashopps.">
                        @elseif(strtolower($brand) == "htc")
                            <meta name="description" content="Compare Online HTC Mobile Prices and Specifications insight from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews at Indiashopps. ">
                        @else
                            <meta name="description" content="Mobiles latest price in India with technical specifications and detailed features. Compare Brands at IndiaShopps.">
                        @endif
                    @elseif((isset($c_name)) && (strtolower($c_name) == "tablets" ))
                        @if(strtolower($brand) == "apple")
                            <meta name="description" content="Compare Online Apple Ipad Price at Indiashopps.com with technical specification & Features. We offer wide range of deals and coupons on top mobile brands.">                        
                        @elseif(strtolower($brand) == "samsung")
                            <meta name="description" content="Compare Online Samsung Tablet Prices and Specifications from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews at Indiashopps. Buy Now!">
                        @else
                            <meta name="description" content="Mobiles latest price in India with technical specifications and detailed features. Compare Brands at IndiaShopps.">
                        @endif
                    @endif
                @else
                    <meta name="description" content="IndiaShopps is the most reputed affiliate online shopping website which helps to buy, search, explore the quality & branded <?php echo $brand." ".$cat; ?> at most comparative prices">
                @endif
            @else
                @if(isset($parent) && ($parent == "men" || $parent == "women") ) 
                    @if($parent == "men" || $parent == "women")
                        <meta name="description" content="Shop or Compare Online <?=$parent?> <?=strtolower($cat)?> latest price in India with Exciting offers, Coupons and deals on Indiashopps. Compare Brands Now.">
                    @else
                        <meta name="description" content="IndiaShopps is the most reputed affiliate online shopping website which helps to buy, 
                        search, explore the quality & branded <?=$cat?> for <?=$parent?> at most comparative prices">
                    @endif
                @elseif(isset($parent) && $parent == "electronics")
                    @if(isset($child) && !empty($child))
                        @if(strtoupper($c_name) == "LED TV")
                            <meta name="description" content="Compare Online 32 inch, 40 inch & more LED TV prices with features and Specification insight only at Indiashopps.com & buy from Flipkart, Snapdeal, Amazon & many more.">
                        @else
                            <meta name="description" content="Compare <?=strtoupper($c_name)?> with prices and Specification buy online from Flipkart, Snapdeal, Amazon. Buy Now!">
                    @endif
                    @else
                        <meta name="description" content="Compare <?=strtolower($cat)?> with prices and buy online from Flipkart, Snapdeal, Amazon. Latest <?=strtolower($cat)?> price list with pictures, features & specification. Compare Now!">
                    @endif
                @elseif(isset($parent) && $parent == "appliances")
                    @if(isset($child) && !empty($child))                       
                        <meta name="description" content="Compare <?=ucwords($c_name)?> with price and Specification at Indiashopps. Buy Latest & Branded Energy saving <?=ucwords($c_name)?> at best price. Lowest Price Guaranteed, Shop Now!">
                    @else                        
                        <meta name="description" content="Compare <?=strtolower($cat)?> prices online at Indiashopps. Buy Microwave, Oven, Induction Cooktop, Gas Stove & many more. Lowest Price Guaranteed, Shop Now!">
                    @endif
                @elseif(isset($parent) && $parent == "beauty-health")
                    @if(isset($child) && !empty($child))                       
                        <meta name="description" content="Save Money & Time - Buy Best <?=ucwords(str_replace('-',' ',$child))?> <?=ucwords($c_name)?> online with Price, Features comparison inside from Flipkart, Amazon & Snapdeal & many more including reviews and latest deal only at Indiashopps.">
                    @else                        
                        <meta name="description" content="Shop <?=strtolower($cat)?> online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside from your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.">
                    @endif
                @elseif(isset($parent) && $parent == "sports-fitness")
                    @if(isset($child) && !empty($child))                       
                        <meta name="description" content="Save Money & Time - Buy Best <?=ucwords(str_replace('-',' ',$child))?> <?=ucwords($c_name)?> online with Price, full Specification comparison inside from Flipkart, Amazon & Snapdeal & many more including reviews and latest deal only at Indiashopps. ">
                    @else                        
                        <meta name="description" content="Purchase Smart & Save money at Indiashopps. Buy <?=strtolower($cat)?> online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside from your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.">
                    @endif
                @elseif(isset($parent) && $parent == "home-decor")
                    @if(isset($child) && !empty($child))                       
                        <meta name="description" content="Browse Best <?=ucwords($c_name)?> online with price comparison inside from Flipkart, Amazon & Snapdeal, including reviews and latest deal only at Indiashopps. ✓ Lowest Price Guaranteed.">
                    @else                        
                        <meta name="description" content="Save money with smart purchase option at Indiashopps, buy <?=strtolower($cat)?> online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.">
                    @endif
                @elseif(isset($parent) && $parent == "mobile")
                    @if(isset($child) && empty($child))  
                        @if(strtolower($c_name) == "mobiles")  
                            <meta name="description" content="Find Latest price of Mobile Phones Online in India & Compare price, technical specifications & features only at Indiashopps! Get best deals, offer, Coupon code etc." />
                        @else
                            <meta name="description" content="<?=ucfirst($c_name)?> latest price in India with technical specifications and detailed features. Compare Brands at IndiaShopps." />
                        @endif
                    @else 
                        @if($child == "headphones-headsets")
                           <meta name="description" content="Compare <?=ucfirst($c_name)?> by Price, Features & Specifications at IndiaShopps.com. Get best deals & coupons on top brands!" />  <!-- Sub-Sub-category -->
                        @else                      
                            <meta name="description" content="Compare <?=ucfirst($parent)?> <?=ucfirst($c_name)?> by Price, Features & Specifications at IndiaShopps.com. Get best deals & coupons on top brands!" />  <!-- Sub-Sub-category -->
                         @endif
                    @endif
                @elseif(isset($parent) && $parent == "computers")
                    @if(isset($child) && !empty($child))    
                    <?php //echo $c_name;exit;?>      
                        @if(isset($c_name) && strtolower($c_name) == "wifi routers")             
                            <meta name="description" content="Compare Online Wifi Router Prices and Specifications at Indiashopps & buy from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews.">
                        @elseif(isset($c_name) && strtolower($c_name) == "pen drives")             
                            <meta name="description" content="Compare Online 16GB, 32GB, 64GB Pen Drives Prices and Specifications only at Indiashopps & buy from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews.">
                        @else
                            <meta name="description" content="Save money & time with smart purchase option only at Indiashopps, Shop <?=ucwords($c_name)?> online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.">
                        @endif
                    @else                       
                        <meta name="description" content="Compare Online <?=strtolower($cat)?> Prices and Specifications from Flipkart, Snapdeal, Amazon and many more insight with latest offers, deals & reviews at Indiashopps.">
                    @endif
                @elseif(isset($parent) && $parent == "kids")
                    @if(isset($child) && !empty($child))                       
                        <meta name="description" content="Browse Best <?=ucwords($c_name)?> online with price comparison inside from Flipkart, Amazon & Snapdeal, including reviews and latest deal only at Indiashopps. ✓ Lowest Price Guaranteed.">
                    @else                        
                        <meta name="description" content="Save money & time with smart purchase option only at Indiashopps, Shop or Compare <?=strtolower($cat)?> online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.">
                    @endif
                 @elseif(isset($parent) && $parent == "camera")
                    @if(isset($child) && !empty($child))  
                        @if(strtolower($c_name) == "digital slr cameras")                     
                            <meta name="description" content="Compare DSLR Camera price in India Online. Browse full Specifications, feature & reviews insight from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews.">
                        @else
                            <meta name="description" content="Shop <?=ucwords($c_name)?> Online with Latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.">
                        @endif
                    @else                        
                        <meta name="description" content="Compare <?=strtolower($cat)?> with prices and buy online from Flipkart, Snapdeal, Amazon.  Latest <?=strtolower($cat)?> price list with pictures, features & specification. Compare Now!">
                    @endif
                @elseif(isset($parent) && $parent == "care")
                    @if(isset($child) && !empty($child))                       
                        <meta name="description" content="Save Money & Time - Buy Best <?=ucwords($c_name)?> online with Price, Features comparison inside from Flipkart, Amazon & Snapdeal & many more including reviews and latest deal only at Indiashopps.">
                    @else                        
                        <meta name="description" content="Purchase Smart & Save money at Indiashopps. Buy <?=strtolower($cat)?> online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside from your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.">
                    @endif
                @elseif(isset($parent) && $parent == "lifestyle")
                    @if(isset($child) && !empty($child))                       
                        <meta name="description" content="Save Money & Time - Buy Best <?=ucwords($c_name)?> online with Price, Features comparison inside from Flipkart, Amazon & Snapdeal & many more including reviews and latest deal only at Indiashopps.">
                    @else                        
                        <meta name="description" content="Purchase Smart & Save money at Indiashopps. Buy <?=strtolower($cat)?> online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside from your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.">
                    @endif
                 @elseif(isset($parent) && $parent == "automotive")
                    @if(isset($child) && !empty($child))                       
                        <meta name="description" content="Shop <?=ucwords($child)?> <?=ucwords($c_name)?> online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.">
                    @else                        
                        <meta name="description" content="Shop Best <?=ucwords($cat)?> Essentials Online with Price, Features & full Specification Comparison inside from Flipkart, Amazon, Snapdeal & many more, including latest offers, deals & reviews only at Indiashopps.">
                    @endif
                @elseif(isset($parent) && $parent == "books")
                    @if(isset($child) && !empty($child))                       
                        <meta name="description" content="Browse <?=ucwords($c_name)?> Books with price comparison, reviews and latest deal at Indiashopps.">
                    @else                        
                        <meta name="description" content="Save money with smart purchase option at Indiashopps, buy <?=strtolower($cat)?> books online with <em>Price Trends</em>, <em>Price Comparisons</em> & <em>Latest Deal/offers</em> directly inside your favorite shopping website like Flipkart, Amazon, snapdeal & many more.">
                    @endif

                @else
                    <meta name="description" content="IndiaShopps is the most reputed affiliate online shopping website which helps to buy, search, explore the quality & branded <?=$cat?> at most comparative prices">
                @endif
            @endif
        @endif
        @yield('meta')
        <!-- ********* META KEYWORDS END **************** --> 
        <script type="text/javascript" src="<?=asset("/js/v1/jquery_1.11.3.min.js")?>"></script>
        <link rel="stylesheet" href="<?=asset("/css/v1/bootstrap.min.css")?>" type="text/css" />
        <link rel="stylesheet" href="<?=asset("/css/v1/bootstrap.min.css")?>" type="text/css" />
        <link rel="stylesheet" href="<?=asset("/css/v1/main.css")?>" type="text/css" />
        
        <link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/pgoackgjjkpbkjoomkklkofbhpkbeboc">
        
        @yield('json')
    </head>
    <body class="background" style="margin: 0px">
    <!-- ==========Header===============- -->
<?php if( Request::input('quickview') != "yes" ): ?>
<header class="StickyHeader" id="sticky-header">
    <div class="container">
        <div class="row">
            <hgroup class="col-sm-2 col-md-3">               
                    <a href="<?=newUrl()?>" title="Indiashopps">
                        <img class="indiashopps-logo img-responsive" src="<?=newUrl()?>images/v1/indiashopps_logo-final.png" alt="Indishopps" />
                    </a>               
            </hgroup>
        <!--  pos search module TOP  -->
            <div class="col-xs-12 col-sm-8 col-md-6">
                <div class="wrap_seach list-inline" id="pos_search_top">
                    <?php if( isset($controller) && $controller == "Coupon" ): ?>
                        @include("v1.common.coupon-search")
                    <?php else: ?>
                        @if( !isset( $navigation ) )
                            <?php $navigation = helper::get_categories_tierd(); ?>
                        @endif
                        @include("v1.common.search",[ 'navigation' => $navigation ])
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-2 col-md-2">
                <div class="my-account" style="margin-top: 20px; display: inline-block; ">
                    <div class="dropdown_menu">
                        <div class="account_menu {{(Auth::check()) ? 'loggedin' : ''}}" style="cursor: pointer;">
                            @if( Auth::check() )
                            <a href="{{newUrl('myaccount')}}">
                                @if( @Auth::user()->pimage == '' )
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                @else
                                    <img class="img-circle" src="{{Auth::user()->pimage}}" width="50px" />
                                @endif
                            @else
                            <a href="{{newUrl('user/login')}}">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            @endif

                            @if( Auth::check() )
                                {{ucwords(Auth::user()->name)}}
                            @endif
                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </a>
                        </div>
                        <span class="submenu" style="display: none">
                            <div class="contents hidden-xs">
                                <div class="info">
                                    <?php if( Auth::check() ):?>
                                        <div class="sub-title">{{ucwords(Auth::user()->name)}}</div>
                                        <div class="sub-email">{{Auth::user()->email}}</div>
                                    <?php else: ?>
                                        <div class="sub-title text-center">Your Account</div>
                                        <div class="sub-email text-center">Access account and manage preferences</div>
                                    <?php endif; ?>
                                </div>
                                <div class="links nb">
                                    <?php if( Auth::check() ):?>
                                        <a href="{{newUrl('myaccount')}}" title="{{Auth::user()->name}}" class="section button">My Account</a>
                                        <a href="{{newUrl('user/logout')}}" class="section button">Logout</a>
                                    <?php else: ?>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-1">
                                            <a class="section button" href="{{newUrl('user/register')}}">Sign up</a>
                                        </div>
                                        <div class="col-md-5 col-sm-5 col-xs-12">
                                            <a class="section button" href="{{newUrl('user/login')}}">Login</a>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
            <!--<div class="col-md-3 col-sm-3 hidden-xs hidden-sm">
                <a href="https://play.google.com/store/apps/details?id=com.indiashopps.android&referrer=source%3DSite ">
                    <img src="<?=asset("/images/v1/download_aap3.png")?>" class="img-responsive aap-icons" width="130">
                </a>
                <a href="#">
                    <img src="<?=asset("/images/v1/download_aap3.png")?>" class="img-responsive aap-icons" width="130">
                </a>
            </div>-->
        </div>
    </div>
</header>
<!-- ================================Category==========================- -->
<?php //dd($navigation); ?>
<div class="menu_out">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-3 col-sm-4">
                <div class="pt_vegamenu">
                    <div class="pt_vmegamenu_title">
                        <div class="main-cat-heading">Categories</div>
                    </div>
                        <div id="pt_vmegamenu" class="pt_vegamenu_cate">
                            
                        </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Menu -->
            <div class="nav-container visible-desktop hidden-xs col-sm-8 col-md-9">
                <div id="pt_custommenu" class="pt_custommenu">
                    <div id="pt_menu_home" class="pt_menu act">
                        <div class="parentMenu">
                            <a href="<?=newUrl()?>">
                                <span>Home</span>
                            </a>
                        </div>
                    </div>
                    <div class="pt_menu_cms pt_menu">
                        <div class="parentMenu">
                            <a href="<?=newUrl(seoUrl('mobile/mobiles'))?>">
                                <span>Mobiles</span>
                            </a>
                        </div>
                    </div>
                    <div class="pt_menu_cms pt_menu">
                        <div class="parentMenu">
                            <a href="<?=newUrl('computers')?>">
                                <span>Computers</span>
                            </a>
                        </div>
                    </div>
                    <div class="pt_menu_cms pt_menu">
                        <div class="parentMenu">
                            <a href="http://www.indiashopps.com/blog" target="_blank">
                                <span>Blogs</span>
                            </a>
                           <!--   <a href="<?=newUrl('romantic-february-valentines-special')?>">
                              
                                <img src="<?=newUrl('/')?>images/v1/valentine.gif" alt="Valentine" class="coupon_menu_img lazy">
                            </a> -->
                        </div>
                    </div>
                    <div class="pt_menu_cms pt_menu">
                            <a href="<?=newUrl('coupons')?>">
                                <img src="<?=newUrl('/')?>images/v1/coupon.gif" alt="Coupons Online Icon" class="coupon_menu_img lazy">
                            </a>
                    </div>
                <div class="pt_menu_cms pt_menu">
                    <div class="parentMenu">
                        <a href="https://play.google.com/store/apps/details?id=com.indiashopps.android&referrer=source%3DSite " class="aap-icons" target="_blank">
                            <img src="<?=asset("/images/v1/download_aap3.png")?>" alt="Download Indiashopp Android App Icon" class="aap_menu_img lazy">
                        </a>
                    </div>
                </div><!-- 
                <div class="pt_menu_cms pt_menu">
                     <div class="parentMenu">
                        <a href="# " class="aap-icons" target="_blank">
                            <img src="<?=asset("/images/v1/extension_chrome.png")?>"  >
                        </a>
                    </div>
                </div> -->
                </div>
                <div class="clearfix"></div>
            </div>                
        </div>
    </div>
</div>
<?php endif; ?>
<style type="text/css">
    .submenu {
        position: absolute;
        z-index: 10;
        left: -60px;
        background: white;
        margin-top:3px;
    }
    .my-account .contents {
        min-width: 240px;
        padding: 10px;
    }
    .my-account .submenu {
        background-color: #fff;
        border: 1px solid #f3f4f5;
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        color: #3e4152;
        font-family: arial;
    }
    .my-account .contents .info {
        padding: 10px 0;
    }
    .my-account .submenu .contents .info .sub-title {
        color: #000;
        font-size: 16px;
        font-weight: 800;
         font-family: arial;
    }
    .section.button {
    border: 1px solid #999;
    color: #999;
    font-family: arial;
    font-size: 15px;
    padding: 8px 14px;
    }
    .fa.fa-user {
        font-size: 40px;
        color: #999;
    }
    .account_menu {
        padding: 3px;
        border-color:#999;
    }
    .sub-email {
    color: #999;
    font-family: arial;
    font-size: 12px;
    font-weight: 600;
}

.account_menu.loggedin a, .account_menu.loggedin .fa-user {
    color: green !important;
}
</style>