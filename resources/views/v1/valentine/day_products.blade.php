<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{$title}}</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="{{$meta_description}}">  
  <meta name="keywords" content="{{$keywords}}">  

  <link rel="shortcut icon" href="<?php echo asset("/assets/valentine/v1/images/faviconindia.png")?>">
  <link href="<?php echo asset("/assets/valentine/v1/css/font-awesome.min.css")?>" rel="stylesheet">
  <link href="<?php echo asset("/assets/valentine/v1/css/bootstrap.min-new.css")?>" rel="stylesheet">
  <link href="<?php echo asset("/assets/valentine/v1/css/style-new.css")?>" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo asset("/assets/valentine/v1/css/banner.css")?>">
  <script src="<?php echo asset("/assets/valentine/v1/js/banner/jquery.min.js")?>"></script>
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<div class="bg_heart"></div>
<!--THE-HEADER-->
<header>
<div class="navbar navbar-default" role="navigation">
    <div class=container>
      <div class=navbar-header>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class=icon-bar></span> <span class=icon-bar></span> <span class=icon-bar></span> </button>
        <a class="navbar-brand" href="<?php echo asset("/"); ?>"><img src="<?php echo asset("/assets/valentine/v1/images/indiashopps_logo-final2.png")?>"/></a> </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li><a class="page-scroll link1" href="<?php echo url("/rose-day-gifts-ideas-online"); ?>">Rose Day</a></li>
          <li><a class="page-scroll link1" href="<?php echo url("/propose-day-gifts-ideas-online"); ?>">Propose Day</a></li>
          <li><a class="page-scroll link1" href="<?php echo url("/chocolate-day-gifts-ideas-online"); ?>">Chocolate Day</a></li>
          <li><a class="page-scroll link1" href="<?php echo url("/teddy-day-gifts-ideas-online"); ?>">Teddy Day</a></li>
          <li><a class="page-scroll link1" href="<?php echo url("/promise-day-gifts-ideas-online"); ?>">Promise Day</a></li>
          <li><a class="page-scroll link1" href="<?php echo url("/hug-day-gifts-ideas-online"); ?>">Hug Day</a></li>
          <li><a class="page-scroll link1" href="<?php echo url("/kiss-day-gifts-ideas-online"); ?>">Kiss Day</a></li>
          <li><a class="page-scroll link1" href="<?php echo url("/assets/valentines-day-gifts-ideas-online"); ?>">VALENTINE’S DAY</a></li>
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
	      <ul>
	      @for($i=1;$i<=$slider_size;$i++)
	        <li><img src="<?php echo asset("/assets/valentine/v1/images/banner/$day/".$day."day$i.jpg"); ?>" alt="{{$day}}" title=""/></li>
	      @endfor
	      </ul>
    </div>
    <div class="ws_shadow"></div>
    <script type="text/javascript" src="<?php echo asset("/assets/valentine/v1/js/banner/wowslider.js"); ?>"></script> 
    <script type="text/javascript" src="<?php echo asset("/assets/valentine/v1/js/banner/script.js"); ?>"></script> 
  </div>
