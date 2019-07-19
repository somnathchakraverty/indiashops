<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Valentine day contest 2017, Showcase your valentine moments online | Indiashopps.com</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Valentine's day contest 2017 and share your valentine's special photos, videos to celebrate love and win exciting prizes.">
  <meta name="keyword" content="Valentine day couple photos, Valentine day couple videos, Valentine day special clicks, Valentine day photos, Valentine day videos">
  <link rel="shortcut icon" href="<?php echo asset("contest/valentine/images/faviconindia.png") ?>">
  <link href="<?php echo asset("contest/valentine/css/font-awesome.min.css") ?>" rel="stylesheet">
  <link href="<?php echo asset("contest/valentine/css/bootstrap.min-new.css") ?>" rel="stylesheet">
  <link href="<?php echo asset("contest/valentine/css/style-new.css") ?>" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo asset("contest/valentine/css/banner.css") ?>">
  <script src="<?php echo asset("contest/valentine/js/banner/jquery.min.js") ?>"></script>
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<div class="bg_heart"></div>
<!--THE-HEADER-->
<header>
  <div class="navbar navbar-default" role="navigation">
    <div class=container>
      <div class=navbar-header>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class=icon-bar></span> <span class=icon-bar></span> <span class=icon-bar></span> </button>
        <a class="navbar-brand" href="#"><img src="<?php echo asset("contest/valentine/images/indiashopps_logo-final2.png") ?>"/></a> </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li><a class="page-scroll link1" href="<?php echo url("/rose-day-gifts-ideas-online"); ?>">Rose Day</a></li>
          <li><a class="page-scroll link1" href="<?php echo url("/propose-day-gifts-ideas-online"); ?>">Propose Day</a></li>
          <li><a class="page-scroll link1" href="<?php echo url("/chocolate-day-gifts-ideas-online"); ?>">Chocolate Day</a></li>
          <li><a class="page-scroll link1" href="<?php echo url("/teddy-day-gifts-ideas-online"); ?>">Teddy Day</a></li>
          <li><a class="page-scroll link1" href="<?php echo url("/promise-day-gifts-ideas-online"); ?>">Promise Day</a></li>
          <li><a class="page-scroll link1" href="<?php echo url("/hug-day-gifts-ideas-online"); ?>">Hug Day</a></li>
          <li><a class="page-scroll link1" href="<?php echo url("/kiss-day-gifts-ideas-online"); ?>">Kiss Day</a></li>
          <li><a class="page-scroll link1" href="<?php echo url("/valentines-day-gifts-ideas-online"); ?>">VALENTINE’S DAY</a></li>
        </ul>
      </div>
    </div>
  </div>
</header>
<!--END-HEADER-->

<div class="clearboth"></div>
<section>
<div class="fullbgcont"><h1 class="productnamehedding3">PHOTO/VIDEO CONTEST</h1></div>
<div class="container">
<div class="col-md-8">

 {!! Form::open(array('url'=>'contest/upload','method' => 'post','files'=>true)) !!}

    <div class="uploadtext">Hey you all love birds! Valentine’s week is just here and we can’t wait to appreciate your feelings and honour them with our exciting prizes. So, here you go! 
      <ul>
        <li>Upload a romantic photo/video of you and your partner to win exciting prizes. </li>
        <li> And the bigger news is our contest is just not confined to love couples, but also singles irrespective of age.</li>
        <li>All of you can choose to upload a personal photo of yours or self-photograph something that conveys the emotion of love. </li>
      </ul>
  </div>
    <div class="uploadhedding">Upload Image/Video</div>
  
	<div class="flash-message">
	@foreach (['danger', 'warning', 'success', 'info'] as $msg)
	@if(Session::has('alert-' . $msg))
	<p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
	@endif
	@endforeach
	</div>
    <div class="uploadimbox">
        <div class="uploadim"><img id="myImg" src="<?php echo asset("contest/valentine/images/cont/conim.jpg") ?>" alt="upload image" /></div>
        <div class="fileUpload btn btn-primary">
            <span>Upload Photo</span>
            <input type="file" name="image" class="upload" />
        </div>
        <a href="#" class="cancelbut">Cancel</a>
    </div>
    <div class="uploadimbox">
    <div class="uploadim"><img id="myImg2" src="<?php echo asset("contest/valentine/images/cont/conim.jpg") ?>" alt="upload Video" /></div>
      <div class="fileUpload btn btn-primary">
        <span>Upload Video</span>
        <input type="file" name="video" class="upload" />
      </div>
      <a href="#" class="cancelbut">Cancel</a>
    </div>
     <div class="form-group">   
        <input type="text" required="required" name="fname" class="form-control form-controlnewname" id="exampleInputEmail1" placeholder="First Name">
      <input type="text" required="required" name="lname" class="form-control form-controlnewname" id="exampleInputEmail1" placeholder="last Name">  
      <input type="email" required="required" name="email" class="form-control form-controlnewname" id="exampleInputEmail1" placeholder="Email Id"> 
      <input type="text" name="phone" class="form-control form-controlnewname" id="exampleInputEmail1" placeholder="Mobile Number">
      <textarea name="message" class="form-control form-controlnew" rows="3" placeholder="Message"></textarea>
     </div>
   
     <button type="submit" class="btn btn-default submitbutnew">Submit</button>
   {!! Form::close() !!}

 <h4 style="margin-top:20px;float:left;clear:both;">Grounds on which we will judge your photo video:</h4>
