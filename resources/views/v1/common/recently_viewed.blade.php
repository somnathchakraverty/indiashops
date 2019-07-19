<?php //dd($r_prods) ?>
<?php if( isset( $r_prods ) && !empty( $r_prods ) ): ?>
	<div class="panel panel-default recent-view-marquee">
		<div class="recent-view-heading">
			<h4>You Recently Viewed </h4>
		</div>
		<div id="myCarousel" class="vertical-slider carousel vertical slide" data-ride="carousel">
		   <!-- Carousel items -->
		   <div class="carousel-inner">
				<?php $count = 0; ?>
				<?php foreach( $r_prods as $p ): ?>
					<?php if( isset( $p->_source ) ):?>
					<?php $prod = $p->_source; 
						$target_url = newUrl('product/'.create_slug($prod->name)."/".$p->_id);
						if( $prod->vendor == 0 )
						$target_url = newUrl('product/'.create_slug($prod->name)."/".$prod->id);
					?>
					<?php if( $count%2==0 ): ?>
					<div class="item <?=( $count == 0 ) ? "active" : ''?>">
					<?php endif; ?>
						<div class="product-detail-recently-view-bg">
							<div class="product-wrapper">
								<div class="row">
									<div class="col-md-4 col-sm-4">
										<a target="_blank" href="<?=$target_url?>">
											<img class="img-responsive compare-img lazy" alt="" src="<?=getImage($prod->image_url,$prod->vendor,'M')?>">
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
				<?php if( $count%2==0 ): ?>
						</div>
				<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

<?php endif; ?>

<style>
/*=================25-3-2016===============*/
a {  cursor:pointer;}
.carousel.vertical .carousel-inner .item {
  -webkit-transition: 0.6s ease-in-out top;
     -moz-transition: 0.6s ease-in-out top;
      -ms-transition: 0.6s ease-in-out top;
       -o-transition: 0.6s ease-in-out top;
          transition: 0.6s ease-in-out top;
}

.carousel.vertical .active {
  top: 0;
}

.carousel.vertical .next {
  top: 100%;
}

.carousel.vertical .prev {
  top: -100%;
}

.carousel.vertical .next.left,
.carousel.vertical .prev.right {
  top: 0;
}

.carousel.vertical .active.left {
  top: -100%;
}

.carousel.vertical .active.right {
  top: 100%;
}

.carousel.vertical .item {
    left: 0;
}

</style>