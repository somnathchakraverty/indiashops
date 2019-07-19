<?php
	$b = $book->_source;
	$b->category = str_replace("books", "", $b->category );
	
	if( $b->parent_category == "books" )
		$subCat = $b->category;
	else
		$subCat = $b->parent_category;
?>
<?php if( !empty($c_name) ) : ?>
	<div class="col-md-12 col-sm-12" style="padding-left: 0px;">
		<h1><?=ucfirst($c_name)?> Books Price List in India</h1>
		<div class="moredata">
		In this digital world, Books are the only friend to motivate you, keeps you rejuvenated, makes you laugh or feel sad, nurture ambitions, builds character, makes you learn too many things, take you beyond the imagination. Order, Buy, purchase, send, or deliver <?=ucwords( $b->category)?> Books through IndiaShopps at most comparative prices. The Company do have best collection written through various authors for book lovers which targets every aged generation.<br/><br/>

		IndiaShopps has been leading in e-Commerce sectors or online shopping of various  <?=ucwords( $b->category)?> Books with millions of titles showing the best prices of leading portals like Amazon, Flipkart, Snapdeal, ebay, Bookadda, PayTm, ShopClues and lots more.<br/><br/>

		With more than 20 categories, this category of Books leads to explore the new world of <?=ucwords( $subCat )?>. IndiaShopps provides you the unique platform with Prices & Fluctuations trend to buy book online in India and one can avail timely Discount offer through applying coupon code. Enjoy Ultimate Online Book shopping experience across India at cheapest prices.

		</div>
	</div>
	<div class="clearfix"></div>
<?php endif; ?>