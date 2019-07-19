<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{$title}}</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="{{$meta_description}}">  
  <meta name="keywords" content="{{$keywords}}">  

  <link rel="shortcut icon" href="<?php echo asset("/valentine/v1/images/faviconindia.png")?>">
  <link href="<?php echo asset("/valentine/v1/css/bootstrap.min-new.css")?>" rel="stylesheet">
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<div class="bg_heart"></div>
<!--THE-HEADER-->
<header>
<div class="navbar navbar-default" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class=icon-bar></span> <span class=icon-bar></span> <span class=icon-bar></span> </button>
        <a class="navbar-brand" href="<?php echo asset("/"); ?>"><img src="<?php echo asset("/valentine/v1/images/indiashopps_logo-final2.png")?>"/></a> </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li><a class="page-scroll link1" href="http://www.indiashopps.com/home-decor/decor/flowers-vases-price-list-in-india.html" target="_blank">Flowers</a></li>
          <li><a class="page-scroll link1" href="http://www.indiashopps.com/women/fancy-jewellery-price-list-in-india.html" target="_blank">Jewellery</a></li>
          <li><a class="page-scroll link1" href="http://www.indiashopps.com/women/bags/handbags-price-list-in-india.html" target="_blank">Handbags</a></li>
          <li><a class="page-scroll link1" href="http://www.indiashopps.com/women/accessories/watches-price-list-in-india.html" target="_blank">Watches</a></li>
          <li><a class="page-scroll link1" href="http://www.indiashopps.com/women/ethnic-clothing-price-list-in-india.html" target="_blank">Ethnic Clothing</a></li>
          <li><a class="page-scroll link1" href="http://www.indiashopps.com/mobile/mobiles-price-list-in-india.html" target="_blank">Mobiles</a></li>
          <li><a class="page-scroll link1" href="http://www.indiashopps.com/women/shoes-price-list-in-india.html" target="_blank">Footwear</a></li>
          <li><a class="page-scroll link1" href="http://www.indiashopps.com/home-decor" target="_blank">Home Decor</a></li>
        </ul>
      </div>
    </div>
  </div>
</header>
<!--END-HEADER-->
<div class="clearboth"></div>
<section>
  <div id="wowslider-container1">
    <div class="ws_images">
      <div class="specialgift">
        <h1>{{$h1}}</h1>
      </div> 
	      <ul id="main_slider">
	      @for($i=1;$i<=$slider_size;$i++)
	        <li><img src="<?php echo asset("/valentine/v1/images/banner/$day/".$day."day$i.jpg"); ?>" alt="{{$day}}" title=""/></li>            
	      @endfor
	      </ul>
    </div>
    <div class="ws_shadow"></div>
  </div>
</section>
<div class="clearboth"></div>
<section>
<div class="productbgimnew">
  <div class="coloronly"></div>
  <div class="container">
    <div class="col-md-3">
      <div class="bgcolor">
        <div class="giftshedding">Mothers Are Special..</div>	<!-- Left links -->
        <div class="giftslist holder">
          <ul id="ticker01">
          @if(isset($tinker))
              @foreach($tinker as $key => $quote)
                  <li>
                      <div class="iconbox"><i class="fa fa-check" aria-hidden="true"></i></div>
                      {{$quote}}
                  </li>
              <?php unset($tinker[$key]) ?>
              @if( $key >= 5  )
                 <?php break; ?>
              @endif
              @endforeach
          @endif
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="productnamehedding">Mother's Day Gifts</div>
      <nav>
        <ul class="control-box pager control-boxnew">
          <li><a data-slide="prev" href="#myCarousel4" class=""><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
          <li><a data-slide="next" href="#myCarousel4" class=""><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
        </ul>
      </nav>
      <div class="carousel slide" id="myCarousel4">
        <div class="carousel-inner">
    <?php $i=0; $class="thumbnail";?>
    @foreach($popular as $key => $product)
      @if($i % 8 ==0)
          <div class="item<?php if($i==0) echo " active" ?>">
            <ul class="thumbnailshim">
	  @endif
	   @if($i % 2 ==0)
              <li class="col-sm-3">
                <div class="fff">
    	@endif
                  <div class="{{$class}}">
                    <!-- <div class="salebg">SALE</div> -->
                    <a target="_blank" href="{{$product->product_url}}"><div class="productim"><img class="imgprodunamenewall" src="{{getImageNew($product->image_url,'M')}}" alt="{{$product->name}}" title="{{$product->name}}"></div></a>
                    <a target="_blank" href="{{$product->product_url}}"><div class="productname">{{truncate($product->name,18)}}</div></a>
                    <div class="price">Rs. {{number_format($product->salesprice)}}</div>
                  </div>                 
          <?php $i++; 
          	if($class == "thumbnail")
          		$class="caption";
          	else
          		$class="thumbnail";
          	?>
      	@if($i % 2 ==0)
                </div>
              </li>
         @endif         
      @if($i % 8 ==0 || $i == count($popular))
            </ul>
          </div>
      @endif
    <?php unset($popular[$key]) ?>
    @if( $i >= 16 )
        <?php break; ?>
    @endif
    @endforeach
        </div>
        <!-- /.control-box -->
      </div>
      <!-- /#myCarousel -->
    </div>
  </div>
  </div>
