<?php //print_r($product);die; ?>
@extends('v1.layouts.master')
@section('description')
	@if( $product->grp == "men" || $product->grp == "women")
		<?php $desc = "Shop or Compare Online ". $product->name." latest price in India with Exciting offers, Coupons/deals & Lowest Price Guaranteed at Indiashopps."; ?>
	@elseif($product->grp == "books")
		<?php $desc = "Buy or Compare ". $product->name." Online Price on ".date("M j, Y")." including Reviews, ISBN & Publication in India with latest offers, deals at Indiashopps. ✓ Lowest Price Guaranteed."; ?>
	@elseif($product->grp == "home & decor" || $product->grp == "care")
		<?php $desc = "Buy or Compare Price ". $product->name." Shop from wide range of ".$product->category." Online in India at lowest price with latest offers deals at Indiashopps. ✓ Lowest Price Guaranteed."; ?>
	@elseif($product->grp == "beauty & health")
		<?php $desc = "Buy or Compare Price ". $product->name." from wide range of ".$product->parent_category." ".$product->category." Online in India at lowest price with latest offers deals at Indiashopps. ✓ Lowest Price Guaranteed"; ?>
	@elseif($product->grp == "sports & fitness")
		<?php $desc = "Buy or Compare Price ". $product->name." from wide range of ".$product->category." Online in India at lowest price with latest offers deals at Indiashopps. ✓ Lowest Price Guaranteed"; ?>
	@elseif($product->grp == "computers")
		<?php $desc = "Experience Smart Shopping only @Indiashopps. Buy ". $product->name." online with latest <em>Price Trends</em>, <em>Price Comparisons</em> & <em> Deal/Offers</em> directly from inside your favorite shopping website like Flipkart, Amazon, Snapdeal & many more."; ?>
	@elseif($product->grp == "electronics")
		<?php $desc = "Compare ". $product->name." Online Price including Reviews, Features, Specifications in India with latest offers, deals & coupon at Indiashopps."; ?>
	@elseif($product->grp == "kids")
		<?php $desc = "Shop or Compare Online ". $product->name." latest price in India with Exciting offers, Color option, Coupons/deals & Lowest Price Guaranteed only at Indiashopps.com."; ?>
	@elseif($product->grp == "camera")
		<?php $desc = "Shop or Compare ". $product->name." Price Online including Reviews, Features & full Specifications in India with latest deals, coupon & best offers only at Indiashopps."; ?>
	@elseif($product->grp == "lifestyle")
		<?php $desc = "Buy or Compare Price ". $product->name." from wide range of ".$product->category." Online in India at lowest price with latest offers deals at Indiashopps. ✓ Lowest Price Guaranteed"; ?>
	@elseif($product->grp == "automotive")
		<?php $desc = "Buy ". $product->name." at Lowest Price online with Price & Feature Comparisons, Deals/Offers, Full Specification, and Reviews only at Indiashopps"; ?>
	@else
		@if ( !empty( $product->description ) )
	       <?php $desc = $product->name." - ".$product->description ?>
	    @else
	        <?php $desc = $product->name ?>
	    @endif
	    <?php if( Request::input('real_prod') != "yes" ): ?>
	    	<?php $desc = trim(str_replace(";", " ", $desc )); ?>
	   	 
	    <?php endif; ?>
	    <?php if( $product->grp == "books" and !empty($product->isbn) ):?>
	    		 <meta name="productID" content="isbn:{{$product->isbn}}" />
	     <?php endif; ?>
	@endif
	<meta name="description" content="{{strip_tags( html_entity_decode($desc) )}}" />
