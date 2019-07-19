@extends('v1.layouts.master')
@section('content')
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
                                <img style="display:none" src='<?=asset("/images/v1/slider/".$slide->image_url)?>' data-thumb="#" alt="" title="#" />
                            <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 hidden-xs">
                    <a href="#">
                        <img class="img-responsive" src="<?=asset("/images/v1/slider/ads3.png")?>" alt= ""/>
                    </a>
                    <br>
                    <a href="#">
                        <img class="img-responsive" src="<?=asset("/images/v1/slider/ads2.jpg")?>" alt= ""/>
                    </a>
                    </div>
            </div>
        </div>
    </div>
<!---=========================slider end=======================-->
<!---=================Vendor logo======================-->
 <div class="logo_container">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="pos_logo">
                    <marquee>
                        <a href="#">
                            <img class="img-responsive pos-logo-slide" src="<?=asset("/images/v1/vendor_logo/amazon_logo.png")?>" alt="Logo" />
                        </a>
                        <a href="#">
                            <img class="img-responsive pos-logo-slide" src="<?=asset("/images/v1/vendor_logo/flipkart_logo1.png")?>" alt="Logo" />
                        </a>
                        <a href="http://posthemes.com/">
                            <img class="img-responsive pos-logo-slide" src="<?=asset("/images/v1/vendor_logo/jabong_logo.png")?>" alt="Logo" />
                        </a>
                        <a href="#">
                            <img class="img-responsive pos-logo-slide" src="<?=asset("/images/v1/vendor_logo/homeshop18_logo.png")?>" alt="Logo" />
                        </a>
                        <a href="#">
                            <img class="img-responsive pos-logo-slide" src="<?=asset("/images/v1/vendor_logo/ebayi_logo.png")?>" alt="Logo" />
                        </a>
                        <a href="#">
                            <img class="img-responsive pos-logo-slide" src="<?=asset("/images/v1/vendor_logo/fabfurnish_logo.png")?>" alt="Logo" />
                        </a>
                        <a href="#">
                            <img class="img-responsive pos-logo-slide" src="<?=asset("/images/v1/vendor_logo/fashionara_logo.png")?>" alt="Logo" />
                        </a>
                        <a href="#">
                            <img class="img-responsive pos-logo-slide" src="<?=asset("/images/v1/vendor_logo/firstcry_logo.png")?>" alt="Logo" />
                        </a>
                    </marquee>
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
						<h3>Latest Products</h3>
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
                                <?php $p_url = newUrl( 'product/'.create_slug($prod->name)."/".$prod->id ); ?>
								<div class="item_out">
									<div class="item">
										<div class="home_tab_img">
											<a class="product_img_link" href="<?=$p_url?>" title="#" itemprop="url">
												<img src="<?=getImage($prod->image_url, $prod->vendor ); ?>" alt="" class="img-responsive product-item-img" />
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
												<span class="price">&#8377;<?=number_format( $prod->saleprice )?></span>
											</div>
										</div>
									</div>
								</div>
                                <?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<a href="#">
					<img src="<?=asset("/images/v1/slider/slider_ads1.png")?>" alt="" class="img-responsive hot-deals-ads hidden-xs" />
				</a>
				<a href="#">
					<img src="<?=asset("/images/v1/slider/slider_ads2.png")?>" alt="" class="img-responsive hot-deals-ads hidden-xs" />
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
							<div class="hotdeals slider_product">
                                <!--------- Hot Deals Items ------ -->
								<?php foreach( $hotDeals as $prod ): ?>
								<?php $prod = $prod->_source; //dd($prod) ?>
                                <?php $p_url = $prod->offer_page; ?>
                                <div class="item_out">
                                    <div class="item">
                                        <div class="home_tab_img">
                                            <a class="product_img_link" href="<?=$p_url?>" itemprop="url" target="_blank" title="<?=$prod->description?>">
                                                <img src="<?=$prod->image_url?>" alt="" class="img-responsive product-item-img" />
                                            </a>
                                            <!--<a class="new-box" href="#"><span>New</span></a>-->
                                        </div>
                                        <div class="home_tab_info">
                                            <a class="product-name" href="<?=$p_url?>" title="<?=$prod->description?>" target="_blank">
                                                <?=$prod->title?>
                                            </a>
                                            <div class="comment_box">
                                                <div class="star_content clearfix">
                                                    <?=ucfirst( $prod->vendor_name )?>
                                                </div>
                                            </div>
                                            <div class="price-box">
                                                <meta itemprop="priceCurrency" content="1" />
                                                <span class="price"><i class='fa fa-thumbs-up'></i> <?= $prod->upvotes ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<a href="#">
					<img src="<?=asset("/images/v1/slider/slider_ads1.png")?>" alt="" class="img-responsive hot-deals-ads hidden-xs" />
				</a>
				<a href="#">
					<img src="<?=asset("/images/v1/slider/slider_ads2.png")?>" alt="" class="img-responsive hot-deals-ads hidden-xs" />
				</a>
			</div>        
