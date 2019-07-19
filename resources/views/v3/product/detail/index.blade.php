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
$prod->name = $product->name;
$prod->image = $images[0];
$prod->mini_spec = (isset($product->mini_spec)) ? $product->mini_spec : '';
$prod->size = (isset($product->size)) ? $product->size : '';
$prod->color = (isset($product->cvariant)) ? $product->cvariant : '';
$prod->brand = (isset($product->brand)) ? $product->brand : '';
$prod->price = (isset($product->saleprice)) ? $product->saleprice : '1000';
$prod->old_price = (isset($product->price)) ? $product->price : 0;
$prod->meta = (isset($product->meta)) ? $product->meta : '';
$prod = Crypt::encrypt(($prod));
?>
@extends('v3.master')
@section('opengraph')
    <meta name="robots" content="index, follow"/>
    <meta name="author" content="IndiaShopps"/>
    <meta itemprop="image" content="{{getImageNew($images[0],'XS')}}">
    <meta itemprop="name" content="{!! app('seo')->getTitle() !!}">
    <meta name="twitter:title" content="{!! app('seo')->getTitle() !!}">
    <meta name="twitter:image:alt" content="{!! app('seo')->getTitle() !!}">
    <meta property="og:title" content="{!! app('seo')->getTitle() !!}"/>
    <meta name="twitter:image" content="{{getImageNew($images[0],'XS')}}">
    <meta name="twitter:image:src" content="{{getImageNew($images[0],'XS')}}">
    <meta property="og:type" content="article"/>
    <meta property="og:image" content="{{getImageNew($images[0],'XS')}}"/>
    <link rel="amphtml" href="{{amp_url($product)}}"/>
