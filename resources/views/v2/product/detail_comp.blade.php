@extends('v2.master')
<?php
$product = $data->product_detail;
if (strpos($product->image_url, ',') !== false && (strpos($product->image_url, '"]') === false)) {
    $product->image_url = explode(",", $product->image_url);
    $product->image_url = str_replace('"', '', $product->image_url[0]);
}

$brand_count = (isset($data->brand_count)) ? $data->brand_count : 0;

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
$prod->cat = $product->category_id;
$prod->size = (isset($product->size)) ? $product->size : '';
$prod->color = (isset($product->cvariant)) ? $product->cvariant : '';
$prod->brand = (isset($product->brand)) ? $product->brand : '';
$prod->price = (isset($product->saleprice)) ? $product->saleprice : '1000';
$prod = Crypt::encrypt(($prod));
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
    <meta name="twitter:image:src" content="{{getImageNew($images[0],'XS')}}">
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{Request::url()}}"/>
    <meta property="og:image" content="{{getImageNew($images[0],'XS')}}"/>
    <meta property="og:site_name" content="IndiaShopps | Buy | Compare Online"/>
    <meta property="fb:admins" content="100000220063668"/>
    <meta property="fb:app_id" content="1656762601211077"/>
    <link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--pd--<?=$product->id?>"/>
    <link rel="amphtml" href="{{amp_url($product)}}"/>
    <link rel="canonical" href="{{route('product_detail_v2',[create_slug($product->name),$product->id])}}"/>


@endsection
@section('json')
    @include('v2.product.json_ld', ['product' => $product,'vendors' => $vendors,'prating'=>$prating ])
