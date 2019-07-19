@extends('v1.layouts.master')
@section('content')
<!--==============left category============= -->	
<div class="all-category-bg">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-4">
				<div class="profile-sidebar">
					<div class="profile-usermenu">
						<ul class="nav">
							<li class="active">
								<a href="<?=newUrl('/coupons/discount/recharge-coupons.html')?>"><i class="fa fa-refresh"></i>Recharge </a>
							</li>
							<li>
								<a href="<?=newUrl('/coupons/discount/mobile--tablets-coupons.html')?>"><i class="fa fa-mobile"></i>Mobile & Tablets</a>
							</li>
							<li>
								<a href="<?=newUrl('/coupons/discount/fashion-coupons.html')?>"><i class="fa fa-female"></i>
								Fashion </a>
							</li>
							<li>
								<a href="<?=newUrl('/coupons/discount/food--dinning-coupons.html')?>"><i class="fa fa-cutlery"></i>Food & Dinning </a>
							</li>
							<li>
								<a href="<?=newUrl('/coupons/discount/computers-laptops--gaming-coupons.html')?>"><i class="fa fa-desktop "></i>Computers, Laptops & Gaming </a>
							</li>
							<li>
								<a href="<?=newUrl('/coupons/discount/home-furnishing--decor-coupons.html')?>"><i class="fa fa-home"></i>Home Furnishing & Decor </a>
							</li>
							
							<li>
								<a href="<?=newUrl('/coupons/discount/travel-coupons.html')?>"><i class="fa fa-plane "></i>Travel </a>
							</li>
							
							<li>
								<a href="<?=newUrl('/coupons/discount/beauty--health-coupons.html')?>"><i class="fa fa-medkit"></i>Beauty & Health </a>
							</li>
							
							<li>
								<a href="<?=newUrl('/coupons/discount/electronic--appliances-coupons.html')?>"><i class="fa fa-plug"></i> Electronic & Appliances </a>
							</li>
							
							<li>
								<a href="<?=newUrl('/coupons/discount/tv-video--movies-coupons.html')?>"><i class="fa fa-video-camera"></i>TV, Video & Movies </a>
							</li>
							
							<li>
								<a href="<?=newUrl('/coupons/discount/cameras--accessories-coupons.html')?>"><i class="fa fa-camera"></i>Cameras & Accessories </a>
							</li>
							
							<li>
								<a href="<?=newUrl('/coupons/discount/entertainment')?>"><i class="fa fa-film"></i>Entertainment </a>
							</li>
							<li>
								<a href="<?=newUrl('/coupons/discount/kids--babies-coupons.html')?>"><i class="fa fa-child"></i> Kids & Babies </a>
							</li>
							<li>
								<a href="<?=newUrl('/coupons/discount/books--stationery-coupons.html')?>"><i class="fa fa-pencil"></i> Books & Stationery </a>
							</li>
							<li>
								<a href="<?=newUrl('/coupons/discount/flowers--gifts-coupons.html')?>"><i class="fa fa-gift"></i>Flowers & Gifts </a>
							</li>
							<li>
								<a href="<?=newUrl('/coupons/discount/sports--fitness-coupons.html')?>"><i class="fa fa-heartbeat"></i> Sports & Fitness</a>
							</li>
							<li>
								<a href="<?=newUrl('/coupons/discount/education--learning-coupons.html')?>"><i class="fa fa-book"></i> Education & Learning</a>
							</li>
							<li>
								<a href="<?=newUrl('/coupons/discount/web-hosting--domains-coupons.html')?>"><i class="glyphicon glyphicon-globe"></i> Web Hosting & Domains </a>
							</li>
						</ul>
					</div>
				<!-- END MENU  -->
				</div>
					<br>
					<a href="/redirect?url=http%3A%2F%2Fwww.flipkart.com%2Fbooks%2Fpr%3Fsid%3Dbks%26offer%3Dnb%253Amp%253A04fd0cca31%26otracker%3Dts_back-to-school_NewMerchUnitModule_5-0_merchandising_vmu1" target="_blank">
						<img src="<?=newUrl('/')?>images/v1/coupon_slider/coupon_ads3.jpg" class="img-responsive">
					</a>
			</div>
			<div class="col-md-9 col-sm-8">
			{!! Breadcrumbs::render() !!}
			<!---------------- slider ----------------- -->
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				<!-- Indicators  -->
					<ol class="carousel-indicators">
						<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
						<li data-target="#carousel-example-generic" data-slide-to="1"></li>
						<li data-target="#carousel-example-generic" data-slide-to="2"></li>
					</ol>
				<!-- Wrapper for slides  -->
					<div class="carousel-inner">
						<div class="item active">
							<a href="/redirect?url=http%3A%2F%2Fwww.indiashopps.com%2Fcoupons%2Fdiscount%2Fmobile--tablets-coupons.html" target="_blank"> 
								<img src="<?=newUrl('/')?>images/v1/coupon_slider/coupon_slider_4.jpg" alt="" class="img-responsive">
							</a>
						</div>
						<div class="item">
							<a href="/redirect?url=http%3A%2F%2Fwww.indiashopps.com%2Fcoupons%2Fdiscount%2Ffashion-coupons.html" target="_blank">
								<img src="<?=newUrl('/')?>images/v1/coupon_slider/coupon_slider_5.jpg" alt="" class="img-responsive">
							</a>
						</div>
						<div class="item">
							<a href="/redirect?url=http%3A%2F%2Fwww.indiashopps.com%2Fcoupons%2Fdiscount%2Fbeauty--health-coupons.html" target="_blank">
								<img src="<?=newUrl('/')?>images/v1/coupon_slider/coupon_slider_6.jpg" alt="" >
							</a>
						</div>
					</div>
				</div><!-- /carousel  -->
				<!---------------- vendor_logo ----------------- -->
				<div class="vendor-logo">
					<h5>Top Brands</h5>
					<a href="<?=newUrl("coupons/amazon-coupons.html")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/amazon_logo.png"></a>
					<a href="<?=newUrl("coupons/flipkart-coupons.html")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/flipkart_logo1.png" ></a>
					<a href="<?=newUrl("coupons/croma-coupons.html")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/croma_logo.png"></a>
					<a href="<?=newUrl("coupons/dominos-coupons.html")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/dominos_logo.png"></a>
					<a href="<?=newUrl("coupons/ebay-coupons.html")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/ebayi_logo.png"></a>
					<a href="<?=newUrl("coupons/expedia-coupons.html")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/expedia_logo.png"></a>
					<a href="<?=newUrl("coupons/fabfurnish-coupons.html")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/fabfurnish_logo.png"></a>
					<a href="<?=newUrl("coupons/paytm-coupons.html")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/paytm_logo.png"></a>
					<a href="<?=newUrl("coupons/firstcry-coupons.html")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/firstcry_logo.png"></a>
					<a href="<?=newUrl("coupons/foodpanda-coupons.html")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/foodpanda_logo.png"></a>
					<a href="<?=newUrl("coupons/healthkart-coupons.html")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/healthkart_logo.png"></a>
				</div>
				<br>
				<!---------------- New Coupons ----------------- -->
				<div class="new-coupon-bg">
					<div class="pos_recently block_product" >
						<div class="row">
							<div class="col-sm-8 col-xs-7 vendor-logo">
								<h5>New Coupon</h5>
							</div>
							<div class="col-sm-4 col-xs-5 new-coupon-slider-icon">
								<div class="controls pull-right">
									<a class="left fa fa-chevron-left btn btn-danger prevtab" href="#carousel-example"	data-slide="prev">
									</a>
									<a class="right fa fa-chevron-right btn btn-danger nexttab" href="#carousel-example"data-slide="next">
									</a>
								</div>
							</div>
						</div>
					<div class="block_content"style="margin-top:0px;">
						<div class="row_edited">
							<div class="recently slider_product">
								<!---------item 1------ -->
                                <?php foreach( $product as $forpro ): ?>
                                    <?php $prosource = $forpro->_source; ?>
    								<div class="item_out">
    									<div class="item" style="margin:10px">
    										<div class="new-coupon-pro">
    											<a href="<?=newUrl("coupon/".create_slug($prosource->title)."/".$prosource->promo);?>" title="{{$prosource->title}}" class="get-code" target="_blank" out-url='<?=$prosource->offer_page?>'>
    												<img src="<?=$prosource->image_url?>" alt="" class="img-responsive" / style="margin:0 auto; max-height: 82px;">
    											</a>
    										</div>
    										<div class="home_tab_info">
    											<a class="product-name" href="<?=newUrl("coupon/".create_slug($prosource->title)."/".$prosource->promo);?>" title="{{$prosource->title}}" class="get-code" target="_blank" out-url='<?=$prosource->offer_page?>'>{{ truncate(($prosource->title),30) }}
    											</a>
    											<a href="<?=newUrl("coupon/".create_slug($prosource->title)."/".$prosource->promo);?>" class="btn btn-danger col-md-offset-3 col-xs-offset-hidden get-code" target="_blank" out-url='<?=$prosource->offer_page?>'>GET CODE</a>
    										</div>
    									</div>
    								</div>
                                <?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
				</div>
			<!--===============Hot Deal's ==================== -->	
				<div class="new-coupon-bg">
					<div class=" vendor-logo">
						<h5>Hot Deal's</h5>
					</div>	
				<div class="row" style="margin:10px">
                    <?php $i=1; ?>
                    <?php foreach( $product1 as $forpro ): ?>
                    <?php $sourcefor =  $forpro->_source; ?>
                    <?php if( $i<=8 ):?>
    					<div class="col-md-3 col-sm-4">
    						<div class="thumbnail new-coupon-pro" >
    							<a href="<?=newUrl("coupon/".create_slug($sourcefor->title)."/".$sourcefor->promo);?>" class="get-code" target="_blank" out-url='<?=$sourcefor->offer_page?>'>
    								<img src="<?=$sourcefor->image_url;?>" class="img-responsive">
    							</a>
    							<div class="caption">
    							<div class="home_tab_info new-coupon-hot-deals">
    								<a  href="<?=newUrl("coupon/".create_slug($sourcefor->title)."/".$sourcefor->promo);?>" title="{{$sourcefor->description}}" class="get-code" target="_blank" out-url='<?=$sourcefor->offer_page?>'>{{truncate($sourcefor->title,50)}}
    								</a>
    							</div>
    							<p class="new-coupon-hot-deals-mini-text">{{truncate($sourcefor->description,50)}}</p>
    							<button class="btn btn-danger col-md-offset-3 col-sm-offset-0 col-xs-offset-4 col-xs-offset-hidden get-code" out-url='<?=$sourcefor->offer_page?>' onclick="window.open('<?=newUrl("coupon/".create_slug($sourcefor->title)."/".$sourcefor->promo);?>');">GET CODE</button>
    							</div>
    						</div>
    					</div>
                    <?php endif; $i++;?>
                    <?php endforeach; ?>
				</div>
				</div>	
			</div>
		</div>	
	</div>
</div>
@endsection
@section("script")
<script type="text/javascript">
	var recently = $(".recently");
    recently.owlCarousel({
        items: 4,
        itemsDesktop: [1199, 4],
        itemsDesktopSmall: [991, 3],
        itemsTablet: [767, 2],
        itemsMobile: [480, 1],
        autoPlay: false,
        stopOnHover: false,
        addClassActive: true,
    });

    // Custom Navigation Events
    $(".pos_recently .nexttab").click(function() {
        recently.trigger('owl.next');
    })
    $(".pos_recently .prevtab").click(function() {
        recently.trigger('owl.prev');
    })
</script>
@endsection