<ul>
<li style="text-align:left;width:100%;clear:both;">The photo/ video quality or resolution should be high. Blurred images will not be entertained.</li>
<li style="text-align:left;width:100%;clear:both;">Your photo/video should reflect the theme “LOVE” strongly. The more intense and deeper the meaning is, the more it will appeal us. </li>
</ul>      
</div>


    <div class="col-md-4">
        <div id="thumbs2">
                <div class="inner">
                    <ul>
                    @if(isset($contest_video_image))
                      @foreach($contest_video_image as $list)
                         <li><a class="thumb" href="{{$list->image_name}}"></a></li>
                      @endforeach
                    @endif   
                    </ul>
                </div>
        </div>      
            
    </div>


</div>
</section>






<div class="clearboth"></div>
@if(isset($top_gifted_products))
<section>
<div class="bordertop"></div>
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
</section>
@endif
<div class="clearboth"></div>
@if(isset($top_popular_gifts))
<section>
  <div class="bordertop"></div>
  <div class="container">
    <div class="productnamehedding2">top POPULAR Gifts</div>
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
      </div>
    </div>
    <!-- /#myCarousel -->
  </div>
  <!-- /.container -->
</section>
@endif
<div class="clearboth"></div>
@if(isset($top_popular_cake))
<section>
  <div class="cakebg">
    <div class="container">
      <div class="productnamehedding2" style="color:#FFFFFF;">top POPULAR cake</div>
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
        </div>
        <!-- /.control-box -->
      </div>
      <!-- /#myCarousel -->
    </div>
    <!-- /.container -->
  </div>
</section>
@endif

<div class="clearboth"></div>
@if(isset($top_teddy_flower))
<section>
  <div class="taddybg">
    <div class="container">
      <div class="productnamehedding2" style="color:#FFFFFF;">top teddy flowers</div>
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
        </div>
        <!-- /.control-box -->
      </div>
      <!-- /#myCarousel -->
    </div>
    <!-- /.container -->
  </div>
</section>
@endif
<div class="clearboth"></div>
<section>
  <div class="productnamehedding2" style="margin-bottom:20px;">top video</div>
  <div class="fullscreen-bg">
    <!--<video loop muted autoplay class="fullscreen-bg__video">
      <source src="images\video/couple.mp4" type="video/mp4" height="100%" width="100%">
    </video>-->
  </div>
</section>

<div class="clearboth"></div>
@if(isset($latest_prod))
<section>
  <div class="container">
    <div class="productnamehedding2">latest updates products</div>
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
</section>
@endif
<div class="clearboth"></div>

<div class="clearboth"></div>
<section>
  <div class="bordertop"></div>
  <div class="container">
    <div class="ads"><a target="_blank" href="<?php echo url("/lifestyle/gifting-events/flowers-price-list-in-india.html"); ?>"><img class="img-responsive" src="<?php echo asset("valentine/v1/images/product/ads1.jpg")?>" alt="Flowers"></a></div>
    <div class="ads"><a target="_blank" href="<?php echo url("/lifestyle/gifting-events/cake-price-list-in-india.html"); ?>"><img class="img-responsive" src="<?php echo asset("valentine/v1/images/product/ads2.jpg")?>" alt="Cake"></a></div>
    <div class="ads"><a target="_blank" href="<?php echo url("/lifestyle/gifting-events/dry-fruits-price-list-in-india.html"); ?>"><img class="img-responsive" src="<?php echo asset("valentine/v1/images/product/ads3.jpg")?>" alt="Dry Fruits"></a></div>

    <div class="saleads"><a href="<?php echo url("/lifestyle/gifting-events/flowers-price-list-in-india.html"); ?>"><img class="img-responsive" src="<?php echo asset("valentine/v1/images/product/saleads.jpg")?>" alt="Flowers"></a></div>
  </div>
</section>
<footer style="background:#cc0228;">
  <div class="container">
    <div class="row">
      <p class="footer-txt">COPYRIGHT &copy; 2017 Indiashopps.com - All Rights Reserved.</p>
    </div>
  </div>
</footer>
<script src="<?php echo asset("contest/valentine/js/jquery.js") ?>"></script>
<script src="<?php echo asset("contest/valentine/js/thumbnail-slider.js") ?>" type="text/javascript"></script>
<script src="<?php echo asset("contest/valentine/js/bootstrap.min.js") ?>"></script>
<script src="<?php echo asset("contest/valentine/js/jquery.easing.min.js") ?>"></script>
<script src="<?php echo asset("contest/valentine/js/script.js") ?>"></script>
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
<script>
$(function () {
    $(":file").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
        }
    });
});

function imageIsLoaded(e) {
    $('#myImg').attr('src', e.target.result);
};
/*function imageIsLoaded(e) {
    $('#myImg2').attr('src', e.target.result);
};*/
</script>
</body>
</html>