</section>
<div class="clearboth"></div>

<section>
<div class="productbgimnew">
  <div class="bordertop"></div>
  <div class="container">
    <div class="col-md-9">
      <div class="productnamehedding">Best Gifts for Mothers</div>
      <nav>
        <ul class="control-box pager control-boxnew">
          <li><a data-slide="prev" href="#myCarousel5" class=""><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
          <li><a data-slide="next" href="#myCarousel5" class=""><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
        </ul>
      </nav>
      <div class="carousel slide" id="myCarousel5">
        <div class="carousel-inner">


    <?php $i=0; $class="thumbnail";?>
        @foreach($popular as $key => $product)
            @if($i % 8 ==0)
                <div class="item<?php if($i==0) echo " active" ?>">
                    <ul class="thumbnailshim">
                        @endif
                        @if($i % 2 ==0)
                            <li class="col-sm-3">
                                <div class="fff">
                                    @endif
                                    <div class="{{$class}}">
                                        <!-- <div class="salebg">SALE</div> -->
                                        <a target="_blank" href="{{$product->product_url}}"><div class="productim"><img class="imgprodunamenewall" src="{{getImageNew($product->image_url,'M')}}" alt="{{$product->name}}" title="{{$product->name}}"></div></a>
                                        <a target="_blank" href="{{$product->product_url}}"><div class="productname">{{truncate($product->name,18)}}</div></a>
                                        <div class="price">Rs. {{number_format($product->salesprice)}}</div>
                                    </div>
                                    <?php $i++;
                                    if($class == "thumbnail")
                                        $class="caption";
                                    else
                                        $class="thumbnail";
                                    ?>
                                    @if($i % 2 ==0)
                                </div>
                            </li>
                        @endif
                        @if($i % 8 ==0 || $i == count($popular))
                    </ul>
                </div>
            @endif
            <?php unset($popular[$key]) ?>
            @if( $i >= 16 )
                <?php break; ?>
            @endif
        @endforeach
   
        </div>
        <!-- /.control-box -->
      </div>
      <!-- /#myCarousel -->
    </div>
    <div class="col-md-3">
      <div class="bgcolor">
        <div class="giftshedding">What SHE means...?</div>
          <div class="giftslist holder">
              <ul id="ticker02">
              @if(isset($tinker))
                  @foreach($tinker as $quote)
                      <li>
                          <div class="iconbox"><i class="fa fa-check" aria-hidden="true"></i></div>
                          {{$quote}}
                      </li>
                  @endforeach
              @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>
<div class="clearboth"></div>

