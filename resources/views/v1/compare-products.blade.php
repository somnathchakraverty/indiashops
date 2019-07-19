@extends('v1.layouts.master')
@section('content') 
<?php if(!isset($products)) {echo "No product available";exit;} ?>
	<div class="wrapper">
		<div class="product-listing-bg">
			<!-- -----------top----------------- -->	
			<div class="container list-main" data-category="">
				<div class="row">
					<div class="col-md-12 col-sm-12" id="compare-div">
						{!! Breadcrumbs::render() !!}
						<h1 style="font-size: 17px; color:#d70d00;"><?php echo $products[0]['details']->name." <span style='font-size: 26px;color: #000;'>v/s</span> ".$products[1]['details']->name; ?></h4>
						<!-- <h4 class="listing-heading">Compare Products</h4> -->
						<hr>
						<?php if( isset( $keys ) && isset( $products ) ): ?>
							<?php $tot_prods = count( $products ); ?>
							<div id="sticky-compare" style="position: fixed; display: none">
								<table class="table table-bordered table-responsive">
									<tr>
									   <th width="12%">
									   		<!-- Jump To Button -->
											<div class="btn-group">
												<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
												Jump <span class="hidden-xxs">to</span> <span class="caret"></span>
												</button>
												<ul class="dropdown-menu">
													<?php foreach( $keys as $cat_key => $key ): ?>
														<?php $href = str_replace(" ", "-", strtolower( $cat_key ) ); ?>
														<li><a href="#<?=$href?>" class="compare"><?=$cat_key?></a></li>
													<?php endforeach; ?>
												</ul>
											</div>
											<!-- Jump To Button -->
									   </th>
									   <?php //dd($products)?>
									   <?php $percent = (88/$tot_prods); ?>
									   <?php foreach( $products as $product ): ?>
									   <?php 
								   		if( $product['details']->vendor == 0 )
											$plink = newUrl('product/'.create_slug($product['details']->name)."/".$product['details']->id);
										else
											$plink = newUrl('product/detail/'.create_slug($product['details']->name)."/".$product['details']->id);
								   		?>
									   		<th width="<?=$percent?>%">
									   			<div class="row">
									   				<div class="col-md-4 col-sm-4">
									   					<a href="<?=$plink?>">
									   						<img src="<?=getImage($product['details']->image_url,0)?>" alt="" class="img-responsive compare-image" style="max-width: auto; max-height: 100px;"/>
									   					</a>
									   				</div>
									   				<div class="col-md-8 col-sm-8">
									   					<p class="product-title">
									   						<a href="<?=$plink?>"><?=$product['details']->name?></a>
									   					</p>
									   					<p class="compare-price-color">Rs. 
									   						<?=number_format( $product['details']->saleprice )?>
									   					</p>
									   					<p><span prod-id="<?=$product['details']->id?>" class="btn btn-danger remove-product btn-xs">Remove</span></p>
									   				</div>
									   			</div>
									   		</th>
									   <?php endforeach; ?>
									</tr>
								</table>
							</div>
							<table class="table table-bordered table-responsive" id="specification">
							<tr>
							   <th width="12%">
							   		<!-- Jump To Button -->
									<div class="btn-group">
										<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Jump <span class="hidden-xxs">to</span> <span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
											<?php foreach( $keys as $cat_key => $key ): ?>
												<?php $href = str_replace(" ", "-", strtolower( $cat_key ) ); ?>
												<li><a href="#<?=$href?>" class="ssmooth compare"><?=$cat_key?></a></li>
											<?php endforeach; ?>
										</ul>
									</div>
									<!-- Jump To Button -->
							   </th>
							   <?php //dd($products)?>
							   <?php $tot_prods = count( $products ); ?>
							   <?php foreach( $products as $product ): ?>
							   <?php 
							   		if( $product['details']->vendor == 0 )
										$plink = newUrl('product/'.create_slug($product['details']->name)."/".$product['details']->id);
									else
										$plink = newUrl('product/detail/'.create_slug($product['details']->name)."/".$product['details']->id);
							   ?>
							   		<th width="<?=$percent?>%">
							   			<div class="row">
							   				<div class="col-md-4 col-sm-4">
							   					<a href="<?=$plink?>">
							   						<img src="<?=getImage($product['details']->image_url,0)?>" alt="" class="img-responsive compare-image" style="max-width: auto; max-height: 100px;"/>
							   					</a>
							   				</div>
							   				<div class="col-md-8 col-sm-8">
							   					<p class="product-title">
							   						<a href="<?=$plink?>"><?=$product['details']->name?></a>
							   					</p>
							   					<p class="compare-price-color">Rs. <?=number_format( $product['details']->saleprice )?></p>
							   					<p><span prod-id="<?=$product['details']->id?>" class="btn btn-danger remove-product btn-xs">Remove</span></p>
							   				</div>
							   			</div>
							   		</th>
							   <?php endforeach; ?>
							</tr>
							<?php
								// dd($products);
								$i=0;

								foreach( $keys as $cat_key => $key )
								{
									if( $i++ == 0 )
									{
										$id = "id='sticky-here'";
									}
									else
									{
										$id = "";
									}

									echo "<tr class='compare-detail-heading' ".$id."><td colspan='".($tot_prods+1)."'>".$cat_key."</td></tr>";
									foreach( $key as $fea_key => $value )
									{
										$href = str_replace(" ", "-", strtolower( $cat_key ) );

										echo "<tr id='".$href."'>";
										echo "<td class='compare-detail-heading1'><strong>".$fea_key."</strong></td>";

											for( $i = 0; $i < $tot_prods; $i++ )
											{
												echo "<td>";
												if( array_key_exists( $cat_key, @$products[$i]['features']) )
												{
													if( array_key_exists( $fea_key, @$products[$i]['features'][$cat_key] ) )
													{
														echo $products[$i]['features'][$cat_key][$fea_key];
													}
													else
													{
														echo "-";
													}
												}
												else
												{
													echo "-";
												}
												echo "</td>";
											}
										echo "</tr>";
									}
								}
							?>
							</table>
						<?php else: ?>
							<div class="alert alert-danger">
								<?=$error?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>		
		</div>
	</div>
