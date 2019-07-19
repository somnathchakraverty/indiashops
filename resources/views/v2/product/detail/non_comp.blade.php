@extends('v2.master')
<?php
$product = $data->product_detail;
if (!empty(json_decode($product->image_url))) {
    $images = json_decode($product->image_url);
}

$brand_count = ( isset($data->brand_count) ) ? $data->brand_count : 0;

if (!isset($images) || !is_array($images)) {
    $images[] = getImageNew($product->image_url);
}
$prating = 3;
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

$prod = new \stdClass;
$prod->id = $pid = $product->id . '-' . $product->vendor;
$prod->cat = $product->category_id;
$prod->name = $product->name;
$prod->vendor = $product->vendor;
$prod->size = (isset($product->size)) ? $product->size : '';
$prod->color = (isset($product->color)) ? $product->color : '';
$prod->brand = (isset($product->brand)) ? $product->brand : '';
$prod->price = (isset($product->saleprice)) ? $product->saleprice : '1000';
?>
@if($detail_meta && $product->seo_title )
@section('title')
    <title>{{$product->seo_title}}</title>
    <meta itemprop="name" content="{{$product->seo_title}}">

    <meta name="twitter:title" content="{{$product->seo_title}}">
    <meta name="twitter:image:alt" content="{{$product->seo_title}}">
    <meta property="og:title" content="{{$product->seo_title}}"/>
@endsection
@section('meta_description')
    <meta name="description" content="{{$detail_meta->description}}">
@endsection
@if(isset($detail_meta->keywords))
@section('keywords')
    <meta name="keywords" content="{!! html_entity_decode($detail_meta->keywords) !!}">
@endsection
@endif
@else
@section('title')
    @include('v2.product.title', ['product' => $product ])
@endsection
@if(isset($meta) && is_object($meta))
@section('meta_description')
    <meta name="description" content="{{$meta->description}}">
@endsection
@elseif(isset($description) && !empty($description))
@section('meta_description')
    @include('v2.product.meta_description', ['product' => $product ])
@endsection
@endif
@endif
@section('meta')
    <meta itemprop="image" content="{{getImageNew($images[0],'XS')}}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@IndiaShopps">
    <meta name="twitter:creator" content="@IndiaShopps">
    <meta name="twitter:image" content="{{getImageNew($images[0],'XS')}}">
    <meta name="twitter:image:src" content="{{$images[0]}}">
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{Request::url()}}"/>
    <meta property="og:image" content="{{getImageNew($images[0],'XS')}}"/>
    <meta property="og:site_name" content="IndiaShopps | Buy | Compare Online"/>
    <meta property="fb:admins" content="100000220063668"/>
    <meta property="fb:app_id" content="1656762601211077"/>
    <link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--pd--<?=$product->id?>"/>
    <link rel="amphtml" href="{{amp_url($product)}}"/>
    <link rel="canonical"
          href="{{route('product_detail_non',[$product->grp, create_slug($product->name),$product->id, $product->vendor])}}"/>

@endsection
@section('json')
    @include('v2.product.json_ld_non_comp', ['product' => $product, 'prating'=>$prating ])
@endsection