@endsection
@section('title')
  @if(!isset($title) && empty($title))	
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
	@elseif($product->grp=="beauty & health" || $product->grp=="sports & fitness")
		<?php $title = "Buy ".$product->name." with Price & Feature Comparison Online| Indiashopps"; ?>
	@elseif($product->grp=="computers" || $product->grp=="camera")
		<?php $title = "Compare ". $product->name." - Price, Feature & Full Specification | Indiashopps"; ?>
	@elseif($product->grp=="kids")
		<?php $title = "Buy or Compare ". $product->name." Price Online in India |Indiashopps "; ?>
	@elseif($product->grp=="books")
		<?php $title = "Buy Online ".$product->name." - Price Comparison & Reviews in India | Indiashopps"; ?>
	@elseif($product->grp=="care")
		<?php $title = "Buy ".$product->name." with Price & Feature Comparison Online| Indiashopps"; ?>
	@elseif($product->grp=="lifestyle")
		<?php $title = "Buy ".$product->name." with Price & Feature Comparison Online| Indiashopps"; ?>
	@elseif($product->grp=="automotive")
		<?php $title = "Compare ".$product->name." - Price, Feature & Full Specification | Indiashopps"; ?>
	@else
		<?php $title = "";?>
		@if(isset($product->color) && !empty($product->color) && $product->color != "[]" && (strpos(strtolower($product->name), strtolower($product->color)) === false) )
			<?php $title = ucfirst($product->color)." "; ?>		
		@endif
	    @if ( strlen( $product->name ) >= 56 )
	       <?php $title .= $product->name; ?>
	    @else
	        <?php $title .= $product->name." | Price Compare India"; ?>
	    @endif
    @endif
   
  @endif
  <title>{{$title}}</title>

@endsection
<?php
	if( json_decode($product->image_url) != NULL )
    {
        $image = json_decode($product->image_url);
    }
    else
    {
        $image = $product->image_url;
    }

    if( !is_array( $image ) )
    {
        $img[0] = getImage( $product->image_url, $product->vendor );
    }
    else
    {
        $img = $image;
    }
//print_r($img);exit;
    if(Request::input('real_prod') != "yes" )
    {
	    if( !empty( $product->vendor ) )
	    {
	        $pid = $product->id."-".$product->vendor;
	    }
	    else
	    {
	        $pid = $product->id;
	    }
	}
?>
@section('meta')
	<meta itemprop="name" content="{{$title}}">
	<meta itemprop="image" content="{{$img[0]}}">
    <!-- Twitter Card data -->
	<meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="@IndiaShopps">
	<meta name="twitter:title" content="{{$title}}">
	<meta name="twitter:description" content="{{strip_tags( html_entity_decode( truncate($title,196) ) )}}">
	<meta name="twitter:creator" content="@IndiaShopps">
	<meta name="twitter:image" content="{{$img[0]}}">
	<meta name="twitter:image:src" content="{{$img[0]}}">
	<meta name="twitter:image:alt" content="{{$title}}">

	<!-- Open Graph data -->
	<meta property="og:title" content="{{$title}}" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="{{Request::url()}}" />
	<meta property="og:image" content="{{$img[0]}}" />
	<meta property="og:description" content="{{strip_tags( html_entity_decode( truncate($title,200) ) )}}" />
	<meta property="og:site_name" content="IndiaShopps | Buy | Compare Online" />
	<meta property="fb:admins" content="100000220063668" /> 
	<meta property="fb:app_id" content="1656762601211077" />
	<link rel="amphtml" href="{{amp_url()}}"/>
	<?php if(Request::input('real_prod') != "yes" ): ?>
		<?php if( $product->grp == "books" ):?>
			<link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--pdb--<?=$pid?>" />
		<?php else: ?>
			<link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--pd--<?=$pid?>" />
		<?php endif; ?>
	<?php endif; ?>
@endsection

<?php $prating = 3;if(isset($product->rating) && $product->rating > 0){$prating = $product->rating;} ?>
@section('json')
<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "Product",
  "name": "{{$product->name}}",
  @if(isset($img) && count($img>0))
  "image": "{{$img[0]}}",
  @endif
  @if(isset($product->description) && !empty($product->description))  
  "description": "Product Description: {{trim(strip_tags( html_entity_decode($desc)))}}",
  @endif
  @if(isset($product->color) && !empty($product->color))
  "color":"{{$product->color}}",
  @endif  
  "brand": {
    "@type": "Thing",
    "name": "{{ucwords($product->brand)}}"
  },  
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{{$prating}}"
  },
  "offers": {
    "@type": "Offer",
    @if($product->track_stock == 1)
    "availability": "http://schema.org/InStock",
    @else
    "availability":"https://schema.org/OutOfStock",
    @endif
    "price": "{{round($product->saleprice)}}",
    "priceCurrency": "INR"
  },
  "itemCondition":"https://schema.org/NewCondition"
  }
}
</script>

