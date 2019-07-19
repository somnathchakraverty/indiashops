<?php
$product = $data->product_detail;
$similar = $data->similar_prod->hits->hits;
if (strpos($product->image_url, ',') !== false && (strpos($product->image_url, '"]') === false)) {
    $product->image_url = explode(",", $product->image_url);
    $product->image_url = str_replace('"', '', $product->image_url[0]);
}

$brand_count = ( isset($data->brand_count) ) ? $data->brand_count : 0;

if (!empty(json_decode($product->image_url))) {
    $images = json_decode($product->image_url);
} else {
    $images[] = $product->image_url;
}
if (!is_array($images)) {
    $images[] = getImageNew($product->image_url);
}
$prating = 3;
if (isset($vendors)) {
    foreach ($vendors as $v) {
        $prating = ($v->_source->rating > $prating) ? $v->_source->rating : $prating;
    }
}

if (isset($product->rating) && $product->rating > 0) {
    $prating = $product->rating;
}
$detail_meta = false;

try {
    if (isset($product->meta) && !empty($product->meta)) {
        $detail_meta = json_decode($product->meta);
    }
}
catch (\Exception $e) {
    $detail_meta = false;
}
$main_product = $product;

$prod = new \stdClass;
$prod->id = $pid = $product->id;
$prod->name = $product->name;
$prod->image = $product->image_url;
$prod->cat = $product->category_id;
$prod->size = (isset($product->size)) ? $product->size : '';
$prod->color = (isset($product->cvariant)) ? $product->cvariant : '';
$prod->brand = (isset($product->brand)) ? $product->brand : '';
$prod->price = (isset($product->saleprice)) ? $product->saleprice : '1000';
$prod = Crypt::encrypt(($prod));
?>
<style>
    .fullbgpro { background: #f8f8f8; margin-top: 10px; padding: 10px 0; }
    .fullwidth { width: 100%; margin: auto; overflow: hidden; }
    .detailsproductname { padding: 0; text-align: center }
    .detailsproductname h1 { font-size: 18px; color: #000; text-align: center }
    .detailsproductprice { font-size: 20px; color: #e40046; padding-top: 1px; text-align: center }
    .detailsproductprice span { font-size: 24px; font-weight: 700; color: #e40046 }
    .content-header .product-title { color: #000; font-size: 24px; font-weight: 500; margin: 0 0 15px }
    .content-header .product-slider { list-style: none; padding: 0; height: 320px; overflow: hidden; outline: 0; margin: 0 0 5px }
    .product-slider li { position: relative; outline: 0 }
    .product-slider li .fullscreen-icon { display: inline-block; position: absolute; right: 10px; top: 10px; padding: 3px 7px; color: #000; border: 1px solid #ddd }
    .product-slider li img, .product-slider .slick-dots button img { max-width: 280px; max-height: 230px; margin: auto; }
    .product-slider .slick-dots { width: 100%; padding: 3px; top: 10px; left: 0; right: 0; margin: 0 auto; position: relative; line-height: 0; background: #fff; }
    .product-slider .slick-dots li { margin: 3px; border: 1px solid #fff; width: 50px; height: 50px; overflow: hidden; display: inline-block; background: #fff; }
    .product-slider .slick-dots li button { margin: 0; height: auto; width: 100%; padding: 0 }
    .product-slider .slick-dots li.slick-active { border: 1px solid #e40046 }
    .product-slider .slick-dots li button.tab { clear: both; display: block; height: 48px; background: #fff; border: 1px solid #dadada; }
    .product-slider .slick-dots li button img { max-width: 38px; max-height: 38px; border: 0px; }
    .slick-thumbs { position: absolute; left: -9999px }
    .slick-slider { position: relative; display: block; -moz-box-sizing: border-box; box-sizing: border-box; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; margin: 2px 0px 25px 0px; text-align: center; padding: 0; user-select: none; -webkit-touch-callout: none; -khtml-user-select: none; -ms-touch-action: pan-y; touch-action: pan-y; -webkit-tap-highlight-color: transparent }
    .slick-list { position: relative; display: inline-grid !important; line-height: 290px; margin: 0; padding: 10px 3px 3px 0px; height: 300px; background: #fff; overflow: hidden; align-items: center; width: 100%; }
    .slick-list:focus { outline: none }
    .slick-list.dragging { cursor: pointer; cursor: hand }
    .slick-slider .slick-track, .slick-slider .slick-list { -webkit-transform: translate3d(0, 0, 0); -moz-transform: translate3d(0, 0, 0); -ms-transform: translate3d(0, 0, 0); -o-transform: translate3d(0, 0, 0); transform: translate3d(0, 0, 0) }
    .slick-track { position: relative; top: 0; left: 0; display: block }
    .slick-track:before, .slick-track:after { display: table; content: '' }
    .slick-track:after { clear: both }
    .slick-loading .slick-track { visibility: hidden }
    .slick-slide { display: none; float: left; height: 100%; min-height: 1px }
    [dir='rtl'] .slick-slide { float: right }
    .slick-slide img { display: initial; }
    .slick-slide.slick-loading img { display: none }
    .slick-slide.dragging img { pointer-events: none }
    .slick-initialized .slick-slide { display: block }
    .slick-loading .slick-slide { visibility: hidden }
    .slick-vertical .slick-slide { display: block; height: auto; border: 1px solid transparent }
    .slick-arrow.slick-hidden { display: none }
    #flexiselDemo1, #flexiselDemo2, #flexiselDemo3 { display: none }
    .nbs-flexisel-container { position: relative; max-width: 100% }
    .nbs-flexisel-ul { position: relative; width: 99999px; margin: 0; padding: 0; list-style: none; text-align: center; overflow: auto }
    .nbs-flexisel-inner { position: relative; overflow: hidden; float: left; width: 100% }
    .nbs-flexisel-item { float: left; margin-left: 1px; padding: 0; cursor: pointer; position: relative; line-height: 0 }
    .nbs-flexisel-item img { max-width: 100%; cursor: pointer; position: relative; margin-top: 10px; margin-bottom: 10px }
    .nbs-flexisel-nav-left, .nbs-flexisel-nav-right { padding: 5px 10px; border-radius: 0; -moz-border-radius: 0; -webkit-border-radius: 0; position: absolute; cursor: pointer; z-index: 4; top: 50%; transform: translateY(-50%); color: #fff }
    .nbs-flexisel-nav-left { background: url({{asset('assets/v2/mobile')}}/images/arrow-left.jpg); width: 30px; height: 30px; left: 5px }
    .nbs-flexisel-nav-right { background: url({{asset('assets/v2/mobile')}}/images/arrow-right.jpg); width: 30px; height: 30px; right: 5px }
    .thumnail { padding: 5px; margin: 10px 0; }
    .productbox, .productboxallcat, .thumnail { width: 100%; background: #fff; text-align: center; }
    .productboxallcat { height: 160px; align-items: center; display: flex; justify-content: center; overflow: hidden; }
    .productname { line-height: 15px; color: #333; padding-top: 5px; width: 100%; }
    .star-ratingreviews { width: 100%; margin: 5px 0 10px }
    .star-ratings-sprite { background: url({{asset('assets/v2/mobile')}}/images/star-rating-sprite.png) repeat-x; height: 12px; width: 61px; margin: 0 auto }
    .star-ratings-sprite-rating { background: url({{asset('assets/v2/mobile')}}/images/star-rating-sprite.png) 0 100% repeat-x; float: left; height: 12px }
    .price { width: 90px !important; margin: 5px auto; color: #fff !important; height: 25px; line-height: 26px; display: block !important; padding: 0 10px; background: #e40046; text-decoration: none !important }
    .productallcatimg { width: auto !important; height: 155px !important }
    .detailsproductname { padding: 0; text-align: center }
    .detailsproductname h1 { font-size: 15px !important; color: #000; text-align: center }
    .shipping { background: #fff; margin: 0; padding: 10px; font-size: 14px; color: #000; }


</style>
<div class="breadcrumb-bg">
    <div class="container"> {!! Breadcrumbs::render("p_detail_new",$product, $brand_count) !!} </div>
</div>
<!--PART-1-->
<div class="container">
    <div class="detailsproductname"> @if($detail_meta && isset($detail_meta->h1))
            <h1>{{$detail_meta->h1}}</h1>
        @else
            <h1>{{$product->name}}</h1>
        @endif </div>
    <div class="detailsproductprice">Rs. <span>{{number_format($product->saleprice)}}</span></div>
</div>
<div class="fullbgpro" style="margin:10px 0px 20px 0px;padding-bottom:15px;">
    <div class="container">
        <ul class="product-slider">
            @foreach( $images as $key => $image )
                <li><img src="{{getImageNew($image, 'L')}}"/></li>
            @endforeach
        </ul>
        <div class="slick-thumbs">
            <ul>
                @foreach( $images as $key => $image )
                    <li class="{{( $key ==0 ) ? 'active' : ''}}">
                        <a data-target="#pic-{{$key}}" data-toggle="tab">
                            <img src="{{getImageNew($image, 'XS')}}"/>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        @if(isset($product->product_url))
            <a href="{{$product->product_url}}" target="_blank"
               onClick="ga('send', 'event', 'shop', 'click_mobile');" rel="nofollow"
               class="btn btn-success" style="float:none!important;">Buy Now</a>
        @endif
    </div>
</div>
<div class="fullbgpro" style="margin-bottom:20px;">
    <div class="container">
        <div class="shipping"><b>FREE</b> Shipping . EMI . COD</div>
    </div>
</div>
<div class="fullbgpro" style="margin-bottom:20px;">
    <div class="container">
        <div class="shipping">
            <div class="features" style="font-size:16px;font-weight:bold;margin-bottom:6px;padding-left:24px;">
                Features
            </div>
            <ul class="mini_description" style="font-size:13px;color:#4c4c4c;">
                {!! getMiniSpec($data->product_detail->mini_spec) !!}
            </ul>
        </div>
    </div>
</div>

<div class="container" style="clear:both;">
    <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#home" aria-controls="home" role="tab" data-toggle="tab"
                   style="color:#000;text-transform:uppercase;">
                    Overview
                </a>
            </li>
            @if(!empty($data->product_detail->specification))
                <li role="presentation">
                    <a href="#specs" aria-controls="profile" role="tab" data-toggle="tab"
                       style="color:#000;text-transform:uppercase;">
                        Specifications
                    </a>
                </li>
        @endif
        <!--<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Reviews</a></li> -->
        </ul>
        <!-- Tab panes -->
        <div class="tab-content tabcontmobile">
            <div role="tabpanel" class="tab-pane active" id="home">
                <div class="comparealllistnew">
                    @if(isset($vendors) && count($vendors)>0)
                        <ul>
                            @foreach( $vendors as $v )
                                <?php $vendor = $v->_source; ?>
                                <li>
                                    <div class="comsitelogonew">
                                        <img src="{{config('vendor.vend_logo.'.$vendor->vendor )}}"
                                             class="vanderlogo"
                                             alt="logo" onerror="imgError(this)"></div>
                                    <div class="emitext">
                                        @if( !empty($vendor->emiAvailable) )
                                            EMI: <b>Yes</b>
                                        @else
                                            EMI: <b>No</b>
                                        @endif </div>
                                    <div class="deliveryday">
                                        @if(!empty($vendor->delivery) && $vendor->delivery != "NULL")
                                            Delivery: {{$vendor->delivery}}
                                        @endif </div>
                                    <div class="compricenewdetails"> Rs. {{number_format($vendor->saleprice)}}</div>
                                    <a class="combutodetailsnew" target="_blank"
                                       out-url="{{$vendor->product_url}}" href="{{$vendor->product_url}}"
                                       onClick="ga('send', 'event', 'shop', 'click_mobile');" rel="nofollow"> Go To
                                        Store </a></li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            @if(!empty($data->product_detail->specification))
                <div role="tabpanel" class="tab-pane" id="specs">
                    <div class="bs-example" data-example-id="striped-table" id="specification">
                        <div class="more-toggledetailstable show">
                            <table>
                                {!! $data->product_detail->specification !!}
                            </table>
                        </div>
                    </div>
                </div>
        @endif
        <!-- <div role="tabpanel" class="tab-pane" id="messages">3</div>-->
        </div>
    </div>
</div>
@if((isset($detail_meta) && isset($detail_meta->meta)))
    <div class="fullbgpro">
        <div class="fullwidth padding10">
            <div class="bgcolorproduct">
                <h3 class="haddingdetails">About {{$product->name}}</h3>
                @if(isset($detail_meta) && isset($detail_meta->meta))
                    {!! html_entity_decode($detail_meta->meta) !!}
                @endif </div>
        </div>
    </div>
@endif
<!--END-PART-1-->
<!--PART-2-->
@if( isset( $slider[0] ) && !empty($slider[0]) )
    <?php $image = $slider[0]; ?>
    <div class="container">
        <a href="{{$image->refer_url}}" target="_blank">
            <img class="img-responsive adimg" src="{{$image->image_url}}" alt="{{$image->alt}}">
        </a>
    </div>
@endif
@if(!empty($data->product_detail->description))
<div class="fullbgpro" style="margin-bottom:20px;">
    <div class="container">
        <div class="shipping">
            <div class="features" style="font-size:18px;font-weight:bold;margin-bottom:-20px; float:left;">
                {{ $data->product_detail->name }} Details
            </div>
            <div class="bs-example description" data-example-id="striped-table">
                {!! $data->product_detail->description !!}
            </div>
        </div>
    </div>
</div>
@endif
<!--END-PART-2-->
<h5 class="catname">Popular Products</h5>
<div class="fullbgpro">
    <div class="container" id="by-brand-wrapper" style="margin:-18px 0px -8px 0px;">
        <div class="fullbgpro">
            <div class="fullwidth" id="by-brand"></div>
        </div>
    </div>
</div>
<!--PART-3-->
@if( isset( $slider[1] ) && !empty($slider[1]) )
    <?php $image = $slider[1]; ?>
    <div class="container">
        <a href="{{$image->refer_url}}" target="_blank">
            <img class="img-responsive adimg" src="{{$image->image_url}}" alt="{{$image->alt}}"/>
        </a>
    </div>
@endif
@if(!empty($custom_links))
    <div class="fullbgpro">
        <div class="fullwidth padding10">
            <div class="bgcolorproduct">
                <h3 class="haddingdetails">Popular Mobile Price Lists</h3>
                <ul class="sctn__list">
                    <?php $i = 1;?>
                    @foreach($custom_links as $t => $l)
                        <li class="sctn__list-item"><a href="{{$l}}" target="_blank">{{$t}}</a></li>
                        <?php
                        $i++;
                        unset($custom_links[$t]);

                        if ($i >= 10) {
                            $custom_links = array_filter($custom_links);
                            break;
                        }
                        ?>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
@if(!empty($custom_links))
    <div class="fullbgpro">
        <div class="fullwidth padding10">
            <div class="bgcolorproduct">
                <h3 class="haddingdetails">Other Mobile Price Lists</h3>
                <ul class="sctn__list">
                    @foreach($custom_links as $t => $l)
                        <li class="sctn__list-item"><a href="{{$l}}" target="_blank">{{$t}}</a></li>
                        <?php
                        $i++;
                        unset($custom_links[$t]);
                        ?>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
<!--END-PART-3-->
<!--PART-4-->
@if( isset( $slider[2] ) && !empty($slider[2]) )
    <?php $image = $slider[2]; ?>
    <div class="container">
        <a href="{{$image->refer_url}}" target="_blank">
            <img class="img-responsive adimg" src="{{$image->image_url}}" alt="{{$image->alt}}"/>
        </a>
    </div>
@endif
@if(isset($similar) && is_array($similar) && count($similar) > 0)
    <h5 class="catname">Similar Products</h5>
    {{--<a href="#" class="view">View All</a>--}}
    <div class="fullbgpro">
        <div class="container">
            <div class="fullwidth">
                <ul id="flexiselDemo1">
                    @foreach( $similar as $sim )
                        <?php $product = $sim->_source;?>
                        <li>
                            <div class="thumnail">
                                <div class="productboxallcat">
                                    <a href="{{product_url($product)}}">
                                        <img class="productallcatimg" src="{{getImageNew($product->image_url, 'M')}}">
                                    </a>
                                </div>
                                <div class="productname">
                                    <a href="{{product_url($product)}}">
                                        {{$product->name}}
                                    </a>
                                </div>
                                <div class="star-ratingreviews">
                                    <div class="star-ratings-sprite"><span style="width:52%"
                                                                           class="star-ratings-sprite-rating"></span>
                                    </div>
                                </div>
                                <a href="{{product_url($product)}}" class="price">
                                    Rs. {{number_format($product->saleprice)}} </a></div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif </div>
    @if( isset( $slider[3] ) && !empty($slider[3]) )
        <?php $image = $slider[3]; ?>
        <div class="container">
            <a href="{{$image->refer_url}}" target="_blank">
                <img style="padding-bottom:10px;" class="img-responsive adimg" src="{{$image->image_url}}"
                     alt="{{$image->alt}}"/>
            </a>
        </div>
    @endif
    <style>
        .description h2{ font-size: 14px; }
    </style>
    <!--END-PART-4-->
    <script>
        var s = document.createElement("script");
        s.type = "text/javascript";
        s.src = asset_url + "js/jquery.flexisel.js";
        document.body.appendChild(s);

        s.addEventListener('load', function () {
            $("#flexiselDemo1").flexisel();

            var s = document.createElement("script");
            s.type = "text/javascript";
            s.src = asset_url + "js/materialize.min.js";
            document.body.appendChild(s);

            var s = document.createElement("script");
            s.type = "text/javascript";
            s.src = asset_url + "js/mobile.js";
            document.body.appendChild(s);

            var sl = document.createElement("script");
            sl.type = "text/javascript";
            sl.src = asset_url + "js/slick.min.js";
            document.body.appendChild(sl);

            sl.addEventListener('load', function () {
                $('.featured-slider').slick({
                    dots: true,
                    arrows: false,
                    autoplay: true,
                    fade: true,
                    speed: 500,
                    cssEase: 'linear'
                });

                // Product (thumb) slider
                $('.product-slider').slick({
                    dots: true,
                    infinite: true,
                    speed: 500,
                    fade: true,
                    slide: 'li',
                    cssEase: 'linear',
                    centerMode: true,
                    slidesToShow: 1,
                    variableWidth: true,
                    responsive: [{
                        breakpoint: 800,
                        settings: {
                            arrows: false,
                            centerMode: false,
                            centerPadding: '40px',
                            variableWidth: false,
                            slidesToShow: 1,
                            dots: true
                        },
                        breakpoint: 1200,
                        settings: {
                            arrows: false,
                            centerMode: false,
                            centerPadding: '40px',
                            variableWidth: false,
                            slidesToShow: 1,
                            dots: true

                        }
                    }],
                    customPaging: function (slider, i) {
                        return '<button class="tab">' + $('.slick-thumbs li:nth-child(' + (i + 1) + ')').html() + '</button>';
                    }
                });

                // Product list slider
                $('.product-list-slider').slick({
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    prevArrow: '<span class="prev-arr"><i class="fa fa-angle-left"></i></span>',
                    nextArrow: '<span class="next-arr"><i class="fa fa-angle-right"></i></span>',
                    responsive: [
                        {
                            breakpoint: 401,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 1025,
                            settings: {
                                slidesToShow: 4,
                                slidesToScroll: 1
                            }
                        }]
                });
            });

            s.addEventListener('load', function () {
                var form_data = {_token: '{{csrf_token()}}', product: '{{$prod}}'};
                CONTENT.uri = "{{route("mobile-page-content")}}";
                CONTENT.pid = '{{$pid}}';
                CONTENT.load("by-brand", true, form_data);
            }, false);
        }, false);
    </script>