<!---------------------------HIM & HER SECTION END HERE------------------------------>
<section>
  <div class="qubg">
    <div class="container">
      <div class="row">
        <div class="span12">
          <div class="well">
            <div id="myCarousel" class="carousel slide">
              <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
              </ol>
              <div class="quotationtext">Quotation For Mother's Day</div>
              <!-- Carousel items -->
              <div class="carousel-inner">
              @if(isset($quotes))
	              <?php $i=0; ?>
	              @foreach($quotes as $quote)
	                <div class="item<?php if($i==0) echo " active"; ?>">
	                  <div class="row-fluid">
	                    <p class="normaltext">{{$quote}}</p>
	                  </div>                  
	                </div>
	                <?php $i++; ?>
	             @endforeach   
          	@endif
              </div>
              <!--/carousel-inner-->
              <!-- <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>-->
            </div>
            <!--/myCarousel-->
          </div>
          <!--/well-->
        </div>
      </div>
    </div>
  </div>
</section>
<div class="clearboth"></div>
@if(isset($gift))
<section>
<div class="productbgimnew">
  <div class="container">
    <div class="productnamehedding2">Mother's Day Special Gifts</div>
    <div id="thumbnail-slider">
      <div class="inner">
        <ul>
        @foreach($gift as $key => $product)
          <li>
            <!-- <div class="salebg">SALE</div> -->
            <a href="{{$product->product_url}}" target="_blank"><div class="productim"><img class="imgprodunamenewall" src="{{getImageNew($product->image_url,'S')}}" alt="{{$product->name}}" title="{{$product->name}}"></div></a>
            <a href="{{$product->product_url}}" target="_blank"><div class="productname">{{truncate($product->name,18)}}</div></a>
            <div class="price">Rs. {{number_format($product->salesprice)}}</div>
          </li>
        @endforeach  
        </ul>
      </div>
    </div>
  </div>
  </div>
</section>
@endif
<div class="clearboth"></div>
<section>
<div class="productbgimnew">
  <div class="bordertop"></div>
  <div class="container">
    <nav>
        <div class="productnamehedding2">Mother's Day Flowers</div>
        <ul class="control-box pager">
        <li><a data-slide="prev" href="#myCarousel1" class=""><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
        <li><a data-slide="next" href="#myCarousel1" class=""><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
      </ul>
    </nav>
    <div class="carousel slide" id="myCarousel1">
      <div class="carousel-inner">
            <?php $i=0; $class="thumbnail";?>
			    @foreach($flower as $key => $product)
			      @if($i % 10 ==0)
			          <div class="item<?php if($i==0) echo ' active'; ?>">
			            <ul class="thumbnails">
				  @endif
				   @if($i % 2 ==0)
			              <li class="col-sm-3">
			                <div class="fff">
			    	@endif
			                  <div class="{{$class}}">
			                    <!-- <div class="salebg">SALE</div> -->
			                    <a target="_blank" href="{{$product->product_url}}"><div class="productim"><img class="imgprodunamenewall" src="{{getImageNew($product->image_url,'S')}}" alt="{{$product->name}}" title="{{$product->name}}"></div></a>
			                    <a target="_blank" href="{{$product->product_url}}"><div class="productname">{{truncate($product->name,18)}}</div></a>
			                    <div class="price">Rs. {{number_format($product->salesprice)}}</div>
			                  </div>                 
			          <?php $i++; 
			          	if($class == "thumbnail")
			          		$class="caption";
			          	else
			          		$class="thumbnail";
			          	?>
			      	@if($i % 2 ==0)
			                </div>
			              </li>
			         @endif         
			      @if($i % 10 ==0 || $i == count($flower))
			            </ul>
			          </div>
			      @endif
			      
			    @endforeach


        <!-- /Slide3 -->
      </div>
      <!-- /.control-box -->
    </div>
    <!-- /#myCarousel -->
  </div>
  <!-- /.container -->
  </div>
