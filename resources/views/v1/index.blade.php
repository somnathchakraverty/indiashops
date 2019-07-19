@extends('v1.layouts.master')
@section('content')
@section('description')	
   	 <meta name="description" content="Compare Prices Online for Mobiles, Electronics, Appliances, Books, Men, and Women - Clothing & Accessories at Indiashopps.com. Get Latest Coupons & Discount." />   
@endsection
@section('meta')	
    <link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store" />
@endsection
<!--=================================Slider===========================-->
 <div class="home_container">
    <div class="slider-container-fliud ">
        <div class="container">
            <div class="row">
                <!--<div class="hidden-xs hidden-sm col-md-3"></div>-->
                <div class="col-sm-9 col-md-9">
                    <div class="pos-slideshow">
                        <div class="flexslider ma-nivoslider">
                            <div class="pos-loading"></div>
                            <div id="pos-slideshow-home" class="slides">
                            <?php foreach( $mainSlider as $slide ): ?>
                            	<a href="<?=$slide->refer_url?>" target="_blank">
                                	<img style="display:none" class="lazy" src='<?php echo config('app.slider_url').$slide->image_url; ?>' data-thumb="#" alt="<?php echo $slide->alt; ?>" title="#" url="<?=$slide->refer_url?>"/>
                                </a>
                            <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="col-md-3 col-sm-3 hidden-xs ">
				<div class="slider_form_bg_img">
					<div class="slider_form_bg">
						<form class="slider_form" method="POST" id="compare_mobiles">
							<div class="row">
								<div class="slider_form_heading hidden-xs hidden-sm">Compare Phones</div>
							<div class="col-md-12 col-sm-12">
							<div class="form-group">
								<div class="col-sm-12 col-md-12">
									<select class="form-control compare_mobiles" id="mobile1" name="mobile1">
										<option value="">-----SELECT-----</option>
									</select>
								</div>
							</div>
							</div>
							</div>
							<div class="row">
								<div class="col-md-8 col-sm-8 col-md-offset-4 col-sm-offset-4">
								 <img class="img-responsive" src="<?=asset("/images/v1/mobile_vs.png")?>" alt="Logo" style="margin-top:10px;"/>
								</div>
							</div>
							<div class="row">
							<div class="col-md-12 col-sm-12">
							<div class="form-group"  style="margin-top: 10px;">
								<div class="col-sm-12 col-md-12">
									<select class="form-control compare_mobiles" id="mobile2" name="mobile2">
										<option value="">-----SELECT-----</option>
									</select>
								</div>
							</div>
							</div>
							</div>
							<div class="row">
							<div class="col-sm-12 col-md-12">
								<div class="form-group">
									<div class="col-md-offset-3 col-sm-9 col-md-9">
									<button type="submit" class="btn btn-danger slider_form_button">Compare</button>
								  </div>
							  </div>
							  </div>
							</div>
							<input type="hidden" value="{{csrf_token()}}" name="_token" />
						</form>
						<div class="slider_form_button_bottom hidden-sm">
							<a href="<?=newUrl('most-compared-mobiles.html')?>">
								<i class="fa fa-mobile" aria-hidden="true" style="font-size: 1.2em;"></i>
								&nbsp;Most Compared Mobiles
							</a>
						</div>
					</div>
				</div>
			</div>
        </div>
        </div>
    </div>
