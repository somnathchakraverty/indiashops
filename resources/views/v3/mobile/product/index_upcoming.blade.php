<?php
if (strpos($product->image_url, ',') !== false && (strpos($product->image_url, '"]') === false)) {
    $product->image_url = explode(",", $product->image_url);
    $product->image_url = str_replace('"', '', $product->image_url[0]);
}

$brand_count = (isset($brand_count)) ? $brand_count : 0;

if (!empty(json_decode($product->image_url))) {
    $images = json_decode($product->image_url);
} else {
    $images[] = $product->image_url;
}
if (!is_array($images)) {
    $images[] = getImageNew($product->image_url);
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
$main_product = clone $product;

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
@extends("v3.mobile.master")
@section('seo_meta')
    @if(shouldNotIndex($product))
        <meta name="robots" content="noindex, nofollow"/>
    @else
        <meta name="robots" content="index, follow"/>
    @endif
    <meta name="author" content="IndiaShopps"/>
    <link rel="amphtml" href="{{amp_url($original_product)}}"/>
@endsection
@section('opengraph')
    <meta name="og_title" property="og:title" content="{!! app('seo')->getTitle() !!}"/>
    <meta name="og:image" property="og:image" content="{{getImageNew($images[0],'XS')}}"/>
    <meta name="og_description" property="og:description" content="{!! app('seo')->getDescription() !!}" />
    <link rel="alternate" href="{{Request::url()}}" hreflang="en" />
@endsection
@section('head')
    <link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--pd--{{$pid}}" />
@endsection
@section('page_content')
    <style>
	#slider3{position:relative;margin:0;height:77px;display:block}
	.thumbelina{position:absolute;white-space:nowrap;-webkit-touch-callout:none;-webkit-user-select:none}
	.thum_wid{width:200px;margin:auto;display:block}
	.thumbelina li{line-height:0;margin:0 1px;vertical-align:-webkit-baseline-middle}
	.thumbelina-but{position:relative;z-index:1;cursor:pointer;color:#888;text-align:center;vertical-align:middle;font-size:14px;font-weight:700;font-family:monospace}
	.thumbelina-but:hover{color:#fff}
	.thumbelina-but.disabled,.thumbelina-but.disabled:hover{color:#ccc;cursor:default;box-shadow:none}
	.thumbelina-but.horiz{width:20px;height:119px;line-height:119px;top:-1px}
	.thumbelina-but.horiz.left{left:-22px;border-radius:5px 0 0 5px}
	.thumbelina-but.horiz.right{right:-22px;border-radius:0 5px 5px 0}
	.thumbelina-but.vert{height:51px;line-height:20px;width:22px;background:#c3c3c3}
	.thumbelina-but.vert.top{left:-20px;border-radius:5px 0 0 5px;position:absolute;top:10px}
	.thumbelina-but.vert.bottom{bottom:15px;border-radius:0 5px 5px 0;right:-20px;position:absolute}
	.protoparo{display:block;line-height:51px;margin:0;font-size:30px;color:#4a4a4a}
	.probottaro{display:block;line-height:51px;margin:0;font-size:30px;color:#4a4a4a}
	.simpleLens-container{width:100%;height:370px;text-align:center;display:inline-table}
	.simpleLens-big-image-container{display:table-cell;vertical-align:middle}
	.simpleLens-big-image{max-width:255px;max-height:340px}
	.simpleLens-mouse-cursor{opacity:.2;position:absolute;top:0;left:0}
	.simpleLens-lens-element{background:#FFF;left:108%;overflow:hidden;position:absolute;top:3px;width:880px;height:495px;z-index:9999;text-align:center;display:none;}
	.simpleLens-lens-element img{position:relative;top:0;left:0;width:auto!important;max-width:none!important}
	.simpleLens-thumbnails-container{width:88%;margin-left:20px;clear:both}
	.simpleLens-thumbnails-container a{display:inline-block}
	.simpleLens-thumbnails-container a img{display:block}
	.simpleLens-thumbnail-wrapper{width:50px;height:50px;border:1px solid #c3c3c3;overflow:hidden;border-radius:4px;text-align:center;align-items:center;display:flex!important;overflow:hidden;justify-content:center;margin-top:10px}
	.thumbnailgallerysmalimg{max-width:41px!important;max-height:40px!important}
	.carousel-inner.vertical{max-height:375px!important;margin-top:20px}
	@media all and (transform-3d),(-webkit-transform-3d) {
	.carousel-inner.vertical > .item{-webkit-transition:-webkit-transform .6s ease-in-out;-o-transition:-o-transform .6s ease-in-out;transition:transform .6s ease-in-out;-webkit-backface-visibility:hidden;backface-visibility:hidden;-webkit-perspective:1000;perspective:1000px}
	.carousel-inner.vertical > .item.next,.carousel-inner.vertical > .item.active.right{-webkit-transform:translate3d(0,33.33%,0);transform:translate3d(0,33.33%,0);top:0}
	.carousel-inner.vertical > .item.prev,.carousel-inner.vertical > .item.active.left{-webkit-transform:translate3d(0,-33.33%,0);transform:translate3d(0,-33.33%,0);top:0}
	.carousel-inner.vertical > .item.next.left,.carousel-inner.vertical > .item.prev.right,.carousel-inner.vertical > .item.active{-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0);top:0}
	}
	#carousel-pager .carousel-control.left{width:70px;top:24px;position:absolute;color:#000;font-size:15px}
	#carousel-pager .carousel-control.right{top:-2px;width:55px;position:relative;color:#000;font-size:15px}
	.spec_box{width:100%!important}
	#details img{width:100%;height:100%;margin-bottom:15px}
	#details table tr td p{font-size:12px}
	.cas_bak{width:65px;margin-top:2px;border:1px dashed #ff4631;font-size:11px;text-align:center;display:inline-block;line-height:15px;padding:3px 5px;color:#ff4631;font-weight:600;border-radius:4px;font-family:'CircularSpotifyText'}
	.add_to_po{float:left;margin-top:10px}
	.add_to_po .productgoto{width:185px}
	.tandc{font-size:14px;float:right;margin:6px 0 0 3px}
	#t_n_c ul li{list-style:disc;font-size:13px;padding-top:10px}
	#cb_modal.modal .modal-content{padding:0}
	.use_code{width:70%;clear:both;font-size:11px;display:inline-block;font-weight:700;margin-top:5px;background:#daefde;padding:3px;border:1px dashed #a2bda7;color:#003c0b;line-height:14px}
	.font_weight{font-weight:400!important}
	.width12{width:12%}
	.width8{width:8%}
	.width25{width:25%}
	.width21{width:21%}
	.width10{width:10%}
    </style>
    {{--<section>
        <div class="container">
            {!! Breadcrumbs::render('p_detail', $product, $brand_count) !!}
        </div>
    </section>--}}
    <section>
        <div class="whitecolorbg" id="Overview">
            <div id="mytabproduct">
                <div class="container">
                    <div class="product-tabs css-carouseltab padding-btm0">
                        <ul class="tabsproduct" id="goto_section">
                            <li class="tab"><a class="activetoptab" href="#Overview">Overview</a></li>
                            @if(isset($vendors) && !empty($vendors))
                                <li class="tab" id="price_nav">
                                    <a href="#pricepart">Prices</a>
                                </li>
                            @endif
                            @if(isset($main_product->description) && !empty($main_product->description))
                                <li class="tab" id="price_nav">
                                    <a href="#details">Detail</a>
                                </li>
                            @endif
                            @if(isset($product->specification) && !empty($product->specification))
                                <li class="tab">
                                    <a href="#Specs">Specs</a>
                                </li>
                            @endif
                            @if(isset($expert_data) && is_array($expert_data))
                                <li class="tab">
                                    <a href="#ExpertReviewsTop">Reviews</a>
                                </li>
                            @endif
                            @if(isset($compare_predecessor) && !empty($compare_predecessor))
                                <li class="tab">
                                    <a href="#compare_pred_wrapper">Comparison</a>
                                </li>
                            @endif
                            @if(isset($youtube_url) && !empty($youtube_url))
                                <li class="tab">
                                    <a href="#videos">Video</a>
                                </li>
                            @endif
                            @if(isset($compare_products) && count($compare_products) > 0)
                                @if(isset($main_product->grp) and ($main_product->grp != "women") and ($main_product->grp != "men") and ($main_product->grp != "kids") )
                                    <li class="tab" id="compare">
                                        <a href="#compare_filters">Competitors</a>
                                    </li>
                                @endif
                            @endif
                            @if(isset($faqs) && is_array($faqs))
                                <li class="tab" id="faq">
                                    <a href="#faqs">FAQs</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container">
                <h1 itemprop="name">{!! app('seo')->getHeading() !!}</h1>
                @if(hasKey($product,'rating','rating_count'))
                    <div class="star-ratings-sprite prodtailspagerating">
                        <span style="width:{{percent($product->rating,5)}}%" class="star-ratings-sprite-rating" title="{{$product->rating}} Star(s)"></span>
                    </div>
                    <div class="revietext">
                        {{$product->rating}} Out of 5 stars
                        <a href="#mobile_reviews">
                            ( {{$product->rating_count}} Ratings )
                        </a>
                    </div>
                @endif
                @if(!shouldNotIndex($product))
                    @if(app('seo')->getShortDescription() || !empty($product->summary))
                        <div class="more_content_wrapper">
                            <div class="more-less-product1 small normelcont">
                                @if(isset($product->summary) && !empty(trim($product->summary)))
                                    {!! $product->summary !!}
                                @else
                                    {!! app('seo')->getShortDescription() !!}
                                @endif
                            </div>
                            <a href="javascript:void(0)" class="moreproduct">Read More <span>&rsaquo;</span></a>
                        </div>
                    @endif
                @endif
                <div class="productimgdetailsbox">
                    <div class="simpleLens-gallery-container" id="demo-1">
                        <div class="simpleLens-container">
                            <div class="simpleLens-big-image-container">
                                <a class="simpleLens-lens-image" data-lens-image="{{getImageNew($images[0],"S")}}">
                                    <img src="{{getImageNew('')}}" data-src="{{getImageNew($images[0],"M")}}" class="simpleLens-big-image">
                                </a>
                            </div>
                        </div>
                        <div id="carousel-pager" class="carousel slide simpleLens-thumbnails-container" data-ride="carousel" data-interval="500000000">
                            <div id="slider3">
                                <div class="thumbelina-but vert top">
                                    <span class="protoparo">&#8249;</span>
                                </div>

                                <ul>
                                    @foreach($images as $key => $image)
                                        <li>
                                            <a href="javascript:void(0)" class="simpleLens-thumbnail-wrapper" data-lens-image="{{getImageNew($image,"L")}}" data-big-image="{{getImageNew($image,"L")}}">
                                                <img class="thumbnailgallerysmalimg" src="{{getImageNew('')}}" data-src="{{getImageNew($image,"XXS")}}">
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="thumbelina-but vert bottom">
                                    <span class="probottaro">&#8250;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="productpricelast">
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
                            @if(isComparativeProduct($product))
                                @if(isset($vendors) && !empty($vendors))
                                    <?php $affLink = productAffLink($product, collect($vendors)->first()->_source->ref_id) ?>
                                @else
                                    <?php $affLink = $product->product_url ?>
                                @endif
                            @else
                                <?php $affLink = productAffLink($product) ?>
                            @endif
                        @endif

                        @if($main_product->saleprice>0)
                            <div class="lastprice">
                                @if(isComingSoon($product))
                                    Expected Price
                                @else
                                    best price
                                @endif
                                <span>Rs {{number_format($main_product->saleprice)}}</span>
                            </div>
                        @endif
                        @if(isComparativeProduct($product))
                            <a href="#pricepart" class="lastpricevanderbutton">
                                @if(isComingSoon($main_product))
                                    Coming Soon
                                @elseif(empty($product->track_stock))
                                    Out Of Stock
                                @else
                                    Check Prices
                                @endif
                                @if(isset($product->code) && !empty($product->code))
                                    <div class="use_code">Use Coupon {{$product->code}} & buy at best price.</div>
                                @endif
                                <span class="right-arrow left10"></span>
                            </a>
                        @else
                            @if(empty($product->track_stock))
                                <a href="javascript:void(0)" class="lastpricevanderbutton" style="width:200px">
                                    OUT OF STOCK
                                </a>
                            @else
                                <a href="{{$affLink}}" class="lastpricevanderbutton" style="width:200px">
                                    BUY FROM {{config('vendor.name.'.$product->vendor)}}
                                    <span class="right-arrow" style="margin-top:1px;"></span>
                                </a>
                            @endif
                        @endif
                    </div>
                    @if(hasKey($product,'variants') && count($product->variants) > 0)
                        <div class="productpricelast">
                            <div class="lastprice">
                                Storgae, RAM
                                <select id="variants" class="form-control fildname">
                                    @foreach($product->variants as $key => $variant)
                                        <option value="{{route('product_detail_v2',[cs($variant->name),$variant->id])}}" {{($variant->id == $product->id) ? 'selected' : ''}}>{{$key}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    @if(!isComingSoon($main_product) && auth()->check())
                        @if(session()->has('corporate_user') && userHasAccess('cashback.purchase') && $hasOrder)
                            <div class="productpricelast">
                                <div class="add_to_po">
                                    <a href="javascript:void(0)" class="productgoto" rel="nofollow" id="add_porder">
                                        Add to Purchase
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--END-PART-1-->
    @if( isComingSoon($product) && releaseDate($product) )
        <div class="whitecolorbg">
            <div class="container">
                <strong>Release Date: </strong>
                <span class="lastpricevanderbutton" style="margin-top: 3px;">
                    {{releaseDate($product)}}
                </span>
            </div>
        </div>
    @endif
    @if(isComingSoon($product) && releaseDate($product))
        <section>
            <div class="whitecolorbg">
                <div class="container">
                    <h2> {{ $product->name }} Expected Price, Release Date </h2>
                    <div class="highlightspoint extedpre">
                        <table>
                            <tr>
                                <td class="extedtd">Expected Price:</td>
                                <td>Rs {{number_format($product->saleprice)}}</td>
                            </tr>
                            <tr>
                                <td class="extedtd">Launch Date:</td>
                                <td>{{releaseDate($product)}}
                                    (Unconfirmed)
                                </td>
                            </tr>
                            @if(isset($product->mini_spec) && !empty($product->mini_spec))
                                <tr>
                                    <?php $vars = array_filter(explode(";", $product->mini_spec)); ?>
                                    <td class="extedtd">Variant:</td>
                                    <td>{{trim(implode(" / ", $vars))}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="extedtd">Status:</td>
                                <td>
                                    <a href="{{route('upcoming_mobiles')}}">
                                        Upcoming Mobile
                                    </a>
                                </td>
                            </tr>
                            @if($brand_count >= 5)
                                <tr>
                                    <td class="extedtd">Brand:</td>
                                    <td>
                                        <a href="{{route('brands.listing',[cs($product->grp), cs($product->brand),cs($product->category)])}}">
                                            {{ucwords($product->brand)}}
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </section>
        @else
        <section>
            <div class="whitecolorbg">
                <div class="container">
                    @if(isComparativeProduct($product) && isset($product->mini_spec))
                        <div class="highlights">
                            <h2>Product Key Features</h2>
                            <ul>
                                {!! miniSpecDetail($product->mini_spec, 10, '&#9989;') !!}
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif
    @if(app('seo')->getExcerpt() || isset($product->excerpt))
        <section id="upcoming_details">
            <div class="whitecolorbg">
                <div class="container more_content_wrapper">
                    <h2>
                        {!! app('seo')->getSubHeading() !!}
                    </h2>
                    <div class="more-less-product1 medium">
                        @if(app('seo')->getExcerpt())
                            {!! app('seo')->getExcerpt() !!}
                        @elseif(isset($product->excerpt))
                            {!! truncate_html($product->excerpt,200) !!}
                        @endif
                    </div>
                    <a href="javascript:void(0)" class="moreproduct">Read More <span>&rsaquo;</span></a>
                </div>
            </div>
        </section>
    @endif
    <!--THE-PART-2-->
    @if(isset($main_product->description) && !empty($main_product->description))
        <section id="details">
            <div class="whitecolorbg">
                <div class="container more_content_wrapper">
                    <h2>{{$main_product->name}} Detail</h2>
                    <div class="more-less-product1">
                        {!! html_entity_decode(imageLazyLoad($product->description)) !!}
                    </div>
                    <a href="javascript:void(0)" class="moreproduct">Read More <span>&rsaquo;</span></a>
                </div>
            </div>
        </section>
    @endif
    <!--END-PART-2-->
    <!--THE-PART-3-->
    <section id="pricepart">
        @if( isComparativeProduct($product) && isset($vendors) && !empty($vendors))
            <?php $total_saving = getSavingAmount($product, $vendors) ?>
        @else
            <?php $total_saving = getSavingAmount($product) ?>
        @endif
        @include("v3.mobile.product.ajax.vendors")
    </section>
    <!--END-PART-3-->
    @if(isset($main_product->specification) && !empty($main_product->specification))
        <section id="Specs">
            <div class="whitecolorbg padding15px">
                <div class="container">
                    <h2>Specification of {{$main_product->name}}</h2>
                    <div class="productdetailstable more_content_wrapper">
                        <div class="more-less-product1">
                            {!! (isset($main_product->specification)) ? $main_product->specification : '' !!}
                        </div>
                        <a class="toggle-btndetails moreproduct allcateglink" data="VIEW Full specs <span>&rsaquo;</span>">
                            VIEW Full specs <span>&rsaquo;</span>
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
                                    <div class="accordionItemHeading accdi_tem">{!! $data->title !!}
                                        <span class="right-arrow"></span>
                                    </div>
                                    <div class="accordionItemContent exrt_cont">
                                        <div class="exrt_revi">
                                            <div class="more_content_wrapper">
                                                <div class="more-less-product1 normelcont">
                                                    {!! $data->content !!}
                                                </div>
                                                <a href="javascript:void(0)" class="moreproduct">Read More
                                                    <span>&rsaquo;</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if(isset($expert_profile) && is_object($expert_profile))
                            @php
                                $socials = [ 'linkedin' => 'licon', 'gplus' => 'googic', 'facebook' => 'faceico', 'twitter' => 'twittico', 'indiashopps' => 'iicon' ]
                            @endphp
                            <div class="social">
                                <ul>
                                    <div class="author">
                                        Reviewed By: {{$expert_profile->author}}
                                    </div>
                                    @foreach($expert_profile as $social => $link)
                                        @if( array_key_exists($social,$socials) )
                                            <li>
                                                <a href="{{$link}}" class="{{$socials[$social]}}" target="_blank" rel="nofollow"></a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif
    @if(isset($youtube_url))
        <section id="videos">
            <div class="whitecolorbg">
                <div class="container">
                    <h2>{!! app('seo')->getHeading() !!} Audio & Video</h2>
                    @if(isset($youtube_url_hindi))
                        <span class="hindi btn registrationsubmit change_video hnd_egl" data-url="{{$youtube_url_hindi}}">
                                View Hindi Version
                            </span>
                    @endif
                    {!! youTubePlayer($main_product->name, $youtube_url) !!}
                </div>
            </div>
        </section>
    @endif

    @if($news->isNotEmpty())
        @include("v3.mobile.product.news")
    @endif
    @if(isset($compare_predecessor))
        @include('v3.mobile.product.compare_products')
    @endif
    @if(isset($compare_products) && !empty($compare_products))
        <div id="compare_filters">
            @include("v3.mobile.product.ajax.reviews")
        </div>
    @endif
    @if(isset($faqs) && is_array($faqs))
        <section id="faqs">
            <div class="whitecolorbg">
                <div class="container fabox">
                    <h2>Frequently asked questions about {{ucwords($product->name)}}</h2>
                    @foreach($faqs as $faq)
                        <span>
                            <b>Q.</b>{{$faq->question}}
                        </span>
                        <p>{{$faq->answer}}</p>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    @if(isComparativeProduct($product))
        <section id="mobile_reviews"></section>
    @endif

    @if(isComparativeProduct($main_product) && isset($product_reviews) && !isComingSoon($product))
        @include('v3.mobile.product.product_review')
    @endif

    <!--THE-PART-8-->
    <section id="deals_on_phone">
        @if( isset($deals) && !empty($deals))
            @include("v3.mobile.product.ajax.deals_non")
        @endif
    </section>
    <!--END-PART-8-->

    <!--THE-PART-9-->
    @if(isComparativeProduct($main_product))

    @else
        @if( isset($by_vendor_one) && !empty($by_vendor_one))
            <section id="by_vendor_one_wrapper">
                <div class="whitecolorbg">
                    <div class="container more_content_wrapper">
                        <h2>Similar Product From Amazon</h2>
                        <div id="by_vendor_one">
                            @include('v3.mobile.product.deals', [ 'products' => $by_vendor_one ])
                        </div>
                    </div>
                </div>
            </section>
        @endif
        @if( isset($by_vendor_two) && !empty($by_vendor_two))
            <section id="by_vendor_two_wrapper">
                <div class="whitecolorbg">
                    <div class="container more_content_wrapper">
                        <h2>Similar Product From Flipkart</h2>
                        <div id="by_vendor_two">
                            @include('v3.mobile.product.deals', [ 'products' => $by_vendor_two ])
                        </div>
                    </div>
                </div>
            </section>
        @endif
        @if( isset($by_brand) && !empty($by_brand))
            <section id="by_brand_wrapper">
                <div class="whitecolorbg">
                    <div class="container more_content_wrapper">
                        <h2>Similar Product By Brand</h2>
                        <div id="by_brand">
                            @include('v3.mobile.product.deals', [ 'products' => $by_brand, 'brand_widget' => true ])
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
    @if( isset($main_product->lp_vendor) )
        <?php $vendor = $main_product->lp_vendor ?>
    @elseif(isset($main_product->vendor))
        <?php
        if (is_array($main_product->vendor)) {
            $vendor = collect($main_product->vendor)->first();
        } else {
            $vendor = $main_product->vendor;
        }
        ?>
    @else
        <?php $vendor = false ?>
    @endif
    @if($vendor)
        @if(!empty($main_product->track_stock))
            <div class="loanstabbg">
                <a href="{{$affLink}}" target="_blank" class="productbutton buyorangebutton">
                    BUY FROM {{config('vendor.name.'.$vendor)}}
                </a>
            </div>
        @endif
    @endif
    <div id="t_n_c" class="modal bottom-sheet">
        <div class="modal-content">
            <h4>Standard Indiashopps Cashback Terms</h4>
            <ul>
                <li>To ensure your Cashback Rewards gets fully tracked, do not visit any other coupons or price
                    comparison site after you have visited Indiashopps and clicked.
                </li>
                <li>Best way to get cashback is to use only coupons provided on Indiashopps.com.</li>
                <li>Your Cashback will generally be tracked in a span of 4 days after the order is dispatched by the
                    merchant.
                </li>
                <li>Cashback is based on various factors like Category of the product , New or Existing users etc.
                    Displayed cashback is highest for that website. Actual will be based on the relevant factors.
                </li>
                <li>Your Cashback Rewards will be validated and Finalized within 90 days from your purchase date.</li>
                <li>For all Cashback questions, you may email
                    <a href="mailto:info@indiashopps.com" target="_blank">info@indiashopps.com</a></li>
            </ul>
        </div>
    </div>
    <div id="cb_modal" class="modal">
        <div class="modal-content" id="cb_popup"></div>
    </div>
@endsection
@section('scripts')
    <!--END-PART-9-->
    <script>
        var form_data = {_token: '{{csrf_token()}}', product: '{{$prod}}'};
        var header = document.getElementById("mytabproduct");
        var sticky = header.offsetTop;

        function restJsLoaded() {
            loadGallery();
            loadThumb();

                    @if(auth()->check())
                    @if(session()->has('corporate_user') && userHasAccess('cashback.purchase'))
            var order_product = {};
            order_product.id = '{{$main_product->id}}';
            order_product.name = '{{$main_product->name}}';
            order_product.image = '{{getImageNew($main_product->image_url,"XXS")}}';
            order_product.price = '{{$main_product->saleprice}}';
            order_product.saving = '{{$total_saving}}';
            order_product.out_url = '{{(isset($affLink)) ? $affLink : "" }}';
            order_product.vendor = '{{(isset($main_product->lp_vendor)) ? $main_product->lp_vendor : $main_product->vendor}}';
            order_product.group = '{{$main_product->grp}}';
            var pro_key = 'product_{{$main_product->id}}';
            @if(isComparativeProduct($product))
                    order_product.comp = 1;
                    @endif

            var interval = setInterval(function () {
                        if (typeof getCookie != 'undefined') {
                            if (getCookie(pro_key)) {
                                $('#add_porder').html('ADDED TO PURCHASE ORDER');
                            }
                            clearInterval(interval);
                        }
                    }, 200);

            $(document).on('click', '#add_porder', function () {
                if (!getCookie(pro_key)) {
                    var button = $(this);
                    button.html("Adding...");
                    $.ajax({
                        url: '{{route('cashback.add-product-order')}}',
                        data: order_product,
                        success: function () {
                            button.html('ADDED TO PURCHASE ORDER');
                            setCookie('product_{{$main_product->id}}', 'Added', 1 * 100);
                        },
                        dataType: 'json'
                    });
                }
            });
            @endif
            @endif

            loadFontAwesome();
        }

        function loadFontAwesome() {
            var interval = setInterval(function () {
                if ($("#product_reviews").isInViewport() || $("#pricepart").isInViewport()) {
                    $("<link/>", {
                        rel: "stylesheet",
                        type: "text/css",
                        href: "https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"
                    }).appendTo("head");
                    clearInterval(interval);
                }
            }, 1500);
        }
        afterJquery(function () {
            var stickOffset;
            var didScroll;
            var lastScrollTop = 0;
            var delta = 5;
            var topnavbarHeight = $('header').outerHeight();
            var bottomnavbarHeight = $('tabloans').outerHeight();

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
        });

        function uiLoaded() {}
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
        function myFunction() {
            if (window.pageYOffset >= sticky) {
                header.classList.add("sticky");
            } else {
                header.classList.remove("sticky");
            }
        }

        function product_vendor_callback() {
            if ($("#product_vendor").html() == "") {
                $("#price_nav").remove();
            }
        }

        function hasScrolled() {
            var st = $(this).scrollTop();
            if (Math.abs(lastScrollTop - st) <= delta)
                return;
            if (st > lastScrollTop && st > topnavbarHeight) {
                $('header1').removeClass('show').addClass('hide');
                $('tabloans').removeClass('show').addClass('hide');
            } else {
                if (st + $(window).height() < $(document).height()) {
                    $('header1').removeClass('hide').addClass('show');
                    $('tabloans').removeClass('hide').addClass('show');
                }
            }
            lastScrollTop = st;
        }

        function loadGallery() {
            afterJquery(function () {
                $('#demo-1 .simpleLens-thumbnails-container img').simpleGallery({
                    loading_image: '{{asset('assets/v3/images/image_loading.gif')}}'
                });

                $('#demo-1 .simpleLens-big-image').simpleLens({
                    loading_image: '{{asset('assets/v3/images/image_loading.gif')}}'
                });
            });
        }

        function loadThumb() {
            afterJquery(function () {
                $('#slider3').Thumbelina({
                    $bwdBut: $('#slider3 .top'),
                    $fwdBut: $('#slider3 .bottom')
                });
            });
        }

        document.addEventListener('jquery_loaded', function (e) {
            $(document).on('click', '#toggle-btndetails4', function () {
                if ($('.more-less-product4').hasClass('show')) {
                    $('.more-less-product4').removeClass('show');
                    $(this).html("VIEW ALL Prices <span>&rsaquo;</span>");

                    $('html, body').animate({
                        scrollTop: $("#specificationsprice").offset().top - 20
                    }, 100);
                }
                else {
                    $('.more-less-product4').addClass('show');
                    $(this).html("Show Less <span>&rsaquo;</span>");
                }
            });

            window.onscroll = function () {myFunction()};

            $("a[href^='#']").click(function (e) {
                e.preventDefault();
                if (typeof $($(this).attr("href")).offset() != 'undefined') {
                    var position = $($(this).attr("href")).offset().top;
                    $("body, html").animate({
                        scrollTop: position
                    });
                }
            });

            $(document).on("scroll", onScroll);

            $('a[href^="#"]').on('click', function (e) {
                e.preventDefault();
                $(document).off("scroll");

                $('a').each(function () {
                    $(this).removeClass('activetoptab');
                });
                $(this).addClass('activetoptab');

                var target = this.hash, menu = target;

                $target = $(target);
                if (typeof $($(this).attr("href")).offset() != 'undefined') {
                    $('').stop().animate({
                        'scrollTop': $target.offset().top + 2
                    }, 500, 'swing', function () {
                        window.location.hash = target;
                        $(document).on("scroll", onScroll);
                    });
                }
            });

            $(window).scroll(function (event) {
                didScroll = true;
                onscroll(event);
            });

            $(document).on('submit', '#product_review_form', function () {
                var rating = $(this).find("input[name='rating']:checked").val();
                var review = $(this).find("textarea").val();
                var name = $(this).find("input[name='name']").val();
                var errors = [];
                if (typeof rating == 'undefined') {
                    errors.push('Rating is required, please select rating..');
                }

                if (review.length == 0) {
                    errors.push('Review is required, please write review before submitting');
                }

                if (name.length == 0) {
                    errors.push('Name is required');
                }

                if (errors.length > 0) {
                    var error = '<ul>';
                    $.each(errors, function (i, e) {
                        error += '<li>' + e + '</li>';
                    });
                    error += '</ul>';

                    $("#errors").html(error).addClass('alert-danger').removeClass('alert-success');
                }
                else {
                    $.ajax({
                        type: 'POST',
                        url: '{{route('add_product_review',[$main_product->id])}}',
                        data: $('#product_review_form').serialize(),
                        success: function () {
                            $('#product_review_form')[0].reset();
                            $("#errors").html('<ul><li>Review Submitted !</li></ul>').removeClass('alert-danger').addClass('alert-success');
                            window.location.reload();
                        }
                    });
                }
                return false;
            });

            $(document).on('click', '.change_video', function () {
                var url = $(this).attr('data-url');
                var old_url = $("#videos iframe").attr('src');

                $(this).attr('data-url', old_url);

                if ($(this).hasClass('hindi')) {
                    $(this).removeClass('hindi').addClass('english').html('View English Version');
                }
                else {
                    $(this).addClass('hindi').removeClass('english').html('View Hindi Version');
                }

                $("#videos iframe").attr('src', url);
            });

            $(document).on('change', "#variants", function () {
                var url = $(this).val();

                if (url != '') {
                    window.location.href = url;
                }
            });
        });

        function onScroll(event) {
            var scrollPosition = $(document).scrollTop() + $("#mytabproduct").height() + 10;
            $('.tabsproduct a').each(function () {
                var currentLink = $(this);
                var refElement = $(currentLink.attr("href"));
                if (refElement.position().top <= scrollPosition && refElement.position().top + refElement.height() > scrollPosition) {
                    $('.tabsproduct li a').removeClass("activetoptab");
                    currentLink.addClass("activetoptab");
                }
                else {
                    currentLink.removeClass("activetoptab");
                }
            });
        }
    </script>
    <script>
        function MLoaded() {
            $('.modal').modal();
        }
        afterJquery(function () {
            $(window).scroll(function () {
                if ($(window).scrollTop() >= 4600) {
                    $('select-catlist').addClass('fixed-comparesticky');
                }
                else {
                    $('select-catlist').removeClass('fixed-comparesticky');
                }
            });
            $(document).on('click', '#toggle-btndetails', function () {
                if ($('.comparedetails1').hasClass('show')) {
                    $('.comparedetails1').removeClass('show');
                    $(this).html("View More <span>&rsaquo;</span>");

                    $('html, body').animate({
                        scrollTop: $("#specificationstable").offset().top - 20
                    }, 300);
                }
                else {
                    $('.comparedetails1').addClass('show');
                    $(this).html("Show Less <span>&rsaquo;</span>");
                }
            });
        });
    </script>
@endsection