@endsection

@section('content')
<!--==============product Detail============= -->	
<div class="all-category-bg">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-xs-12 product-detail-tag-line">
				<ul class="list-unstyled product-detail-price-alert-hd">
					<?php if( Request::input('quickview') != "yes" and Request::input('real_prod') != "yes" ): ?>
						{!! Breadcrumbs::render("p_detail",$product) !!}
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12">
				<div class="alert alert-success" id="price-watch-mdiv" style="display: none;">
					<div id="price-watch-msg"></div>
				</div>
			</div>
		</div>
		<div class="row">
			<?php if( Request::input('quickview') != "yes" )
				{
					$class = "col-md-9";
				}
				else
				{
					$class = "col-md-12";
				}
			?>
			<div class="<?=$class?> col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div id="sync1" class="owl-carousel">
                        <?php
                        	// dd($product);
                        	if(Request::input('real_prod') != "yes" )
    						{
	                            if( !empty( $product->vendor ) )
	                            {
	                                $prod_id = $product->id."-".$product->vendor;
	                            }
	                            else
	                            {
	                                $prod_id = $product->id;
	                            }
	                         }
                            ?>
                            <!--  <?php                        	
                        	if(Request::input('real_prod') != "yes" )
    						{ ?>
                            <div class="hide" id="product_details">
                                <div class="product-box-heading">
                                
                                    <a class="url" href="<?=newUrl('/product/'.create_slug($product->name)."/".$product->id)?>"><?=$product->name; ?></a>
                                  
                                </div>
                                <div class="product-box-heading-price">Rs. <?=number_format($product->saleprice); ?></div>
                                <img src="<?=getImageNew($img[0],'L')?>" alt="<?php echo $product->name;?>" title="<?php echo $product->name;?>" class="product-box-img lazy"/>
                                <input id="productID" value="<?=$prod_id; ?>" type="hidden"/>
                            </div>
                             <?php } ?> -->
                            <?php
                            if(is_array($img))
                            {
                                foreach($img as $key=>$image)
                                {   
                                    if(!empty($image))
                                    { ?>
                                        <div class="item">
                                            <div class='list-group gallery'>
                                                <a class="thumbnail thumbnail-product fancybox" rel="ligthbox" href="<?=getImageNew($image,'L')?>">
                                                   <img src="<?=getImageNew($image,'M')?>" alt="<?php echo clean($product->name);?>" title="<?php echo clean($product->name);?>" class="img-responsive lazy" width="auto" onerror="imgError(this)">
                                                </a>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                }
                            }
                        ?>
						</div>
		
						<div id="sync2" class="owl-carousel">
                            <?php
                                if(is_array($img))
                                {
                                    foreach($img as $key=>$image)
                                    {   
                                        if(!empty($image))
                                        { ?>
                                            <div class="item">
                                                <div class='mini-list-group mini-gallery'>
                                                    <img src="<?=getImageNew($image,'S')?>" class="img-responsive product-details-small-slider lazy" onerror="imgError(this)">
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    }
                                }
                            ?>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="product-detail-content-bg">
							<h1><?=$product->name; ?></h1> <!-- by <?=$product->brand; ?> -->
							<ul class="list-inline list-unstyled product-detail-price-alert-hd">
					<!-- Set Price Alert popup  -->
					<li>
						<a href="#" class="product-detail-price-alert" data-toggle="modal" data-target="#myModal" id="price-watch">
							<i class="fa fa-bell"></i> Set Price Alert 
						</a>
						<a href="#" class="product-detail-price-alert" data-toggle="modal" id="price-watch-remove" style="display: none;">
							<i class="fa fa-remove"></i> Remove Alert 
						</a>
					</li>
					<!-- --------------Modal------------  -->
						  <div class="modal" id="myModal" role="dialog">
							<div class="modal-dialog">
							  <!-- Modal content -->
							  <div class="modal-content set-price-alert">
								<div class="modal-header set-price-alert-header">
									Set Price Alert
									<button type="button" class="close" data-dismiss="modal" style="color:#fff;" >&times;</button>
								</div>
								<div class="modal-body">
								        <div class="form-group">
											<label for="InputName" class="email-heading">Email Address:</label>
											<div class="input-group">
												<input type="text" class="form-control set-price-alert-input" name="email" id="email" placeholder="Email Address:" required>
												<span class="input-group-addon"><a href="#" class="set-price-alert-submit" id="pw-submit">Submit</a></span>
											</div>
										</div>
								</div>
								<!--<div class="modal-footer">
								  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div> -->
							  </div>
							</div>
						  </div>
							<li>|</li>
								@if(!empty($product->rating))
									<li>
										<div class="star_rating_out" title="Rating: (<?=$product->rating?>/5)">
											<div class="star_rating_in" style="width:<?=($product->rating/5)*100?>%" rate="<?=$product->rating?>"></div>
	    								</div>
									</li>
								@else
									<li>
										<div class="star"></div>
										<div class="star"></div>
										<div class="star"></div>
										<div class="star"></div>
										<div class="star"></div>
									</li>
								@endif
							</ul>
							<p>Lowest Price
							<?php if( $product->track_stock == 0 ): ?>
								<span class="label label-danger">Out Of Stock</span>
							<?php endif; ?>
							</p>
							<h4><a href="#" class="product-detail-price">Rs. <?=number_format($product->saleprice); ?></a></h4>
							<div class="btn-product">
                                <?php if( !empty( $product->price ) && !empty( $product->discount ) ): ?>
    								<del>Rs. <?=number_format($product->price)?></del>
    								<span class="label label-success product-disc"><?=$product->discount?>% off</span>
                                <?php endif; ?>
								<div class="row vendor-links">
									<div class="col-sm-4">
										<img src="<?=config('vendor.vend_logo.'.$product->vendor )?>" class="img-responsive lazy" alt="<?=config('vendor.name.'.$product->vendor )?>" onerror="imgError(this)"></a>
									</div>
									<div class="col-sm-8">
									<?php                         	
			                        	if(Request::input('real_prod') != "yes" )
			    						{ ?>
										<a class="btn btn-danger shopnow" onClick="ga('send', 'event', 'shop', 'click');" href="<?=newUrl('log?_id='.$product->id.'-'.$product->vendor.'&vendor_id='.$product->vendor.'&url='.urlencode($product->product_url))?>"out-url="<?=$product->product_url?>" target="_blank">Shop Now</a>
										<?php }else{ ?>
										<a class="btn btn-danger shopnow" href="<?=$product->product_url?>" out-url="<?=$product->product_url?>" target="_blank">Shop Now</a>
										<?php } ?>
                                        <a href="#similar" class="btn btn-danger ssmooth" >Similar Products</a>
									</div>
								</div>
							</div>
							<!--**********Product Size**********-->
							@if(!empty($product->size))
							<?php $sizes = @json_decode($product->size); ?>
							<?php if( is_array( $sizes ) ) { ?>
							<div class="row vendor-links">
								<div class="col-md-12 col-sm-12 col-xs-12">
									@foreach($sizes as $size)
										<span class="select_size_btn">{{$size}}</span>
									@endforeach
								</div>
							</div>							
							<?php } ?>
							@endif						
							
							<?php if( !empty( $product->description ) ):?>
								<div class="comment more-data " style="height: 245px; overflow: hidden; margin-top:20px;">
									<h4>Description</h4>
									<ul>
										<?=html_entity_decode( $product->description )?>
									</ul>
								</div>
								<span class="show-more show-toggle" style="display: none;"><a href="#" class="more">Show More >></a></span>
								<span class="show-less show-toggle" style="display: none;"><a href="#" class="more">Show Less <<</a></span>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
            <!-- *************Recently View*********** -->
            <?php if( Request::input('quickview') != "yes" and Request::input('real_prod') != "yes" ): ?>
				<div class="col-md-3 hidden-xs hidden-sm">
					<?php echo View::make('v1/common/recently_viewed', $views ); ?>
				</div>
			<?php endif; ?>
            <!-- *************Recently View*********** -->
		</div>
	</div>	
</div>
	
	<!--------------------------Table --------------------------- -->	
<div class="container">	

	<!--------------------------Table end...--------------------------- -->	

	<!--------------------------Who Viewed This Also Viewed...--------------------------- -->
	<div class="row" id="similar">
	<div class="col-xs-12 col-sm-12 " style="margin-top:10px;">
				<div class="pos_recently block_product">
					<div class="title_block">
						<h3>Who Viewed This Also Viewed...</h3>
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
								<!---------items------ -->
                                <?php foreach( $ViewAlso as $viewpro ): ?>
                                <?php 
                                    $viewpro2 = $viewpro->_source;

                                    if( $viewpro->_index == "books" )
                                    $target_url = newUrl('product/'.create_slug($viewpro2->name." book")."/".$viewpro->_id);
                               		else
                                    $target_url = newUrl('product/'.create_slug($viewpro2->name)."/".$viewpro->_id);

                                    if($viewpro2->vendor == 0)
                                        $target_url = newUrl('product/'.create_slug($viewpro2->name)."/".$viewpro->_id);

                                    // dd($viewpro2->vendor);
                                ?>
								<div class="item_out">
									<div class="item">
										<div class="home_tab_img">
											<a class="product_img_link" href="<?=$target_url?>" title="<?php echo clean($viewpro2->name); ?>">
												<img src="<?=getImage($viewpro2->image_url,$viewpro2->vendor,'M')?>" alt="<?php echo clean($viewpro2->name); ?>" class="img-responsive product-item-img lazy" onerror="imgError(this)"/>
											</a>
										</div>
										<div class="home_tab_info">
											<a class="product-name" href="#" title="<?php echo clean($viewpro2->name); ?>"><?=truncate($viewpro2->name,40)?>
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
												
												<span class="price">Rs. <?=number_format($viewpro2->saleprice)?></span>
											</div>
										</div>
									</div>
								</div>
                                <?php endforeach; ?>
								<!--*****items end******-->
							</div>
						</div>
					</div>
				</div>
			</div>    
	</div> 			
</div>
@endsection
@section('script')
<link rel="stylesheet" type="text/css" href="<?=asset("/js/source/jquery.fancybox.css")?>"/>
<script type="text/javascript" src="<?=asset("/js/jquery.mousewheel-3.0.6.pack.js")?>"></script>
<script src="<?php echo asset('js/indshp.js'); ?>"></script>
<!--<script src="<?php echo asset('js/compare.js'); ?>"></script>-->	
<script type="text/javascript">
    $("a.shopnow").click(function(){
        var href = $(this).attr('href');
        var url = $(this).attr('out-url');
        window.open(url);
        $.get(href);
        return false;
    });
	<?php                         	
	if(Request::input('real_prod') != "yes" )
	{ ?>
    var email 		= getCookie('price-watch-email');
	var pid 		= '<?=$product->id?>';
	var action 		= "add";
	var price_added = '<?=$product->saleprice?>';
	var url 		= 'http://www.indiashopps.com/ext/pwlist_web.php';
	var vendor 		= <?=$product->vendor?>;
	<?php } ?>
	if( email.length > 0 )
	{
		$("#email").val( email );

		var price_alert = getCookie( "price-watch-prod"+pid );

		if( price_alert.length > 0 )
		{
			$("#price-watch").hide();
			$("#price-watch-remove").show();
		}
	}

	$("#price-watch-remove").click(function(){
		setCookie( "price-watch-prod"+pid, pid, -1 );
		action = "remove";
		call_price_watch( url, action, email, pid, vendor, price_added );
		display_message( "Successfully removed.. !!", "success" );
		$("#price-watch-remove").fadeOut('slow', function(){ $("#price-watch").fadeIn('slow'); });
	});

	$("#pw-submit").click(function(){
		var email = $("#email").val();
		console.log(email);
		if( email.length == 0 )
		{
			$("#email").css("border","1px red dotted");
			display_message( "Please enter your Email ID !!", "danger" );
			hide_modal();
			return false;
		}
		else if( INDSHP.utils.validate.email( email, "" ) )
		{
			action = "add";
			$("#email").css("border","");
			setCookie( "price-watch-email", email, 1000 );
			setCookie( "price-watch-prod"+pid, pid, 1000 );
			call_price_watch( url, action, email, pid, vendor, price_added );
			$("#price-watch-div").slideUp();
			$("#price-watch").fadeOut('slow', function(){ 
				$("#price-watch-remove").fadeIn('slow');
				display_message( "Great !!! We will keep you posted !!", "success" );
			});
			display_message( "Great !!! We will keep you posted !!", "success" );
			
		}
		else
		{
			$("#email").css("border","1px red dotted");
			display_message( "Please enter valid Email ID !!", "danger" );
			hide_modal();
			return false;
		}

		hide_modal();
	});

	function hide_modal()
	{
		$('#myModal').modal('hide');
		$('.modal-backdrop').remove();
	}

	function call_price_watch( url, action, email, prod_id, vendor, price_added )
	{
		$.post( url, { action: action, email: email, vendor: vendor, product_id: prod_id, price_added: price_added } ) ;
	}

	function display_message( msg, cls )
	{
		$("#price-watch-mdiv").attr( "class", "alert alert-"+cls );
		$("#price-watch-msg").html( msg );
		$("#price-watch-mdiv").fadeIn('slow');
		setTimeout(function(){$("#price-watch-mdiv").slideUp('slow')},3000);
	}

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

    $(document).ready(function(){
    	if( $(".more-data")[0].scrollHeight > 245 )
    	{
    		$(".show-more.show-toggle").show();
    	}
    })
</script>
<style type="text/css">
	.modal-dialog{width: 400px;}
	.product-detail-content-bg h1 {
	    color: #d70d00;
	    font-size: 17px;
	}
	.star_rating_out
	{
		background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAPCAMAAADarb8dAAAAaVBMVEUAAADc3Nzb29va2trf39/b29vb29vb29va2trb29vl5eXc3NzU1NTl5eXd3d3b29vh4eHc3Nzd3d3d3d3Y2Njb29vb29vc3NzZ2dnY2Nji4uLZ2dnh4eHc3Nza2trb29va2trX19fd3d2CEtWOAAAAH3RSTlMA3Zsby/zy5eO7nG5YV0pIOCYgEsempYqIgH1pZw0MZXyrxwAAAHFJREFUCNdVjkcShDAQA+VAzrA5acz/H7lUDS5wn9R9EnaGASnGpD6LzEmoQ6jP7jIyc7rb5/1aFdwoqtvj1aELPLG2wGQkqpgJG4uPwS/xhPpxpdRQRh9XDWGE8ibzpskpHyie1gHO8qL+tb2O3v6AP9s3CvGPg24UAAAAAElFTkSuQmCC');
		height: 15px;
		width: 80px;
	}

	.star_rating_in
	{
		background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAPCAMAAADarb8dAAAAaVBMVEUAAADpzhfozxnrzxjpzxjp0hnqzhfqzhjozRjpzhjrzhfpzxju1xPs0hTvyxL0xQzl0RzkyxzqzhjqzhjqzhfqyxbpzhjpzhnozxnoyxnsyRXw4BDt1xPqzRno0BvqzhjozxnnyRvkzh38flBMAAAAH3RSTlMA3JtJG8ls/ebj3rucflg4KCEM8vHMpqWKiGdYVhMRLmM3mgAAAHFJREFUCNdVj0cOxDAMxMY1vW6vY+f/j0wAC3DMk8iDIEEwBiVKlb6QSxH6GPuz24qsbJrH4Xnvah7U3eM1fPGJzIRtBGaVvZ1x8HcUbj8k2uT5lCaFBsIUZMUkwQdevb8wvCU4agtYTZd81UY+1iuwA+WCCufeK5AiAAAAAElFTkSuQmCC');
		height: 15px;
	}
</style>
@endsection