@endsection
@section('page_content')
    <section>
        <div class="container">
            {!! Breadcrumbs::render('p_detail', $product, $brand_count) !!}
        </div>
    </section>  
        <div class="container">            
                <h1>{!! app('seo')->getHeading() !!}</h1>          
            <div class="prodtpgrat">
                <div class="str-rtg">
                    <?php $rating = (isset($product->rating) ? (int)$product->rating : rand(1, 5)); ?>
                    <?php $rating = ($rating > 0) ? $rating : rand(1, 5) ?>
                    <span style="width:{{percent($rating,5)}}%" class="str-ratg"></span>
                </div>
            </div>
            <div class="revietext">({{$rating}})</div>
            <div class="ratrevtxt">
                {{--<ul>
                    <li>331 Rating</li>
                    <li>30 Reviews</li>
                    <li>1 Selfie</li>
                    <li class="border">Have a Question?</li>
                </ul>--}}
            </div>
            <div class="normelcont">{!! app('seo')->getShortDescription() !!}</div>
            <div class="maskbox">
                <div class="col-md-4 pleft proimgdebox">                   
                        <div class="sigllcon" id="demo-1">
                            <div class="simcon">
                                <div class="simbgimcon">
                                    <a class="simleim" data-lens-image="{{getImageNew($images[0],"L")}}">
                                        <img src="{{getImageNew($images[0],"M")}}" class="simpbgim" alt="product images">
                                    </a>
                                </div>
                            </div>
                            <div id="carousel-pager" class="carousel slide " data-ride="carousel" data-interval="500000000">
                                <div class="simthucon">
                                    <div class="carousel-inner vertical">
                                        @foreach($images as $key => $image)
                                            <div class="item {{($key==0) ? 'active' : ''}}">
                                                <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="{{getImageNew($image,"L")}}" data-big-image="{{getImageNew($image,"L")}}">
                                                    <img class="thugllimg" src="{{getImageNew($image,"XXS")}}" alt="product images">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <a class="left carousel-control" href="#carousel-pager" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span> </a>
                                    <a class="right carousel-control" href="#carousel-pager" role="button" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span> </a></div>
                            </div>
                        </div>
                        @if( isset($product->availability) && $product->availability == 'Coming Soon' )
                            <div class="prprias">
                                <span class="laprivanbutt">Coming Soon</span>
                            </div>
                        @else
                            @if($product->track_stock != 0)
                                <div class="prprias">
                                    <div class="lastprice">Rs {{number_format($product->saleprice)}}</div>
                                    <?php
                                    if (isset($product->lp_vendor)) {
                                        $vendor = $product->lp_vendor;
                                    } else {
                                        if (is_array($product->vendor)) {
                                            $vendor = collect($product->vendor)->first();
                                        } else {
                                            $vendor = $product->vendor;
                                        }
                                    }
                                    ?>
                                    @if(!empty($vendor))
                                        <a href="{{$product->product_url}}" target="_blank" class="laprivanbutt" onClick="ga('send', 'event', 'shop', 'click');" rel="nofollow">
                                            Buy from {{config('vendor.name.'.$vendor)}}
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @endif
                  
                </div>
                <div class="col-md-8 pright">
                    <div class="prdefull">
                        <h2>{{ $product->name }} Price</h2>
                        <p>
                            @if(isset($product->excerpt))
                                {!! truncate_html($product->excerpt,200) !!}
                            @endif
                        </p>
                        <div class="proprbox">
                            @if($product->track_stock != 0)
                                <div class="pricopt">
                                    <div class="col-md-3 pleft">
                                        <div class="bestprice">best price</div>
                                        <div class="pricetext">Rs {{number_format($product->saleprice)}}</div>
                                    </div>
                                    @if( isset($product->cvariant) )
                                        <?php $product->cvariant = trim($product->cvariant, ']') ?>
                                        <?php $product->cvariant = trim($product->cvariant, '[') ?>
                                        <?php $colors = explode(":", $product->cvariant)?>
                                        <div class="col-md-3 pleft">
                                            <div class="bestprice">Color</div>
                                            @foreach($colors as $color)
                                                <div class="{{create_slug($color)}}-color" title="{{$color}}"></div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="col-md-6 pleft">
                                        <div class="bestprice"></div>
                                        <div class="sizeslist">
                                            {{--<ul>
                                                <li><a href="#" class="current">16GB</a></li>
                                                <li><a href="#">32GB</a></li>
                                                <li><a href="#">64GB</a></li>
                                                <li><a href="#">128GB</a></li>
                                            </ul>--}}
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="pricopt">
                                <?php
                                if (isset($product->lp_vendor)) {
                                    $vendor = $product->lp_vendor;
                                } else {
                                    if (is_array($product->vendor)) {
                                        $vendor = collect($product->vendor)->first();
                                    } else {
                                        $vendor = $product->vendor;
                                    }
                                }
                                ?>
                                @if(!empty($vendor))
                                    <div class="col-md-2 pleft">
                                        <div class="vendorlogo">
                                            @if( isset($product->availability) && $product->availability == 'Coming Soon' )
                                                <span class="productgoto">Coming Soon</span>
                                            @else
                                                <img src="{{config('vendor.vend_logo.'.$vendor )}}" alt="vendor logo">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 pleft">
                                        &nbsp;
                                    </div>
                                    <div class="col-md-3 pleft">
                                        @if( isset($product->availability) && $product->availability == 'Coming Soon' )
                                            <span rel="nofollow" class="productgoto">Coming Soon</span>
                                        @else
                                            <div class="flprice">Rs {{number_format($product->saleprice)}}</div>
                                        @endif
                                    </div>
                                @endif
                                <div class="col-md-3 pleft">
                                    <div class="flbutton">
                                        @if(!empty( $product->product_url ) && $product->track_stock == 1)
                                            <a href="{{$product->product_url}}" class="productgoto" target="_blank" onClick="ga('send', 'event', 'shop', 'click');" rel="nofollow">go
                                                to store</a>
                                        @endif
                                        @if($product->track_stock == 0)
                                            <a rel="nofollow" class="productgoto">OUT OF STOCK</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if(isComparativeProduct($product) && isset($product->availability) && $product->availability != 'Coming Soon')
                                <a href="#all_stores" class="more-stores" style="display:none"><span id="vendor_count"></span>More
                                    Stores
                                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                                </a>
                            @endif
                        </div>
                        @if(isComparativeProduct($product) && isset($product->mini_spec))
                            <div class="highlights">
                                <h4>highlights</h4>
                                <ul>
                                    {!! miniSpecDetail($product->mini_spec, 10, '&raquo;') !!}
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Tab panes -->
            </div>
        </div>
        @if( isComparativeProduct($product) )
            <div class="container">
                <div class="comparison" id="all_stores">{{$product->name}} Price Comparison</div>
                <div class="comparisontable">
                    <div class="bs-example" data-example-id="condensed-table" id="product_vendor"></div>
                </div>
            </div>
        @endif

        @if( isset($product->availability) && $product->availability == 'Coming Soon' || !isComparativeProduct($product) )
            <?php $cols = '12' ?>
        @else
            <?php $cols = '9' ?>
        @endif
        <section id="specifications">
            <div class="container">
                <div class="col-md-{{$cols}} pleft specificationpadd">
                    @if((isset($product->specification) && !empty($product->specification)))
                        <h2>Specification and features of {{$product->name}}</h2>
                        <div class="comparisontable">
                            <div class="more-less-toggledetails">
                                @if(isset($product->specification))
                                    @if(stripos($product->specification, "spec_ttle") === false && stripos($product->specification, "spec_des") === false)
                                        <table>
                                            {!! $product->specification !!}
                                        </table>
                                    @else
                                        {!! $product->specification !!}
                                    @endif
                                @endif
                                <div class="disclaimer">Disclaimer: We cannot guarantee the information is 100%
                                    accurate.
                                </div>
                                <div class="report">
                                    <span>Error?</span><a href="/contact-us?report={{base64_encode('Product Reported. PID:- '.$product->id)}}">Report
                                        to us
                                        <span class="glyphicon glyphicon-menu-right arrow" aria-hidden="true"></span></a>
                                </div>
                            </div>
                            <a class="toggle-btndetails" id="toggle-btndetails">View More</a>
                        </div>
                    @endif
                    @if( isset($product->description) && !empty($product->description) )
                        <div class="comparison">{{$product->name}} Details</div>
                        <div class="comparisontable">
                            {!! html_entity_decode($product->description) !!}
                        </div>
                    @endif
                    @if(isset($expert_data) && is_array($expert_data))
                        <div class="comparison">Expert Reviews</div>
                        <div class="comparisontable">
                            @foreach($expert_data as $data)
                                <div class="spec_box">
                                    <div class="spcsLeft"><span class="specHead">{!! $data->title !!}</span></div>
                                    <div class="reviewscont">{!! $data->content !!}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if(isset($faqs) && is_array($faqs))
                        <div class="comparison">{{ucwords($product->name)}} - Questions And Answers</div>
                        <div class="comparisontable">
                            @foreach($faqs as $faq)
                                <div class="spec_box">
                                    <div class="question">
                                        <h3><b>Q. </b>{{$faq->question}}</h3>
                                    </div>
                                    <div class="answer">
                                        {{$faq->answer}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if(isComparativeProduct($product))
                        <div id="mobile_reviews"></div>
                        <div id="compare_filters"></div>
                    @endif
                </div>
                @if(isComparativeProduct($product))
                    <div class="col-md-3 pright">
                        @if( !isComingSoon($product) )
                            <div class="sidebar sticky" id="all_store_wrapper">
                                <div class="sidebarprodbox">
                                    <div class="stickyproimg">
                                        <img class="stickyproimgsize" src="{{getImageNew($images[0],"XXS")}}" alt="productimg">
                                    </div>
                                    <div class="stickyproname">{{$product->name}}</div>
                                </div>
                                <span id="all_store_price"></span>
                                <a href="#all_stores" class="stickybutton">VIEW ALL Stores</a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </section>
        <section id="deals_on_phone_wrapper">
            <div class="container">
                <div class="trendingdeals">
                    <?php $Category = \indiashopps\Category::find($product->category_id); ?>
                    <h2>Top deals on {{ucwords($product->category)}}</h2>
                    <div class="expcat mtop10">
                        <a href="{{getCategoryUrl($Category)}}">VIEW ALL {{$Category->name}}
                            <span class="glyphicon glyphicon-menu-right arrow" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
                <div id="deals_on_phone"></div>
            </div>
        </section>
        @if(isComparativeProduct($product))
            <section id="category_accessories_wrapper" class="sticky-stopper">
                <div class="container">
                    <div class="trendingdeals">
                        <h2>Top Deals on Accessories</h2>
                    </div>
                    <div id="category_accessories"></div>
                </div>
            </section>
        @else
            <section id="by_vendor_one_wrapper" class="sticky-stopper">
                <div class="container">
                    <div class="trendingdeals">
                        <h2>Similar Product From Amazon</h2>
                    </div>
                    <div id="by_vendor_one"></div>
                </div>
            </section>
            <section id="by_vendor_two_wrapper" class="sticky-stopper">
                <div class="container">
                    <div class="trendingdeals">
                        <h2>Similar Product From Flipkart</h2>
                    </div>
                    <div id="by_vendor_two"></div>
                </div>
            </section>
            <section id="by_brand_wrapper" class="sticky-stopper">
                <div class="container">
                    <div class="trendingdeals">
                        <h2>Similar Product By Brand</h2>
                    </div>
                    <div id="by_brand"></div>
                </div>
            </section>
        @endif
   
@endsection
@section('scripts')
    <script>
        var load_image = "<?=get_file_url('images/loader.gif')?>";
        var target = '{{route('compare_competitors')}}';
        var form_data = {_token: '{{csrf_token()}}', product: '{{$prod}}'};
        var stickOffset;
    </script>
    <link type="text/css" rel="stylesheet" href="{{get_file_url('css/jquery.simpleLens.css')}}">
    <script src="{{get_file_url('js')}}/jquery.nanoscroller.js" async></script>
    <script src="{{get_file_url('js')}}/jquery.simpleGallery.js" defer></script>
    <script src="{{get_file_url('js')}}/jquery.simpleLens.js" defer></script>
    <script src="{{get_file_url('js')}}/jquery.flexisel.js" defer onload="loadCarousel()"></script>
    <script src="{{get_file_url('js')}}/productdetail.js" defer></script>
    <script src="{{get_file_url('js/front.js')}}" defer onload="frontJsLoaded()"></script>
    <script>

        function frontJsLoaded() {
            var interval = setInterval(function () {
                if (typeof $ != "undefined") {
                    CONTENT.uri = '{{route('detail-ajax-v3')}}';
                    CONTENT.f(true).load('product_vendor', false, form_data, process_vendor());

                    @if(isComparativeProduct($product))
                        CONTENT.f(true).load('mobile_reviews', true, form_data);
                    CONTENT.f(true).load('category_accessories', true, form_data);
                    CONTENT.f(true).load('compare_filters', true, form_data, function () {
                        check_products_compare();
                    });
                    @else
                        CONTENT.f(true).load('by_vendor_one', true, form_data);
                    CONTENT.f(true).load('by_vendor_two', true, form_data);
                    CONTENT.f(true).load('by_brand', true, form_data);
                    @endif
                    CONTENT.load('deals_on_phone', true, form_data);

                    var home_ajax_url = '{{route('v3_ajax_home')}}';
                    CONTENT.uri = home_ajax_url;

                    CONTENT.uri = '{{route('detail-ajax-v3')}}';

                    ListingPage.model.extra['product'] = '{{$prod}}';

                    clearInterval(interval);
                }
            }, 500);
        }

        document.addEventListener('jquery_loaded', function (e) {
            var $sticky = $('.sticky');
            var $stickyrStopper = $('.sticky-stopper');
            if (!!$sticky.offset()) {

                stickOffset = 0;
                var generalSidebarHeight = $sticky.innerHeight();
                var stickyTop = $sticky.offset().top;
                var stickyStopperPosition = $stickyrStopper.offset().top;
                var stopPoint = stickyStopperPosition - generalSidebarHeight - stickOffset;
                var diff = stopPoint + stickOffset;

                $(window).scroll(function () {
                    var windowTop = $(window).scrollTop();

                    if (stopPoint + stickOffset < windowTop) {
                        $sticky.css({position: 'absolute', top: diff});
                    } else if (stickyTop + stickOffset < windowTop) {
                        $sticky.css({position: 'fixed', top: 0});
                    } else {
                        $sticky.css({position: 'absolute', top: 'initial'});
                    }
                });

                $(document).on('show.bs.dropdown', function () {
                    $('#overlay-list').toggleClass("menu-open");
                });
                $(document).on('hide.bs.dropdown', function () {
                    $('#overlay-list').toggleClass("menu-open");
                });
            }

            $(document).on('click', '#toggle-btndetails', function () {
                if ($('.more-less-toggledetails').hasClass('show')) {
                    $('.more-less-toggledetails').removeClass('show');
                    $(this).html("Show More");

                    $('html, body').animate({
                        scrollTop: $("#specifications").offset().top - 20
                    }, 100);
                }
                else {
                    $('.more-less-toggledetails').addClass('show');
                    $(this).html("Show Less");
                }
            });

            var interval = setInterval(function () {
                if (typeof $ != "undefined") {
                    $('#demo-1 .simthucon img').simpleGallery({
                        loading_image: 'images/loading.gif'
                    });

                    $('#demo-1 .simpbgim').simpleLens({
                        loading_image: 'images/loading.gif'
                    });
                    clearInterval(interval);
                }
            }, 500);

            $('.carousel .vertical .item').each(function () {
                var next = $(this).next();
                if (!next.length) {
                    next = $(this).siblings(':first');
                }
                next.children(':first-child').clone().appendTo($(this));

                for (var i = 1; i < 5; i++) {
                    next = next.next();
                    if (!next.length) {
                        next = $(this).siblings(':first');
                    }

                    next.children(':first-child').clone().appendTo($(this));
                }
            });
        });

        function loadCarousel() {
            $("#flexisel-compare1").flexisel({
                infinite: false,
                itemsToScroll: 3,
                visibleItems: 3,
            });
        }

        function process_vendor(html) {
            var vendor_wrapper = $("#product_vendor");
            setTimeout(function () {
                var html = $(vendor_wrapper.html());

                if (vendor_wrapper.html().length == 0) {
                    $("#all_store_wrapper").hide();
                    return false;
                }

                var price_html = '';

                $.each(html.find('tbody tr'), function (key, tr) {
                    var img = $($(tr).find('.vendorlogoimg')).attr('src');
                    var price = $($(tr).find('.flprice')).text();
                    var url = $($(tr).find('.productgoto')).attr('href');

                    price_html += '<a href="' + url + '" target="_blank">';
                    price_html += '<div class="pricopt">';
                    price_html += '<div class="col-md-6 pleft">';
                    price_html += '<div class="vendorlogo">';
                    price_html += '<img class="vendorlogosize" src="' + img + '">';
                    price_html += '</div>';
                    price_html += '</div>';
                    price_html += '<div class="col-md-6 pleft">';
                    price_html += '<div class="stickyprice">' + price;
                    price_html += '<span class="glyphicon glyphicon-menu-right stickyarrow" aria-hidden="true"></span>';
                    price_html += '</div>';
                    price_html += '</div>';
                    price_html += '</div>';
                    price_html += '</a>';

                    if (key >= 3) {
                        return false;
                    }
                });

                var vendor_count = parseInt(html.find('tbody tr').length - 1);

                $("#all_store_price").html(price_html);

                if (vendor_count > 0) {
                    $("#vendor_count").html(vendor_count + "+ ");
                    $(".more-stores").fadeIn();
                }

                stickOffset = $("#product_vendor").height();
            }, 2000);
        }

        function change_min_max_price(min, max) {
            ListingPage.model.vars.min_price = min;
            ListingPage.model.vars.max_price = max;
        }
    </script>
    <style>
        .overlay_list { position: absolute; width: 100%; height: 100%; background: rgba(255, 43, 0, .4); left: 0; top: 0; z-index: 99 }
        .center { position: absolute; height: 50px; top: 50%; left: 50%; margin-left: -50px; margin-top: -25px }
        ​.overlay_list .loader { height: 20px; width: 250px }
        .overlay_list .loader--dot { animation-name: loader; animation-timing-function: ease-in-out; animation-duration: 3s; animation-iteration-count: infinite; height: 20px; width: 20px; border-radius: 100%; background-color: #000; position: absolute; border: 2px solid #fff }
        .overlay_list .loader--dot:first-child { background-color: #8cc759; animation-delay: .5s }
        .overlay_list .loader--dot:nth-child(2) { background-color: #8c6daf; animation-delay: .4s }
        .overlay_list .loader--dot:nth-child(3) { background-color: #ef5d74; animation-delay: .3s }
        .overlay_list .loader--dot:nth-child(4) { background-color: #f9a74b; animation-delay: .2s }
        .overlay_list .loader--dot:nth-child(5) { background-color: #60beeb; animation-delay: .1s }
        .overlay_list .loader--dot:nth-child(6) { background-color: #fbef5a; animation-delay: 0 }
        @keyframes loader {
            15%, 95% { transform: translateX(0) }
            45%, 65% { transform: translateX(230px) }
        }
        div#appliedFilter { background: #fff; width: auto; overflow: hidden }
        div#appliedFilter.applied { padding: 10px; margin-top: 83px }
        .fltr-remove { margin-left: 5px; background: #c7003d; padding: 5px 10px; color: #fff }
        h4, .h4 { font-size: 16px; font-weight: bold; padding-top: 15px; }
        .checkbox.features label { width: 100%; }
    </style>
@endsection