</section>
<div class="clearboth"></div>
<section>
  <div class="taddybg">
    <div class="container">
      <div class="productnamehedding2" style="color:#FFFFFF;">Best watches for Mothers</div>
      <nav>
        <ul class="control-box pager">
          <li><a data-slide="prev" href="#myCarousel3" class=""><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
          <li><a data-slide="next" href="#myCarousel3" class=""><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
        </ul>
      </nav>
      <div class="carousel slide" id="myCarousel3">
        <div class="carousel-inner">


          <?php $i=0; $class="thumbnail";?>
			    @foreach($watch as $key => $product)
			      @if($i % 10 ==0)
			          <div class="item<?php if($key==0) echo ' active'; ?>">
			            <ul class="thumbnails">
				  @endif
				   @if($i % 2 ==0)
			              <li class="col-sm-3">
			                <div class="fff">
			    	@endif
			                  <div class="{{$class}}">
			                    <!-- <div class="salebg">SALE</div> -->
			                    <a target="_blank" href="{{$product->product_url}}"><div class="productim"><img class="imgprodunamenewall" src="{{getImageNew($product->image_url,'S')}}" alt="{{$product->name}}" title="{{$product->name}}"></div></a>
			                    <a target="_blank" href="{{$product->product_url}}"><div class="productname">{{truncate($product->name,18)}}</div></a>
			                    <div class="price">Rs. {{number_format($product->salesprice)}}</div>
			                  </div>                 
			          <?php $i++; 
			          	if($class == "thumbnail")
			          		$class="caption";
			          	else
			          		$class="thumbnail";
			          	?>
			      	@if($i % 2 ==0)
			                </div>
			              </li>
			         @endif         
			      @if($i % 10 ==0 || $i == count($watch))
			            </ul>
			          </div>
			      @endif
			      
			    @endforeach

          <!-- /Slide3 -->
        </div>
        <!-- /.control-box -->
      </div>
      <!-- /#myCarousel -->
    </div>
    <!-- /.container -->
  </div>
</section>
<div class="clearboth"></div>
<!--<section>
  <div class="productnamehedding2" style="margin-bottom:20px;">top video</div>
  <div class="fullscreen-bg">
  
    <video loop muted autoplay class="fullscreen-bg__video">
      <source src="<?php echo asset("valentine/v1/images/video/couple.mp4"); ?>" type="video/mp4" height="100%" width="100%">
    </video> 
  </div>
</section>-->

<div class="clearboth"></div>
<section>
<div class="productbgimnew">
  <div class="container">
    <div class="productnamehedding2">Amazing gifts for Moms</div>
    <div id="thumbnail-slider3">
      <div class="inner">
        <ul>
        @foreach($popular as $key => $product)
          <li>
            <!-- <div class="salebg">SALE</div> -->
            <a href="{{$product->product_url}}" target="_blank"><div class="productim"><img class="imgprodunamenewall" src="{{getImageNew($product->image_url,'S')}}" alt="{{$product->name}}" title="{{$product->name}}"></div></a>
            <a href="{{$product->product_url}}" target="_blank"><div class="productname">{{truncate($product->name,18)}}</div></a>
            <div class="price">Rs. {{number_format($product->salesprice)}}</div>
          </li>
        @endforeach
        </ul>
      </div>
    </div>
  </div>
  </div>
</section>
<div class="clearboth"></div>
<section>
  <div class="bordertop"></div>
  <div class="container">
    <div class="ads"><a target="_blank" href="<?php echo url("/women/bags/handbags-price-list-in-india.html"); ?>"><img class="img-responsive" src="<?php echo asset("valentine/v1/images/product/ads1_new.jpg")?>" alt="Flowers"></a></div>
    <div class="ads"><a target="_blank" href="<?php echo url("/women/fancy-jewellery-price-list-in-india.html"); ?>"><img class="img-responsive" src="<?php echo asset("valentine/v1/images/product/ads2_new.jpg")?>" alt="Cake"></a></div>
    <div class="ads"><a target="_blank" href="<?php echo url("/women/accessories-price-list-in-india.html"); ?>"><img class="img-responsive" src="<?php echo asset("valentine/v1/images/product/ads3_new.jpg")?>" alt="Dry Fruits"></a></div>
    <div class="saleads"><a href="http://www.amazon.in/b?node=6630507031&tag=indiashopps-21" target="_blank"><img class="img-responsive" src="<?php echo asset("valentine/v1/images/product/amazon-sale.jpg")?>" alt=""></a></div>

  </div>