<!---=========================slider end=======================-->
<!---=================Vendor logo======================-->
 <div class="logo_container">
    <div class="container">
		<div class="vendor_row">
			<div class="row">
			<div class="col-md-3 vendor_compare_online">
				<h1>Compare Price Online & Save</h1>
			</div>
				<div class="col-xs-12 col-md-9" style="overflow: hidden;">
					<div class="pos_logo">
						<marquee>
							<a href="<?=newUrl('search?search_text=Showpieces & Decoratives&group=all#query=Showpieces & Decoratives&vendor=3')?>" target="_blank">
								<img class="img-responsive pos-logo-slide" src="<?=asset("/images/v1/vendor_logo/amazon_logo.png")?>" alt="amazon" />
							</a>
							<a href="<?=newUrl('search?search_text=dresses&group=Women#query=dresses&vendor=1')?>" target="_blank">
								<img class="img-responsive pos-logo-slide" src="<?=asset("/images/v1/vendor_logo/flipkart_logo1.png")?>" alt="flipkart" />
							</a>
							<a href="<?=newUrl('search?search_text=dresses&group=Women#query=dresses&vendor=16')?>" target="_blank">
								<img class="img-responsive pos-logo-slide" src="<?=asset("/images/v1/vendor_logo/snapdeal_logo.png")?>" alt="snapdeal" />
							</a>
							 <a href="<?=newUrl('search?search_text=dresses&group=Women#query=dresses&vendor=4')?>" target="_blank">
								<img class="img-responsive pos-logo-slide" src="<?=asset("/images/v1/vendor_logo/myntra_logo.png")?>" alt="myntra" />
							</a>
							<a href="<?=newUrl('search?search_text=dresses&group=Women#query=dresses&vendor=2')?>" target="_blank">
								<img class="img-responsive pos-logo-slide" src="<?=asset("/images/v1/vendor_logo/jabong_logo.png")?>" alt="jabong" />
							</a>
							<a href="<?=newUrl('search?search_text=dresses&group=all#query=dresses&vendor=5')?>" target="_blank">
								<img class="img-responsive pos-logo-slide" src="<?=asset("/images/v1/vendor_logo/homeshop18_logo.png")?>" alt="homeshop18" />
							</a>   
							<a href="<?=newUrl('search?search_text=kids&group=all#query=kids&vendor=23')?>" target="_blank">
								<img class="img-responsive pos-logo-slide" src="<?=asset("/images/v1/vendor_logo/firstcry_logo.png")?>" alt="firstcry" />
							</a>
						</marquee>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>       
<!---=======================Vendor logo end=============================- -->
<div class="home_content">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-9">
				<div class="pos_featured_product block_product">
					<div class="title_block">
						<h3>Latest Products ( as on <?=date("F j, Y")?> )</h3>
						<div class="navi ">
							<a class="prevtab">
								<i class="fa fa-angle-left"></i>
							</a>
							<a class="nexttab">
								<i class="fa fa-angle-right"></i>
							</a>
						</div>
					</div>
					<div class="block_content">
						<div class="row_edited">
							<div class="featuredSlide slider_product">
								<!--------- Latest Product Items ------ -->
                                <?php foreach( $latestPro as $prod ): ?>
	                                <?php if($prod->found): ?>
	                                <?php $prod = $prod->_source; ?>
	                                <?php $p_url = newUrl( 'product/'.create_slug($prod->name)."/".$prod->id ); ?>
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=$p_url?>" title="<?=$prod->name?>" itemprop="url">
													<?php 
													 /*$file = basename(getImage($prod->image_url, $prod->vendor )); 
													 $newimg = newUrl("images/v1/")."/others/".$file; 
													 if( file_exists( base_path()."/images/v1/others/".$file ) )
															$img = $newimg;
														  else
															$img = getImage($prod->image_url, $prod->vendor );*/										
															$img = getImageNew($prod->image_url, 'XS' );
													?>
													<img src="<?=$img?>" alt="<?=$prod->name?>" class="img-responsive product-item-img lazy" />
												</a>
												<!--<a class="new-box" href="#"><span>New</span></a>-->
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="<?=$p_url?>?quickview=yes">
													<i class="icon-eye"></i>Quick view				
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="<?=$p_url?>" title="Faded Short Sleeves T-shirt">
	                                                <?=$prod->name?>
												</a>
												<div class="comment_box">
													<div class="star_content clearfix">
														<div class="star"></div>
														<div class="star"></div>
														<div class="star"></div>
														<div class="star"></div>
														<div class="star"></div>
													</div>
												</div>
												<div class="price-box">
													<meta itemprop="priceCurrency" content="1" />
													<span class="price">Rs. <?=number_format( $prod->saleprice )?></span>
												</div>
											</div>
										</div>
									</div>
	                                <?php endif; ?>
                                <?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<a href="{{seoUrl(url('mobile/mobiles'))}}" target="_blank">
					<img src="<?=asset("/images/v1/ads/ad_11.jpg")?>" alt="Buy Mobile Online Icon" class="img-responsive hot-deals-ads hidden-xs lazy" />
				</a>
				<a href="https://play.google.com/store/apps/details?id=com.indiashopps.android&referrer=source%3DSite" target="_blank">
					<img src="<?=asset("/images/v1/ads/ad_12.jpg")?>" alt="Download Indiashopps Android app Icon" class="img-responsive hot-deals-ads hidden-xs lazy" />
				</a>
			</div>
