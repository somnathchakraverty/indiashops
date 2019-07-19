<?php if(!empty($product)):

    foreach($product as $single ): 
    $pro = $single->_source; 
    $img = getImageNew($pro->image_url,'S');

    // if( $pro->vendor != 0 )
    // 	if( $book )
    // 		$proURL = newUrl('product/'.create_slug($pro->name." book")."/".$single->_id );
    // 	else
    // 		$proURL = newUrl('product/'.create_slug($pro->name)."/".$single->_id );
    // else
    // 	$proURL = newUrl('product/'.create_slug($pro->name)."/".$pro->id );
    $proURL = product_url($single);
    // dd($scat);
    $pricelist = isPricelist($scat);
    ?>
		<?php ( isset($trending) ) ? $class="col-md-3" : $class="col-md-4" ?>
		<div class="<?=$class?> col-sm-6">
			<?php ( $pricelist ) ? $class = "product-item" : $class = "product-items" ?>
			<?php if( !empty($trending) ) $class = "product-item"; ?>
			<div class="thumbnail <?=$class?>" >
				<div class="product-img-fix">
					<div class="row">
						<div class="col-sm-8 col-xs-8">
	               <?php if( !empty( $pro->discount ) ): ?>
							   <span class="label label-success product-disc"><?=$pro->discount?>% OFF</span>
	               <?php endif; ?>
						</div>
						<div class=" col-sm-4 col-xs-4">
							<!-- <a href="<?=$proURL?>">
								<span class="wishlist-icon" prod-id="<?=$single->_id?>" title='Add to wishlist'>
									<i class="fa fa-heart-o"></i>
								</span>
							</a> -->
						</div>
					</div>
					<a title="<?=$pro->name?>" href="<?=$proURL?>"><img src="<?=$img?>" alt="<?=$pro->name?>" class="img-responsive lazy" onerror="imgError(this)"></a>
				</div>	
				<div class="caption">
					<div class="product-title">
						<a href="<?=$proURL?>" title="<?=$pro->name?>"><?=truncate($pro->name,35)?></a>
					</div>
					<hr class="separator">
					<div class="row">
						<?php if( !empty($pro->price) && $pro->saleprice != $pro->price ): ?>
						<div class="col-md-6 col-sm-6 btn-product ">
							<del>Rs. <?=number_format( $pro->price )?></del>
						</div>
						<?php endif; ?>
						<div class="col-md-6 col-sm-6 btn-product">
							@if($pro->saleprice>0)
							<a href="<?=$proURL?>" class="listing_category_heading">Rs. <?=number_format( $pro->saleprice )?></a>
							@else
								<a href="<?=$proURL?>" class="listing_category_heading">N/A</a>
							@endif
						</div>
					</div>
					<?php if( !empty($pro->stores) ): ?>
						<p>9 Stores at ₹45,999</p>
					<?php endif; ?>
					<?php if( !empty($pro->mini_spec) && ( $pricelist || $isSearch ) ): ?>
					<div class="show-more">
						<hr class="separator">
						<ul class="mini_description">
							<?=getMiniSpec($pro->mini_spec)?>
						</ul>
					</div>
					<div class="checkbox brand">
						<label class="fix-slide-checkbox" style="padding-left: 6px;">
						<input type="checkbox" prod-id="<?=$pro->id?>" class="add-to-compare" /> Add to Compare
						</label>
					</div>
					<?php endif; ?>
					<!--	<a class="btn btn-default ad-to-compare">
						<i class="fa fa-balance-scale"></i>
						Add To Compare</a>-->
				</div>
			</div>
		</div>
    <?php endforeach; ?>
 <?php endif; ?>