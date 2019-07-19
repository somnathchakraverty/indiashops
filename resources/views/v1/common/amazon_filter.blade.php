<!-- $aggr is the variable for the filter data..  -->
<?php //echo "<PRE>"; print_r( $aggr ); exit;?>
<?php $categories = @$aggr->categories; unset($aggr->categories)?>
<?php $categories = (isset( $categories ) ) ? $categories : array(); ?>
<div id="wrapper">
	<div >
	<div id="wrapper1" >
				<div class="nano1" id="sidebar">
					<div id='product-left-fixed-menu' class="nano-content">
						<ul >
							@if(!empty($categories))
							<li class='active has-sub'><a href='#'>Category</a>
						       <div class="nano">
						       <div class="nano-content">
								<ul  style="width: 95%;">
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
								</div>
								</div>
							</li>
							@endif
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
											<input type="number" name="minPrice" id="minPrice" value="<?=@$minPrice?>" class="form-control fltr__src" field="saleprice_min" min="<?=@$minPrice?>" max="<?=@$maxPrice?>"/>
										</div>
										<div class="col-md-6">
											<label>TO:</label><br/>
											<input type="number" name="maxPrice" id="maxPrice" value="<?=@$maxPrice?>" class="form-control fltr__src" field="saleprice_max" min="<?=@$minPrice?>" max="<?=@$maxPrice?>"/>
											<br/>
										</div>
									</div>
								</ul>
							</li>
							<li class='active has-sub'><a href='#'>Search</a>
								<ul>
									<div id="custom-search-input">
										<div class="input-group col-md-12">
											<input type="text" class="form-control fltr__src" placeholder="Search Products" id="search" field="query" value="<?=Request::get('search_text')?>" />
												<span class="input-group-btn">
													<button class="btn btn-info btn-lg" type="button">
														<i class="glyphicon glyphicon-search"></i>
													</button>
												</span>
										</div>
									</div>
								</ul>
							</li>
							@foreach( $aggr as $key => $section )
							@if( $key != 'saleprice_min' && $key != 'saleprice_max' && $key != 'grp' )
							<li class='active has-sub'><a href='#'>{{ucwords(str_replace( "_"," ",$key))}}</a>
								<ul>								 
									<div id="custom-search-input">
										<div class="input-group col-md-12">
											<input type="text" class="form-control search_attr" placeholder="Search" id="search-{{strtolower($key)}}"/>
												<span class="input-group-btn">
													<button class="btn btn-info btn-lg" type="button">
														<i class="glyphicon glyphicon-search"></i>
													</button>
												</span>
										</div>
									</div>
									<div id='{{strtolower($key)}}-wrapper' class="nano">
										 <div class="nano-content">
											@foreach( $section->buckets as $b )
											<div class="checkbox {{strtolower($key)}}">
												<label class="fix-slide-checkbox">
												<input type="checkbox" value="<?=$b->key?>" id="chk<?=cleanID($b->key); ?>" class="fltr__src" field="{{strtolower($key)}}">
												@if( $key == 'vendor' )
													<span class="value"><?=ucwords(config('vendor.name.'.$b->key ))?> </span>
												@else
													<span class="value"><?=ucwords($b->key)?> </span>
												@endif
												<span class="count">[<?=$b->doc_count?>]</span>
												</label>
											</div>
											@endforeach
										</div>
									</div>
								</ul>
							</li>
							@endif
							@endforeach
						</ul>
					</div>
				</div>	
		</div> <!-- /col-md-4 -->
</div>			
</div>			
<style type="text/css">
	#product-left-fixed-menu{
		width: 95%;height:100%;overflow: hidden;
	}
	#product-left-fixed-menu > ul > li > ul { max-height: 215px; overflow:hidden; }
	.ui-slider-handle.ui-state-default{ position: absolute !important; background: #D70D00 !important;  }
	.col-md-11{ padding-right: 0px;  }
</style>
<script type="text/javascript">
	@if( !empty($brand) )
		window.location.hash = "brand={{$brand}}"
	@endif
</script>