@endsection
@section('script')
<script type="text/javascript" src="{{url()}}/js/compare.js"></script>
<style type="text/css">
	#sticky-compare.sticky
	{
	    top: 75px;
	    z-index: 99;
	    -webkit-transition: all 0.3s linear;
	    -moz-transition: all 0.3s linear;
	    transition: all 0.3s linear;
	}

	.product-title{ min-height: 45px;  }
	#sticky-compare {
	    -webkit-transition: all 0.3s linear;
	    -moz-transition: all 0.3s linear;
	    transition: all 0.3s linear;
	    top:-150px;
	    background: #eee;
	    position: fixed;
	}
	#sticky-compare .table{ margin-bottom: 0px !important;  }
	#sticky-compare img{ max-width: 50px !important; max-height: 50px !important; }
	#sticky-compare p { margin: 0px !important;  }
	.highlight {
	    border-bottom: 3px double red;
	    color: #D30900;
	    cursor: pointer;
	    font-weight: bold;
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$.ajax({
            url: '<?=newUrl('json/mobile_specs.json')?>',
            type: "GET",
            dataType: "json",
            success: function (specifications) {
                
                var oldHtml = $('#specification').html();
                var newHtml = oldHtml;

                $.each( specifications, function( word, definition ){
                       
					newHtml = newHtml.replaceAll( word,"<span class='highlight' data-toggle='tooltip' title='"+definition+"'>"+word+"</span>");
                });
                	
                $('#specification').html( newHtml );
                $('[data-toggle="tooltip"]').tooltip()
            }
        });
	});

	String.prototype.replaceAll = function(search, replacement) {
	    var target = this;
	    return target.replace(new RegExp(search, 'ig'), replacement);
	};
</script>
@endsection