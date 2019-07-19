<?php $dimage  = base_path()."/images/v1/hot_deals/new/"; ?>
<?php foreach( $hotDeals as $prod ): ?>
<?php $prod = $prod->_source; //dd($prod) ?>
<?php $p_url = newUrl("coupon/".create_slug($prod->title)."/".$prod->promo); ?>
<?php //$p_url = newUrl("coupon/couponlistdetail?promo=".$prod->promo); ?>
<div class="item_out">
    <div class="item">
        <div class="home_tab_img">
            <a class="product_img_link" href="<?=$p_url?>" itemprop="url" target="_blank" title="<?=$prod->description?>">
            	<?php
            		$url = $prod->image_url;
					preg_match("/store\/(.*?)\/logo/i", $url, $match);

                    if( isset($match[1]) )
					   $name = $match[1].".jpg";
                    else
                        $name = "test.jpg";

					if( file_exists( $dimage.$name ) )
						$cimg = newUrl('/images/v1/hot_deals/new')."/".$name;
					  else
						$cimg = $url;
            	?>	
                <img src="<?=$cimg?>" alt="<?=$prod->title?> Image" class="img-responsive product-item-img lazy" />
            </a>
            <!--<a class="new-box" href="#"><span>New</span></a>-->
        </div>
        <div class="home_tab_info">
            <a class="product-name" href="<?=$p_url?>" title="<?=$prod->description?>" target="_blank">
                <?=$prod->title?>
            </a>
            <div class="comment_box">
                <div class="star_content clearfix hot-deals-heading-text">
                    <?=ucfirst( truncate($prod->vendor_name,20) )?>
                </div>
            </div>
            <div class="price-box">
                <meta itemprop="priceCurrency" content="1" />
                <span class="price"><i class='fa fa-thumbs-up'></i> <?= $prod->upvotes ?></span>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>