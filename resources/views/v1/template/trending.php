<?php foreach( $trending->hits->hits as $t ): ?>
	<?php $trend = $t->_source; ?>
	<?php
		if( $trend->vendor != 0 )
	    	$proURL = newUrl('product/'.create_slug($trend->name)."/".$t->_id );
	    else
	    	$proURL = newUrl('product/'.create_slug($trend->name)."/".$trend->id );
	?>
	<div class="item_out">
		<div class="item">
			<div class="home_tab_img pull-left">
				<a class="product_img_link" href="<?=$proURL?>" title="<?=$trend->name?>" itemprop="url" target="_blank">
					<?php $file = basename(getImage($trend->image_url, $trend->vendor)); 
					 $newimg = newUrl("images/v1/")."/others/".$file; 
					 if( file_exists( base_path()."/images/v1/others/".$file ) )
					 {
							$img = $newimg;
					 }else{
					 	if( $trend->vendor != 0 ){
							$img = getImage($trend->image_url, $trend->vendor);
						 }else{
							$img = getImageNew($trend->image_url, 'XS' );
						}
					 }

					?>
					<img src="<?=$img?>" class="img-responsive product-item-img new-product-img-resize lazy" alt="Buy <?=$trend->name?> Online"/>
				</a>
			</div>
			<div class="home_tab_info">
				<a class="product-name" href="<?=$proURL?>" title="<?=$trend->name?>" target="_blank">
					<?=$trend->name?>
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
					<span class="price">Rs. <?=number_format($trend->saleprice)?></span>
					<?php if( !empty( $trend->price ) ):?>
						<span class="old-price product-price">
								Rs. <?=number_format($trend->price)?>
						</span>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>