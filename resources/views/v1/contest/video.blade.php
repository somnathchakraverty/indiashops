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
        <a class="navbar-brand" href="<?php echo asset("/"); ?>"><img src="<?php echo asset("contest/valentine/images/indiashopps_logo-final2.png") ?>"/></a> </div>
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
<div class="fullbgcont"><h1 class="productnamehedding3">VIDEO CONTEST</h1></div>
<div class="container">
{!! Form::open(array('url'=>'contest/upload','method' => 'post','files'=>true)) !!}

    <div class="uploadtext">Hey you all love birds! Valentine’s week is just here and we can’t wait to appreciate your feelings and honour them with our exciting prizes. So, here you go! 
      <ul style="margin:20px 0px 0px -23px;">
        <li>Upload a romantic video of you and your partner to win exciting prizes. </li>
        <li> And the bigger news is our contest is just not confined to love couples, but also singles irrespective of age.</li>
        <li>All you have to do is upload your best/romantic/happy/self expressing video or any video that expresses/ defines your idea of love or Valentine! </li>
    <li>This is contest sponsered by IndiaShopps.com. </li>
    <li>Your video should be in any of these formats 3gp, wmv, mov, mp4, dat, mkv, mpe, mkv, vob,flv. </li>
    <li>The size limit of your file should be 24 MB.</li>
    <li>IndiaShopps will inform the winners through emails and phone numbers (if available) at their registered email IDs.</li>
    </ul>
 
    <div class="uploadhedding">Upload Video</div>

     <div class="flash-message">
  @foreach (['danger', 'warning', 'success', 'info'] as $msg)
  @if(Session::has('alert-' . $msg))
  <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
  @endif
  @endforeach
  </div> 
   </div>
<div class="col-md-3">  
    
    <div class="uploadimbox">
    <div class="uploadim"><img id="myImg2" src="<?php echo asset("contest/valentine/images/cont/video.jpg") ?>" alt="upload Video" />
      <video class="fullscreen-bg__video" style="display:none" controls="" loop="" src=""></video>
    </div>
      <div class="fileUpload btn btn-primary">
        <span>Upload Video</span>
        <input type="file" name="video" class="upload" />
      </div>      
    </div>
</div>
<div class="col-md-5">
<div class="form-group">   
        <input style="width:100%;" type="text" required="required" name="fname" class="form-control form-controlnewname" id="exampleInputEmail1" placeholder="First Name">
      <input style="width:100%;" type="text" required="required" name="lname" class="form-control form-controlnewname" id="exampleInputEmail1" placeholder="last Name">  
      <input style="width:100%;" type="email" required="required" name="email" class="form-control form-controlnewname" id="exampleInputEmail1" placeholder="Email Id"> 
      <input style="width:100%;" type="text" name="phone" class="form-control form-controlnewname" id="exampleInputEmail1" placeholder="Mobile Number">
      <textarea style="width:100%;" name="message" class="form-control form-controlnew" rows="3" placeholder="Message"></textarea>
     </div>
   
     <button style="float:right;margin: 20px -40px 0px 0px !important;" type="submit" class="btn btn-default submitbutnew">Submit</button>
   {!! Form::close() !!}
   </div>
    <div class="col-md-4">
        <div id="thumbs2" style="height:360px;">
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

<h4 class="excitingprizes2">Selection Criteria:</h4>
<ul style="margin: 20px 0px 0px -23px; float:left;">
<li style="text-align:left;width:100%;clear:both;">The video quality or resolution should be high. Blurred images will not be entertained.</li>
<li style="text-align:left;width:100%;clear:both;">Your video should reflect the theme “LOVE” strongly. The more intense and deeper the meaning is, the more it will appeal us. </li>
</ul>  
</div>
</section>



<section>
<div class="bordertop"></div>
<div class="container">
<div class="excitingprizes">Win Exciting Prizes to Make Your Valentine's Day Special</div>
<div class="prizeslist">
<ul>
<li><a data-toggle="modal" data-target=".bs-example-modal-lg"><img class="img-responsive" src="<?php echo asset("contest/valentine/images/cont/cont-post1.jpg"); ?>"></a></li>
<li><a data-toggle="modal" data-target=".bs-example-modal-lg2"><img class="img-responsive" src="<?php echo asset("contest/valentine/images/cont/cont-post2.jpg"); ?>"></a></li>
<li><a data-toggle="modal" data-target=".bs-example-modal-lg3"><img class="img-responsive" src="<?php echo asset("contest/valentine/images/cont/cont-post3.jpg"); ?>"></a></li>
<li><a data-toggle="modal" data-target=".bs-example-modal-lg4"><img class="img-responsive" src="<?php echo asset("contest/valentine/images/cont/cont-post4.jpg"); ?>"></a></li>
<li><a data-toggle="modal" data-target=".bs-example-modal-lg5"><img class="img-responsive" src="<?php echo asset("contest/valentine/images/cont/cont-post5.jpg"); ?>"></a></li>
<li><a data-toggle="modal" data-target=".bs-example-modal-lg6"><img class="img-responsive" src="<?php echo asset("contest/valentine/images/cont/cont-post6.jpg"); ?>"></a></li>
</ul>
</div>
</div>
</section>