@section('breadcrumbs')
    <section style="background-color:#fff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12"> {!! Breadcrumbs::render("p_detail",$product, $brand_count) !!} </div>
            </div>
        </div>
    </section>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 PL0">
                <div class="shadow-box">
                    <div class="col-md-6 PL0 PR0" style="border-right:1px solid #e3e3e3;">
                        <div id="sync1" class="owl-carousel"> @if(isset($images))
                                @foreach($images as $key=>$image)
                                    @if(!empty($image))
                                        <div class="item">
                                            <div class='list-group gallery'><a class="larg-box fancybox" rel="ligthbox"
                                                                               href="<?=getImageNew($image, 'L')?>">
                                                    <img src="<?=getImageNew($image, 'M')?>" class="img-responsive"
                                                         alt="<?php echo clean($product->name);?>"
                                                         title="<?php echo clean($product->name);?>"
                                                         onerror="imgError(this)"> </a></div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div id="sync2" class="owl-carousel bordertopproduct">
                            @if(isset($images))
                                @foreach( $images as $image )
                                    <div class="item">
                                        <div class='mini-list-group mini-gallery galleryproductimgnewui'><img
                                                    style="max-width:50px;" src="<?=getImageNew($image, 'XS')?>"
                                                    alt="<?php echo clean($product->name);?>"
                                                    title="<?php echo clean($product->name);?>"
                                                    onerror="imgError(this)"></div>
                                    </div>
                                @endforeach
                            @endif </div>
                        @if(isset( $product->enabled ) && $product->enabled == 0)
                            <div class="discontinue">Discontinued</div>
                        @else
                            <div class="col-md-12">
                                <a type="button" class="btn btn-danger details-btn width100per"
                                   href="<?=$product->product_url?>" out-url="<?=$product->product_url?>"
                                   onClick="ga('send', 'event', 'shop', 'click');" target="_blank" rel="nofollow">Shop Now</a>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6 PR0">
                        <div class="description">
                            @if($detail_meta && isset($detail_meta->h1))
                                <h1>{{$detail_meta->h1}}</h1>
                            @else
                                <h1>{{$product->name}}</h1>
                            @endif
                            <div class="star-rating">
                                <?php
                                $repeat = rand(3, 5);
                                $star = '<span class="fa fa-star"></span>';
                                $starb = '<span class="fa fa-star-o"></span>';

                                echo str_repeat($star, $repeat);
                                echo str_repeat($starb, (5 - $repeat));
                                ?>
                            </div>
                            <hr class="pull-left width100per" />
                            @if( ($product->track_stock == 0))
                                <h3 class="red-color">Out Of Stock</h3>
                            @elseif(isset( $product->enabled ) &&$product->enabled == 0)
                                <h3 class="red-color">DISCONTINUED !</h3>
                            @else
                                <h3 class="red-color">Rs. {{number_format($product->saleprice)}}</h3>
                                @if($product->price > 0 && $product->saleprice != $product->price)
                                    <span class="cut-price">Rs. {{number_format($product->price)}} </span>
                                @endif
                                @if($product->discount > 0)
                                    <span class="offer-price red-border">
                                        {{@$product->discount}} % OFF
                                    </span>
                                @endif
                            @endif
                            <br/>
                            <span class="pull-left"><b>FREE</b> Shipping . EMI . COD</span>
                            <div class="clearfix"></div>
                            <br/>
                            @if(!empty($product->description))
                                <div class="panel panel-default">
                                    <div class="panel-heading description-panel">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle show" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" id="accordion">Description
                                                <i class="indicator fa fa-plus pull-right" style="color:#e40046;"></i></a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse">
                                        <div class="panel-body listing-body">
                                            @if (strpos($product->description, '<a') !== false)
                                                <p>{!! preg_replace('#<a.*?>(.*?)</a>#i', '', $product->description) !!}</p>
                                            @else
                                                <p>{!! html_entity_decode($product->description) !!}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if(isset( $product->enabled ) && $product->enabled == 0)

                        @else
                            <div class="comparealllistnew">
                                <ul>
                                    <li>
                                        <div class="comsitelogonew">
                                            <img src="{{config('vendor.vend_logo.'.$product->vendor )}}" alt="{{config('vendor.name.'.$product->vendor )}} Image">
                                        </div>
                                        <div class="compricenewdetails">Rs. {{number_format($product->saleprice)}}</div>
                                        <a href="{{$product->product_url}}" out-url="<?=$product->product_url?>"
                                           onClick="ga('send', 'event', 'shop', 'click');" target="_blank"
                                           rel="nofollow" class="combutodetailsnew">Go To Store</a></li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <!--THE-PART-1-->
                @if(isset($detail_meta) && isset($detail_meta->meta))
                <div class="whitecolorbg">
                    <div class="sub-title"><span>Product Details</span></div>
                    {!! html_entity_decode($detail_meta->meta) !!}
                </div>
                @endif
                {{--Coupons Ajax Content--}}
                <div id="vendor_coupons"></div>
            </div>
            <!--END-PART-4-->
            <!--THE-RIGHT-PARAT-->
            <div class="col-md-4 PR0 PL0">
                <div class="shadow-box fix-height vertical-carousel">
                    <div class="carousel slide" data-ride="carousel" id="quote-carousel">
                        <h2>Our Offers</h2>
                        <div class="pull-right">
                            <div class="arrowfull">
                                <a data-slide="prev" href="#quote-carousel"
                                   class="left carousel-control arrow-box arrow arrow-left arrow-leftnew">
                                    <i class="fa fa-chevron-left"></i>
                                </a>
                                <a data-slide="next" href="#quote-carousel" class="right carousel-control arrow-box arrow arrow-rightnew">
                                    <i class="fa fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- Carousel Slides / Quotes -->
                        <div class="carousel-inner">
                            @include('v2.product.detail.common.offers')
                        </div>
                        <!-- Carousel Buttons Next/Prev -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div id=vuukle-emote></div>
        </div>
        <!--END-RIGHT-PARAT-->
        <div class="row">
            <!--THE-PART-5-->
            <div class="whitecolorbg">
                <div id="by-vendor-one-wrapper">
                    <div class="sub-title"><span>Similar Products on <strong>Amazon</strong></span>
                        <ul class="customNavigation">
                            <li><a class="prev prevtab"><i class="fa fa-angle-left"></i></a></li>
                            <li><a class="next"><i class="fa fa-angle-right"></i></a></li>
                        </ul>
                    </div>
                    <div id="by-vendor-one"></div>
                </div>
            </div>
            <!--END-PART-5-->
            <!--THE-PART-6-->
            <div class="whitecolorbg">
                <div id="by-vendor-two-wrapper">
                    <div class="sub-title"><span>Similar Products on <strong>Flipkart</strong></span>
                        <ul class="customNavigation">
                            <li><a class="prev prevtab"><i class="fa fa-angle-left"></i></a></li>
                            <li><a class="next"><i class="fa fa-angle-right"></i></a></li>
                        </ul>
                    </div>
                    <div id="by-vendor-two"></div>
                </div>
            </div>
            <div>
                <div class="col-md-12 PL0 PR0 MB15">
                    <!--Image style for local server-->
                    <a href="https://chrome.google.com/webstore/detail/indiashopps/pgoackgjjkpbkjoomkklkofbhpkbeboc"
                       target="_blank"> <img src="{{asset('assets/v2/')}}/images/banner.jpg" class="img-responsive"> </a></div>
            </div>
            <div class="whitecolorbg">
                <div id="by-brand-wrapper">
                    <div class="sub-title"><span>Similar Products</span>
                        <ul class="customNavigation">
                            <li><a class="prev prevtab"><i class="fa fa-angle-left"></i></a></li>
                            <li><a class="next"><i class="fa fa-angle-right"></i></a></li>
                        </ul>
                    </div>
                    <div id="by-brand"></div>
                </div>
            </div>
            <div class="whitecolorbg">
                <div id="by-saleprice-wrapper">
                    <div class="sub-title"><span>Popular Products</span>
                        <ul class="customNavigation">
                            <li><a class="prev prevtab"><i class="fa fa-angle-left"></i></a></li>
                            <li><a class="next"><i class="fa fa-angle-right"></i></a></li>
                        </ul>
                    </div>
                    <div id="by-saleprice"></div>
                </div>
            </div>
            <div id=vuukle_div></div>
        </div>
        <!--END-PART-6-->
    </div>