<!------========================Hot Deals==============- -->
            <div class="col-xs-12 col-sm-9">
				<div class="hot_deals_product block_product">
					<div class="title_block">
						<h3>Hot Deals</h3>
						<div class="navi">
							<a class="prevtab">
								<i class="fa fa-angle-left"></i>
							</a>
							<a class="nexttab">
								<i class="fa fa-angle-right"></i>
							</a>
						</div>
					</div>
					<div class="block_content">
						<div class="row_edited">
							<div class="hotdeals slider_product" id="hotdeals">
                                <div style="text-align: center;">
									<img src="<?=asset("images/loading.gif")?>" alt="Loading...">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<a href="/redirect?url=http%3A%2F%2Fwww.homeshop18.com%2Fvaranga%2Fcategoryid%3A3396%2Fsearch%3Avaranga%2Fsort%3ADiscounts%2F" target="_blank">
					<img src="<?=asset("/images/v1/ads/ad_25.jpg")?>" alt="Special Offers" class="img-responsive hot-deals-ads hidden-xs lazy" />
				</a>
				<a href="https://chrome.google.com/webstore/detail/pgoackgjjkpbkjoomkklkofbhpkbeboc" target="_blank">
					<img src="<?=asset("/images/v1/ads/ad_4.jpg")?>" alt="Indishopp Chrome Extension" class="img-responsive hot-deals-ads hidden-xs lazy" />
				</a>
			</div>        
<!--========================Banners=====================-->
			<div class="cate_image_bg col-md-6 col-sm-6 col-xs-12">
				<a href="/redirect?url=http%3A%2F%2Flinksredirect.com%2F%3Fpub_id%3D4618CL4384%26url%3Dhttp%253A%252F%252Fwww.jabong.com%252Fall-products%252Fdiscount-more-than-29%252F" target="_blank">
					<img src="<?=asset("/images/v1/banners/banner_91.jpg")?>" alt="dDiwali Offers" class="img-responsive lazy" />
				</a>
			</div>
			<div class="cate_image_bg col-md-6 col-sm-6 col-xs-12">
				<a href="/redirect?url=http%3A%2F%2Fwww.amazon.in%2FOppo-OPPO-A1601-F1S-Gold%2Fdp%2FB01NCEG4UD%3Ftag%3Dindiashopps-21" target="_blank">
					<img src="<?=asset("/images/v1/banners/banner_92.jpg")?>" alt="Festive and Party looks" class="img-responsive lazy" />
				</a>
			</div>
