<style>
    .catname{font-size:16px;color:#5d5d5d;float:left;padding-top:10px;}
    .view{background:#e40046;color:#fff!important;padding:5px;margin-top:14px;float:right;font-size:14px;border-radius:5px;}
    .fullbgpro{background:#ececec;margin-top:10px;padding:10px 0;}
    .fullwidth{width:100%;margin:auto;overflow:hidden;}
    .thumnail{padding:5px;margin:10px 0;}
    .productbox{height:110px;align-items:center;display:flex;justify-content:center;overflow:hidden;}
    .productimg{width:auto!important;height:100px!important;}
    .productname{line-height:15px;color:#333;padding-top:5px;width:100%;}
    .star-ratingreviews{width:100%;margin:5px 0 10px}
    .star-ratings-sprite{background: url({{asset('assets/v2/mobile')}}/images/star-rating-sprite.png) repeat-x;height:12px;width:61px;margin:0 auto}
    .star-ratings-sprite-rating{background:url({{asset('assets/v2/mobile')}}/images/star-rating-sprite.png) 0 100% repeat-x;float:left;height:12px}
    .price{width:90px!important;margin:5px auto;color:#fff!important;height:25px;line-height:26px;display:block!important;padding:0 10px;background:#e40046;text-decoration:none!important;}
    .productbox, .productboxallcat, .thumnail{width:100%;background:#fff;text-align:center;}
    .price, .productname{font-size:13px;text-align:center;}
    .silider{padding-top:93px;}
    .adimg{margin-top:10px;}
    .panel-footer h1{font-size:14px;color:#3e3e3e;font-weight:700;line-height:20px;}
    .panel-footer h2, .panel-footer h4{font-size:14px;color:#000;}
	.carousel-control .glyphicon-chevron-right, .carousel-control .icon-next{right:0%!important;margin-right:0px!important;background:#000;height:30px;width:30px;line-height:30px;}
.carousel-control .glyphicon-chevron-left, .carousel-control .icon-prev{left:0%!important;margin-left:0px!important;background:#000;height:30px;width:30px;line-height:30px;}
.carousel-control .glyphicon-chevron-left, .carousel-control .glyphicon-chevron-right, .carousel-control .icon-next, .carousel-control .icon-prev{font-size:14px;position:absolute;top:37%!important;z-index:5;display:inline-block;margin-top:0px!important;}
.homehadding{text-align:left!important;float:left!important;width:auto!important;padding-bottom:0px!important;}
</style>
<div class="silider">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @foreach($home->slider as $key => $slider)
                <li data-target="#carousel-example-generic" data-slide-to="{{$key}}" class="{{($key == 0) ? 'active' : ''}}"></li>
            @endforeach
        </ol>
        <div class="carousel-inner" role="listbox">
            @foreach($home->slider as $key => $slider)
                <div class="item {{($key == 0) ? 'active' : ''}}">
                    @if( !empty($slider->refer_url) )
                        <a href="{{$slider->refer_url}}" target="_blank">
                            <img class="img-responsive" src="{{$slider->image_url}}" alt="{{$slider->alt}}">
                        </a>
                    @else
                        <img class="img-responsive" src="{{$slider->image_url}}" alt="{{$slider->alt}}">
                    @endif
                </div>
            @endforeach
        </div>
        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>
<!--END-SILDER-->
<!--PART-1-->
<div class="container">
    <h5 class="catname homehadding">Mobiles</h5>
    <a href="{{newUrl('mobile/mobiles-price-list-in-india.html')}}" class="view">View All</a></div>
<div class="fullbgpro">
    <div class="fullwidth">
        @foreach($home->block1->top_products as $key => $product )
        <div class="col-xs-6 col-sm-6">
            <div class="thumnail">
                <div class="productbox">
                    <a href="{{product_url_home($product)}}">
                        <img class="productimg" src="{{product_image($product->image_url)}}" alt="{{$product->name}} Image">
                    </a>
                </div>
                <div class="productname">
                    <a href="{{product_url_home($product)}}">
                        {{$product->name}}
                    </a>
                </div>
                <div class="star-ratingreviews">
                    <div class="star-ratings-sprite">
                        <span style="width:52%" class="star-ratings-sprite-rating"></span>
                    </div>
                </div>
                <a href="{{product_url_home($product)}}" class="price">Rs. {{number_format($product->saleprice)}}</a> </div>
        </div>
        @endforeach
    </div>
</div>
<!--END-PART-1-->
<!--PART-2-->
@if( !empty($mslider->get('smart_wearable')) )
    <?php $image = $mslider->get('smart_wearable'); ?>
    <div class="container">
        <a href="{{$image->refer_url}}" target="_blank">
            <img class="img-responsive adimg" src="{{$image->image_url}}" alt="{{$image->alt}}">
        </a>
    </div>
@endif
<div class="container">
    <h5 class="catname homehadding">Smart Wearables</h5>
    <a href="{{newUrl('electronics/smart-wearable-price-list-in-india.html')}}" class="view">View All</a></div>
<div class="fullbgpro">
    <div class="fullwidth">
        @foreach($home->block2->top_products as $key => $product )
            <div class="col-xs-6 col-sm-6">
                <div class="thumnail">
                    <div class="productbox">
                        <a href="{{product_url_home($product)}}">
                            <img class="productimg" src="{{product_image($product->image_url)}}" alt="{{$product->name}} Image">
                        </a>
                    </div>
                    <div class="productname">
                        <a href="{{product_url_home($product)}}">
                            {{$product->name}}
                        </a>
                    </div>
                    <div class="star-ratingreviews">
                        <div class="star-ratings-sprite">
                            <span style="width:52%" class="star-ratings-sprite-rating"></span>
                        </div>
                    </div>
                    <a href="{{product_url_home($product)}}" class="price">Rs. {{number_format($product->saleprice)}}</a> </div>
            </div>
        @endforeach
    </div>
</div>
<!--END-PART-2-->
<!--PART-3-->
@if( !empty($mslider->get('womens')) )
    <?php $image = $mslider->get('womens'); ?>
    <div class="container">
        <a href="{{$image->refer_url}}" target="_blank">
            <img class="img-responsive adimg" src="{{$image->image_url}}" alt="{{$image->alt}}">
        </a>
    </div>
@endif
<div class="container">
    <h5 class="catname homehadding">Women's Wear</h5>
    <a href="{{newUrl('women/clothing-price-list-in-india.html')}}" class="view">View All</a></div>
<div class="fullbgpro">
    <div class="fullwidth">
        @foreach($home->block3->top_products as $key => $product )
            <div class="col-xs-6 col-sm-6">
                <div class="thumnail">
                    <div class="productbox">
                        <a href="{{product_url_home($product)}}">
                            <img class="productimg" src="{{product_image($product->image_url)}}" alt="{{$product->name}} Image">
                        </a>
                    </div>
                    <div class="productname">
                        <a href="{{product_url_home($product)}}">
                            {{$product->name}}
                        </a>
                    </div>
                    <div class="star-ratingreviews">
                        <div class="star-ratings-sprite">
                            <span style="width:52%" class="star-ratings-sprite-rating"></span>
                        </div>
                    </div>
                    <a href="{{product_url_home($product)}}" class="price">Rs. {{number_format($product->saleprice)}}</a> </div>
            </div>
        @endforeach
    </div>
</div>
<!--END-PART-3-->
<!--PART-4-->
@if( !empty($mslider->get('headphone')) )
    <?php $image = $mslider->get('headphone'); ?>
    <div class="container">
        <a href="{{$image->refer_url}}" target="_blank">
            <img class="img-responsive adimg" src="{{$image->image_url}}" alt="{{$image->alt}}">
        </a>
    </div>
@endif
<div class="container">
    <h5 class="catname homehadding">Headphones & Headsets </h5>
    <a href="{{newUrl('mobile/headphones-headsets-price-list-in-india.html')}}" class="view">View All</a></div>
<div class="fullbgpro">
    <div class="fullwidth">
        @foreach($home->block4->top_products as $key => $product )
            <div class="col-xs-6 col-sm-6">
                <div class="thumnail">
                    <div class="productbox">
                        <a href="{{product_url_home($product)}}">
                            <img class="productimg" src="{{product_image($product->image_url)}}" alt="{{$product->name}} Image">
                        </a>
                    </div>
                    <div class="productname">
                        <a href="{{product_url_home($product)}}">
                            {{$product->name}}
                        </a>
                    </div>
                    <div class="star-ratingreviews">
                        <div class="star-ratings-sprite">
                            <span style="width:52%" class="star-ratings-sprite-rating"></span>
                        </div>
                    </div>
                    <a href="{{product_url_home($product)}}" class="price">Rs. {{number_format($product->saleprice)}}</a> </div>
            </div>
        @endforeach
    </div>
</div>
@if( !empty($mslider->get('offers')) )
    <?php $image = $mslider->get('offers'); ?>
    <div class="container">
        <a href="{{$image->refer_url}}" target="_blank">
            <img class="img-responsive adimg" src="{{$image->image_url}}" alt="{{$image->alt}}" style="padding-bottom:10px;">
        </a>
    </div>
@endif