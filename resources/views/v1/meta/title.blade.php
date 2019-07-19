   @if( $product->grp == "men" || $product->grp == "women")
		<?php $title = "Buy ".$product->name." for ".ucwords($product->grp)." Online India, Best Price, Reviews & Brands"; ?>
	@elseif($product->grp=="mobile")
		<?php $title = $product->name." Lowest, Best Price Online in India on ".date("j M, Y").". View Specifications, Ratings, Reviews, Details, Offers | Indiashopps.com"; ?>
	@elseif($product->grp=="electronics")
		<?php $title = $product->name." - Comparison, Price & Specification"; ?>
	@elseif($product->grp=="appliances")
		<?php $title = "Shop Online ".$product->name." - Comparison, Price & Specification in India"; ?>
	@elseif($product->grp=="home & decor")
		<?php $title = "Buy or Compare Price ".$product->name." - Online in India | Indiashopps"; ?>
	@elseif($product->grp=="computers" || $product->grp=="camera")
		<?php $title = "Compare ". $product->name." - Price, Feature & Full Specification | Indiashopps"; ?>
	@elseif($product->grp=="kids")
		<?php $title = "Buy or Compare ". $product->name." Price Online in India |Indiashopps "; ?>
	@elseif($product->grp=="books")
		<?php $title = "Buy Online ".$product->name." - Price Comparison & Reviews in India | Indiashopps"; ?>
	@elseif($product->grp=="care")
		<?php $title = "Buy ".$product->name." with Price & Feature Comparison Online| Indiashopps"; ?>
	@elseif($product->grp=="beauty & health" || $product->grp=="sports & fitness")
		<?php $title = "Buy ".$product->name." with Price & Feature Comparison Online| Indiashopps"; ?>
	@elseif($product->grp=="lifestyle")
		<?php $title = "Buy ".$product->name." with Price & Feature Comparison Online| Indiashopps"; ?>
	@elseif($product->grp=="automotive")
		<?php $title = "Compare ".$product->name." - Price, Feature & Full Specification | Indiashopps"; ?>	
	@else
		@if ( strlen( $product->name ) >= 56 )
	       <?php $title = $product->name; ?>
	    @else
	        <?php $title = $product->name." | Price Compare India"; ?>
	    @endif
    @endif
    <title>{{$title}}</title>
     <meta itemprop="name" content="{{$title}}">
       <meta name="twitter:image:alt" content="{{$title}}">
         <meta name="twitter:title" content="{{$title}}">
           <meta property="og:title" content="{{$title}}" />
             <meta name="twitter:description" content="{{strip_tags( html_entity_decode( truncate($title,196) ) )}}">
               <meta property="og:description" content="{{strip_tags( html_entity_decode( truncate($title,200) ) )}}" />