<!------========================Top Brand==============- -->
            <div class="col-xs-12">
				<div class="postabcateslider postabcateslider1 block_product">
					<div class="title_block">
						<h3>
							<span >Top Brands</span>
						</h3>
						<div id="navi1_0" class="navi">
							<a class="prevtab">
								<i class="fa fa-angle-left"></i>
							</a>
							<a class="nexttab">
								<i class="fa fa-angle-right"></i>
							</a>
						</div>
						<div id="navi1_1" class="navi">
							<a class="prevtab">
								<i class="fa fa-angle-left"></i>
							</a>
							<a class="nexttab">
								<i class="fa fa-angle-right"></i>
							</a>
						</div>
						<div id="navi1_2" class="navi">
							<a class="prevtab">
								<i class="fa fa-angle-left"></i>
							</a>
							<a class="nexttab">
								<i class="fa fa-angle-right"></i>
							</a>
						</div>
						<div id="navi1_3" class="navi">
							<a class="prevtab">
								<i class="fa fa-angle-left"></i>
							</a>
							<a class="nexttab">
								<i class="fa fa-angle-right"></i>
							</a>
						</div>
						<div class="cate_title">
							<ul class="tabs1">
								<li class=" active " rel="tab1_0" data-navi="navi1_0">
									Mobiles
								</li>
								<li class="" rel="tab1_1" data-navi="navi1_1">
									Laptops
								</li>
								<li class="" rel="tab1_2" data-navi="navi1_2">
									Dresses
								</li>
								<li class="" rel="tab1_3" data-navi="navi1_3">
									Home & Furniture
								</li>
							</ul>
						</div>
					</div>
					<div class="tab_container block_content">
						<div id="tab1_0" class="tab_content">
							<div class="row_edited">
								<div id="tab1_0_in" class="tabSlide">
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('mobile/micromax--mobiles')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/mobile/mobile_1.jpg")?>" alt="Buy Micromax Mobile online" class="img-responsive product-item-img lazy" />
												</a>
												<!--<a class="new-box" href="#">
													<span>Sale</span>
												</a>-->
												<!--<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view			
												</a>-->
											</div>
										</div>
									</div>
									<!-------------item 1----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('mobile/apple--mobiles')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/mobile/mobile_2.jpg")?>" alt="Buy Iphone online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 2----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('mobile/motorola--mobiles')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/mobile/mobile_3.jpg")?>" alt="Buy Motorola Mobile online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 3----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('mobile/nokia--mobiles')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/mobile/mobile_4.jpg")?>" alt="Buy Nokia Mobile online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 4----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('mobile/samsung--mobiles')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/mobile/mobile_5.jpg")?>" alt="Buy Samsung Mobile online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 5----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('mobile/lenovo--mobiles')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/mobile/mobile_6.jpg")?>" alt="Buy Lenovo Mobile online" class="img-responsive product-item-img" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 6----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('mobile/panasonic--mobiles')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/mobile/mobile_7.jpg")?>" alt="Buy Panasonic Mobile online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 7----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('mobile/htc--mobiles')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/mobile/mobile_8.jpg")?>" alt="Buy HTC Mobile online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 8----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('mobile/blackberry--mobiles')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/mobile/mobile_9.jpg")?>" alt="Buy Blackberry Mobile online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 9----- -->
								</div>
							</div>
						</div>
						<!-----------------Electronics---------------- -->
						<div id="tab1_1" class="tab_content">
							<div class="row_edited">
								<div id="tab1_1_in" class="tabSlide">
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('computers/hp--laptops')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/electronics/laptop_1.jpg")?>" alt="Buy HP Laptops online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 1----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('computers/lenovo--laptops')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/electronics/laptop_2.jpg")?>" alt="Buy Lenovo Laptops online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 2----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('computers/dell--laptops')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/electronics/laptop_3.jpg")?>" alt="Buy DELL Laptops online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 3----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('computers/acer--laptops')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/electronics/laptop_4.jpg")?>" alt="Buy ACER Laptops online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 4----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('computers/asus--laptops')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/electronics/laptop_5.jpg")?>" alt="Buy Asus Laptops online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 5----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('computers/apple--laptops')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/electronics/laptop_6.jpg")?>" alt="Buy Apple Laptops online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 6----- -->
								</div>
							</div>
						</div>
						<!-------------------------Dresses-------------------- -->
						<div id="tab1_2" class="tab_content">
							<div class="row_edited">
								<div id="tab1_2_in" class="tabSlide">
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('women/clothing/biba--dresses')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/dresses/dresses_1.jpg")?>" alt="Buy Biba Women Dresses online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 1----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('women/clothing/yepme--dresses')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/dresses/dresses_2.jpg")?>" alt="Buy Yepme Women Cloths online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 2----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('women/clothing/lee--jeans')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/dresses/dresses_3.jpg")?>" alt="Buy Lee Women Jeans online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 3----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('women/clothing/cottinfab--dresses')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/dresses/dresses_4.jpg")?>" alt="Buy Cotting Fab Women Cloths online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 4----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('women/clothing/lambency--dresses')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/dresses/dresses_5.jpg")?>" alt="Buy Lambency Women Cloths online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 5----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('women/clothing/texco--dresses')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/dresses/dresses_6.jpg")?>" alt="Buy Texco Women Cloths online" class="img-responsive product-item-img lazy" />
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="tab1_3" class="tab_content">
							<div class="row_edited">
								<div id="tab1_3_in" class="tabSlide">
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('home-decor/nilkamal--furniture')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/home_furniture/home_furniture_1.jpg")?>" alt="Buy Nilkamal Furniture online" class="img-responsive product-item-img" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 1----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('home-decor/fablooms--furniture')?>" title="#" itemprop="url">
													<img src="<?=asset("images/v1/latest_products/home_furniture/home_furniture_2.jpg")?>" alt="Buy Fablooms Furniture online" class="img-responsive product-item-img" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 2----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('home-decor/arra--furniture')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/home_furniture/home_furniture_3.jpg")?>" alt="Buy Arra Furniture online" class="img-responsive product-item-img" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 3----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('home-decor/home-by-shekhawati--furniture')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/home_furniture/home_furniture_4.jpg")?>" alt="Buy Shekhawati Furniture online" class="img-responsive product-item-img" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 4----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('home-decor/springwel--furniture')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/home_furniture/home_furniture_5.jpg")?>" alt="Buy Spring Well Furniture online" class="img-responsive product-item-img" />
												</a>
											</div>
										</div>
									</div>
									<!-------------item 5----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="<?=seoUrl('home-decor/meSleep--furniture')?>" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/home_furniture/home_furniture_6.jpg")?>" alt="Buy Me Sleep Furniture online" class="img-responsive product-item-img" />
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>        
<!---------------------new Products--------------------- -->
            <div class="col-xs-12">
				<div class="pos_new_product block_product">
					<div class="title_block">
						<h3>New Products ( as on <?=date("F j, Y")?> )</h3>
						<div class="navi">
							<a class="prevtab">
								<i class="fa fa-angle-left"></i>
							</a>
							<a class="nexttab">
								<i class="fa fa-angle-right"></i>
							</a>
						</div>
					</div>
					<div class="new_block_content">
						<div class="row">
							<div class="newSlide slider_product" id="trending">
								<div style="text-align: center;">
									<img src="<?=asset("images/loading.gif")?>" alt="Loading...">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
