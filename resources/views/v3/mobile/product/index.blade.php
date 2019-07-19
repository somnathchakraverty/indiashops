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
$prod->meta = (isset($product->meta)) ? $product->meta : '';

$prod = Crypt::encrypt(($prod));
?>
<style>
    .simpleLens-container { width: 75%; float: right; position: relative; height: 370px; }
    .simpleLens-big-image-container { display: table-cell; vertical-align: middle; text-align: center; position: relative; height: 375px; width: 100% }
    .simpleLens-big-image { max-width: 255px; max-height: 340px }
    .simpleLens-lens-image { height: auto !important; width: 260px; height: 400px; display: inline-block; text-align: center; margin: 0; box-shadow: none; float: none; position: relative }
    .simpleLens-mouse-cursor { /*background:#CCC;*/ opacity: .2; /*filter:alpha(opacity = 20);*/ position: absolute; top: 0; left: 0; /*border:1px solid #999;box-shadow:0 0 2px 2px #999;cursor:crosshair;*/ }
    .simpleLens-lens-element { background: #FFF; left: 108%; overflow: hidden; position: absolute; top: 3px; width: 880px; height: 495px; z-index: 9999; text-align: center; display:none;}
    .simpleLens-lens-element img { position: relative; top: 0; left: 0; width: auto !important; max-width: none !important }
    .simpleLens-thumbnails-container { float: left; width: 50px; margin: 10px }
    .simpleLens-thumbnails-container a { display: inline-block }
    .simpleLens-thumbnails-container a img { display: block }
    .simpleLens-thumbnail-wrapper { width: 50px; height: 50px; border: 1px solid #e4e4e4; overflow: hidden; border-radius: 4px; text-align: center; align-items: center; display: flex !important; overflow: hidden; justify-content: center; margin-top: 10px; overflow: hidden }
    .thumbnailgallerysmalimg { max-width: 41px !important; max-height: 40px !important }
    .carousel-inner.vertical { max-height: 375px !important; margin-top: 20px; }
    @media all and (transform-3d),(-webkit-transform-3d) {
        .carousel-inner.vertical > .item { -webkit-transition: -webkit-transform .6s ease-in-out; -o-transition: -o-transform .6s ease-in-out; transition: transform .6s ease-in-out; -webkit-backface-visibility: hidden; backface-visibility: hidden; -webkit-perspective: 1000; perspective: 1000px }
        .carousel-inner.vertical > .item.next, .carousel-inner.vertical > .item.active.right { -webkit-transform: translate3d(0, 33.33%, 0); transform: translate3d(0, 33.33%, 0); top: 0 }
        .carousel-inner.vertical > .item.prev, .carousel-inner.vertical > .item.active.left { -webkit-transform: translate3d(0, -33.33%, 0); transform: translate3d(0, -33.33%, 0); top: 0 }
        .carousel-inner.vertical > .item.next.left, .carousel-inner.vertical > .item.prev.right, .carousel-inner.vertical > .item.active { -webkit-transform: translate3d(0, 0, 0); transform: translate3d(0, 0, 0); top: 0 }
    }
    #carousel-pager .carousel-control.left { width: 70px; top: 24px; position: absolute; color: #000; font-size: 15px }
    #carousel-pager .carousel-control.right { top: -2px; width: 55px; position: relative; color: #000; font-size: 15px }
</style>
<section>
    <div class="container">
        {!! Breadcrumbs::render() !!}
    </div>
</section>
<section>    
    <div class="whitecolorbg" id="Overview">
    <div id="mytabproduct">
        <div class="container">
            <div class="product-tabs">
                <ul class="tabsproduct" id="goto_section">
                    <li class="tab"><a class="activetoptab" href="#Overview">Overview</a></li>
                    @if(isset($page_type) && $page_type == "comparative" )
                        <li class="tab" id="price_nav">
                            <a href="#pricepart">Prices</a>
                        </li>
                        @if(isset($product->specification) && !empty($product->specification))
                            <li class="tab">
                                <a href="#Specs">Specs</a>
                            </li>
                        @endif
                        @if(isset($expert_data) && is_array($expert_data))
                            <li class="tab">
                                <a href="#ExpertReviewsTop">Expert Reviews</a>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </div>
        <div class="container">
            <div class="headdingcat">
                <h1>{!! app('seo')->getHeading() !!}</h1>
            </div>
            <div class="productdetailsheadding">
                <div class="prodtailspagerating">
                    <div class="star-ratings-sprite"><span style="width:100%" class="star-ratings-sprite-rating"></span>
                    </div>
                </div>
                <div class="revietext">(4.2)</div>
            </div>
            <div class="normelcont">{!! app('seo')->getShortDescription() !!}</div>
            <div class="pricehaddingpro">
                <h2>{{ $product->name }} Price</h2>
            </div>
            <div class="productimgdetailsbox">
                <div class="simpleLens-gallery-container" id="demo-1">
                    <div class="simpleLens-container">
                        <div class="simpleLens-big-image-container">
                            <a class="simpleLens-lens-image" data-lens-image="{{getImageNew($images[0],"S")}}"><img src="{{getImageNew($images[0],"M")}}" class="simpleLens-big-image"></a>
                        </div>
                    </div>
                    <div id="carousel-pager" class="carousel slide " data-ride="carousel" data-interval="500000000">
                        <div class="simpleLens-thumbnails-container">
                            <div id="slider3">
                                <div class="thumbelina-but vert top">
                                    <span class="protoparo"></span>
                                </div>
                                <ul>
                                    @foreach($images as $key => $image)
                                        <li>
                                            <a href="javascript:void" class="simpleLens-thumbnail-wrapper" data-lens-image="{{getImageNew($image,"L")}}" data-big-image="{{getImageNew($image,"L")}}">
                                                <img class="thumbnailgallerysmalimg" src="{{getImageNew($image,"XXS")}}">
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="thumbelina-but vert bottom">
                                    <span class="probottaro"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @if(isset($product->excerpt) && !empty($product->excerpt))
                    <div class="highlightspoint more_content_wrapper" id="specifications">
                        <div class="more-less-product1">
                            <p>
                                {!! $product->excerpt !!}
                            </p>
                        </div>
                        <a href="javascript:void" class="moreproduct">Read More <span>&raquo;</span></a>
                    </div>
                @endif

                <div class="productpricelast">
                    <div class="lastprice">best price<span>Rs {{number_format($product->saleprice)}}</span></div>
                    <a href="#pricepart" class="lastpricevanderbutton">
                        @if(isComingSoon($product))
                            Coming Soon
                        @else
                            Check Prices
                        @endif
                        <span class="right-arrow left10"></span>
                    </a>
                </div>
            </div>       
        </div>
    </div>
</section>
<!--END-PART-1-->

<!--THE-PART-2-->
@if(isset($product->description) && !empty($product->description))
    <section>
        <div class="whitecolorbg">
            <div class="container more_content_wrapper">
            <h2>{{$product->name}} Detail</h2>
                <div id="specifications">
                    <div class="more-less-product1">
                        <p>
                            {!! html_entity_decode($product->description) !!}
                        </p>
                    </div>
                </div>
                <a href="javascript:void" class="moreproduct">Read More <span>&raquo;</span></a>
            </div>
        </div>
    </section>
@endif
<!--END-PART-2-->

<!--THE-PART-3-->
<div id="product_vendor_wrapper">
    <div id="product_vendor"></div>
</div>
<!--END-PART-3-->

<!--THE-PART-4-->
@if(isset($product->specification) && !empty($product->specification))
    <section id="Specs">
        <div class="whitecolorbg" id="specificationstable">
            <div class="container">
            <h2>Specification of {{$product->name}}</h2>
                <div class="productdetailstable more_content_wrapper">
                    <div class="more-less-product1">
                        @if(stripos($product->specification, "spec_ttle") === false && stripos($product->specification, "spec_des") === false)                          
                                {!! (isset($product->specification)) ? $product->specification : '' !!}                           
                        @else
                            {!! (isset($product->specification)) ? $product->specification : '' !!}
                        @endif

                    </div>
                  
                        <a class="toggle-btndetails moreproduct allcateglink" data="VIEW Full specs <span>&raquo;</span>">
                            VIEW Full specs <span>&raquo;</span>
                        </a>
                   
                </div>
            </div>
        </div>
    </section>
@endif
<!--END-PART-4-->
@if(isset($expert_data) && is_array($expert_data))
    <section id="ExpertReviewsTop">
        <div class="whitecolorbg" id="reviews">
            <div class="container">
             <h2>Expert Reviews</h2>
                <div class="tabreviews">
                    @foreach($expert_data as $key => $data)
                        <div class="part1">
                            <div class="accordionItem {{ ($key==0) ? 'open' : 'close'}}">
                                <div class="accordionItemHeading">{!! $data->title !!}
                                    <img class="arrow-filter" src="{{asset('assets/v3/mobile')}}/images/arrow-filter.png" alt="arrow-filter">
                                </div>
                                <div class="accordionItemContent more_content_wrapper">
                                    <div class="normelcont">
                                        <div class="more-less-product1">
                                            <p>{!! $data->content !!}</p>
                                            <a href="javascript:void" class="moreproduct" id="toggle-btndetails5">Read
                                                More <span>&raquo;</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
@if(isPricelist($product->category_id))
    <div id="mobile_reviews"></div>
    <div id="compare_filters"></div>
@endif

<!--THE-PART-8-->
<div id="deals_on_phone">
    
</div>
<!--END-PART-8-->

<!--THE-PART-9-->
@if(isComparativeProduct($product))
    <div id="category_accessories">
        
    </div>
@else
    <div id="by_vendor_one_wrapper">
        <div class="whitecolorbg">
            <div class="container more_content_wrapper">
            <h2>Similar Product From Amazon</h2>
                <div id="by_vendor_one"></div>
            </div>
        </div>
    </div>
    <div id="by_vendor_two_wrapper">
        <div class="whitecolorbg">
            <div class="container more_content_wrapper">
            <h2>Similar Product From Flipkart</h2>
                <div id="by_vendor_two"></div>
            </div>
        </div>
    </div>
    <div id="by_brand_wrapper">
        <div class="whitecolorbg">
            <div class="container more_content_wrapper">
             <h2>Similar Product By Brand</h2>
                <div id="by_brand"></div>
            </div>
        </div>
    </div>
@endif
@if( isset($product->lp_vendor) )
    <?php $vendor = $product->lp_vendor ?>
@elseif(isset($product->vendor))
    <?php
    if (is_array($product->vendor)) {
        $vendor = collect($product->vendor)->first();
    } else {
        $vendor = $product->vendor;
    }
    ?>
@else
    <?php $vendor = false ?>
@endif

@if($vendor)
    <tabloans class="show">
        <div class="loanstabbg">
            <ul>
                <a href="{{$product->product_url}}" target="_blank" class="productbutton buyorangebutton">
                    BUY FROM {{config('vendor.name.'.$vendor)}}
                </a>
            </ul>
        </div>
    </tabloans>
@endif
<!--END-PART-9-->
<style>
.tab.nbs-flexisel-item{width:68px!important;}
</style>
<script type="text/javascript" src="{{get_file_url('mobile/js/front.js')}}" async></script>
<script type="text/javascript" src="{{asset('assets/v3/mobile')}}/js/product/jquery.simpleGallery.js"></script>
<script type="text/javascript" src="{{asset('assets/v3/mobile')}}/js/product/jquery.simpleLens.js"></script>
<script type="text/javascript" src="{{asset('assets/v3/mobile')}}/js/thumbelina.js"></script>
<script>
    $(function () {
        $('#demo-1 .simpleLens-thumbnails-container img').simpleGallery({
            loading_image: '{{asset('assets/v3/mobile')}}/images/loading.gif'
        });

        $('#demo-1 .simpleLens-big-image').simpleLens({
            loading_image: '{{asset('assets/v3/mobile')}}/images/loading.gif'
        });

        $('#slider3').Thumbelina({
            orientation: 'vertical',
            $bwdBut: $('#slider3 .top'),
            $fwdBut: $('#slider3 .bottom')
        });
        $(".moreproduct").on('click', function () {
            var element = $(this).closest('.more_content_wrapper').find('.more-less-product1');

            if (element.hasClass('show')) {
                element.removeClass('show');

                if (typeof $(this).attr('data') != "undefined") {
                    $(this).html($(this).attr('data'));
                }
                else {
                    $(this).html("Read More <span>&raquo;</span>");
                }
            }
            else {
                element.addClass('show');
                $(this).html("Show Less <span>&raquo;</span>");
            }
        });

        $(document).on('click', '#toggle-btndetails4', function () {
            if ($('.more-less-product4').hasClass('show')) {
                $('.more-less-product4').removeClass('show');
                $(this).html("VIEW ALL Prices <span>&raquo;</span>");

                $('html, body').animate({
                    scrollTop: $("#specificationsprice").offset().top - 20
                }, 100);
            }
            else {
                $('.more-less-product4').addClass('show');
                $(this).html("Show Less <span>&raquo;</span>");
            }
        });

        var accItem = document.getElementsByClassName('accordionItem');
        var accHD = document.getElementsByClassName('accordionItemHeading');
        for (i = 0; i < accHD.length; i++) {
            accHD[i].addEventListener('click', toggleItem, false);
        }
        function toggleItem() {
            var itemClass = this.parentNode.className;
            for (i = 0; i < accItem.length; i++) {
                accItem[i].className = 'accordionItem close';
            }
            if (itemClass == 'accordionItem close') {
                this.parentNode.className = 'accordionItem open';
            }
        }

        var form_data = {_token: '{{csrf_token()}}', product: '{{$prod}}'};
        var stickOffset;

        CONTENT.uri = '{{route('detail-ajax-v3')}}';

        @if(isComparativeProduct($product))
            CONTENT.f(true).load('mobile_reviews', true, form_data);
        CONTENT.f(true).load('category_accessories', true, form_data);

        @else
            CONTENT.f(true).load('by_vendor_one', true, form_data);
        CONTENT.f(true).load('by_vendor_two', true, form_data);
        CONTENT.f(true).load('by_brand', true, form_data);
        @endif

        CONTENT.load('deals_on_phone', true, form_data);
        CONTENT.f(true).load('product_vendor', false, form_data);
        var home_ajax_url = '{{route('v3_ajax_home')}}';
        CONTENT.uri = home_ajax_url;
        /*CONTENT.load('deals_on_phone', true);*/
        CONTENT.uri = '{{route('detail-ajax-v3')}}';
    });
    function product_vendor_callback() {
        if ($("#product_vendor").html() == "") {
            $("#price_nav").remove();
        }
    }
</script>
<script>
    window.onscroll = function () {myFunction()};

    var header = document.getElementById("mytabproduct");
    var sticky = header.offsetTop;

    function myFunction() {
        if (window.pageYOffset >= sticky) {
            header.classList.add("sticky");
        } else {
            header.classList.remove("sticky");
        }
    }
</script>
<script>
    $("a[href^='#']").click(function (e) {
        e.preventDefault();
        var position = $($(this).attr("href")).offset().top;
        $("body, html").animate({
            scrollTop: position
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(document).on("scroll", onScroll);

        //smoothscroll
        $('a[href^="#"]').on('click', function (e) {
            e.preventDefault();
            $(document).off("scroll");

            $('a').each(function () {
                $(this).removeClass('activetoptab');
            })
            $(this).addClass('activetoptab');

            var target = this.hash,
                    menu = target;
            $target = $(target);
            $('').stop().animate({
                'scrollTop': $target.offset().top + 2
            }, 500, 'swing', function () {
                window.location.hash = target;
                $(document).on("scroll", onScroll);
            });
        });

        $("#goto_section").flexisel({
            infinite: false,
            visibleItems: 3.5,
            itemsToScroll: 1,
            responsiveBreakpoints: {
                portrait: {
                    changePoint: 480,
                    visibleItems: 3.5,
                    itemsToScroll: 1
                },
                landscape: {
                    changePoint: 640,
                    visibleItems: 4,
                    itemsToScroll: 3
                },
            }
        });
    });
    function onScroll(event) {
        var scrollPos = $(document).scrollTop();
        $('#menu-center a').each(function () {
            var currLink = $(this);
            var refElement = $(currLink.attr("href"));
            if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
                $('#menu-center ul li a').removeClass("activetoptab");
                currLink.addClass("activetoptab");
            }
            else {
                currLink.removeClass("activetoptab");
            }
        });
    }
</script>
<script>
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var topnavbarHeight = $('header').outerHeight();
    var bottomnavbarHeight = $('tabloans').outerHeight();
    $(window).scroll(function (event) {
        didScroll = true;
    });
    setInterval(function () {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 250);
    function hasScrolled() {
        var st = $(this).scrollTop();
        if (Math.abs(lastScrollTop - st) <= delta)
            return;
        if (st > lastScrollTop && st > topnavbarHeight) {
            // Scroll Down
            $('header1').removeClass('show').addClass('hide');
            $('tabloans').removeClass('show').addClass('hide');
        } else {
            // Scroll Up
            if (st + $(window).height() < $(document).height()) {
                $('header1').removeClass('hide').addClass('show');
                $('tabloans').removeClass('hide').addClass('show');
            }
        }
        lastScrollTop = st;
    }
</script>