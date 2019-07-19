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
            <div class="col-md-9 PL0">
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
                                <a type="button" class="btn btn-success details-btn width100per"
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
                            @if(!empty($prating))
                                <div class="star_rating_out" title="Rating: (<?=$prating?>/5)">
                                    <div class="star_rating_in" style="width:<?=($prating / 5) * 100?>%"
                                         rate="<?=$prating?>"></div>
                                </div>
                                <div class="fullboxprice" style="border:none;">
                                    <div class="priceboxleft"> @endif
                                        {{--<a href="#" product_id="{{$product->id}}" class="pull-right red-color"><i class="fa fa-bell" aria-hidden="true"></i> Set Price Alert</a>--}}
                                        <hr class="pull-left width100per">
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
                                        {{--<span class="pull-right"><b>FREE</b> Shipping . EMI . COD</span>--}} </div>
                                    @if(isset( $product->enabled ) && $product->enabled == 0)

                                    @else
                                        <div class="logoshoppingsiteboxright">
                                            <div class="logositename">
                                                <p class="normaltext">Lowest Price On:</p>
                                                <a href="{{$product->product_url}}" out-url="<?=$product->product_url?>"
                                                   onClick="ga('send', 'event', 'shop', 'click');" target="_blank"
                                                   rel="nofollow">
                                                    <img src="{{config('vendor.vend_logo.'.$product->vendor )}}"
                                                         alt="config('vendor.name.'.$product->vendor )"
                                                         style="max-width:120px;margin-top:4px; max-height:50px;"/></a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                        </div>
                        @if(!empty($product->description))
                            <div class="panel panel-default">
                                <div class="panel-heading description-panel">
                                    <h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse"
                                                               data-parent="#accordion" href="#collapseOne"
                                                               id="accordion">Description <i
                                                    class="indicator fa fa-plus pull-right" style="color:#e40046;"></i></a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse">
                                    <div class="panel-body listing-body">
                                        @if(!(isset($detail_meta) && isset($detail_meta->meta)))
                                            @if (strpos($product->description, 'src') !== false)
                                                <p>{!! preg_replace('#<a.*?>(.*?)</a>#i', '\1', $product->description) !!}</p>
                                            @else
                                                <p>{!! html_entity_decode($product->description) !!}</p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                    @endif
                        <div class="MT15"> Tags:
                            @foreach(explode(" ",$product->tags) as$tag) <a href="#"><span
                                        class="tag1">{{ucfirst($tag)}}</span></a> @endforeach </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 PR0 PL0">
                <div class="shadow-box fix-height2 vertical-carousel">
                    <div class="carousel slide" data-ride="carousel" id="quote-carousel">
                        <h2>Our Offers</h2>
                        <div class="pull-right"><a data-slide="prev" href="#quote-carousel"
                                                   class="left carousel-control arrow-box arrow arrow-left noncom-arrow-left"><i
                                        style="background:#e40046;padding:5px;color:#FFFFFF;"
                                        class="fa fa-chevron-left"></i></a> <a data-slide="next" href="#quote-carousel"
                                                                               class="right carousel-control arrow-box arrow"><i
                                        style="background:#e40046;padding:5px;color:#FFFFFF;margin-left:-20px;"
                                        class="fa fa-chevron-right"></i></a></div>
                        <!-- Carousel Slides / Quotes -->
                        <div class="carousel-inner">
                            <?php $index = 0 ?>
                            <?php $product = $data->similar_prod->hits->hits; ?>
                            @foreach($product as $pro)
                                <?php $product = $pro->_source; $index++; ?>
                                @if( ($index)%6 == 1 )
                                    <div class="item {{( $index == 1) ? 'active' : '' }}"> @endif
                                        @if( ($index)%2 == 1 )
                                            <div class="row"> @endif
                                                <div class="col-sm-6">
                                                    <div class="gray-border shadow-box MT0 boxsizefixednoncomp">
                                                        <div class="center-item"><a href="{{product_url($pro)}}"> <img
                                                                        style="height:50px;" alt="{{$product->name}}"
                                                                        title="{{$product->name}}"
                                                                        src="{{getImageNew($product->image_url,'S')}}"/>
                                                            </a></div>
                                                        <aside class="PT15 ML0 contbottomfixed"><a target="_blank"
                                                                                                   title="{{$product->name}}"
                                                                                                   href="{{product_url($pro)}}"
                                                                                                   class="font-12 contnormelrightpart contnormelrightpartnoncomp"> {{truncate($product->name,20)}} </a>
                                                            <div class="phoneratting2">
                                                                <div class="star-rating"><span class="fa fa-star"
                                                                                               data-rating="1"></span>
                                                                    <span class="fa fa-star" data-rating="2"></span>
                                                                    <span class="fa fa-star" data-rating="3"></span>
                                                                    <span class="fa fa-star" data-rating="4"></span>
                                                                    <span class="fa fa-star-o" data-rating="5"></span>
                                                                </div>
                                                            </div>
                                                            <span class="price font-12">Rs.{{number_format($product->saleprice)}}</span>
                                                        </aside>
                                                    </div>
                                                </div>
                                                @if( ($index)%2 == 0 ) </div>
                                        @endif
                                        @if( ($index)%6 == 0 ) </div>
                                @endif
                            @endforeach
                            @if( ($index)%2 != 0) </div>
                        @endif
                        @if( ($index)%6 != 0) </div>
                @endif
                <!-- Carousel Buttons Next/Prev -->
                </div>
            </div>
            <!--image hight for local test-->
        </div>
    </div>
    <link href="{{asset('assets/v2/')}}/css/font-awesome.min.css" rel="stylesheet">
    <div class="row">
        <div id="by-color-wrapper" style="display:none">
            <div class="col-md-6 PL0">
                <div class="sub-title MT10"><span>By Color </span>
                    <ul class="customNavigation">
                        <li><a class="prev prevtab"><i class="fa fa-angle-left"></i></a></li>
                        <li><a class="next"><i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </div>
                <div id="by-color" class="owl-carousel owl-theme"></div>
            </div>
        </div>
        <div id="by-size-wrapper" style="display:none">
            <div class="col-md-6 PL0 PR0 ">
                <div class="sub-title MT10"><span>By Size</span>
                    <ul class="customNavigation">
                        <li><a class="prev prevtab"><i class="fa fa-angle-left"></i></a></li>
                        <li><a class="next"><i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </div>
                <div id="by-size" class="owl-carousel owl-theme"></div>
            </div>
        </div>
    </div>
    @if(isset($detail_meta) && isset($detail_meta->meta))
        <div class="sub-title"><span>Description</span></div>
        <div class="shadow-box min-hight484" style="padding:0px;" id="description">
            <div class="bs-example" data-example-id="striped-table">
                <table>
                    {!! html_entity_decode($detail_meta->meta) !!}
                </table>
            </div>
        </div>
    @endif
    <div id="by-brand-wrapper" style="display:none">
        <div class="row">
            <div class="col-md-12 PL0 PR0">
                <div class="sub-title"><span>By Brands</span>
                    <ul class="customNavigation">
                        <li><a class="prev prevtab"><i class="fa fa-angle-left"></i></a></li>
                        <li><a class="next"><i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </div>
                <div id="by-brand" class="owl-carousel owl-theme"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 PL0 PR0 MB15">
            <!--Image style for local server-->
            <a href="https://chrome.google.com/webstore/detail/indiashopps/pgoackgjjkpbkjoomkklkofbhpkbeboc"
               target="_blank"> <img src="{{asset('assets/v2/')}}/images/banner.jpg" class="img-responsive"> </a></div>
    </div>
    <div id="by-saleprice-wrapper" style="display:none">
        <div class="row">
            <div class="col-md-12 PL0 PR0">
                <div class="sub-title"><span>Matching Products</span>
                    <ul class="customNavigation">
                        <li><a class="prev prevtab"><i class="fa fa-angle-left"></i></a></li>
                        <li><a class="next"><i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </div>
                <div id="by-saleprice" class="owl-carousel owl-theme"></div>
            </div>
        </div>
    </div>
    </div>
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

        @if(!empty($prod->size))
            CONTENT.load("by-size", true, form_data);
        @endif
        @if(!empty($prod->color))
            CONTENT.load("by-color", true, form_data);
        @endif
    </script>
@endsection