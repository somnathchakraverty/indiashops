<?php $vendors = $vendor->hits->hits; ?>
<?php
  if( !empty( json_decode($product->image_url) ) )
    {
        $image = json_decode($product->image_url);
    }
    else
    {
        $image = $product->image_url;
    }

    if( !is_array( $image ) )
    {
        $img[0] = getImage( $product->image_url, $product->vendor );
    }
    else
    {
        $img = $image;
    }
    if( !empty( $product->vendor ) && !is_array( $product->vendor ) )
      {
          $pid = $product->id."-".$product->vendor;
      }
      else
      {
          $pid = $product->id;
      }
?>
<!doctype html>
<html amp lang="en">
<head>
<meta charset="utf-8">
 @if(isset($title) && !empty($title)) 
    <title>{{$title}}</title>
 @else
  @include("v1.meta.title",[ 'product' => $product ])
 @endif
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="shortcut icon" href="<?=newUrl()?>images/v1/favicon.png">
@if(isset($meta) && !empty($meta->keyword))
    <meta name="keywords" content="<?=$meta->keyword?>">
@endif
 @include("v1.meta.description",[ 'product' => $product ])
 @include("v1.meta.structure_data_new",[ 'product' => $product,'vendors' => $vendor->hits->hits ])
<meta name="theme-color" content="#d70d00">
<meta name="msapplication-navbutton-color" content="#d70d00">
<meta name="apple-mobile-web-app-status-bar-style" content="#d70d00">  
<meta name="ROBOTS" content="index,follow" />
<meta name="ROBOTS" content="ALL" />
<meta name="googlebot" content="index,follow,archive" />
<meta name="msnbot" content="index,follow,archive" />
<meta name="Slurp" content="index,follow,archive" />
<meta name="language" content="English" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="canonical" href="{{route('product_detail_v2',[create_slug($product->name),$product->id])}}" />
  <meta itemprop="image" content="{{$img[0]}}">
    <!-- Twitter Card data -->
  <meta name="twitter:card" content="summary">
  <meta name="twitter:site" content="@IndiaShopps">
  <meta name="twitter:creator" content="@IndiaShopps">
  <meta name="twitter:image" content="{{$img[0]}}">
  <meta name="twitter:image:src" content="{{$img[0]}}">
  <!-- Open Graph data -->
  <meta property="og:type" content="article" />
  <meta property="og:url" content="{{Request::url()}}" />
  <meta property="og:image" content="{{$img[0]}}" />
  <meta property="og:site_name" content="IndiaShopps | Buy | Compare Online" />
  <meta property="fb:admins" content="100000220063668" /> 
  <meta property="fb:app_id" content="1656762601211077" />
  <?php if(Request::input('real_prod') != "yes" ): ?>
    <?php if( $product->grp == "books" ):?>
      <link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--pdb--<?=$pid?>" />
    <?php else: ?>
      <link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--pd--<?=$pid?>" />
    <?php endif; ?>
  <?php endif; ?>
<script async src="https://cdn.ampproject.org/v0.js"></script>
<script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>
<script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
<script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
<script async custom-element="amp-accordion" src="https://cdn.ampproject.org/v0/amp-accordion-0.1.js"></script>
@if(isset($detail_meta->video_url))
    <script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