@endsection
@section('script')
    <style>
        .discontinue {
            position: absolute;
            background: #e40046;
            padding: 10px;
            font-size: 30px;
            color: #FFF;
            z-index: 9;
            top: 25%;
            left: -1%;
            transform: skewY(-20deg);
            width: 100%;
            text-align: center
        }
    </style>
    <script src="<?=asset("/assets/v2/js/source/jquery.fancybox.pack.js")?>"></script>
    <script src="{{asset('assets/v2/')}}/js/product_detail.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=asset("/assets/v2/js/source/jquery.fancybox.css")?>"/>
    <script>
        var isExitPopupPage = true;
        var product = '{{Crypt::encrypt($prod)}}';
        var page = 'non_comp';

        $(document).ready(function () {

            function toggleChevron(e) {
                $(e.target)
                        .prev('.panel-heading')
                        .find("i.indicator")
                        .toggleClass('fa-toggle-on');
            }

            $('#accordion').on('hidden.bs.collapse', toggleChevron);
            $('#accordion').on('shown.bs.collapse', toggleChevron);
            $("a[rel='ligthbox']").fancybox();
        });

        var form_data = {_token: '{{csrf_token()}}', product: '{{Crypt::encrypt($prod)}}'};
        CONTENT.uri = "{{route("detail-ajax")}}";
        CONTENT.pid = '{{$pid}}';
        CONTENT.load("by-saleprice", true, form_data);
        CONTENT.load("by-brand", true, form_data);

        @if(!empty($prod->color))
            CONTENT.load("by-color", true, form_data);
        @endif

        CONTENT.load("vendor_coupons", false, form_data);

        <?php $prod->vendor = 3 ?>
        form_data.product = '{{Crypt::encrypt($prod)}}';
        CONTENT.load("by-vendor-one", true, form_data);
        <?php $prod->vendor = 1 ?>
        form_data.product = '{{Crypt::encrypt($prod)}}';
        CONTENT.load("by-vendor-two", true, form_data);
    </script>
    @include('v2.product.detail.common.vuukle')
@endsection