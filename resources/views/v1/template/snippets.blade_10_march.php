<?php if( !empty($c_name) ) : 

$snippetscript = array(); 
$snippetscript['@context'] = "http://schema.org/"; 
$snippetscript['@type'] = "ItemList";
?>
	@if(!isset($title))	
		@if( strtolower($c_name) == "mobiles" || strtolower($c_name) == "tablets" )
			<?php $c_name = ucfirst( rtrim($c_name, "s") ) ?>
		@else
			<?php $c_name = ucfirst( $c_name ) ?> 
		@endif
		@if(isset($brand) && !empty($brand))
			@if( strtolower($brand) == "lg" || strtolower($brand) == "htc" || strtolower($brand) == "hp" )
				<?php $c_brand = strtoupper($brand) ?>
			@else
				<?php $c_brand = ucfirst( $brand ) ?> 
			@endif
		@endif
		<?php $snip_name = "";
			if(isset($brand) && !empty($brand)):
				$snip_name = $c_brand." ";
			endif;
			if(isset($parent) && ($parent == "men" || $parent == "women") ) 
			{
				$snip_name .= ucfirst($parent)." ";
			}
			if(isset($parent) && ($parent == "kids" && (isset($child) && ($child == "boy-clothing" || $child == "girl-clothing" || $child == "boys-footwear" || $child == "girls-footwear"))) ) 
			{
				$snip_name .= ucfirst( str_replace("-clothing", "",(str_replace("-footwear", "", $child))) )." ";
			}

			$snip_name .= $c_name;

			?>
	@endif
	<div class="box_container who_viewed top_mobiles_width topspace" style="border:2px solid #bbbbbc !important;margin-right: 14px;margin-top: 10px !important;">
		<h2 id="finder-heading" style="float:left;padding:10px; margin:0px;">		
		<?php if(isset($title)){
				echo $title;
			}else{
				echo $snip_name. " Price List in India (". date('Y').")";
			} ?>
			
		</h2>
		<div class="clearfix"></div>
		@if(isset($description))
			<p style="text-align:justify;padding:10px"><?php echo $description; ?></p>
		@endif
		<table class="table">
		    <thead>
			    <tr>
			        <th>Position</th>
			        <th><?php if(isset($title)){echo $title;}else{echo $snip_name." Price List";} ?> </th>
			        <th>Prices</th>
			        <th>Rating</th>
			    </tr>
		    </thead>
		    <tbody>
		    <?php if(!empty($product)):
		    		$snippetscript['itemListElement'] = array();
		    		$i=0;
		    		foreach($snippet as $single ): 
		   				$pro = $single->_source;
		   				$rand = $pro->id;
		   				if( $pro->vendor != 0 )
		   				{
					    	if( $book )
					    		$proURL = url('product/detail/'.create_slug($pro->name." book")."/".$single->_id );
					    	else
					    		$proURL = url('product/detail/'.create_slug($pro->name)."/".$single->_id );
					    }else{
					    	$proURL = url('product/'.create_slug($pro->name)."/".$pro->id );
					    }
						    echo "<tr>".
						        "<td>".($i+1)."</td>".
						        "<td>$pro->name</td>".
						        "<td class='red'>Rs.". number_format($pro->saleprice)."</td>";
						        if($rand % 2 == 0)
						        	echo "<td>4/5</td>";
						        elseif($rand % 3 == 0)
						        	echo "<td>4.5/5</td>";
						        else
						        	echo "<td>5/5</td>";
							echo "</tr>";

							$snippetscript['itemListElement'][$i]['@type'] = "Product";
							$snippetscript['itemListElement'][$i]['name'] = $pro->name;
							$snippetscript['itemListElement'][$i]['position'] = ($i+1);
							$snippetscript['itemListElement'][$i]['image'] = NULL;
							$snippetscript['itemListElement'][$i]['url'] = $proURL;
							$snippetscript['itemListElement'][$i]['offers']['@type'] = "Offer";
							$snippetscript['itemListElement'][$i]['offers']['priceCurrency'] = "INR";
							$snippetscript['itemListElement'][$i]['offers']['price'] = number_format($pro->saleprice);
							$snippetscript['itemListElement'][$i]['offers']['availability'] = "http://schema.org/InStock";
							$i++;
					endforeach;
				  endif;  
			?> 
			</tbody>
		</table>
	</div>
	<?php 
		$snippetscript['url'] = "http://schema.org/"; 
		$snippetscript['numberOfItems'] = $sn_numberOfItems; 
		$snippetscript['itemListOrder'] = "https://schema.org/ItemListOrderAscending";
		if(isset($title))
		{
			$snippetscript['name'] = $title;	
		}else{
			$snippetscript['name'] =  $snip_name. " Price List in India (". date('Y').")";	
		}
	?>
	<script type='application/ld+json'><?php echo json_encode($snippetscript); ?></script>
<?php endif; ?>