<?php
if (strpos($product->image_url, ',') !== false && (strpos($product->image_url, '"]') === false)) {
    $product->image_url = explode(",", $product->image_url);
    $product->image_url = str_replace('"', '', $product->image_url[0]);
}

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
?>
@extends('v3.amp.master')
@section('opengraph')
    @if(shouldNotIndex($product))
        <meta name="robots" content="noindex, nofollow"/>
    @else
        <meta name="robots" content="index, follow"/>
    @endif
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
@endsection
@section('head')
    <link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--pd--{{$product->id}}"/>
    @if( isset($main_product->meta) && isset($main_product->meta->video_url) )
        <script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
    @endif
    <link rel="canonical" href="{{amp_canonical($original_product)}}"/>
    <script async custom-element="amp-position-observer" src="https://cdn.ampproject.org/v0/amp-position-observer-0.1.js"></script>
    <script async custom-element="amp-animation" src="https://cdn.ampproject.org/v0/amp-animation-0.1.js"></script>
@endsection
@section('page_content')
    <!--THE-BANNER-->
    @if( isset($sliders) && !empty($sliders) )
        @include('v3.amp.slider', [ 'slider' => collect($sliders)->first() ])
    @endif
    {{--<div class="container">
        {!! Breadcrumbs::render('p_detail', $product, $brand_count) !!}
    </div>--}}
    <!--END-BANNER-->
    @include('v3.amp.product.amp-declarations')
    <div id="sticky-header">
        <div class="whitecolorbg overflowhidden">
            <div class="container">
                @include('v3.amp.product.scroll_to')
            </div>
        </div>
    </div>
    <section id="overview">
        <div class="whitecolorbg overflowhidden">
            <div class="container">
                @include('v3.amp.product.scroll_to')
                <amp-position-observer on="enter:hideSticky.start; exit:showSticky.start;" layout="nodisplay"></amp-position-observer>
            </div>
            <div class="container">
                <div class="headdingcat">
                    <h1 itemprop="name">{!! app('seo')->getHeading() !!}</h1>
                </div>
                @if(hasKey($product,'rating','rating_count'))
                    <div class="productdetailsheadding">
                        <div class="prodtailspagerating">
                            <div class="star-ratings-sprite">
                                {!! ampStar($product->rating) !!}
                            </div>
                        </div>
                        <div class="revietext">
                            {{$product->rating}} Out of 5 stars
                            <a href="#mobile_reviews" on="tap:mobile_reviews.scrollTo(duration=400)">
                                ( {{$product->rating_count}} Ratings )
                            </a>
                        </div>
                        <div class="ratingreviewstext"></div>
                    </div>
                @endif
                <div style="clear:both"></div>
                <div class="productimgdetailsbox">
                    @if(!shouldNotIndex($product))
                        @if(app('seo')->getShortDescription() || !empty($product->summary))
                            <div class="normelcont">
                                <div [class]="shortDesc.top.class" class="hidden-content small">
                                    @if(isset($product->summary) && !empty(trim($product->summary)))
                                        {!! removeInlineStyle1($product->summary) !!}
                                    @else
                                        {!! removeInlineStyle1(app('seo')->getShortDescription()) !!}
                                    @endif
                                </div>
                                <button id="show-more-button" [class]="shortDesc.top.class" class="shown" on="tap:AMP.setState({shortDesc: {top : {class: ''}}})">
                                    Read More
                                </button>
                            </div>
                        @endif
                            <h2>
                                {!! app('seo')->getSubHeading() !!}
                            </h2>
                    @endif
                    <div class="slidesbox">
                        <amp-carousel width="300" height="280" type="slides">
                            @foreach($images as $key => $image)
                                <amp-img src="{{getImageNew($image,"M")}}" width="158" height="250" alt="mob-1"></amp-img>
                            @endforeach
                        </amp-carousel>
                    </div>
                    <div class="productpricelast">
                        <div class="lastprice">
                            @if(isComingSoon($product))
                                Expected Price
                            @else
                                best price
                            @endif
                            <span>Rs {{number_format($product->saleprice)}}</span>
                        </div>
                        @if($product->track_stock != 0)
                            @if( isset($product->availability) && $product->availability == 'Coming Soon' )
                                <a href="#" class="lastpricevanderbutton">
                                    Coming Soon
                                    <i class="fa fa-angle-right right-arrowpro"></i>
                                </a>
                            @else
                                @if( isComparativeProduct($product) )
                                    <a href="#pricepart" class="lastpricevanderbutton">
                                        Check Prices
                                        <i class="fa fa-angle-right right-arrowpro"></i>
                                    </a>
                                @else
                                    <?php $main_product = changeFkUrl($main_product); ?>
                                    <a href="{{proUrl($main_product->product_url,true)}}" target="_blank" class="lastpricevanderbutton">
                                        BUY FROM {{config('vendor.name.'.$main_product->vendor)}}
                                    </a>
                                @endif
                            @endif
                        @else
                            <a href="#" class="lastpricevanderbutton">
                                Out Of Stock
                                <i class="fa fa-angle-right right-arrowpro"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <amp-position-observer on="exit:showSticky.start;" layout="nodisplay"></amp-position-observer>
    </section>
    @if( isComingSoon($product) && isset($product->release_date) )
        <div class="whitecolorbg">
            <div class="container">
                <strong>Release Date: </strong>
                <span class="lastpricevanderbutton release_date">{{$product->release_date}}</span>
            </div>
        </div>
    @endif
    @if(isComingSoon($product) && isset($product->release_date))
        <section>
            <div class="whitecolorbg">
                <div class="container">
                    <h2> {{ $product->name }} Expected Price, Release Date </h2>
                    <div class="normelcont extedpre">
                        <table>
                            <tr>
                                <td class="extedtd">Expected Price:</td>
                                <td>Rs {{number_format($product->saleprice)}}</td>
                            </tr>
                            <tr>
                                <td class="extedtd">Launch Date:</td>
                                <td>{{(isset($product->release_date)) ? $product->release_date : ''}}
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
                            <tr>
                                <td class="extedtd">Brand:</td>
                                <td>
                                    <a href="{{route('brand_category_list_comp_1',[cs($product->brand),'mobiles','351'])}}">
                                        {{ucwords($product->brand)}}
                                    </a>
                                </td>
                            </tr>
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
    @if( isset($product->description) && !empty($product->description) )
        <section id="detail_section">
            <amp-position-observer on="enter:detailsShow.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:priceHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:faqHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:reviewHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compareHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:videoHide.start;" layout="nodisplay"></amp-position-observer>
            <div class="whitecolorbg com_table">
                <div class="container">
                    <h2>{{$main_product->name}} Detail</h2>
                    <div class="normelcont">
                        <p>{!! removeInlineStyle(html_entity_decode($product->description)) !!}</p>
                    </div>
                </div>
            </div>
            <amp-position-observer on="enter:detailsShow.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:priceHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:faqHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:reviewHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compareHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:videoHide.start;" layout="nodisplay"></amp-position-observer>
        </section>
    @endif
    @if( isComparativeProduct($product) && isset($vendors) && !empty($vendors) )
        <section id="pricepart">
            <amp-position-observer on="enter:priceShow.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:faqHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:detailsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:reviewHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compareHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:videoHide.start;" layout="nodisplay"></amp-position-observer>
            <div class="whitecolorbg">
                <div class="container">
                    <h2>{{$product->name}} Price Comparison</h2>
                    <div class="bs-example">
                        <table class="table table-condensed">
                            <tbody>
                            @foreach($vendors as $v)
                                <?php $v = $v->_source; ?>
                                <tr>
                                    <td>
                                        <div class="vendorlogo">
                                            <amp-img class="vendorlogoimg" src="{{config('vendor.vend_logo.'.$v->vendor)}}" width="93" height="34" alt="{{config('vendor.name.'.$v->vendor)}} Logo"></amp-img>
                                        </div>
                                        @if(isset($v->delivery))
                                            <div class="delivery">{{(!is_null($v->delivery))? $v->delivery : ''}}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flprice">
                                            @if( $v->track_stock == 1 )
                                                Rs {{number_format($v->saleprice)}}
                                            @else
                                                Out Of Stock
                                            @endif
                                            @if(isset($v->rating))
                                                <div class="star-ratings-sprite">
                                                    {!! ampStar($v->rating) !!}
                                                </div>
                                            @endif
                                            @if(isset($v->code) && !empty($v->code))
                                                <div class="use_code font_weight">Use Coupon {{$v->code}} & buy at best
                                                    price.
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <?php $v = changeFkUrl($v); ?>
                                        @if($v->track_stock == 1)
                                            <a href="{{$v->product_url}}" target="_blank" class="productgoto">go to
                                                store</a>
                                        @else
                                            <a href="{{$v->product_url}}" target="_blank" class="productgoto">Out Of
                                                Stock</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <amp-position-observer on="enter:priceShow.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:faqHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:detailsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="exit:priceHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:reviewHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compareHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:videoHide.start;" layout="nodisplay"></amp-position-observer>
        </section>
    @endif
    @if(app('seo')->getExcerpt() || ( isset($product->excerpt) && !empty($product->excerpt)))
        <div class="whitecolorbg">
            <div class="container">

                <div class="normelcont">
                    <div [class]="desc.class" class="hidden-content small">
                        @if(app('seo')->getExcerpt())
                            {!! app('seo')->getExcerpt() !!}
                        @elseif(isset($product->excerpt))
                            <p>{!! removeInlineStyle($product->excerpt) !!}</p>
                        @endif
                    </div>
                    <button id="show-more-button1" [class]="desc.class" class="shown" on="tap:AMP.setState({shortDesc1: {class : ''}})">
                        Read More
                    </button>
                </div>
            </div>
        </div>
    @endif
    @if((isset($product->specification) && !empty($product->specification)))
        <section id="specs">
            <amp-position-observer on="enter:priceHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:specsShow.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:faqHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:detailsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:reviewHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compareHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:videoHide.start;" layout="nodisplay"></amp-position-observer>
            <div class="whitecolorbg overflowhidden" id="specificationstable">
                <div class="container">
                    <h2>Specification and features of {{$product->name}}</h2>
                    <div class="productdetailstable">
                        <div class="more-less-product3">
                            <div [class]="desc.class" class="hidden-content specs">
                                @if(stripos($product->specification, "spec_ttle") === false && stripos($product->specification, "spec_des") === false)
                                    <table>
                                        {!! removeInlineStyle($product->specification) !!}
                                    </table>
                                @else
                                    {!! removeInlineStyle($product->specification) !!}
                                @endif
                            </div>
                            <button id="show-more-button1" [class]="desc.class" class="shown" on="tap:AMP.setState({shortDesc1: {class : ''}})">
                                Read More
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <amp-position-observer on="enter:priceHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:specsShow.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:faqHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:detailsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="exit:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:reviewHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compareHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:videoHide.start;" layout="nodisplay"></amp-position-observer>
        </section>
    @endif
    @if(isset($expert_data) && is_array($expert_data))
        <section id="review_sec">
            <amp-position-observer on="enter:reviewShow.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:priceHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:faqHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:detailsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="exit:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compareHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:videoHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compHide.start;" layout="nodisplay"></amp-position-observer>

            <div class="whitecolorbg padding7">
                <div class="container">
                    <h2>Expert Reviews</h2>
                    <amp-accordion disable-session-states>
                        @foreach($expert_data as $data)
                            <section>
                                <h4 class="belowprice borderbottom">{!! $data->title !!}
                                    <i class="fa fa-angle-right rightarrowtab"></i></h4>
                                <div class="normelcont">
                                    <p>{!! $data->content !!}</p>
                                </div>
                            </section>
                        @endforeach
                    </amp-accordion>
                    @if(isset($expert_profile) && is_object($expert_profile))
                        @php
                            $socials = [ 'linkedin' => 'linkedin', 'gplus' => 'google-plus', 'facebook' => 'facebook', 'twitter' => 'twitter', 'indiashopps' => 'indiashopps' ]
                        @endphp
                        <div class="social">
                            <ul>
                                <div class="author">
                                    Reviewed By: {{$expert_profile->author}}
                                </div>
                                @foreach($expert_profile as $social => $link)
                                    @if( array_key_exists($social,$socials) )
                                        <li>
                                            <a href="{{$link}}" class="fa fa-{{$socials[$social]}}-square fontsize" target="_blank" rel="nofollow"></a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <amp-position-observer on="enter:priceHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:faqHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:detailsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="exit:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:reviewShow.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compareHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:videoHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compHide.start;" layout="nodisplay"></amp-position-observer>
        </section>
    @endif
    @if(isset($youtube_url))
        <section id="videos_sec">
            <amp-position-observer on="enter:videoShow.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:priceHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:faqHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:detailsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="exit:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:reviewHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compareHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compHide.start;" layout="nodisplay"></amp-position-observer>
            <div class="container">
                <h2>{!! app('seo')->getHeading() !!} Audio & Video</h2>
                {!! ampYouTubePlayer($youtube_url) !!}
            </div>
            </div>
            <amp-position-observer on="enter:priceHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:faqHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:detailsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="exit:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:reviewHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compareHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:videoShow.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compHide.start;" layout="nodisplay"></amp-position-observer>
        </section>
    @endif
    @if(isComparativeProduct($main_product) && isset($product_reviews) && $product_reviews->count() > 0)
        @include('v3.amp.product.product_review')
    @endif
    @if($news->isNotEmpty())
        @include("v3.amp.product.news")
    @endif
    @if(isset($compare_predecessor))
        @include('v3.amp.product.compare_products')
    @endif
    @if(isset($compare_products) && !empty($compare_products))
        <section id="compare_sec">
            <amp-position-observer on="enter:priceHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:faqHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:detailsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="exit:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:reviewHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compShow.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compareHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:videoHide.start;" layout="nodisplay"></amp-position-observer>

            <div class="whitecolorbg">
                <div class="container">
                <h3>Competitors for {{$main_product->name}}</h3>
                    <amp-carousel class="full-bottom" height="350" layout="fixed-height" type="carousel">
                        @foreach($compare_products as $product)
                            @include('v3.common.product.amp.card')
                        @endforeach
                    </amp-carousel>
                </div>
            </div>
            <amp-position-observer on="enter:priceHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:faqHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:detailsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="exit:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:reviewHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compShow.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compareHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:videoHide.start;" layout="nodisplay"></amp-position-observer>
        </section>
    @endif
    @if(isset($faqs) && is_array($faqs))
        <section id="faq_section">
            <amp-position-observer on="enter:priceHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:faqShow.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:detailsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:reviewHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compareHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:videoHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compHide.start;" layout="nodisplay"></amp-position-observer>
            <div class="whitecolorbg">
                <div class="container">
                    <h2>Frequently asked questions about {{ucwords($main_product->name)}}</h2>
                    @foreach($faqs as $faq)
                        <div class="spec_box">
                            <div class="spcsLeft">
                                <span class="specHead"><b>Q. </b>{{$faq->question}}</span>
                                <div class="spec_answer">
                                    <p>{{$faq->answer}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <amp-position-observer on="enter:priceHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:faqShow.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:detailsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="exit:faqHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:reviewHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compareHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:videoHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compHide.start;" layout="nodisplay"></amp-position-observer>
        </section>
    @endif
    @if(isset($reviews) && !empty($reviews))
        <section id="review_sec">
            <amp-position-observer on="enter:priceHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:faqHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:detailsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="exit:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:reviewShow.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compareHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:videoHide.start;" layout="nodisplay"></amp-position-observer>
            <div class="whitecolorbg">
                <div class="container">
                    <h2>Reviews and latest news</h2>
                    <amp-selector role="tablist" layout="container" class="ampTabContainer">
                        <div role="tab" class="tabButton tab40px tableft15" selected option="a">User Review</div>
                        <div role="tabpanel" class="tabContent">
                            <amp-carousel class="full-bottom" height="175" layout="fixed-height" type="carousel">
                                @foreach( $reviews->reviews as $vendor => $review )
                                    <div class="thumnail">
                                        <div class="productdetailsimgcard">
                                            <amp-img class="productimg" src="{{ config('vendor.vend_logo.'.$vendor) }}" width="156" height="53" alt="flipkart"></amp-img>
                                        </div>
                                        <div class="loans-container reviewscont">
                                            <div class="product_name reviewscontproduct_name">User rating
                                                on {{ucwords(config('vendor.name.'.$vendor))}}</div>
                                            <div class="pdpuserrating">
                                                <div class="prodtailspagerating">
                                                    <div class="star-ratings-sprite">
                                                        {!! ampStar($reviews->rating->{$vendor}) !!}
                                                    </div>
                                                </div>
                                                <div class="revietext">{{ $reviews->rating->{$vendor} }}/5</div>
                                            </div>
                                        </div>
                                        <a href="#" class="productbutton">Read all {{$reviews->total}} reviews</a></div>
                                @endforeach
                            </amp-carousel>
                        </div>
                    </amp-selector>
                </div>
            </div>
            <amp-position-observer on="enter:priceHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:faqHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:detailsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="exit:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:reviewShow.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compareHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:videoHide.start;" layout="nodisplay"></amp-position-observer>
        </section>
    @endif
    @if(isset($compare_products) && !empty($compare_products))
        <section id="compare_sec">
            <amp-position-observer on="enter:priceHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:faqHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:detailsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="exit:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:reviewHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compareShow.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:videoHide.start;" layout="nodisplay"></amp-position-observer>
            <div class="whitecolorbg">
                <div class="container">
                    <h3>Compare with Competitors</h3>
                    <amp-carousel class="full-bottom" height="350" layout="fixed-height" type="carousel">
                        @foreach($compare_products as $product)
                            @include('v3.common.product.amp.card')
                        @endforeach
                    </amp-carousel>
                </div>
            </div>
            <amp-position-observer on="enter:priceHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:faqHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:detailsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="exit:specsHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:reviewHide.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:compareShow.start;" layout="nodisplay"></amp-position-observer>
            <amp-position-observer on="enter:videoHide.start;" layout="nodisplay"></amp-position-observer>
        </section>
    @endif
    @if(isComparativeProduct($product))
        <section id="mobile_reviews">
            @include('v3.amp.product.reviews')
        </section>
    @endif
    {{-- Deals with Range Starts --}}
    @if(isset($deals) && count($deals) > 0)
        @include('v3.amp.product.top_deals')
    @endif
    {{-- Deals with Range Ends --}}
    @if(isset($by_vendor_one) && !empty($by_vendor_one))
        <section>
            <div class="whitecolorbg">
                <div class="container">
                    <h2>Similar Product From Amazon</h2>
                    <amp-carousel class="full-bottom" height="350" layout="fixed-height" type="carousel">
                        @foreach($by_vendor_one as $product)
                            @include('v3.common.product.amp.card')
                        @endforeach
                    </amp-carousel>
                </div>
            </div>
        </section>
    @endif
    @if(isset($by_vendor_two) && !empty($by_vendor_two))
        <section>
            <div class="whitecolorbg">
                <div class="container">
                    <h2>Similar Product From Flipkart</h2>
                    <amp-carousel class="full-bottom" height="350" layout="fixed-height" type="carousel">
                        @foreach($by_vendor_two as $product)
                            @include('v3.common.product.amp.card')
                        @endforeach
                    </amp-carousel>
                </div>
            </div>
        </section>
    @endif
    @if(isset($by_brand) && !empty($by_brand))
        <section>
            <div class="whitecolorbg">
                <div class="container">
                    <h2>Similar Product By Brand</h2>
                    <amp-carousel class="full-bottom" height="350" layout="fixed-height" type="carousel">
                        @foreach($by_brand as $product)
                            @include('v3.common.product.amp.card')
                        @endforeach
                    </amp-carousel>
                    <?php
                    $p = $by_brand[0]->_source;

                    if (in_array($p->grp, config('listing.brand.groups'))) {
                        $brand_url = route('amp.brands.listing', [cs($p->grp), cs($p->brand), cs($p->category)]);
                    } else {
                        $brand_url = route('amp.brand_category_list', [cs($p->brand), cs($p->grp), cs($p->category)]);
                    }

                    ?>
                    <div class="allcateglinkphone">
                        <a href="{{$brand_url}}">
                            VIEW ALL {{$p->brand}} {{$p->category}} <i class="fa fa-angle-right right-arrow"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif
    @if(isComparativeProduct($main_product))

    @endif
    @if(!isComparativeProduct($main_product))
        <div class="loanstabbg">
            <ul>
                <a href="{{proUrl($main_product->product_url,true)}}" class="productbutton buyorangebutton" target="_blank">
                    BUY FROM {{config('vendor.name.'.$main_product->vendor)}}
                </a>
            </ul>
        </div>
    @endif
@endsection