<!--========================Banners=====================-->
			<div class="cate_image_bg col-md-6 col-sm-6 col-xs-12">
				<a href="http://www.snapdeal.com/products/mobiles-mobile-phones?q=Brand%3ASamsung|Occasion_s%3ANewly%20Launched|&sort=plrty&MID=42433|web|bronze|||MF|Mobiles||" target="_blank">
					<img src="<?=asset("/images/v1/banners/banner_1.jpg")?>" alt="category image" class="img-responsive" />
				</a>
			</div>
			<div class="cate_image_bg col-md-6 col-sm-6 col-xs-12">
				<a href="http://www.flipkart.com/bsd?otracker=announcement_strip&otracker=hp_announcement_strip" target="_blank">
					<img src="<?=asset("/images/v1/banners/banner_2.jpg")?>" alt="category image" class="img-responsive" />
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
									Electronics
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
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view			
												</a>
											</div>
											<div class="home_tab_info">
											<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 1----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view			
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 2----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view		
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 3----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view		
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 4----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view		
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">									Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 5----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view		
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 6----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view		
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 7----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view	
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 8----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view	
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
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
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 1----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view	
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 2----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 3----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 4----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 5----- -->
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
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 1----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 2----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 3----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 4----- -->
								</div>
							</div>
						</div>
						<div id="tab1_3" class="tab_content">
							<div class="row_edited">
								<div id="tab1_3_in" class="tabSlide">
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 4----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 4----- -->
									<div class="item_out">
										<div class="item">
											<div class="home_tab_img">
												<a class="product_img_link" href="#" title="#" itemprop="url">
													<img src="<?=asset("/images/v1/latest_products/lp_1.jpg")?>" alt="" class="img-responsive product-item-img" />
												</a>
												<a class="new-box" href="#">
													<span>New</span>
												</a>
												<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="#">
													<i class="icon-eye"></i>Quick view
												</a>
											</div>
											<div class="home_tab_info">
												<a class="product-name" href="#" title="Faded Short Sleeves T-shirt">Faded Short Sleeves T-shirt
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
													<span class="price">&#8377;16.51</span>
												</div>
											</div>
										</div>
									</div>
									<!-------------item 3----- -->
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
						<h3>New Products</h3>
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
							<div class="newSlide slider_product">
								<div class="item_out">
									<div class="item">
										<div class="home_tab_img pull-left">
											<a class="product_img_link" href="#" title="#" itemprop="url">
												<img src="<?=asset("/images/v1/latest_products/lp_3.jpg")?>" class="img-responsive product-item-img" />
											</a>
										</div>
										<div class="home_tab_info">
											<a class="product-name" href="#" title="#">
												Printed Chiffon Dress
											</a>
											<div class="comment_box">
												<div class="comments_note" >
													<div class="star_content clearfix">
														<div class="star"></div>
														<div class="star"></div>
														<div class="star"></div>
														<div class="star"></div>
														<div class="star"></div>
													</div>
												</div>
											</div>
											<div class="price-box">
												<span class="price">&#8377;16.40</span>
												<span class="old-price product-price">
														&#8377;20.50
												</span>
											</div>
										</div>
									</div>
								</div>
								<!----------item 1------------------- -->
								<div class="item_out">
									<div class="item">
										<div class="home_tab_img pull-left">
											<a class="product_img_link" href="#" title="#" itemprop="url">
												<img src="<?=asset("/images/v1/latest_products/lp_3.jpg")?>" class="img-responsive product-item-img" />
											</a>
										</div>
										<div class="home_tab_info">
											<a class="product-name" href="#" title="#">
												Printed Chiffon Dress
											</a>
											<div class="comment_box">
												<div class="comments_note" >
													<div class="star_content clearfix">
														<div class="star"></div>
														<div class="star"></div>
														<div class="star"></div>
														<div class="star"></div>
														<div class="star"></div>
													</div>
												</div>
											</div>
											<div class="price-box">
												<span class="price">&#8377;16.40</span>
												<span class="old-price product-price">
													&#8377;20.50
												</span>
											</div>
										</div>
									</div>
								</div>
								<!----------item 2------------------- -->
								<div class="item_out">
									<div class="item">
										<div class="home_tab_img pull-left">
											<a class="product_img_link" href="#" title="#" itemprop="url">
												<img src="<?=asset("/images/v1/latest_products/lp_3.jpg")?>" class="img-responsive product-item-img" />
											</a>
										</div>
										<div class="home_tab_info">
											<a class="product-name" href="#" title="#">
												Printed Chiffon Dress
											</a>
											<div class="comment_box">
												<div class="comments_note" >
													<div class="star_content clearfix">
														<div class="star"></div>
														<div class="star"></div>
														<div class="star"></div>
														<div class="star"></div>
														<div class="star"></div>
													</div>
												</div>
											</div>
											<div class="price-box">
												<span class="price">&#8377;16.40</span>
												<span class="old-price product-price">
													&#8377;20.50
												</span>
											</div>
										</div>
									</div>
								</div>
								<!----------item 3------------------- -->
								<div class="item">
									<div class="home_tab_img pull-left">
										<a class="product_img_link" href="#" title="#" itemprop="url">
											<img src="<?=asset("/images/v1/latest_products/lp_3.jpg")?>" class="img-responsive product-item-img" />
										</a>
									</div>
									<div class="home_tab_info">
										<a class="product-name" href="#" title="#">
											Printed Chiffon Dress
										</a>
										<div class="comment_box">
											<div class="comments_note" >
												<div class="star_content clearfix">
													<div class="star"></div>
													<div class="star"></div>
													<div class="star"></div>
													<div class="star"></div>
													<div class="star"></div>
												</div>
											</div>
										</div>
										<div class="price-box">
											<span class="price">&#8377;16.40</span>
											<span class="old-price product-price">
												&#8377;20.50
											</span>
										</div>
									</div>
								</div>
								<!----------item 4------------------- -->
								<div class="item">
									<div class="home_tab_img pull-left">
										<a class="product_img_link" href="#" title="#" itemprop="url">
											<img src="<?=asset("/images/v1/latest_products/lp_3.jpg")?>" class="img-responsive product-item-img" />
										</a>
									</div>
									<div class="home_tab_info">
										<a class="product-name" href="#" title="#">
											Printed Chiffon Dress
										</a>
										<div class="comment_box">
											<div class="comments_note" >
												<div class="star_content clearfix">
													<div class="star"></div>
													<div class="star"></div>
													<div class="star"></div>
													<div class="star"></div>
													<div class="star"></div>
												</div>
											</div>
										</div>
										<div class="price-box">
											<span class="price">&#8377;16.40</span>
											<span class="old-price product-price">
												&#8377;20.50
											</span>
										</div>
									</div>
								</div>
								<!----------item 5------------------- -->
							</div>
						</div>
					</div>
				</div>
			</div>        