</section>
<div class="clearboth"></div>
<section>
<div class="productbgimnew">
  <div class="coloronly"></div>
  <div class="container">
    <div class="col-md-3">
      <div class="bgcolor">
        <div class="giftshedding">TOP GIFT IDEAS</div>	<!-- Left links -->
        <div class="giftslist">
          <ul>
          @if(isset($list_him))
            @foreach($list_him as $list)
            	<?php $keyword = explode("/",$list); ?>
            	<li><a href="<?php echo url($list); ?>"><div class="iconbox"><i class="fa fa-check" aria-hidden="true"></i></div>{{ucwords(reverse_slug($keyword[1]))}}</a></li>
        	@endforeach
          @endif  
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="productnamehedding">Top Products</div>
      <nav>
        <ul class="control-box pager control-boxnew">
          <li><a data-slide="prev" href="#myCarousel4" class=""><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
          <li><a data-slide="next" href="#myCarousel4" class=""><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
        </ul>
      </nav>
      <div class="carousel slide" id="myCarousel4">
        <div class="carousel-inner">
    <?php $i=0; $class="thumbnail";?>
    @foreach($products_for_him as $men)
    	<?php $men = $men->_source; //print_r($men);exit; ?>
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
                    <a target="_blank" href="{{$men->product_url}}"><div class="productim"><img class="imgprodunamenewall" src="{{getImageNew($men->image_url,'M')}}" alt="{{$men->name}}" title="{{$men->name}}"></div></a>
                    <a target="_blank" href="{{$men->product_url}}"><div class="productname">{{truncate($men->name,18)}}</div></a>
                    <div class="price">Rs. {{number_format($men->saleprice)}}</div>
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
      @if($i % 8 ==0 || $i == count($products_for_him))
            </ul>
          </div>
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
      <div class="productnamehedding">Top Products Her</div>
      <nav>
        <ul class="control-box pager control-boxnew">
          <li><a data-slide="prev" href="#myCarousel5" class=""><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
          <li><a data-slide="next" href="#myCarousel5" class=""><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
        </ul>
      </nav>
      <div class="carousel slide" id="myCarousel5">
        <div class="carousel-inner">
         

          <?php $i=0; $class="thumbnail";?>
    @foreach($products_for_her as $women)
    	<?php $women = $women->_source; //print_r($women);exit; ?>
      @if($i % 8 ==0)
          <div class="item<?php if($i==0) echo ' active'; ?>">
            <ul class="thumbnailshim">
	  @endif
	   @if($i % 2 ==0)
              <li class="col-sm-3">
                <div class="fff">
    	@endif
                  <div class="{{$class}}">
                    <!-- <div class="salebg">SALE</div> -->
                    <a target="_blank" href="{{$women->product_url}}"><div class="productim"><img class="imgprodunamenewall" src="{{getImageNew($women->image_url,'S')}}" alt="{{$women->name}} title="{{$women->name}}"></div></a>
                    <a target="_blank" href="{{$women->product_url}}"><div class="productname">{{truncate($women->name,18)}}</div></a>
                    <div class="price">Rs. {{number_format($women->saleprice)}}</div>
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
      @if($i % 8 ==0 || $i == count($products_for_her))
            </ul>
          </div>
      @endif
      
    @endforeach
   
        </div>
        <!-- /.control-box -->
      </div>
      <!-- /#myCarousel -->
    </div>
    <div class="col-md-3">
      <div class="bgcolor">
        <div class="giftshedding">TOP GIFTS FOR Her</div>
        <div class="giftslist">
          <ul>
            @if(isset($list_her))
            @foreach($list_her as $list)
            	<?php $keyword = explode("/",$list); ?>
            	<li><a href="<?php echo url($list); ?>"><div class="iconbox"><i class="fa fa-check" aria-hidden="true"></i></div>{{ucwords(reverse_slug($keyword[1]))}}</a></li>
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
              <div class="quotationtext">Quotation For {{ucwords($day)}} Day</div>
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
@if(isset($top_gifted_products))
<section>
<div class="productbgimnew">
  <div class="container">
    <div class="productnamehedding2">Top Gifted Products</div>
    <div id="thumbnail-slider">
      <div class="inner">
        <ul>
        @foreach($top_gifted_products as $prods)
         <?php $prods = $prods->_source; ?>
          <li>
            <!-- <div class="salebg">SALE</div> -->
            <a href="{{$prods->product_url}}" target="_blank"><div class="productim"><img class="imgprodunamenewall" src="{{getImageNew($prods->image_url,'S')}}" alt="{{$prods->name}}" title="{{$prods->name}}"></div></a>
            <a href="{{$prods->product_url}}" target="_blank"><div class="productname">{{truncate($prods->name,18)}}</div></a>
            <div class="price">Rs. {{number_format($prods->saleprice)}}</div>
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
    <div class="productnamehedding2">Top POPULAR Gifts</div>
    <nav>
      <ul class="control-box pager">
        <li><a data-slide="prev" href="#myCarousel1" class=""><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
        <li><a data-slide="next" href="#myCarousel1" class=""><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
      </ul>
    </nav>
    <div class="carousel slide" id="myCarousel1">
      <div class="carousel-inner">


            <?php $i=0; $class="thumbnail";?>
			    @foreach($top_popular_gifts as $prods)
			    	<?php $prods = $prods->_source; //print_r($prods);exit; ?>
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
			                    <a target="_blank" href="{{$prods->product_url}}"><div class="productim"><img class="imgprodunamenewall" src="{{getImageNew($prods->image_url,'S')}}" alt="{{$prods->name}}" title="{{$prods->name}}"></div></a>
			                    <a target="_blank" href="{{$prods->product_url}}"><div class="productname">{{truncate($prods->name,18)}}</div></a>
			                    <div class="price">Rs. {{number_format($prods->saleprice)}}</div>
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
			      @if($i % 10 ==0 || $i == count($top_popular_gifts))
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
  <div class="cakebg">
    <div class="container">
      <div class="productnamehedding2" style="color:#FFFFFF;">Top POPULAR Cake</div>
      <nav>
        <ul class="control-box pager">
          <li><a data-slide="prev" href="#myCarousel2" class=""><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
          <li><a data-slide="next" href="#myCarousel2" class=""><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
        </ul>
      </nav>
      <div class="carousel slide" id="myCarousel2">
        <div class="carousel-inner">


          <?php $i=0; $class="thumbnail";?>
			    @foreach($top_popular_cake as $prods)
			    	<?php $prods = $prods->_source; //print_r($prods);exit; ?>
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
			                    <a target="_blank" href="{{$prods->product_url}}"><div class="productim"><img class="imgprodunamenewall" src="{{getImageNew($prods->image_url,'S')}}" alt="{{$prods->name}}" title="{{$prods->name}}"></div></a>
			                    <a target="_blank" href="{{$prods->product_url}}"><div class="productname">{{truncate($prods->name,18)}}</div></a>
			                    <div class="price">Rs. {{number_format($prods->saleprice)}}</div>
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
			      @if($i % 10 ==0 || $i == count($top_popular_cake))
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
      <div class="productnamehedding2" style="color:#FFFFFF;">Top Flowers & Teddy Gifts</div>
      <nav>
        <ul class="control-box pager">
          <li><a data-slide="prev" href="#myCarousel3" class=""><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>
          <li><a data-slide="next" href="#myCarousel3" class=""><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
        </ul>
      </nav>
      <div class="carousel slide" id="myCarousel3">
        <div class="carousel-inner">


          <?php $i=0; $class="thumbnail";?>
			    @foreach($top_teddy_flower as $prods)
			    	<?php $prods = $prods->_source; //print_r($prods);exit; ?>
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
			                    <a target="_blank" href="{{$prods->product_url}}"><div class="productim"><img class="imgprodunamenewall" src="{{getImageNew($prods->image_url,'S')}}" alt="{{$prods->name}}" title="{{$prods->name}}"></div></a>
			                    <a target="_blank" href="{{$prods->product_url}}"><div class="productname">{{truncate($prods->name,18)}}</div></a>
			                    <div class="price">Rs. {{number_format($prods->saleprice)}}</div>
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
			      @if($i % 10 ==0 || $i == count($top_teddy_flower))
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
  <div class="productnamehedding2" style="margin-bottom:20px;">top video</div>
  <div class="fullscreen-bg">
  
    <video loop muted autoplay class="fullscreen-bg__video">
      <source src="<?php echo asset("valentine/v1/images/video/couple.mp4"); ?>" type="video/mp4" height="100%" width="100%">
    </video> 
  </div>
