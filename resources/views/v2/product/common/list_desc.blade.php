@if( !empty($c_name) )
	<div class="row whitecolorbglistpage">
 	@if(isset($parent) && $parent == 'mobile')
 		@if(empty($child))
	 		@if( strtolower($c_name) == "mobiles" || strtolower($c_name) == "tablets" )
				<?php $c_name = ucfirst( rtrim($c_name, "s") ) ?>
			@else
				<?php $c_name = ucfirst( $c_name ) ?> 
			@endif
		@else
			@if( strtolower($c_name) == "mobiles" || strtolower($c_name) == "tablets" )
				<?php $c_name = ucfirst($parent)." ".ucfirst( rtrim($c_name, "s") ) ?>
			@else
				@if($child == "headphones-headsets")
					<?php $c_name = ucfirst( $c_name ) ?> 
				@elseif($child == "tablet-accessories")
					<?php $c_name = ucfirst(str_replace("-"," ",$child))." ".ucfirst( $c_name ) ?> 
				@else
					<?php $c_name = ucfirst($parent)." ".ucfirst( $c_name ) ?> 
				@endif
			@endif
		@endif
	@endif
		@if(isset($brand) && !empty($brand))
			@if( strtolower($brand) == "lg" || strtolower($brand) == "htc" || strtolower($brand) == "hp" )
				<?php $c_brand = strtoupper($brand) ?>
			@else
				<?php $c_brand = ucfirst( $brand ) ?> 
			@endif
		@endif

	@if(isset($h1))
		<h1>{{$h1}}</h1>
	@elseif(isset($title) && (strtolower($c_name) != "digital slr cameras") )
		<h1><?php echo $title; ?></h1>
	@else
		@if(isset($parent) && ($parent == "men" || $parent == "women"|| ($parent == "kids" && (isset($child) && ($child == "boy-clothing" || $child == "girl-clothing" || $child == "boys-footwear" || $child == "girls-footwear") )) ))
			@if($parent == "kids")
				<h1>@if(isset($brand) && !empty($brand))<?php echo $c_brand." "; ?>@endif<?=ucfirst( str_replace("-clothing", "",(str_replace("-footwear", "", $child))) )?> <?=$c_name?> Price List in India</h1>
			@else
				<h1>@if(isset($brand) && !empty($brand))<?php echo $c_brand." "; ?>@endif<?=ucfirst($parent)?> <?=$c_name?> Price List in India</h1>
			@endif
		@elseif(isset($parent) && ($parent == "home-decor"))
			@if(isset($child) & !empty($child))
				<h1>@if(isset($brand) && !empty($brand))<?php echo $c_brand." "; ?>@endif<?=$c_name?> - Online Price List in India</h1>
			@else
				<h1>@if(isset($brand) && !empty($brand))<?php echo $c_brand." "; ?>@endif<?=$c_name?> - Lowest Price List in India with Comparison</h1>
			@endif
		@elseif(isset($parent) && ($parent == "kids"))
			@if(isset($child) & !empty($child))
				<h1>@if(isset($brand) && !empty($brand))<?php echo $c_brand." "; ?>@endif<?=$c_name?> - Online Price List in India</h1>
			@else
				<h1>@if(isset($brand) && !empty($brand))<?php echo $c_brand." "; ?>@endif<?=$c_name?> Online Price List in India</h1>
			@endif
		@elseif(isset($parent) && ($parent == "automotive"))
			@if(isset($child) & !empty($child))
				<h1>{{ucwords($child)}} @if(isset($brand) && !empty($brand))<?php echo $c_brand." "; ?>@endif<?=$c_name?> - Online Price List in India with Comparison</h1>
			@else
				<h1>@if(isset($brand) && !empty($brand))<?php echo $c_brand." "; ?>@endif<?=$c_name?> - Online Price List in India with Comparison</h1>
			@endif
		@elseif(isset($parent) && ($parent == "beauty-health"))
			@if(isset($child) & !empty($child))
				<h1>{{ucwords(str_replace("-"," ",$child))}} @if(isset($brand) && !empty($brand))<?php echo $c_brand." "; ?>@endif<?=$c_name?> Online Price List in India</h1>
			@else
				<h1>@if(isset($brand) && !empty($brand))<?php echo $c_brand." "; ?>@endif<?=$c_name?> Essentials Online Price List in India</h1>
			@endif
		@elseif(isset($parent) && ($parent == "computers"))
			@if(strtolower($c_name) == "pen drives")
				<h1>Compare Online @if(isset($brand) && !empty($brand))<?php echo $c_brand." "; ?>@endif Pen Drives Price List in India</h1>
			@else
				<h1>@if(isset($brand) && !empty($brand))<?php echo $c_brand." "; ?>@endif<?=$c_name?> Online Price List in India</h1>
			@endif
		@elseif(isset($parent) && ($parent == "camera" || $parent == "care" || $parent == "sports-fitness" || $parent == "lifestyle"))
			<h1>@if(isset($brand) && !empty($brand))<?php echo $c_brand." "; ?>@endif<?=$c_name?> Online Price List in India with Comparison</h1>
		@else
			<h1>@if(isset($brand) && !empty($brand))<?php echo $c_brand." "; ?>@endif<?=$c_name?> Price List in India</h1>
		@endif
	@endif
	</div>
	<div class="clearfix"></div>
@else
	@if(isset($h1))
		<h1>{{$h1}}</h1>
	@elseif(isset($title) && (strtolower($c_name) != "digital slr cameras") )
		<h1><?php echo $title; ?></h1>
	@endif
@endif
<br/>
