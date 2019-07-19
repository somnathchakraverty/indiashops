<?php //dd($facet) ?>
<div class="panel panel-default offer-type">
	<div class="coupon_list_left-bar">
		<div class="row">
			<div class="col-md-8 col-sm-8">
				<h3 class="panel-title">OFFER TYPE</h3>
			</div>
			<div class="col-md-4 col-sm-4">
				<a id="" style="display: none;">CLEAR</a>
			</div>
		</div>
	</div>
	<div class="panel-body ">
		<div class="checkbox">
		  <label><input type="radio" value="all" name="type" checked="checked" class="fltr__src">All</label>
		</div>
		<div class="checkbox">
		  <label><input type="radio" value="promotion" name="type" class="fltr__src">Promotion</label>
		</div>
		<div class="checkbox">
		  <label><input type="radio" value="coupon" name="type" class="fltr__src">Coupons</label>
		</div>
	</div>						
</div>
@if( isset( $facet['left']['cats'] ) )
<div class="panel panel-default offer-type">
	<div class="coupon_list_left-bar">
		<div class="row">
			<div class="col-md-8 col-sm-8">
				<h3 class="panel-title">CATEGORY</h3>
			</div>
			<div class="col-md-4 col-sm-4">
				<a id="category" class="fltr__reset" style="display: none;" href="#">CLEAR</a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<?php foreach( $facet['left']['cats'] as $cat ):?>
			<div class="checkbox">
			  <label><input type="checkbox" value="<?=strtolower($cat->key)?>" name="category" class="fltr__src"><?=ucwords( $cat->key)?></label>
			</div>
		<?php endforeach; ?>
	</div>
</div>
@endif

@if( isset( $facet['left']['vendors'] ) )
<div class="panel panel-default offer-type">
	<div class="coupon_list_left-bar">
		<div class="row">
			<div class="col-md-8 col-sm-8">
				<h3 class="panel-title">Vendor</h3>
			</div>
			<div class="col-md-4 col-sm-4">
				<a id="vendor_name" class="fltr__reset" style="display: none;" href="#">CLEAR</a>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<?php foreach( $facet['left']['vendors'] as $cat ):?>
			<div class="checkbox">
			  <label><input type="checkbox" value="<?=strtolower($cat->key)?>" name="vendor_name" class="fltr__src"><?=ucwords( $cat->key)?></label>
			</div>
		<?php endforeach; ?>
	</div>
</div>
@endif