</section>

<div class="clearboth"></div>
<section>
<div class="productbgimnew">
  <div class="container">
    <div class="productnamehedding2">Latest Updated Products</div>
    <div id="thumbnail-slider3">
      <div class="inner">
        <ul>
        @foreach($latest_prod as $prods)
        <?php $prods = $prods->_source; //print_r($prods);exit; ?>
          <li>
            <!-- <div class="salebg">SALE</div> -->
            <a href="{{$prods->product_url}}" target="_blank"><div class="productim"><img class="imgprodunamenewall" src="{{getImageNew($prods->image_url,'S')}}" alt="{{$prods->name}}" title="{{$prods->name}}"></div></a>
            <a href="{{$prods->product_url}}" target="_blank"><div class="productname">{{truncate($prods->name,18)}}</div></a>
            <div class="price">Rs. {{number_format($prods->saleprice)}}</div>
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
    <div class="ads"><a target="_blank" href="<?php echo url("/lifestyle/gifting-events/flowers-price-list-in-india.html"); ?>"><img class="img-responsive" src="<?php echo asset("valentine/v1/images/product/ads1.jpg")?>" alt="Flowers"></a></div>
    <div class="ads"><a target="_blank" href="<?php echo url("/lifestyle/gifting-events/cake-price-list-in-india.html"); ?>"><img class="img-responsive" src="<?php echo asset("valentine/v1/images/product/ads2.jpg")?>" alt="Cake"></a></div>
    <div class="ads"><a target="_blank" href="<?php echo url("/lifestyle/gifting-events/dry-fruits-price-list-in-india.html"); ?>"><img class="img-responsive" src="<?php echo asset("valentine/v1/images/product/ads3.jpg")?>" alt="Dry Fruits"></a></div>

    <div class="saleads"><a href="<?php echo url("/lifestyle/gifting-events/flowers-price-list-in-india.html"); ?>"><img class="img-responsive" src="<?php echo asset("valentine/v1/images/product/saleads.jpg")?>" alt=""></a></div>

  </div>
</section>

<section>
  <div class="bordertop"></div>
  <div class="container">
  <?php
  if($day == "valentines"){ ?>
  <h3 style="text-align:center;">Valentine’s Day</h3>
 <?php }else{ ?> 
  <h3 style="text-align:center;"><?php echo ucwords($day); ?> Day</h3>  
   <?php } ?>
    @if(isset($text))
      <?php echo $text; ?>
    @endif

  </div>
</section>

<footer style="background:#cc0228;">
  <div class="container">
    <div class="row">
      <p class="footer-txt">COPYRIGHT &copy; 2017 Indiashopps.com - All Rights Reserved.</p>
    </div>
  </div>
</footer>
<script src="<?php echo asset("/assets/valentine/v1/js/jquery.js")?>"></script>
<script src="<?php echo asset("/assets/valentine/v1/js/thumbnail-slider.js")?>" type="text/javascript"></script>
<script src="<?php echo asset("/assets/valentine/v1/js/bootstrap.min.js")?>"></script>
<script src="<?php echo asset("/assets/valentine/v1/js/easing.min.js")?>"></script>
<script src="<?php echo asset("/assets/valentine/v1/js/script.js")?>"></script>
<script>
$(document).ready(function() {
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