<div class="clearboth"></div>
@if(isset($top_gifted_products))
<section>
<div class="bordertop"></div>
  <div class="container">
    <div class="productnamehedding2">Top Gift Ideas</div>
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
    <div class="productnamehedding2">Top Popular Gifts</div>
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
      <div class="productnamehedding2" style="color:#FFFFFF;">top POPULAR cakes</div>
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
      <div class="productnamehedding2" style="color:#FFFFFF;">top teddy & FLOWER HAMPERS</div>
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
  <div class="productnamehedding2" style="margin-bottom:20px;"></div>
  <div class="fullscreen-bg">
    <video loop muted autoplay class="fullscreen-bg__video">
      <source src="<?php echo asset("contest/valentine/images/video/couple.mp4")?>" type="video/mp4" height="100%" width="100%">
    </video>
  </div>
</section>

<div class="clearboth"></div>
@if(isset($latest_prod))
<section>
  <div class="container">
    <div class="productnamehedding2">BEST GIFT IDEAS ONLINE</div>
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
          $('#myImg2').hide();
          $('.uploadim video').show();    
          vid = window.URL.createObjectURL(this.files[0]);         
          $('#myImg2').hide();
          $('.uploadim video').show(); 
          $('.uploadim video').attr('src', vid);           
        }
    });
});


</script>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
  <button style="color:#000;position: absolute;right: -8px;z-index: 9999;top: -10px;background: #fff;opacity: 2;padding: 4px 8px 4px 8px; outline:none;border-radius: 50%;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <div class="modal-content" style="padding:6px;">
      <img class="img-responsive" src="<?php echo asset("contest/valentine/images/cont/cont-post-big1.jpg"); ?>">
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-lg2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
  <button style="color:#000;position: absolute;right: -8px;z-index: 9999;top: -10px;background: #fff;opacity: 2;padding: 4px 8px 4px 8px; outline:none;border-radius: 50%;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <div class="modal-content" style="padding:6px;">
      <img class="img-responsive" src="<?php echo asset("contest/valentine/images/cont/cont-post-big2.jpg"); ?>">
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-lg3" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
  <button style="color:#000;position: absolute;right: -8px;z-index: 9999;top: -10px;background: #fff;opacity: 2;padding: 4px 8px 4px 8px; outline:none;border-radius: 50%;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <div class="modal-content" style="padding:6px;">
      <img class="img-responsive" src="<?php echo asset("contest/valentine/images/cont/cont-post-big3.jpg"); ?>">
    </div>
  </div>
</div>


<div class="modal fade bs-example-modal-lg4" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
  <button style="color:#000;position: absolute;right: -8px;z-index: 9999;top: -10px;background: #fff;opacity: 2;padding: 4px 8px 4px 8px; outline:none;border-radius: 50%;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <div class="modal-content" style="padding:6px;">
      <img class="img-responsive" src="<?php echo asset("contest/valentine/images/cont/cont-post-big4.jpg"); ?>">
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-lg5" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
  <button style="color:#000;position: absolute;right: -8px;z-index: 9999;top: -10px;background: #fff;opacity: 2;padding: 4px 8px 4px 8px; outline:none;border-radius: 50%;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <div class="modal-content" style="padding:6px;">
      <img class="img-responsive" src="<?php echo asset("contest/valentine/images/cont/cont-post-big5.jpg"); ?>">
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-lg6" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
  <button style="color:#000;position: absolute;right: -8px;z-index: 9999;top: -10px;background: #fff;opacity: 2;padding: 4px 8px 4px 8px; outline:none;border-radius: 50%;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <div class="modal-content" style="padding:6px;">
      <img class="img-responsive" src="<?php echo asset("contest/valentine/images/cont/cont-post-big6.jpg"); ?>">
    </div>
  </div>
</div>

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