<!--========================Banners=====================-->                 
			<div class="cate_image_bg col-md-6 col-sm-6 col-xs-12">
				<a href="/redirect?url=https%3A%2F%2Fwww.flipkart.com%2Foppo-f1s-rose-gold-64-gb%2Fp%2Fitmezptphhfrzubm%3Fpid%3DMOBEQCQVGHRKYZEZ%26affid%3Daffiliate7%26affExtParam1%3Dsite" target="_blank">
					<img src="<?=asset("/images/v1/banners/banner_92.jpg")?>" alt="Unbox Diwali Sale" class="img-responsive " />
				</a>
			</div>
			<div class="cate_image_bg col-md-6 col-sm-6 col-xs-12" >
				<a href="/redirect?url=http%3A%2F%2Flinksredirect.com%2F%3Fpub_id%3D4618CL4384%26url%3Dhttps%253A%252F%252Fgadgets360.com%252Fshop%252Flaptops%253Fsort%253Dpopularity%2526campname%253Dextra10offer%2526camplink%253DH_G360_Shop_Banner" target="_blank">
					<img src="<?=asset("/images/v1/banners/banner_93.jpg")?>" alt="Ethnicals" class="img-responsive" />
				</a>
			</div>
<!--------------------------Recently Viewed--------------------------- -->
            <div class="col-xs-12 col-sm-12 " style="margin-top:10px;">
				<div class="pos_recently block_product">
					<div class="title_block">
						<h3>Recently Viewed</h3>
						<div class="navi">
							<a class="prevtab">
								<i class="fa fa-angle-left"></i>
							</a>
							<a class="nexttab">
								<i class="fa fa-angle-right"></i>
							</a>
						</div>
					</div>
					<div class="block_content">
						<div class="row_edited">
							<div class="recently slider_product" id="recently_viewed">
								<div style="text-align: center;">
									<img src="<?=asset("images/loading.gif")?>" alt="Loading...">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>    
        </div>
    </div>
</div>
</div>
@endsection
@section('script')
<link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" rel="stylesheet">
<script type="text/javascript">
	$(document).ready(function(){
		// CONTENT.load("hotdeals");
		// CONTENT.load("trending");

		CONTENT.uri = "<?=newUrl("ajaxContent")?>";
		CONTENT.load("trending",true);
		CONTENT.load("hotdeals",true);
		CONTENT.f(true).load("recently_viewed",true);
		CONTENT.compare_url = '<?=newUrl('compare_mobiles.json')?>';
		CONTENT.compare.load();

		$("#compare_mobiles").submit(function(){
			var com_url = '<?=newUrl("compare-mobiles")?>';
			var m1 = $("#mobile1").val();
			var m2 = $("#mobile2").val();

			if( m1.length > 0 && m2.length > 0 )
			{
				var next_url = com_url+"/"+m1+"/"+m2
				location.href = next_url
			}

			return false;
		});
	});
</script>
@endsection