@endif
<style amp-custom>
body{font-family:'Roboto', sans-serif; font-size:14px; background-color:#FFFFFF;}
h1{ font-size:24px; line-height:34px; font-weight:500; text-align:center;}
h2{ font-size:22px; line-height:32px; font-weight:500; text-align:center;}
h3{ font-size:20px; line-height:30px; font-weight:500; text-align:center; text-transform:uppercase; padding-top:10px;}
h4{ font-size:16px; font-weight:500; text-align:center; text-transform:uppercase; padding:10px 0px 10px 0px;}
h5{ font-size:16px; color:#FFFFFF; line-height:26px; font-weight:500; text-align:center;}
h6{ font-size:14px; font-weight:500; text-transform:uppercase; text-align:left; color:#d40a00;margin:20px 0px 5px 23px;}
div, a, p, img, blockquote, form, fieldset, textarea, input, label, iframe, code, pre {display: block;position:relative;}
p{line-height:20px; text-align:center; margin:auto; width:90%;font-weight:400; color:#666666; font-size:14px; margin-bottom:30px; clear: both;}
a{text-decoration:none; color:#3498db;} 
.icon-list{list-style:none; font-size:14px; line-height:28px; color:#666666;}
.icon-list i{width:30px;}
header{position:fixed;height:120px;background-color:#fff;width:100%;z-index:99999;border-bottom: 1px solid #f3f2f1;}
.header-icon-1, .header-icon-2{position:absolute;color:#000;line-height:60px;text-align:center;width:50px;display:block;font-size:14px;background-color:transparent;border:none;outline:none;}
.header-icon-2{right:0px; top:0px;}
.header-logo{background: url(<?=newUrl()?>images/v1/indiashopps_logo-final.png);background-size:130px 45px;width:130px;height:45px;display:block;margin:12px auto 0px auto;}
.header-clear{height:60px;}
#sidebar{width:250px;background-color:#FFFFFF;}
.searchbar {background:#fff;display:block;width:60%; float:left;padding:10px 10px 12px;height:15px;font-size:14px;margin-bottom:30px;color:#222;border:1px solid #d40a00;outline:none;}
.searchbut{outline:none;border:none;background:#ED1B24;color:#FFFFFF; font-size:16px; padding:10px 10px 10px 10px;cursor:pointer;}
.searchbut:hover{outline:none;border:none;background:#000;color:#FFFFFF; font-size:16px; padding: 10px 10px 10px 10px;cursor:pointer;}
.searchbox{max-width:800px; margin:auto; text-align:center; padding:10px 20px 10px 20px;}
.navitopmob{display:block; margin-top:97px; padding:0px;}
.navitopmob ul{display:block; margin:0px; padding:0px;}
.navitopmob ul li{display:block; margin:0px; padding:0px; font-size:13px; color:#000; text-decoration:none; list-style:none; border-bottom:1px solid #e0e0e0;}
.navitopmob ul li a{display:block; margin:0px; padding:15px; font-size:13px; color:#000; text-decoration:none; list-style:none; text-transform:uppercase;}
.navitopmob ul li a:hover{display:block; margin:0px; padding:15px; font-size:13px; color:#fff; text-decoration:none; list-style:none; background:#cf0801; text-transform:uppercase;}
.breadcrumb {line-height: 24px;overflow: hidden;margin-top:75px; text-align:center;z-index: 1;display: block;text-transform: capitalize;font-size: 12px; clear:both;}
.breadcrumb li {display: inline-block;}
.breadcrumb a {display: inline-block;z-index: 2;color:#000;text-decoration: none;}
.aboutuspartbottmob {background: #f6f8f9;margin-top:50px;text-align: center;padding:40px 0px 40px 0px;}
.slidesbox{background:#fff; overflow:hidden; padding:35px 0px 0px 0px;}
.mobilename{font-size:14px; color:#000000; text-align:center; margin:20px 0px 0px 0px;}
.product-detail-price{ width:100%; margin:15px 0px 15px 0px; text-align:center;}
.product-detail-price ul{ margin:0; text-align:center;}
.product-detail-price ul li{ margin:0px; padding:5px 10px 5px 10px; text-align:center; display:inline-block; list-style:none; font-size:13px; color:#000000;}
.starcolor{ color:#ff9900; font-size:15px;}
.lowestprice{font-size:16px; color:#d40a00; text-align:center;}
.lowestprice span{font-size:16px; font-weight:bold; color:#d40a00; text-align:center; margin:10px 0px 10px 0px;}
.buy-nowbut{text-align:center; margin:10px 0px 10px 0px; outline:none;}
.shoppingsitelogo{border:1px solid #CCCCCC; width:100px; height:30px; text-align:center; margin:30px auto auto; overflow:hidden; padding:3px;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;}
.description-list{ width:100%; margin:0px; text-align:left;}
.description-list ul{ margin:0; text-align:left;}
.description-list ul li{ margin:0px; padding-top:5px;text-align:left; font-size:13px; color:#000000;}
.descriptionbox{max-width:200px; margin:auto auto 40px;}
.tablist{font-size:16px; color:#FFFFFF; background:#d40a00; margin-top:6px; text-align:center; padding:10px 0px 10px 0px; text-transform:uppercase;}
amp-live-list > [items] {display: flex;flex-direction: column;}
.amp-live-list-item {}
.card {display: flex;margin:15px;padding:10px;justify-content: center;align-items:center;}
.card > div {flex-basis: 50%;}
.side {display: flex;align-items: center;justify-content: space-around;}
.content {font-size: 1.5rem;}
#live-list-update-button {position: fixed;top: 10px;left: 50%;transform: translateX(-50%);}
.headdingtext{font-size:16px; color:#000000; font-weight:bold; text-align:center; background:#fbfbfb; width:100%; border:1px solid #ddd; padding:6px;}
.logosite{float:left; text-align:left;}
.shopnowbut{background:#f3515c; font-size:12px; color:#fff; padding:5px;}
.contentbott{font-size:14px; color:#000; padding: 0px 6px 0px 10px;}
.specificationslist{display:block; margin:0px; padding:0px;}
.specificationslist ul{display:block; margin:0px; padding:0px;}
.specificationslist ul li{display:block; margin:0px; padding:5px 10px 5px 10px; font-size:13px; font-weight:bold; color:#000; list-style:none; background:#f2f2f2; border:1px solid #e6e6e6;}
.specificationslist ul li span{margin:0px; padding:5px 10px 5px 20px; font-size:13px; color:#000; font-weight:normal;}
.headdingname{background:#fe9903; font-size:16px; color:#fff;padding:5px 10px 5px 10px;}
.footer{background:#3c3c3c; color:#fff; padding:20px; margin-top:30px; text-align:center;}
.viewedbox{margin:0 auto; text-align:center; border:1px solid #e4e4e4; width:200px; overflow:hidden; padding:5px; max-height:157px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;}
.mobilenamecat{margin:0px; padding:0px;}
.details{font-size:14px; color:#000000; text-align:center;}
.allcategories{margin-top:50px;}
.detailstextmobile{font-size:14px; text-align:center; color:#000000;}
.pricers{font-size:16px; font-weight:bold; margin-top:5px;color:#d40a00;}
.similar-products{text-align:center;  margin:-20px 0 0px 0; font-size:14px; font-weight:bold; color:#d40a00; text-transform:uppercase;}
.viewedtop{margin-top:1px; padding-top:17.5%;}
.naviicon{cursor:pointer;}
.product_img img{display:block;max-height:100%;min-width:inherit;width:auto;max-width:100%;height:auto;margin:auto;}

</style>
<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i">
</head>
<body>

<!--THE-HEADER-->
<header>
  <button class="header-icon-1 naviicon" on='tap:sidebar.toggle'><i class="fa fa-navicon"></i></button>
  <a href="/" class="header-logo"></a>
  <div class="searchbox">
    <form method="get" action="/search" target="_blank" novalidate="" class="-amp-form user-invalid">
      <input name="search_text" class="searchbar" value="<?=Request::get('search_text')?>" placeholder="Search Best Prices. Compare Before Your Buy ..." required="">
      <input type="hidden" name="cat_id" class="search_cat_id">
      <input type="submit" value="Search" class="searchbut">
    </form>
  </div>
</header>
<div class="header-clear"></div>
<!--END-HEADER-->
{!! Breadcrumbs::render("p_detail_new_amp",$product) !!}
<!--THE-MOBILE-SLIDE-->
<section id="services" class="overlay-services">
  <div class="aboutuspartbottmob">
    <div class="slidesbox">
      <amp-carousel width="300" height="280" type="slides"> 
       <?php
          if(is_array($img))
          {
              foreach($img as $key=>$image)
              {   
                  if(!empty($image))
                  { ?>
                    <a href="#">
                    <amp-img class="product_img" src="<?=getImageNew($image,'M')?>" title="<?php echo clean($product->name);?>" width="122" height="250" alt="<?php echo clean($product->name);?>"/>
                    </a> 
         <?php
                      }
                  }
              }
          ?>
      </amp-carousel>
    </div>
    <div></div>
  </div>
</section>
<!--END-SERVICES-->
<!--THE-CONTACT-->
<section id="contactus" class="overlay-contactus">
<div class="container">   
<?php //print_r($product);exit;?>
@if(($product->saleprice != 0) and ($product->track_stock==1) && (isset($product->availability) && $product->availability != 'Coming Soon'))
    <div class="shoppingsitelogo">
    <amp-img src="<?=config('vendor.vend_logo.'.$product->lp_vendor )?>" width="80" height="30" alt="<?=config('vendor.name.'.$product->lp_vendor)?>" />
    </div>
@elseif(isset($product->availability) && $product->availability == 'Coming Soon')
    <div class="similar-products">Coming Soon</div>
@endif
  <div class="mobilename"><?=$product->name; ?>
              @if($product->category_id== 351)
                <?php echo " Mobile Phone"; ?>
              @endif
              @if(!empty($product->size) && strpos(str_replace(" ","",$product->name), str_replace(" ","",$product->size)) === false)
                ({{$product->size}})
              @endif</div>
  <div class="product-detail-price">
    <ul>
     <!-- <li><a href="#"><i class="fa fa-bell"></i> Set Price Alert</a></li>
      <li><a href="#"><i class="fa fa-retweet"></i> Add to compare</a></li>-->
      <li><a href="#">
      <i class="fa fa-star-o starcolor" aria-hidden="true"></i> <i class="fa fa-star-o starcolor" aria-hidden="true"></i> <i class="fa fa-star-o starcolor" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i> <i class="fa fa-star-o" aria-hidden="true"></i>
      </a></li>
    </ul>
  </div>
  @if(($product->saleprice != 0) and ($product->track_stock==0))
    <div class="lowestprice">Price <span>Not Available</span></div>
  @else
      <div class="lowestprice">Lowest Price <span>Rs. <?=number_format($product->saleprice); ?></span></div>
  @endif
  @if(!empty($product->product_url))
    <a href="<?php echo $product->product_url; ?>" target="_blank" class="buy-nowbut">
      <amp-img src="<?=newUrl()?>images/v1/buy-now.png" width="120" height="40" alt="buy-now"/>
    </a>
  @endif
  @if(!empty($product->mini_spec))
    <div class="descriptionbox">
      <h6>Description</h6>
      <div class="description-list">
        <ul>
        <?php $mspec = explode(";",$product->mini_spec ); ?>
        @foreach($mspec as $mini)
          @if(!empty($mini))
          <?php $mini = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $mini); ?>
            <li>{{$mini}}</li>
          @endif
        @endforeach  
        </ul>
      </div>
    </div>
    @endif
</div>
</section>
<div class="container">
  <div>
    <amp-accordion>
      <!--END-MOBILE-SLIDE-->
      <!--THE-COMPARE-PRICE-->
      <section>
        <h4>Compare Price</h4>
        <div id="list-item-2" data-sort-time="1462814963693" class="amp-live-list-item">
          <div class="card">
            <div class="side side-left">
              <div class="logo headdingtext">Seller</div>
              <div class="content headdingtext">In Stock</div>
            </div>
            <div class="side side-right">
              <div class="content headdingtext">Price</div>
              <div class="logo headdingtext">Link</div>
            </div>
          </div>
          <?php foreach( $vendors as $vendor ): 
            $val = $vendor->_source;?>

              <div class="card">
                <div class="side side-left">
                  <div class="logosite">
                    <amp-img class="-amp-fill-content -amp-replaced-content" src="<?=config('vendor.vend_logo.'.$val->vendor )?>"  alt="<?=config('vendor.name.'.$val->vendor )?>" width="40" height="20"></amp-img>
                  </div>
                  <div class="contentbott"><?php echo ($val->track_stock==0?"Out Of Stock":"In Stock"); ?></div>
                </div>
                <div class="side side-right">
                  <div class="contentbott">Rs.&nbsp;<?=number_format($val->saleprice)?></div>
                  <div class="logo"> <a href="<?=$val->product_url?>" class="shopnowbut">Shop&nbsp;Now</a> </div>
                </div>
              </div>
        <?php endforeach; ?>
        </div>
      </section>
      <!--END-COMPARE-PRICE-->
      <!--THE-SPECIFICATIONS-->
      @if(isset($product->description) && !empty($product->description))
      <section>
        <h4>Specifications</h4>
        <div class="specificationslist">         
          <ul>
            <?php echo amp_desc($product->description); ?>
          </ul>
        </div>
      </section>
     @endif
    @if(isset($detail_meta->video_url))
        <section>
            <h4>{{ $product->name  }} Videos</h4>
            {!! ampYouTubePlayer($detail_meta->video_url) !!}
        </section>
    @endif
    </amp-accordion>
  </div>
</div>
<!--END-SPECIFICATIONS-->
<!--THE-ALL-CATEGORIES-->
<div class="allcategories">
<div class="similar-products">Similar Products</div>
  <amp-carousel width="400"  height="350" layout="responsive" type="slides">
  @foreach( $ViewAlso as $viewpro )
  <?php 
      $viewpro2 = $viewpro->_source;
      $target_url = newUrl('product/'.create_slug($viewpro2->name)."/".$viewpro->_id);
  ?>
    <div class="viewedbox">
      <div class="mobilenamecat">
      <a href="{{$target_url}}">
        <amp-img src="<?=getImageNew($viewpro2->image_url,'S')?>" width="102" height="108" alt="<?php echo clean($viewpro2->name); ?>"/>
      </a>
      </div>
      <a href="{{$target_url}}" title="<?php echo clean($viewpro2->name); ?>" class="detailstextmobile"><?=truncate($viewpro2->name,40)?></a>
      <div class="pricers">Rs.<?=number_format($viewpro2->saleprice)?></div>
    </div>
  @endforeach  
  </amp-carousel>
</div>
<!--END-ALL-CATEGORIES-->
<!--THE-FOOTER-->
<div class="footer">
  <div class="center-text">COPYRIGHT © 2017 Indiashopps.com - All Rights Reserved.</div>
</div>
<!--END-FOOTER-->
<!--THE-NAVi-->
<amp-sidebar id='sidebar'
      layout="nodisplay"
      side="left">
  <amp-img class='amp-close-image'
        src="/images/ic_close_black_18dp_2x.png"
        width="20"
        height="20"
        alt="close sidebar"
        on="tap:sidebar.close"
        role="button"
        tabindex="0"></amp-img>
  <div class="navitopmob">
    <div class="navitopmob">
      <ul>
        <li><a href="<?=newUrl()?>">Home</a></li>
        <li><a href="<?=newUrl(seoUrl('mobile/mobiles'))?>">Mobiles</a></li>
        <li><a href="<?=newUrl('computers')?>">Computers</a></li>
        <li><a href="<?=newUrl('hot-trending-products')?>">Trending</a></li>
        <li><a href="<?=newUrl('coupons')?>">Coupons</a></li>
      </ul>
    </div>
  </div>
</amp-sidebar>
<!--END-NAVi-->
</body>
</html>