@endsection
@section('breadcrumbs')
    <section style="background-color:#fff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12"> {!! Breadcrumbs::render("p_detail_new",$product, $brand_count) !!} </div>
            </div>
        </div>
    </section>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 PL0 nopadding" id="left_content">
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
                            @endif </div>
                        <div id="sync2" class="owl-carousel bordertopproduct"> @if(isset($images))
                                @foreach( $images as $image )
                                    <div class="item">
                                        <div class='mini-list-group mini-gallery galleryproductimgnewui'><img
                                                    style="max-width:50px;max-height:103px;"
                                                    src="<?=getImageNew($image, 'XS')?>"
                                                    alt="<?php echo clean($product->name);?>"
                                                    title="<?php echo clean($product->name);?>"
                                                    onerror="imgError(this)"></div>
                                    </div>
                                @endforeach
                            @endif </div>
                        @if(isset( $product->enabled ) && $product->enabled == 0)
                            <div class="discontinue">Discontinued</div>
                        @elseif(isset($product->product_url))
                            <div class="col-md-12">
                                <a class="btn btn-danger details-btn width48p" href="{{$product->product_url}}"
                                   target="_blank" onClick="ga('send', 'event', 'shop', 'click');" rel="nofollow"
                                   style="background:#4CAF50;">Buy Now</a>
                                <a class="btn btn-danger details-btn width48p" href="#specifications">Features</a></div>
                        @endif
                        {{--@if(isset($vendors) && count($vendors)>0)
                        <div class="col-md-12 PL0 PR0 text-center"> <a href="#vendors" class="more-store">Available in {{count($vendors)}} More Store <i class="fa fa-angle-double-right" aria-hidden="true"></i></a> </div>
                        @endif--}}
                        <div class="MT15"> Tags:
                            @foreach(explode(" ",$product->tags) as$tag) <a href="#"><span
                                        class="tag1">{{ucfirst($tag)}}</span></a> @endforeach </div>
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
                                <div class="fullboxprice">
                                    <div class="priceboxleft"> @endif
                                        <hr class="pull-left width100per"/>
                                        @if($product->saleprice > 0)
                                            <h3 class="red-color">Rs. {{number_format($product->saleprice)}}</h3>
                                        @endif
                                        @if(isset( $product->enabled ) && $product->enabled == 0)
                                            <h3 class="red-color">Discountinued !</h3>
                                        @endif
                                        @if( ($product->track_stock == 0))
                                            <h3 class="red-color">Out Of Stock</h3>
                                        @endif
                                        @if(!empty($product->availability) && $product->availability != "NULL")
                                            <h3 class="red-color">{{$product->availability}}</h3>
                                        @endif
                                        @if($product->price > 0) <span
                                                class="cut-price">Rs. {{number_format($product->price, 2)}} </span> @endif
                                        @if($product->discount > 0) <span class="offer-price red-border">{{@$product->discount}}
                                            % OFF</span> @endif <span class="pull-rightcod"><b>FREE</b> Shipping . EMI . COD</span>
                                    </div>
                                    @if($product->lp_vendor > 0)
                                        <div class="logoshoppingsiteboxright">
                                            <div class="logositename">
                                                <p class="normaltext">Lowest Price On:</p>
                                                <a href="{{$product->product_url}}" target="_blank"
                                                   onClick="ga('send', 'event', 'shop', 'click');" rel="nofollow">
                                                    <img src="{{config('vendor.vend_logo.'.$product->lp_vendor )}}"
                                                         alt="{{config('vendor.name.'.$product->lp_vendor )}}"
                                                         style="max-width:120px;margin-top:4px; max-height:50px;"/>
                                                </a>
                                            </div>
                                        </div>
                                    @endif </div>
                                <div class="gray-box">
                                    <ul class="mini_description">
                                        {!! getMiniSpec($product->mini_spec) !!}
                                    </ul>
                                </div>
                        </div>
                        @if(isset($product->specification) && !empty($product->specification))
                            <div class="panel panel-default">
                                <div class="panel-heading description-panel">
                                    <h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse"
                                                               data-parent="#accordion" href="#collapseOne">
                                            Specification <i class="indicator fa fa-plus pull-right"
                                                             style="color:#e40046;"></i> </a></h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in">
                                    <div class="panel-body listing-body">
                                        @if (strpos($product->specification, 'src') !== false || strpos($product->specification, 'href') !== false)
                                            <p>{!! preg_replace('#<a.*?>(.*?)</a>#i', '', $product->specification) !!}</p>
                                        @else
                                            <p>{!! html_entity_decode($product->specification) !!}</p>
                                        @endif
                                        <p><a class="ssmooth" href="#specifications">More...</a></p>
                                    </div>
                                </div>
                            </div>
                        @endif </div>
                </div>
                <link href="{{asset('assets/v2/')}}/css/font-awesome.min.css" rel="stylesheet">
                @if(isset($vendors) && count($vendors)>0)
                    <div class="sub-title"><span>Compare Price</span></div>
                    <div class="shadow-box min-hight484" style="padding:0px;">
                        <div class="bs-example" data-example-id="striped-table">
                            <table class="table table-striped">
                                <tbody>
                                @foreach( $vendors as $v )
                                    <?php $vendor = $v->_source; ?>
                                    <tr>
                                        <td>
                                            <img style="width:60px;"
                                                 src="{{config('vendor.vend_logo.'.$vendor->vendor )}}">
                                        </td>
                                        @if( !empty($vendor->emiAvailable) )
                                            <td class="emitext">EMI: <b>Yes</b></td>
                                        @else
                                            <td class="emitext">EMI: <b>No</b></td>
                                        @endif
                                        <td>
                                            @if(!empty($vendor->delivery) && $vendor->delivery != "NULL")
                                                Delivery: {{$vendor->delivery}} @endif
                                            <span class="dis-inher">
                                                Color:
                                                @foreach(explode(";",trim($vendor->color,'"')) as $color)
                                                    <span class="store_color {{str_slug($color)}}"
                                                          title="{{ucwords($color)}}">
                                                    </span>
                                                @endforeach
                                            </span>
                                        </td>
                                        <td>
                                            <b class="sub-title1">Rs. {{number_format($vendor->saleprice)}}</b>
                                            <span class="dis-inher font-12">
                                                <b class="red-color">FREE</b> Shipping
                                            </span>
                                        </td>
                                        <td> @if($vendor->track_stock==0) Out Of Stock @else In Stock @endif</td>
                                        <td>
                                            <a class="btn btn-danger details-btn" target="_blank"
                                               out-url="{{$vendor->product_url}}" href="{{$vendor->product_url}}"
                                               onClick="ga('send', 'event', 'shop', 'click');" rel="nofollow">
                                                SHOP NOW
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                        <div class="chromeextension">
                            <a href="https://chrome.google.com/webstore/detail/indiashopps/pgoackgjjkpbkjoomkklkofbhpkbeboc"
                               target="_blank"> <img src="{{asset('assets/v2/')}}/images/comp847x100.jpg"
                                                     class="img-responsive">
                            </a>
                        </div>
                    </div>
                @endif
                <div id="by-brand-wrapper" style="display:none">
                    <div class="sub-title"><span>Product By Brand</span>
                        <ul class="customNavigation">
                            <li><a class="prev prevtab"><i class="fa fa-angle-left"></i></a></li>
                            <li><a class="next"><i class="fa fa-angle-right"></i></a></li>
                        </ul>
                    </div>
                    <div id="by-brand" class="owl-carousel owl-theme"></div>
                    <div id="specifications">&nbsp;</div>
                </div>
                @if(!empty($data->product_detail->specification))
                    <div class="sub-title" id=""><span>Specifications</span></div>
                    <div class="shadow-box min-hight484" style="padding:0px;">
                        <div class="bs-example" data-example-id="striped-table">
                            <table>
                                {!! $data->product_detail->specification !!}
                            </table>
                        </div>
                    </div>
                @endif
                @if(isset($detail_meta) && isset($detail_meta->meta))
                    <div class="sub-title"><span>Description</span></div>
                    <div class="shadow-box min-hight484" style="padding:0px;" id="description">
                        <div class="bs-example" data-example-id="striped-table">
                            <table>
                                {!! html_entity_decode($detail_meta->meta) !!}
                            </table>
                        </div>
                    </div>
                @elseif(!empty($data->product_detail->description))
                    <div class="sub-title"><span>Description</span></div>
                    <div class="shadow-box min-hight484" style="padding:0px;" id="description">
                        <div class="bs-example" data-example-id="striped-table">
                            <table>
                                {!! $data->product_detail->description !!}
                            </table>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-4 PR0 PL0">
                <div class="shadow-box fix-height vertical-carousel">
                    <div class="carousel slide" data-ride="carousel" id="quote-carousel">
                        <h2>Top Offers</h2>
                        <div class="pull-right">
                            <a data-slide="prev" href="#quote-carousel"
                               class="left carousel-control arrow-box arrow arrow-left">
                                <i style="background:#e40046;padding:5px;color:#FFFFFF;" class="fa fa-chevron-left"></i>
                            </a>
                            <a data-slide="next" href="#quote-carousel" class="right carousel-control arrow-box arrow">
                                <i style="background:#e40046;padding:5px;color:#FFFFFF;margin-left:-20px;"
                                   class="fa fa-chevron-right"></i>
                            </a>
                        </div>
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
                                                    <div class="gray-border shadow-box MT0 boxsizefixed">
                                                        <div class="center-item"><a href="{{product_url($pro)}}"> <img
                                                                        style="width:65px; max-height:120px;"
                                                                        alt="100%x200"
                                                                        src="{{getImageNew($product->image_url,'S')}}"
                                                                        class="img-responsive"/> </a></div>
                                                        <aside class="PT15 ML0 contbottomfixed"><a
                                                                    href="{{product_url($pro)}}"
                                                                    class="font-12 contnormelrightpart"> {{$product->name}} </a>
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
                <!-- Carousel Buttons Next/Prev -->
            </div>
        </div>
        <div class="row">
            <div id=vuukle-emote></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 PL0 PR0">
            <div id="by-saleprice-wrapper" style="display:none">
                <div class="sub-title"><span>Matching Products</span>
                    <ul class="customNavigation">
                        <li><a class="prev prevtab"><i class="fa fa-angle-left"></i></a></li>
                        <li><a class="next"><i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </div>
                <div id="by-saleprice" class="owl-carousel owl-theme"></div>
            </div>
        </div>
        <div id=vuukle_div></div>
    </div>
    </div>
    </div>
@endsection
@section('script')
    <style>
        .discontinue { position: absolute; background: #e40046; padding: 10px; font-size: 30px; color: #FFF; z-index: 9; top: 25%; left: -1%; transform: skewY(-20deg); width: 100%; text-align: center }
        #left_content { display: inline-block !important; }
    </style>
    <script src="{{asset("/assets/v2/js/source/jquery.fancybox.pack.js")}}"></script>
    <script src="{{asset('assets/v2/')}}/js/product_detail.js"></script>
    <link rel="stylesheet" type="text/css" href="{{asset("/assets/v2/js/jquery.fancybox.css")}}"/>
    <script>
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

        var form_data = {_token: '{{csrf_token()}}', product: '{{$prod}}'};
        CONTENT.uri = "{{route("detail-ajax")}}";
        CONTENT.pid = '{{$pid}}';
        CONTENT.load("by-saleprice", true, form_data);
        CONTENT.load("by-brand", true, form_data);
    </script>
    @include('v2.product.detail.common.vuukle',['product'=> $main_product])
@endsection