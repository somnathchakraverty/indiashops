@if($product->category_id != 351)
    @if($product->grp=="electronics")
        <?php
            $description = "Compare ".$product->name." Online Price including Reviews, Features, Specifications in India with latest offers, deals & coupon at Indiashopps.";
        ?>
    @elseif($product->grp=="appliances")
        <?php
            $description = "Compare ".$product->name." Online Price on ".date("M j, Y")." including Reviews, Features & full Specifications in India with latest offers, deals at Indiashopps. Lowest Price Guaranteed.";
        ?>
    @elseif($product->grp == "home & decor" || $product->grp == "care")
    <?php $description = "Buy or Compare Price ". $product->name." Shop from wide range of ".$product->category." Online in India at lowest price with latest offers deals at Indiashopps. ✓ Lowest Price Guaranteed."; ?>
    @elseif($product->grp == "computers")
        <?php $description = "Experience Smart Shopping only @Indiashopps. Buy ". $product->name." online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly from inside your favorite shopping website like Flipkart, Amazon, Snapdeal & many more."; ?>
    @elseif($product->grp == "kids")
        <?php $description = "Shop or Compare Online ". $product->name." latest price in India with Exciting offers, Color option, Coupons/deals & Lowest Price Guaranteed only at Indiashopps.com."; ?>
    @elseif($product->grp == "camera")
        <?php $description = "Shop or Compare ". $product->name." Price Online including Reviews, Features & full Specifications in India with latest deals, coupon & best offers only at Indiashopps."; ?>
    @elseif($product->grp == "beauty & health")
    <?php $description = "Buy or Compare Price ". $product->name." from wide range of ".$product->parent_category." ".$product->category." Online in India at lowest price with latest offers deals at Indiashopps. ✓ Lowest Price Guaranteed"; ?>
    @elseif($product->grp == "sports & fitness")
    <?php $description = "Buy or Compare Price ". $product->name." from wide range of ".$product->category." Online in India at lowest price with latest offers deals at Indiashopps. ✓ Lowest Price Guaranteed"; ?>
    @elseif($product->grp == "lifestyle")
        <?php $description = "Buy or Compare Price ". $product->name." from wide range of ".$product->category." Online in India at lowest price with latest offers deals at Indiashopps. ✓ Lowest Price Guaranteed"; ?>
    @elseif($product->grp == "automotive")
        <?php $description = "Buy ". $product->name." at Lowest Price online with Price & Feature Comparisons, Deals/Offers, Full Specification, and Reviews only at Indiashopps"; ?>

    @else
        <?php
          if(isset($product->mini_spec)){
            $description = $product->name." - ".$product->mini_spec;
          }else{
            $description = $product->name;
            if ( !empty( $product->description ) )
            {
                $description .= " - ".$product->description;
            }
          }
            $description = trim(str_replace(";", " ", $description ));
        ?>
    @endif
@else
    <?php 
        if(!empty($product->saleprice))
            $description = $product->name." Price: INR.".number_format($product->saleprice).". Compare battery, OS, WiFi, camera & display screen size.";
        else
            $description = $product->name.". Compare battery, OS, WiFi, camera & display screen size.";
        if(!empty($product->mini_spec))
        {
            $mspecs = explode(";",$product->mini_spec);
            if(count($mspecs)>=5){
                $description = $product->name." Mobile Phone - RAM:".$mspecs[4].", Camera:".$mspecs[2]." & Price: INR.".number_format($product->saleprice).". Compare battery, OS, WiFi, camera & display screen size.";
            }
        }
        
    ?>      
@endif
@if(isset($meta) && is_object($meta))
    <?php $description = $meta->description ?>
@endif

@section('meta_desciption')
    <meta name="description" content="{{strip_tags( html_entity_decode( $description ) )}}" />
    <meta name="twitter:description" content="{{strip_tags( html_entity_decode( truncate(getMiniSpec($description),196) ) )}}">
    <meta property="og:description" content="{{strip_tags( html_entity_decode( getMiniSpec($description) ) )}}" />
@endsection
