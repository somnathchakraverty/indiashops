<?php if(!empty($product)):

    foreach($product as $single ): 
    $pro = $single->_source;

    $proURL = $pro->product_url;

    if(json_decode($pro->image_url) != NULL)
    {
       $img = json_decode($pro->image_url);
    }else{
       $img = $pro->image_url;
    }
    if(is_array($img))
       $img = $img[0];
    
    $img = getImageNew($img,'S');
    
    $discount = "10";
    ?>
	@if( true )
		<div class="col-sm-4 col-md-4 col-sm-6 product">
				<div class="thumbnail product-items" >
					<div class="row">
						<div class="col-sm-8 col-xs-8">
							<span class="label label-success product-disc">{{$discount}}% off</span>
						</div>
					</div>
					<a href="{{$proURL}}" target="_blank"><img src="{{$img}}" class="img-responsive"></a>
					<div class="caption">
						<div class="product-title">
							<a href="{{$proURL}}" target="_blank">{{$pro->name}}</a>
						</div>
						<div class="row">
							@if( !empty( $pro->price ) )
							<div class="col-md-6  btn-product">
								<del>Rs. {{number_format($pro->price)}}</del>
							</div>
							@endif
							<div class="col-md-6  btn-product">
								<a href="{{$proURL}}" target="_blank">Rs. {{number_format($pro->saleprice)}}</a>
							</div>
							<div class="col-md-12 deals_time_end">
								<span><b>Ends in &nbsp;</b></span>
								<span data-countdown="{{$pro->end_datetime}}"></span>
							</div>
						</div>
					</div>
				</div>
		</div>
		@endif
    <?php endforeach; ?>
 <?php endif; ?>