</section>

<section>
  <div class="bordertop"></div>
  <div class="container">
  <?php
  if($day == "valentines"){ ?>
  <h3 style="text-align:center;">Valentine’s Day</h3>
 <?php }else{ ?> 
  <h3 style="text-align:center;">Mother's Day</h3>
   <?php } ?>
    @if(isset($text))
      <?php echo $text; ?>
    @endif

  </div>
</section>

<footer style="background:#cc0228;margin-top:20px;">
  <div class="container">
    <div class="row">
      <p class="footer-txt">COPYRIGHT &copy; 2017 Indiashopps.com - All Rights Reserved.</p>
    </div>
  </div>
</footer>
<link href="<?php echo asset("/valentine/v1/css/style-new.css")?>" rel="stylesheet">
<script src="<?php echo asset("/valentine/v1/js/banner/jquery.min.js")?>"></script>
<script src="<?php echo asset("/valentine/v1/js/jquery.js")?>"></script>
<script type="text/javascript" src="<?php echo asset("/valentine/v1/js/banner/wowslider.js"); ?>"></script>
<script type="text/javascript" src="<?php echo asset("/valentine/v1/js/banner/script.js"); ?>"></script>
<script src="<?php echo asset("/valentine/v1/js/thumbnail-slider.js")?>" type="text/javascript"></script>
<script src="<?php echo asset("/valentine/v1/js/bootstrap.min.js")?>"></script>
<script src="<?php echo asset("/valentine/v1/js/script.js")?>"></script>
<script src="{{url("assets/v2/js/news_ticker.js")}}"></script>
<link href="<?php echo asset("/valentine/v1/css/font-awesome.min.css")?>" rel="stylesheet">

<script>
$(document).ready(function() {
    $(function(){
        $("ul#ticker01").liScroll();
        $("ul#ticker02").liScroll();
    });
    $('.carousel').carousel({
        interval: 10000
	});
	var thumbnailSliderOptions2 =
{
    sliderId: "thumbnail-slider2",
    orientation: "horizontal",
    thumbWidth: "90px",
    thumbHeight: "45px",
    showMode: 1,
    autoAdvance: true,
    selectable: false,
    slideInterval: 3000,
    transitionSpeed: 1500,
    shuffle: false,
    startSlideIndex: 0, //0-based
    pauseOnHover: true,
    initSliderByCallingInitFunc: false,
    rightGap: 0,
    keyboardNav: true,
    mousewheelNav: false,
    before: null,
    license: "mylicense"
};

var mcThumbnailSlider2 = new ThumbnailSlider(thumbnailSliderOptions2);

var thumbnailSliderOptions3 =
{
    sliderId: "thumbnail-slider3",
    orientation: "horizontal",
    thumbWidth: "90px",
    thumbHeight: "45px",
    showMode: 1,
    autoAdvance: true,
    selectable: false,
    slideInterval: 3000,
    transitionSpeed: 1500,
    shuffle: false,
    startSlideIndex: 0, //0-based
    pauseOnHover: true,
    initSliderByCallingInitFunc: false,
    rightGap: 0,
    keyboardNav: true,
    mousewheelNav: false,
    before: null,
    license: "mylicense"
};

var mcThumbnailSlider3 = new ThumbnailSlider(thumbnailSliderOptions3);

});
</script>
</body>
</html>
<script>
 (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-69454797-1', 'auto');
  ga('send', 'pageview');
</script>
<style>
.holder {background-color:#ccc;height:590px;padding:10px;overflow:hidden;font-family:Helvetica;}
.holder .mask {position:relative;left:0px;top:10px;height:240px;/*overflow: hidden;*/}
.holder ul {list-style:none;margin:0;padding:10px;position:relative;}
.holder ul li {padding:10px 0px;text-align:justify;}
.holder ul li a {color:darkred;text-decoration:none;}
#main_slider{ display: none!important; }
.ws_shadow + div{height:auto!important;}
</style>