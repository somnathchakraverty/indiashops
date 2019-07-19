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
				<a class="product_img_link" href="<?=$p_url?>" title="<?=$prod->name?>" itemprop="url">
					<?php if( $prod->vendor != 0 ){
							$img = getImage($prod->image_url, $prod->vendor);
						 }else{
							$img = getImageNew($prod->image_url, 'XS' );
						}

					?>
					<img src="<?=$img?>" alt="Buy <?=$prod->name?> Online" class="img-responsive product-item-img lazy" />
				</a>
				<!--<a class="new-box" href="#"><span>New</span></a>-->
				<a title="Quick view" class="quick-view hidden-xs hidden-sm" href="<?=$p_url?>?quickview=yes">
					<i class="icon-eye"></i>Quick view				
				</a>
			</div>
			<div class="home_tab_info">
				<a class="product-name" href="<?=$p_url?>" title="<?=$prod->name?>">
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
					<meta itemprop="priceCurrency" content="INR" />
					<span class="price">Rs. <?=number_format( $prod->saleprice )?></span>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>