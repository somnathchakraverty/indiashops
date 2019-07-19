@extends('v2.master')
<?php
$product = $data->product_detail;
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

$prod = new \stdClass;
$prod->id = $pid = $product->id;
$prod->name = $product->name;
$prod->image = $product->image_url;
$prod->cat = $product->category_id;
$prod->size = (isset($product->size)) ? $product->size : '';
$prod->color = (isset($product->cvariant)) ? $product->cvariant : '';
$prod->brand = (isset($product->brand)) ? $product->brand : '';
$prod->price = (isset($product->saleprice)) ? $product->saleprice : '1000';
$prod->vendor = $product->lp_vendor;
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
            <div class="col-md-8 PL0">
                <div class="shadow-box">
                    <div class="col-md-6 PL0 PR0" style="border-right:1px solid #e3e3e3;">
                        <div id="sync1" class="owl-carousel"> @if(isset($images))
                                @foreach($images as $key=>$image)
                                    @if(!empty($image))
                                        <div class="item">
                                            <div class='list-group gallery'>
                                                <a class="larg-box fancybox" rel="ligthbox"
                                                   href="<?=getImageNew($image, 'L')?>">
                                                    <img src="<?=getImageNew($image, 'M')?>" class="img-responsive"
                                                         alt="<?php echo clean($product->name);?>"
                                                         title="<?php echo clean($product->name);?>"
                                                         onerror="imgError(this)">
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif </div>
                        <div id="sync2" class="owl-carousel bordertopproduct">
                            @if(isset($images))
                                @foreach( $images as $image )
                                    <div class="item">
                                        <div class='mini-list-group mini-gallery galleryproductimgnewui'>
                                            <img style="max-width:50px;max-height:103px;"
                                                 src="<?=getImageNew($image, 'XS')?>"
                                                 alt="<?php echo clean($product->name);?>"
                                                 title="<?php echo clean($product->name);?>" onerror="imgError(this)">
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="col-md-12">
                            @if(isset($data->product_detail->specification) && !empty($data->product_detail->specification) )
                                <a type="button" class="btn btn-success details-btn width48p ssmooth"
                                   href="#specifications">
                                    Features
                                </a>
                            @endif
                            @if(count($vendors)>0)
                                <a type="button" class="btn btn-danger details-btn width48p"
                                   href="{{$vendors[0]->_source->product_url}}" target="_blank">Buy Now</a>
                            @endif
                        </div>
                        <div class="col-md-12 PL0 PR0 MT10"> Tags:
                            @foreach(explode(" ",$product->tags) as$tag)
                                <span class="tag1">{{ucfirst($tag)}}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6 PR0">
                        <div class="description">
                            @if($detail_meta && isset($detail_meta->h1))
                                <h2>{{$detail_meta->h1}}</h2>
                            @else
                                <h2>{{$product->name}}</h2>
                            @endif
                            <a href="#" class="pull-left"><i class="fa fa-star rating" aria-hidden="true"></i></a>
                            <a href="#" class="pull-left"><i class="fa fa-star rating" aria-hidden="true"></i></a>
                            <a href="#" class="pull-left"><i class="fa fa-star rating" aria-hidden="true"></i></a>
                            {{--<a href="#" class="pull-left">(3.9 out of 5 from 5408 ratings)</a>
                            <a href="#" class="pull-left red-color setpricealertdetails">
                                <i class="fa fa-bell" aria-hidden="true"></i> Set Price Alert
                            </a>--}}
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
                            @if($product->price > 0)
                                <span class="cut-price">Rs. {{number_format($product->price, 2)}} </span>
                            @endif
                            @if($product->discount > 0)
                                <span class="offer-price red-border">{{@$product->discount}}% OFF</span>
                            @endif
                            <span><b>FREE</b> Shipping . EMI . COD</span>
                            <div class="gray-box">
                                <ul class="mini_description">
                                    {!! getMiniSpec($product->mini_spec) !!}
                                </ul>
                            </div>
                        </div>
                        <div class="comparealllistnew">
                            @if(isset($data->product_detail->specification) && !empty($data->product_detail->specification) )
                                <a href="#specifications" class="seefulllink ssmooth">See Full Specs</a>
                            @endif
                            @if(isset($vendors) && count($vendors)>0)
                                <ul>
                                    @foreach( $vendors as $key => $v )
                                        <?php $vendor = $v->_source; ?>
                                        <li>
                                            <div class="comsitelogonew">
                                                <img src="{{config('vendor.vend_logo.'.$vendor->vendor )}}"
                                                     class="img-responsive" alt="logo">
                                            </div>
                                            <div class="compricenewdetails">
                                                Rs.{{number_format($vendor->saleprice)}}</div>
                                            @if($vendor->track_stock==0)
                                                <a target="_blank" href="javascript:;" rel="nofollow"
                                                   class="combutodetailsnew">Out Of Stock</a>
                                            @else
                                                <a target="_blank" href="{{$vendor->product_url}}"
                                                   onClick="ga('send', 'event', 'shop', 'click');" rel="nofollow"
                                                   class="combutodetailsnew">Go To Store</a>
                                            @endif
                                        </li>
                                        @if($key >= 3)
                                            <?php break; ?>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                            @if(count($vendors) > 4 )
                                <div class="col-md-12 PL0 PR0 text-center">
                                    <a href="#comparelist" class="more-store ssmooth">
                                        available in {{count($vendors)-4}} More Store(s)
                                        <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if(isset($detail_meta) && isset($detail_meta->meta))
                    <div class="sub-title"><span>{{$product->name}} Details</span></div>
                    <div class="shadow-box min-hight484" style="padding:0px;" id="description">
                        <div class="bs-example" data-example-id="striped-table">
                            <table>
                                {!! html_entity_decode($detail_meta->meta) !!}
                            </table>
                        </div>
                    </div>
                @elseif(!empty($data->product_detail->description))
                    <div class="sub-title"><span>{{$product->name}} Details</span></div>
                    <div class="shadow-box min-hight484" style="padding:0px;" id="description">
                        <div class="bs-example" data-example-id="striped-table">
                            <table>
                                {!! $data->product_detail->description !!}
                            </table>
                        </div>
                    </div>
                @endif
                @if(isset($vendors) && count($vendors)>0)
                    <section id="comparelist">
                        <div class="whitecolorbg min-hight484">
                            <div class="sub-title"><span>Compare Price</span></div>
                            <div class="bs-example" data-example-id="striped-table" id='comp_vendors'>
                                @include('v2.product.detail.common.vendors')
                            </div>
                        </div>
                    </section>
                @endif
                @if(isset($data->product_detail->specification) && !empty($data->product_detail->specification) )
                    <section id="specifications">
                        <div class="whitecolorbg">
                            <div class="sub-title"><span>{{$product->name}} SPECIFICATIONS</span></div>
                            <div class="bs-example" data-example-id="striped-table" id="specification">
                                <div class="more-toggledetailstable">
                                    @include('v2.product.detail.common.specifications')
                                </div>
                                <a class="toggle-btndetails" id="toggle-btntable"> Show More
                                <span class="glyphicon glyphicon-chevron-down chevron-downshow"
                                      aria-hidden="true"></span>
                                </a>
                            </div>
                        </div>
                    </section>
                @endif
                <div id="mobile_reviews"></div>
                <div id="mobile_qa"></div>
                @if(isset($detail_meta->video_url))
                    <div id="product_video">
                        {!! youTubePlayer($product->name, $detail_meta->video_url) !!}
                    </div>
                @endif
                <div id="vendor_coupons"></div>
                <div id="add_compare"></div>
                <div id="vs_compare"></div>
                <div id="snippets"></div>
            </div>
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
                                <a data-slide="next" href="#quote-carousel"
                                   class="right carousel-control arrow-box arrow arrow-rightnew">
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
                @if(isset($custom_links) && count($custom_links) > 0 )
                    <div id="feature_block_1">
                        <div class="sub-title MT5"><span>Featured Links</span></div>
                        <div class="shadow-box vertical-carousel">
                            <div class="panel panel-default" style=" margin-bottom: 10px;border: none;">
                                <?php $i = 1; ?>
                                <ul class="best_phones_under">
                                    @foreach($custom_links as $t => $l)
                                        <li>
                                            <a href="{{$l}}" target="_blank">{{$t}}</a>
                                        </li>
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
                @if(isset($custom_links) && count($custom_links) > 0 )
                    <div id="feature_block_2">
                        <div class="sub-title MT5"><span>Featured Links</span></div>
                        <div class="shadow-box vertical-carousel">
                            <div class="panel panel-default" style="margin-bottom: 10px;border: none;">
                                <ul class="best_phones_under">
                                    @foreach($custom_links as $t => $l )
                                        <li>
                                            <a href="{{$l}}" target="_blank">{{$t}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div id=vuukle-emote></div>
        </div>
        <div class="row">
            <div class="col-md-12 PL0 PR0">
                <div id="by-saleprice-wrapper">
                    <div class="sub-title"><span>Popular Mobiles</span>
                        <ul class="customNavigation">
                            <li><a class="prev prevtab"><i class="fa fa-angle-left"></i></a></li>
                            <li><a class="next"><i class="fa fa-angle-right"></i></a></li>
                        </ul>
                    </div>
                    <div id="by-saleprice" class="owl-carousel owl-theme" style="opacity: 1; display: block;"></div>
                </div>
                <div class="col-md-12 PL0 PR0">
                    <div id="by-saleprice"></div>
                </div>
            </div>
        </div>
        <div id=vuukle_div></div>
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

        .coupon a.get-code {
            text-decoration: none
        }

        ul.best_phones_under {
            padding: 0px;
        }

        .best_phones_under li {
            list-style: none;
        }

        .highlight {
            border-bottom: 3px double red;
            color: #D30900;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
    <script src="{{asset("/assets/v2/js/source/jquery.fancybox.pack.js")}}"></script>
    <script src="{{asset('assets/v2/')}}/js/product_detail.js"></script>
    <link rel="stylesheet" type="text/css" href="{{asset("/assets/v2/js/source/jquery.fancybox.css")}}"/>
    <script>
        var isExitPopupPage = true;
        var product = '{{$prod}}';

        $('[data-toggle="tooltip"]').tooltip();
        $(document).on('click', '#toggle-btntable', function () {
            if ($('.more-toggledetailstable ').hasClass('show')) {
                $('.more-toggledetailstable ').removeClass('show');
                $(this).html("Show More");
                $('html, body').animate({
                    scrollTop: $("#specification").offset().top - 20
                }, 100);
            }
            else {
                $('.more-toggledetailstable ').addClass('show');
                $(this).html("Show Less");
            }
        });
        $(document).ready(function () {
            function toggleChevron(e) {
                $(e.target)
                        .prev('.panel-heading')
                        .find("i.indicator")
                        .toggleClass('fa-toggle-on');
            }

            $(document).on('click', '.get-code', function () {
                var data = $(this).attr('data');
                data = atob(data);

                setCookie('selected_coupon', data, 1);
                window.open($(this).attr('out-url'));
                window.location = $(this).attr('href');
                return false;
            });

            $('#accordion').on('hidden.bs.collapse', toggleChevron);
            $('#accordion').on('shown.bs.collapse', toggleChevron);
            $("a[rel='ligthbox']").fancybox();
        });

        var form_data = {_token: '{{csrf_token()}}', product: '{{$prod}}'};
        CONTENT.uri = "{{route("detail-ajax")}}";
        CONTENT.pid = '{{$pid}}';
        CONTENT.load("by-saleprice", true, form_data);

        CONTENT.uri = "{{route("mobile-detail-ajax")}}";
        CONTENT.load("vendor_coupons", false, form_data);
        CONTENT.load("vs_compare", false, form_data);
        CONTENT.load("mobile_reviews", false, form_data);
        CONTENT.load("mobile_qa", false, form_data);
        CONTENT.load("snippets", false, form_data);
        CONTENT.load("add_compare", false, form_data, function () {
            refresh_compare_list()
        });
    </script>
    @if( env('APP_ENV') == 'production' )
        @include('v2.product.detail.common.vuukle')
    @endif
@endsection