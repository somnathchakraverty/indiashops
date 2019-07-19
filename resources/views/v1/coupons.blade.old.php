@extends('v1.layouts.master')
@section('content')
<!--==============left category============= -->	
<div class="all-category-bg">
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-3">
				<div class="profile-sidebar">
					<div class="profile-usermenu">
						<ul class="nav">
							<li class="active">
								<a href="<?=newUrl('coupon/couponlistcategory?category=Recharge')?>"><i class="fa fa-refresh"></i>Recharge </a>
							</li>
							<li>
								<a href="<?=newUrl('coupon/couponlistcategory?category=Mobile--Tablets')?>"><i class="fa fa-mobile"></i>Mobile & Tablets</a>
							</li>
							<li>
								<a href="<?=newUrl('coupon/couponlistcategory?category=Fashion')?>"><i class="fa fa-female"></i>
								Fashion </a>
							</li>
							<li>
								<a href="<?=newUrl('coupon/couponlistcategory?category=Food--Dinning')?>"><i class="fa fa-cutlery"></i>Food & Dinning </a>
							</li>
							<li>
								<a href="<?=newUrl('coupon/couponlistcategory?category=Computers,-Laptops--Gaming')?>"><i class="fa fa-desktop "></i>Computers, Laptops & Gaming </a>
							</li>
							<li>
								<a href="<?=newUrl('coupon/couponlistcategory?category=Home-Furnishing--Decor')?>"><i class="fa fa-home"></i>Home Furnishing & Decor </a>
							</li>
							
							<li>
								<a href="<?=newUrl('coupon/couponlistcategory?category=Travel')?>"><i class="fa fa-plane "></i>Travel </a>
							</li>
							
							<li>
								<a href="<?=newUrl('coupon/couponlistcategory?category=Beauty--Health')?>"><i class="fa fa-medkit"></i>Beauty & Health </a>
							</li>
							
							<li>
								<a href="<?=newUrl('coupon/couponlistcategory?category=Electronic--Appliances')?>"><i class="fa fa-plug"></i> Electronic & Appliances </a>
							</li>
							
							<li>
								<a href="<?=newUrl('coupon/couponlistcategory?category=TV,-Video--Movies')?>"><i class="fa fa-video-camera"></i>TV, Video & Movies </a>
							</li>
							
							<li>
								<a href="<?=newUrl('coupon/couponlistcategory?category=Cameras--Accessories')?>"><i class="fa fa-camera"></i>Cameras & Accessories </a>
							</li>
							
							<li>
								<a href="<?=newUrl('coupon/couponlistcategory?category=Entertainment')?>"><i class="fa fa-film"></i>Entertainment </a>
							</li>
							<li>
								<a href="<?=newUrl('coupon/couponlistcategory?category=Kids--Babies')?>"><i class="fa fa-child"></i> Kids & Babies </a>
							</li>
							<li>
								<a href="<?=newUrl('coupon/couponlistcategory?category=Books--Stationery')?>"><i class="fa fa-pencil"></i> Books & Stationery </a>
							</li>
							<li>
								<a href="<?=newUrl('coupon/couponlistcategory?category=Flowers--Gifts')?>"><i class="fa fa-gift"></i>Flowers & Gifts </a>
							</li>
							<li>
								<a href="<?=newUrl('coupon/couponlistcategory?category=Sports--Fitness')?>"><i class="fa fa-heartbeat"></i> Sports & Fitness</a>
							</li>
							<li>
								<a href="<?=newUrl('coupon/couponlistcategory?category=Education--Learning')?>"><i class="fa fa-book"></i> Education & Learning</a>
							</li>
							<li>
								<a href="<?=newUrl('coupon/couponlistcategory?category=Web-Hosting--Domains')?>"><i class="glyphicon glyphicon-globe"></i> Web Hosting & Domains </a>
							</li>
						</ul>
					</div>
				<!-- END MENU  -->
				</div>
					<br>
					<a href="http://offers.homeshop18.com/o/facialkitextra/inStock:%28%22true%22%29/" target="_blank">
						<img src="<?=newUrl('/')?>images/v1/coupon_slider/coupon_ads1.png" class="img-responsive">
					</a>
			</div>
			<div class="col-md-9 col-sm-9">
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
							<a href="http://www.flipkart.com/mobiles/~lenovo-phones/pr?sid=tyy%2C4io&otracker=hp_banner_widget_1"> 
								<img src="<?=newUrl('/')?>images/v1/coupon_slider/coupon_slider1.jpg" alt="" class="img-responsive">
							</a>
						</div>
						<div class="item">
							<a href="http://www.amazon.in/b/ref=br_imp_ara-1?_encoding=UTF8&node=9614430031&pf_rd_m=A1VBAL9TL5WCBF&pf_rd_s=desktop-hero-kindle-A&pf_rd_r=0Q8JKCEY03YD7P5352QE&pf_rd_t=36701&pf_rd_p=849405967&pf_rd_i=desktop">
								<img src="<?=newUrl('/')?>images/v1/coupon_slider/coupon_slider2.jpg" alt="" class="img-responsive">
							</a>
						</div>
						<div class="item">
							<a href="http://www.shopclues.com/super-saver-bazaar.html">
								<img src="<?=newUrl('/')?>images/v1/coupon_slider/coupon_slider3.jpg" alt="" >
							</a>
						</div>
					</div>
				</div><!-- /carousel  -->
				<!---------------- vendor_logo ----------------- -->
				<div class="vendor-logo">
					<h5>Top Brands</h5>
					<a href="<?=newUrl("coupon/couponlist?vendor_name=amazon")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/amazon_logo.png"></a>
					<a href="<?=newUrl("coupon/couponlist?vendor_name=flipkart")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/flipkart_logo1.png" ></a>
					<a href="<?=newUrl("coupon/couponlist?vendor_name=croma")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/croma_logo.png"></a>
					<a href="<?=newUrl("coupon/couponlist?vendor_name=domino's")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/dominos_logo.png"></a>
					<a href="<?=newUrl("coupon/couponlist?vendor_name=ebay")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/ebayi_logo.png"></a>
					<a href="<?=newUrl("coupon/couponlist?vendor_name=expedia")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/expedia_logo.png"></a>
					<a href="<?=newUrl("coupon/couponlist?vendor_name=fabfurnish")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/fabfurnish_logo.png"></a>
					<a href="<?=newUrl("coupon/couponlist?vendor_name=fashionara")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/fashionara_logo.png"></a>
					<a href="<?=newUrl("coupon/couponlist?vendor_name=firstcry")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/firstcry_logo.png"></a>
					<a href="<?=newUrl("coupon/couponlist?vendor_name=foodpanda")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/foodpanda_logo.png"></a>
					<a href="<?=newUrl("coupon/couponlist?vendor_name=healthkart")?>"><img src="<?=newUrl('/')?>images/v1/vendor_logo/healthkart_logo.png"></a>
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
    											<a href="<?=newUrl("coupon/couponlistdetail?promo=".$prosource->promo);?>" title="{{$prosource->title}}">
    												<img src="<?=$prosource->image_url?>" alt="" class="img-responsive" />
    											</a>
    										</div>
    										<div class="home_tab_info">
    											<a class="product-name" href="<?=newUrl("coupon/couponlistdetail?promo=".$prosource->promo);?>" title="{{$prosource->title}}">{{ truncate(($prosource->title),30) }}
    											</a>
    											<a href="<?=newUrl("coupon/couponlistdetail?promo=".$prosource->promo);?>" class="btn btn-danger col-md-offset-3 col-xs-offset-hidden">GET CODE</a>
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
    							<a href="<?=$sourcefor->offer_page;?>" onclick="window.open('<?=newUrl("coupon/couponlistdetail?promo=".$sourcefor->promo);?>');">
    								<img src="<?=$sourcefor->image_url;?>" class="img-responsive">
    							</a>
    							<div class="caption">
    							<div class="home_tab_info new-coupon-hot-deals">
    								<a  href="<?=$sourcefor->offer_page;?>" title="{{$sourcefor->description}}" onclick="window.open('<?=newUrl("coupon/couponlistdetail?promo=".$sourcefor->promo);?>');">{{truncate($sourcefor->title,50)}}
    								</a>
    							</div>
    							<p class="new-coupon-hot-deals-mini-text">{{truncate($sourcefor->description,50)}}</p>
    							<button class="btn btn-danger col-md-offset-3 col-sm-offset-2 col-xs-offset-4 col-xs-offset-hidden" onclick="window.open('<?=newUrl("coupon/couponlistdetail?promo=".$sourcefor->promo);?>');">GET CODE</button>
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