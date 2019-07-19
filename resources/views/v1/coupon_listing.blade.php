@if ( !isset($ajax) )
	@extends('v1.layouts.master')
	@section('description')
	  @if(isset($vendor_name))
		@if($vendor_name == "flipkart")
    		<meta name="Save your huge bucks with Flipkart Discount Coupons and Promo Codes verified by thousands of customer only at IndiaShopps. Grab latest offers and deals Now!">
	    @elseif($vendor_name == "amazon")
	    	<meta name="Grab latest Amazon Discount Coupons and Promo Codes verified by thousands of customer only at IndiaShopps. Explore latest offers and deals on your online shopping.">
	    @elseif($vendor_name == "paytm")
	    	<meta name="Use Paytm Mobile Recharge Coupons and Promo Codes & Save your hard earned money only at Indiashopps. Grab latest offers and deals Now!">
	    @else
	    	<meta name="IndiaShopps is the most reputed affiliate online shopping website which helps to buy, search, explore the quality & branded Mobiles at most comparative prices">
	    @endif
	  @endif
	@endsection
	@section('content')
	<!--==============Coupon Listing============= -->	
	<div class="all-category-bg">
		<div class="container">
			<div class="row">
			<br>
				<div class="col-sm-4 col-md-3">
					@include( 'v1.common.coupon_filter', [ 'facet' => $facet ] )
					<a href="/redirect?url=http%3A%2F%2Fwww.lenskart.com%2Feyewear%2Fbest-of-best" class="hidden-xs" target="_blank">
						<img  src="<?=newUrl()?>images/v1/coupons_listing/coupon_listing_ads7.jpg" class="img-responsive hot-deals-ads">
					</a>
					<a href="/redirect?url=http%3A%2F%2Fwww.snapdeal.com%2Fproducts%2Fmens-footwear-sports-shoes%3Fsort%3Dplrty" target="_blank">
						<img  src="<?=newUrl()?>images/v1/coupons_listing/coupon_listing_ads8.jpg" class="img-responsive hot-deals-ads">
					</a>
					<a href="/redirect?url=http://indiashopps.yourshoppingwizard.com/coupons/dominos-coupons.html" class="hidden-xs" target="_blank">
						<img  src="<?=newUrl()?>images/v1/coupons_listing/coupon_listing_ads9.jpg" class="img-responsive hot-deals-ads ">
					</a>
				</div>
	<!----------------- / Offers and Coupons  --------------- -->			
				<div class="col-sm-8 col-md-9"  id="right_container">
					{!! Breadcrumbs::render() !!}
					<?php if( !empty( $catmeta ) ): ?>
						<div class="row">
							<div class="col-sm-12 col-xs-12">
								<br/>
								<div class="comment more-data slide closed" style="height: 32px; overflow: hidden;" data-height="32">
									<?=$catmeta?>
								</div>
								<span class="show-more show-toggle"><a href="#" class="more">Show More >></a></span>
								<span class="show-less show-toggle" style="display: none;"><a href="#" class="more">Show Less <<</a></span>
							</div>
						</div>
					<?php endif; ?>
					<?php if( !empty( $vendor_name ) && !empty( $product[0] ) && empty( @$search ) ): ?>
						<div class="row">
							<div class="col-sm-12 col-xs-12">
								<img  src="<?=newUrl()?>images/v1/coupons_listing/mobile_tablets.jpg" class="img-responsive">
								<div class="row">
									<div class="col-md-2 col-sm-4 col-xs-5">
										<div class="coupon_list_profile">
											<img  src="<?=$product[0]->_source->vendor_logo?>" class="img-responsive">
										</div>
									</div>
									<div class="col-md-10 col-sm-8 col-xs-7">
										<h4 class="coupon_list_profile-heading"><?=@ucwords( $vendor_name )?></h4>
										<p class="coupon_list_profile-heading">Online Website</p>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<div class="vendor-logo ">
						@if(isset($vendor_name) && $vendor_name == "flipkart")
							<h1 class=" vendor-logo">Filpkart Discount Coupon Code</h1>
						@elseif(isset($vendor_name) && $vendor_name == "amazon")
							<h1 class=" vendor-logo">Amazon Discount Coupon Code</h1>
						@elseif(isset($vendor_name) && $vendor_name == "paytm")
							<h1 class=" vendor-logo">Paytm Mobile Recharge Coupon Code</h1>
						@else
							<h1 class=" vendor-logo"><?=@ucwords( $vendor_name )?> Offers and Coupons (<span id="c_total"><?=$product_count?></span>) </h1>
						@endif
					</div>
					@include('v1.common.coupon_desc', [ 'vendor' => @$vendor_name ] )
					<div id="appliedFilter"></div>
					<div id="coupon-wrapper">
					<!----------------- / panel 1  --------------- -->
