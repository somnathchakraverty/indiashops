<?php if( !empty($c_name) ) : ?>
	<div class="col-md-12 col-sm-12" style="padding-left: 0px;">
	@if( strtolower($c_name) == "mobiles" || strtolower($c_name) == "tablets" )
		<?php $c_name = ucfirst( rtrim($c_name, "s") ) ?>
	@else
		<?php $c_name = ucfirst( $c_name ) ?> 
	@endif
	@if(isset($brand) && !empty($brand))
		@if( strtolower($brand) == "lg" || strtolower($brand) == "htc" || strtolower($brand) == "hp" )
			<?php $c_brand = strtoupper($brand) ?>
		@else
			<?php $c_brand = ucfirst( $brand ) ?> 
		@endif
	@endif
	@if(isset($title))
		<h1><?php echo $title; ?></h1>
	@else
		<h1>@if(isset($brand) && !empty($brand))<?php echo $c_brand." "; ?>@endif<?=$c_name?> Price List in India</h1>
	@endif
	<div class="moredata">
		Customer search for the best <?=$c_name?> at most competitive prices in India which must fulfill their motive of using the <?=rtrim($c_name, "s")?> phone. Due to emerge of too many online stores in India, it becomes hard to compare the quality, features and price But this online portal provides a unique platform to compare the price and quality at the same time which further helps to choose better and durable <?=rtrim($c_name, "s")?> phones.

		When it comes to well known brand, quality itself speaks louder than prices. IndiaShopps not only lead to providing best option but also take you to the particular online store from where you can buy through convenient mode of payment or can avail offers if available.
	</div>
	</div>
	<div class="clearfix"></div>
<?php endif; ?>