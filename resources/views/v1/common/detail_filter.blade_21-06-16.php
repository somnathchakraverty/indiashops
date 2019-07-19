<!-- $aggr is the variable for the filter data..  -->
<?php //echo "<PRE>"; print_r( $aggr ); exit;?>
<?php extract($aggr); ?>
<div id="wrapper">
	<div id="sidebar-wrapper">
		<div id="wrapper1" >
			<div id="scroller1"  >
				<div id="sidebar">
					<div id='product-left-fixed-menu'>
						<ul>
							<li class='active has-sub'><a href='#'>Category</a>
								<ul>
									<?php foreach( $categories as $cat ): ?>
										<li class=' has-sub'>
											<a><?=ucwords($cat->key)?> ( <?=$cat->doc_count?> ) </a>
											<?php if( isset( $cat->category_id ) && is_object( $cat->category_id ) ): ?>
											<ul>
												<?php foreach( $cat->category_id->buckets as $c ): ?>
												<li>
													<a class="search-category" id="<?=$c->key?>">
														<?=ucwords($c->category->buckets[0]->key)?> ( <?=$c->doc_count?> )
													</a>
												</li>
												<?php endforeach; ?>
											</ul>
											<?php endif; ?>
										</li>
									<?php endforeach; ?>
								</ul>
							</li>
							<li class='active has-sub'><a href='#'>Price</a>
								<ul>
									<div>
										<div class="col-md-11">
											<br/>
											<div id="price-range"></div>
											<br/><br/>
										</div>
										<div class="col-md-6">
											<label>FROM:</label><br/>
											<input type="text" name="minPrice" id="minPrice" value="<?=$minPrice?>" class="form-control fltr__src" fltr--val="mins-<?=$minPrice?>" min="<?=$minPrice?>" max="<?=$maxPrice?>"/>
										</div>
										<div class="col-md-6">
											<label>TO:</label><br/>
											<input type="text" name="maxPrice" id="maxPrice" value="<?=$maxPrice?>" class="form-control fltr__src" fltr--val="maxs-<?=$minPrice?>" min="<?=$minPrice?>" max="<?=$maxPrice?>"/>
											<br/>
										</div>
									</div>
								</ul>
							</li>
							<li class='active has-sub'><a href='#'>Search</a>
								<ul>
									<div id="custom-search-input">
										<div class="input-group col-md-12">
											<input type="text" class="form-control fltr__src" placeholder="Search Products" id="search" fltr--val="qu-"/>
												<span class="input-group-btn">
													<button class="btn btn-info btn-lg" type="button">
														<i class="glyphicon glyphicon-search"></i>
													</button>
												</span>
										</div>
									</div>
								</ul>
							</li>
							<?php $brands = array_filter($lbrand );?>
							<?php if( !empty( $brands ) ): ?>
							<li class='active has-sub'><a href='#'>Brand</a>
								<ul>
									<div id="custom-search-input">
										<div class="input-group col-md-12">
											<input type="text" class="form-control" placeholder="Search" id="search-brand"/>
												<span class="input-group-btn">
													<button class="btn btn-info btn-lg" type="button">
														<i class="glyphicon glyphicon-search"></i>
													</button>
												</span>
										</div>
									</div>
									<div id='brand-wrapper'>
										<?php foreach( $lbrand as $brand ): ?>
										<?php //$brand->key = str_replace("-", "_", $brand->key ); ?>
										<div class="checkbox brand">
											<label class="fix-slide-checkbox">
											<input type="checkbox" value="" id="chk<?=clean($brand->key); ?>" class="fltr__src" fltr--val="br-<?=($brand->key)?>">
											<span class="value"><?=ucwords($brand->key)?> </span>
											<span class="count">[<?=$brand->doc_count?>]</span>
											</label>
										</div>
										<?php endforeach; ?>
									</div>
								</ul>
							</li>
							<?php endif; ?>
							<?php if( !empty( $sellers ) ): ?>
							<li class='active has-sub'><a href='#'>Sellers</a>
								<ul>
									<div id='seller-wrapper'>
										<?php foreach( $sellers as $seller ): ?>
											<?php if( !empty( $seller->key ) ): ?>
											<div class="checkbox seller">
												<label class="fix-slide-checkbox">
													<input type="checkbox" value="" id="chk<?=clean($seller->key); ?>" class="fltr__src" fltr--val="ve-<?=$seller->key?>">
													<span class="value"><?=ucwords(config('vendor.name.'.$seller->key ))?> </span>
													<span class="count">[<?=$seller->doc_count?>]</span>
												</label>
											</div>
											<?php endif; ?>
										<?php endforeach; ?>
									</div>
								</ul>
							</li>
							<?php endif; ?>
						</ul>
					</div>
				</div>	
			</div> <!-- / panel-group -->
		</div> <!-- /col-md-4 -->
	</div>  
</div>
<style type="text/css">
	#product-left-fixed-menu > ul > li > ul { max-height: 215px; overflow: auto;  }
	.ui-slider-handle.ui-state-default{ position: absolute !important; background: #D70D00 !important;  }
	.col-md-11{ padding-right: 0px;  }
</style>
<script type="text/javascript">
	var minPrice = <?=$minPrice?>;
	var maxPrice = <?=$maxPrice?>;
</script>