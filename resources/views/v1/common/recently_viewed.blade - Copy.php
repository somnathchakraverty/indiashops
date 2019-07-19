<?php //dd($r_prods) ?>
<?php if( isset( $r_prods ) && !empty( $r_prods ) ): ?>
	<div class="panel panel-default recent-view-marquee">
		<div class="recent-view-heading">
			<h4>You Recently Viewed </h4>
		</div>
		<marquee scrollamount="2" direction="up">
		<?php $count = 1; ?>
		<?php foreach( $r_prods as $p ): ?>
			<?php if( isset( $p->_source ) ):?>
			<?php $prod = $p->_source; 
				$target_url = newUrl('product/detail/'.create_slug($prod->name)."/".$p->_id);
				if( $prod->vendor == 0 )
				$target_url = newUrl('product/'.create_slug($prod->name)."/".$prod->id);
			?>
			<div class="product-detail-recently-view-bg">
				<div class="product-wrapper">
					<div class="row">
						<div class="col-md-4 col-sm-4">
							<a target="_blank" href="<?=$target_url?>">
								<img class="img-responsive compare-img" alt="" src="<?=getImage($prod->image_url,$prod->vendor,'M')?>">
							</a>
						</div>
						<div class="col-sm-8 col-sm-8">
							<a target="_blank" href="#">
								<h5 class="recent-view-title">
									<a href="<?=$target_url?>" target="_blank"><?=$prod->name?></a>
								</h5>
							</a>
							<p class="compare-price-color">Rs. <?=number_format($prod->saleprice)?></p>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>
		<?php if( $count == 12 ) break; else $count++; ?>
		<?php endforeach; ?>
		</marquee>
	</div>

<?php endif; ?>