@endif
	                <?php foreach( $product as $c ): ?> 
	                <?php $coupon = $c->_source ?>
					<div class="panel panel-default coupon-list-panel">
						<div class="row">
							<div class="col-md-2 col-sm-3 ">
								<figure class="coupon-list-panel-logo">
									<a href="<?=newUrl("coupon/".create_slug($coupon->title)."/".$coupon->promo); ?>" onClick="ga('send', 'event', 'coupon', 'click');" class="coupon-list-panel-heading" target="_blank">
										 <img style="width:120px" src="<?=$coupon->image_url?>" class="img-responsive">
									</a>
								</figure>
							</div>
							<div class="col-md-7 col-sm-5 coupon-list-panel-content">
								<a href="<?=newUrl("coupon/".create_slug($coupon->title)."/".$coupon->promo); ?>" onClick="ga('send', 'event', 'coupon', 'click');" class="coupon-list-panel-heading" target="_blank"><?=$coupon->title?></a>
									<p><?=$coupon->description?></p>
							</div>
							<div class="col-md-2 col-sm-3 coupon-list-panel-content">
								<a style="color:#fff;" href="<?=newUrl("coupon/".create_slug($coupon->title)."/".$coupon->promo); ?>" target="_blank" out-url='<?=$coupon->offer_page?>' class="get-code">
									<button onClick="ga('send', 'event', 'coupon', 'click');" class="btn btn-danger activate-deal "><?php if(empty($coupon->code)){ ?>Activate Deal<?php } else{ echo "Get Code";}?></button>
								</a>
								<img src="<?=$coupon->vendor_logo?>"  class="img-responsive coupon-listing-vendor-logo">
							</div>
						</div>
					</div>
	                <?php endforeach; ?>
@if ( !isset($ajax) )
					</div>
				</div>
			</div>
		</div> <!-- /container  -->  
	</div>
	@endsection
	@section('script')
		<script type="text/javascript"> var load_image = "<?=newUrl('images/loading.gif')?>" </script>
	    <script type="text/javascript" src="<?=newUrl('js/v1/couponlist.js')?>"></script>
	    <style type="text/css">
			div#appliedFilter {
				background: #f2f2f2 none repeat scroll 0 0;
				margin: 10px 0px;
				width: auto;
			}
			h1{ font-size: 20px; color: #D70D00; padding: 10px; }
			.wishlist-icon.wish-added{ color: #D70D00  }
			div#message-div{ margin-top: 10px; width: auto; }
			div#appliedFilter.applied{  padding: 10px; }
			div#appliedFilter div { display: inline; margin-left: 10px; }
			div#appliedFilter div:last-child{ margin-right: 10px;  }
			div#appliedFilter .fltr-label { font-weight: bolder;  }
			div#appliedFilter .clear-all{ cursor: pointer; text-decoration: underline;  }
			div#appliedFilter .single-fltr div:hover{ cursor: pointer; text-decoration: line-through;  }
			div#appliedFilter .fltr-remove{ margin-left:  5px; }
			.comment.more-data.slide.closed:after {
			    content: "...";
			    position: absolute;
			    right: 29px;
			    top: 23px;
			    font-size: 3em;
			}
			.comment.more-data.slide.closed { padding-right: 50px; }
	   </style>
	@endsection
@endif