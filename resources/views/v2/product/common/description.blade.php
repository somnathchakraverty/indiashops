<?php $c_name = (isset($c_name)) ? $c_name : '' ;
if(isset($brand) && is_object($brand) && isset($brand->brand))
{
    $brand = $brand->brand;
}
?>
@if(isset($brand) && !empty($brand))
    @if(isset($parent) && $parent == "computers")
        @if(strtolower($brand) == "dell")
            <meta name="description" content="Compare Online Dell Laptop Prices and Specifications insight from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews at Indiashopps.">
        @elseif(strtolower($brand) == "hp")
            <meta name="Compare Online HP Laptop Prices and Specifications insight from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews at Indiashopps.">
        @elseif(strtolower($brand) == "lenovo")
            <meta name="Compare Online Lenovo Laptop Prices and Specifications insight from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews at Indiashopps.">
        @else
            <meta name="description" content="IndiaShopps is the most reputed affiliate online shopping website which helps to buy, search, explore the quality & branded <?php echo $brand." ".$c_name; ?> at most comparative prices">
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
        <meta name="description" content="IndiaShopps is the most reputed affiliate online shopping website which helps to buy, search, explore the quality & branded <?php echo $brand." ".$c_name; ?> at most comparative prices">
    @endif
@else
    @if(isset($parent) && ($parent == "men" || $parent == "women") )
        @if($parent == "men" || $parent == "women")
            <meta name="description" content="Shop or Compare Online <?=$parent?> <?=strtolower($c_name)?> latest price in India with Exciting offers, Coupons and deals on Indiashopps. Compare Brands Now.">
        @else
            <meta name="description" content="IndiaShopps is the most reputed affiliate online shopping website which helps to buy,
                        search, explore the quality & branded <?=$c_name?> for <?=$parent?> at most comparative prices">
        @endif
    @elseif(isset($parent) && $parent == "electronics")
        @if(isset($child) && !empty($child))
            @if(strtoupper($c_name) == "LED TV")
                <meta name="description" content="Compare Online 32 inch, 40 inch & more LED TV prices with features and Specification insight only at Indiashopps.com & buy from Flipkart, Snapdeal, Amazon & many more.">
            @else
                <meta name="description" content="Compare <?=strtoupper($c_name)?> with prices and Specification buy online from Flipkart, Snapdeal, Amazon. Buy Now!">
            @endif
        @else
            <meta name="description" content="Compare <?=strtolower($c_name)?> with prices and buy online from Flipkart, Snapdeal, Amazon. Latest <?=strtolower($c_name)?> price list with pictures, features & specification. Compare Now!">
        @endif
    @elseif(isset($parent) && $parent == "appliances")
        @if(isset($child) && !empty($child))
            <meta name="description" content="Compare <?=ucwords($c_name)?> with price and Specification at Indiashopps. Buy Latest & Branded Energy saving <?=ucwords($c_name)?> at best price. Lowest Price Guaranteed, Shop Now!">
        @else
            <meta name="description" content="Compare <?=strtolower($c_name)?> prices online at Indiashopps. Buy Microwave, Oven, Induction Cooktop, Gas Stove & many more. Lowest Price Guaranteed, Shop Now!">
        @endif
    @elseif(isset($parent) && $parent == "beauty-health")
        @if(isset($child) && !empty($child))
            <meta name="description" content="Save Money & Time - Buy Best <?=ucwords(str_replace('-',' ',$child))?> <?=ucwords($c_name)?> online with Price, Features comparison inside from Flipkart, Amazon & Snapdeal & many more including reviews and latest deal only at Indiashopps.">
        @else
            <meta name="description" content="Shop <?=strtolower($c_name)?> online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside from your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.">
        @endif
    @elseif(isset($parent) && $parent == "sports-fitness")
        @if(isset($child) && !empty($child))
            <meta name="description" content="Save Money & Time - Buy Best <?=ucwords(str_replace('-',' ',$child))?> <?=ucwords($c_name)?> online with Price, full Specification comparison inside from Flipkart, Amazon & Snapdeal & many more including reviews and latest deal only at Indiashopps. ">
        @else
            <meta name="description" content="Purchase Smart & Save money at Indiashopps. Buy <?=strtolower($c_name)?> online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside from your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.">
        @endif
    @elseif(isset($parent) && $parent == "home-decor")
        @if(isset($child) && !empty($child))
            <meta name="description" content="Browse Best <?=ucwords($c_name)?> online with price comparison inside from Flipkart, Amazon & Snapdeal, including reviews and latest deal only at Indiashopps. ✓ Lowest Price Guaranteed.">
        @else
            <meta name="description" content="Save money with smart purchase option at Indiashopps, buy <?=strtolower($c_name)?> online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.">
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
        <meta name="description" content="Compare Online <?=strtolower($c_name)?> Prices and Specifications from Flipkart, Snapdeal, Amazon and many more insight with latest offers, deals & reviews at Indiashopps.">
    @endif
    @elseif(isset($parent) && $parent == "kids")
        @if(isset($child) && !empty($child))
            <meta name="description" content="Browse Best <?=ucwords($c_name)?> online with price comparison inside from Flipkart, Amazon & Snapdeal, including reviews and latest deal only at Indiashopps. ✓ Lowest Price Guaranteed.">
        @else
            <meta name="description" content="Save money & time with smart purchase option only at Indiashopps, Shop or Compare <?=strtolower($c_name)?> online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.">
        @endif
    @elseif(isset($parent) && $parent == "camera")
        @if(isset($child) && !empty($child))
            @if(strtolower($c_name) == "digital slr cameras")
                <meta name="description" content="Compare DSLR Camera price in India Online. Browse full Specifications, feature & reviews insight from Flipkart, Snapdeal, Amazon and many more with latest offers, deals & reviews.">
            @else
                <meta name="description" content="Shop <?=ucwords($c_name)?> Online with Latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.">
            @endif
        @else
            <meta name="description" content="Compare <?=strtolower($c_name)?> with prices and buy online from Flipkart, Snapdeal, Amazon.  Latest <?=strtolower($c_name)?> price list with pictures, features & specification. Compare Now!">
        @endif
    @elseif(isset($parent) && $parent == "care")
        @if(isset($child) && !empty($child))
            <meta name="description" content="Save Money & Time - Buy Best <?=ucwords($c_name)?> online with Price, Features comparison inside from Flipkart, Amazon & Snapdeal & many more including reviews and latest deal only at Indiashopps.">
        @else
            <meta name="description" content="Purchase Smart & Save money at Indiashopps. Buy <?=strtolower($c_name)?> online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside from your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.">
        @endif
    @elseif(isset($parent) && $parent == "lifestyle")
        @if(isset($child) && !empty($child))
            <meta name="description" content="Save Money & Time - Buy Best <?=ucwords($c_name)?> online with Price, Features comparison inside from Flipkart, Amazon & Snapdeal & many more including reviews and latest deal only at Indiashopps.">
        @else
            <meta name="description" content="Purchase Smart & Save money at Indiashopps. Buy <?=strtolower($c_name)?> online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside from your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.">
        @endif
    @elseif(isset($parent) && $parent == "automotive")
        @if(isset($child) && !empty($child))
            <meta name="description" content="Shop <?=ucwords($child)?> <?=ucwords($c_name)?> online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly inside your favorite shopping website like Flipkart, Amazon, Snapdeal & many more.">
        @else
            <meta name="description" content="Shop Best <?=ucwords($c_name)?> Essentials Online with Price, Features & full Specification Comparison inside from Flipkart, Amazon, Snapdeal & many more, including latest offers, deals & reviews only at Indiashopps.">
        @endif
    @elseif(isset($parent) && $parent == "books")
        @if(isset($child) && !empty($child))
            <meta name="description" content="Browse <?=ucwords($c_name)?> Books with price comparison, reviews and latest deal at Indiashopps.">
        @else
            <meta name="description" content="Save money with smart purchase option at Indiashopps, buy <?=strtolower($c_name)?> books online with <em>Price Trends</em>, <em>Price Comparisons</em> & <em>Latest Deal/offers</em> directly inside your favorite shopping website like Flipkart, Amazon, snapdeal & many more.">
        @endif

    @else
        <meta name="description" content="IndiaShopps is the most reputed affiliate online shopping website which helps to buy, search, explore the quality & branded <?=$c_name?> at most comparative prices">
    @endif
@endif