<!--========================Banners=====================-->                 
			<div class="cate_image_bg col-md-6 col-sm-6 col-xs-12">
				<a href="http://www.lenskart.com/eyewear/support-women-empowerment" target="_blank">
					<img src="<?=asset("/images/v1/banners/banner_3.jpg")?>" alt="category image" class="img-responsive " />
				</a>
			</div>
			<div class="cate_image_bg col-md-6 col-sm-6 col-xs-12" >
				<a href="http://www.cromaretail.com/Mobile-Phones-c-10.aspx#!B=Motorola" target="_blank">
					<img src="<?=asset("/images/v1/banners/banner_4.jpg")?>" alt="category image" class="img-responsive" />
				</a>
			</div>
			<?php if( is_array( $r_prods ) ) :?>
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
							<div class="recently slider_product">
								<?php foreach( $r_prods as $product ): ?>
								<?php $prod = $product->_source; ?>
								<?php if( $prod->vendor == 0 ): ?>
									<?php $p_url = $p_url = newUrl( 'product/'.create_slug($prod->name)."/".$prod->id ); ?>
								<?php else: ?>
									<?php $p_url = $p_url = newUrl( 'product/detail/'.create_slug($prod->name)."/".$product->_id ); ?>
								<?php endif; ?>
								<!---------item 1------ -->
								<div class="item_out">
									<div class="item">
										<div class="home_tab_img">
											<a class="product_img_link" href="<?=$p_url?>" title="#" itemprop="url">
												<img src="<?=getImage($prod->image_url, $prod->vendor ); ?>" alt="" class="img-responsive product-item-img" />
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
												<span class="price">&#8377;<?=number_format( $prod->saleprice )?></span>
											</div>
										</div>
									</div>
								</div>
								<?php endforeach; ?>
								<!---------item 2------ -->
							</div>
						</div>
					</div>
				</div>
			</div> 
			<?php endif;?>     
        </div>
    </div>
</div>
</div>
@endsection