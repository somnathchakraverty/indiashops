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
    <meta name="og_description" property="og:description" content="{!! app('seo')->getDescription() !!}"/>
    <link rel="alternate" href="{{Request::url()}}" hreflang="en"/>
@endsection
@section('head')
    <link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--pd--{{$pid}}"/>
@endsection
@section('page_content')
    <div class="container">
        {!! Breadcrumbs::render('p_detail', $product, $brand_count) !!}
    </div>
    <section>
        <div class="container">
            <div id="tabstkypro">
                @include('v3.product.detail.scroll_to')
            </div>
        </div>
        <div class="container comparison">
            <h1 itemprop="name">{!! app('seo')->getHeading() !!}</h1>
            @if(hasKey($product,'rating','rating_count') || !shouldNotIndex($product))
            <div class="ratfull">
            @if(hasKey($product,'rating','rating_count'))                
                    <div class="str-rtg prodtpgrat" title="{{$product->rating}} Star(s)">
                        <span style="width:{{percent($product->rating,5)}}%" class="str-ratg"></span>
                    </div>
               
                <span class="revietext">
                    {{$product->rating}} Out of 5 stars
                    <a href="#mobile_reviews">
                        ( {{$product->rating_count}} Ratings )
                    </a>
                </span>
            @endif
            @if(!shouldNotIndex($product))
                <p>
                    @if(isset($product->summary) && !empty(trim($product->summary)))
                        {!! $product->summary !!}
                    @else
                        {!! app('seo')->getShortDescription() !!}
                    @endif
                </p>
                
            @endif
             </div>
             @endif

            <div class="maskbox">
                <div class="col-md-4 pleft proimgdebox">
                    <div class="sigllcon" id="demo-1">
                        <div class="simcon">
                            <div class="simbgimcon">
                                <a class="simleim" data-lens-image="{{getImageNew($images[0],"L")}}">
                                    <img class="simpbgim" src="{{getImageNew('')}}" data-src="{{getImageNew($images[0],"M")}}" alt="product images">
                                </a>
                            </div>
                        </div>
                        <div id="carousel-pager" class="carousel slide " data-ride="carousel" data-interval="500000000">                           
                                <div class="simthucon" id="slider3">
                                    <div class="thumbelina-but top">
                                        <span class="aropr prodletop"></span>
                                    </div>
                                    <ul>
                                        @foreach($images as $key => $image)
                                            <li class="{{($key==0) ? 'active' : ''}}">
                                                <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="{{getImageNew($image,"L")}}" data-big-image="{{getImageNew($image,"L")}}">
                                                    <img class="thugllimg" src="{{getImageNew('')}}" data-src="{{getImageNew($image,"XXS")}}" alt="product images">
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="thumbelina-but bottom">
                                        <span class="aropr prodlebottom"></span>
                                    </div>
                                </div>                           
                        </div>
                    </div>
                    @if( isComingSoon($product) )
                        <div class="prprias">
                            <span class="laprivanbutt">Coming Soon</span>
                        </div>
                    @else
                        @if($product->track_stock != 0)
                            <div class="prprias">
                                <span class="lastprice">Rs {{number_format($product->saleprice)}}</span>
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
                                        @if(isset($product->lp_ref_id))
                                            <?php $affLink = productAffLink($product,$product->lp_ref_id) ?>
                                        @elseif(isset($vendors) && !empty($vendors))
                                            <?php $affLink = productAffLink($product, collect($vendors)->first()->_source->ref_id) ?>
                                        @else
                                            <?php $affLink = $product->product_url ?>
                                        @endif
                                    @else
                                        <?php $affLink = productAffLink($product) ?>
                                    @endif
                                    <a href="{{$affLink}}" target="_blank" class="laprivanbutt" onClick="ga('send', 'event', 'shop', 'click');" rel="nofollow">
                                        Buy from {{config('vendor.name.'.$vendor)}}
                                    </a>
                                @endif
                            </div>
                        @endif
                    @endif

                </div>
                <div class="col-md-8 pright proprbox">
                            @if($product->track_stock != 0)
                                <div class="pricopt">
                                    <div class="col-md-3 pleft bestprice">                                        
                                            @if(isComingSoon($product))
                                                Expected Price
                                            @else
                                                best price
                                            @endif                                        
                                        <span>Rs {{number_format($product->saleprice)}}</span>
                                    </div>
                                    @if(hasKey($product,'variants') && count($product->variants) > 0)
                                        <div class="col-md-3 pleft bestprice">                                            
                                                Storgae, RAM                                            
                                            <select id="variants" class="form-control">
                                                @foreach($product->variants as $key => $variant)
                                                    <option value="{{route('product_detail_v2',[cs($variant->name),$variant->id])}}" {{($variant->id == $product->id) ? 'selected' : ''}}>{{$key}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    @if( isComingSoon($product) && releaseDate($product) )
                                        <div class="col-md-4 pleft bestprice">
                                            Release Date
                                            <span title="{{$product->name}} Release Date in India">
                                                {{releaseDate($product)}}
                                            </span>
                                        </div>
                                    @endif
                                    @if( isset($product->cvariant) && $product->cvariant != "NULL" )
                                        <?php $product->cvariant = trim($product->cvariant, ']') ?>
                                        <?php $product->cvariant = trim($product->cvariant, '[') ?>
                                        <?php $colors = explode(":", $product->cvariant)?>
                                        @if(isset($colors) && count($colors) > 0)
                                            <div class="col-md-3 pleft bestprice">
                                                Color
                                                @foreach($colors as $color)
                                                    <div class="{{create_slug($color)}}-color" title="{{$color}}"></div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                    @if(isset($product->code) && !empty($product->code))
                                        <span class="use_code">Use Coupon {{$product->code}} & buy at best price.</span>
                                    @endif
                                </div>
                            @endif
                            @if(!isComingSoon($product))
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
                                        <div class="col-md-2 pleft vendorlogo">

                                            @if( isComingSoon($product) )
                                                <span class="productgoto">Coming Soon</span>
                                            @else
                                                <img src="{{config('vendor.vend_logo.'.$vendor )}}" alt="vendor logo">
                                            @endif

                                        </div>
                                        <div class="col-md-4 pleft flprice">
                                            @if( !isComingSoon($product) )
                                                Rs {{number_format($product->saleprice)}}
                                            @endif
                                        </div>
                                        <div class="col-md-3 pleft">
                                            @if(!isComingSoon($product) && auth()->check())
                                                @if(session()->has('corporate_user') && userHasAccess('cashback.purchase') && $hasOrder)
                                                    <a href="javascript:void(0)" class="productgoto" rel="nofollow" id="add_porder">
                                                        Add to Purchase
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    @endif
                                    <div class="col-md-3 pleft">
                                        @if(!empty( $affLink ))
                                            <a href="{{$affLink}}" class="productgoto" target="_blank" onClick="ga('send', 'event', 'shop', 'click');" rel="nofollow">
                                                go to store
                                            </a>
                                        @endif
                                        @if( !isComingSoon($product) && $product->track_stock == 0)
                                            <a rel="nofollow" class="productgoto no_cb">OUT OF STOCK</a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if(isComparativeProduct($product) && isset($product->availability) && $product->availability != 'Coming Soon')
                                <a href="#all_stores" class="more-stores" style="display:none"><span id="vendor_count"></span>More
                                    Stores
                                    <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                                </a>
                            @endif
                      
                        @if(isComingSoon($product))                           
                                <h2> {{ $product->name }} Expected Price, Release Date </h2>                            
                            <div class="comparisontable extedpre">
                                <table>
                                    <tr>
                                        <td class="extedtd">Expected Price:</td>
                                        <td>Rs {{number_format($product->saleprice)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="extedtd">Launch Date:</td>
                                        <td>
                                            @if(releaseDate($product))
                                                {{releaseDate($product)}} (unconfirmed)
                                            @endif
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
                                            <span style="margin-left: 10px">
                                                <button class="btn btn-default registrationsubmit" data-toggle="modal" data-target="#upcoming_notify">
                                                    NOTIFY ME WHEN LAUNCHED
                                                </button>
                                            </span>
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
                        @else
                            @if(isComparativeProduct($product) && isset($product->mini_spec))                                    
                                    <ul class="highlights">
                                    <h2>Product Key Features</h2>
                                        {!! miniSpecDetail($product->mini_spec, 10, '&#9989;') !!}
                                    </ul>
                               
                            @endif
                        @endif
                   
                </div>
                <!-- Tab panes -->
            </div>
        </div>
    </section>
    @if(app('seo')->getExcerpt() || isset($product->excerpt))
        <section id="upcoming_headings">
            <div class="container comparison">           
                    <h2>
                        {!! app('seo')->getSubHeading() !!}
                    </h2>
                    <div class="comparisontable">
                        <p>
                            @if(app('seo')->getExcerpt())
                                {!! app('seo')->getExcerpt() !!}
                            @elseif(isset($product->excerpt))
                                {!! truncate_html($product->excerpt,200) !!}
                            @endif
                        </p>
                    </div>           
            </div>
    	</section>
      @endif
    <section id="details">
        @if( isset($product->description) && !empty($product->description) )
            <div class="container comparison">                
                    <h3>{{$product->name}} Details</h3>
                    <div class="comparisontable">
                        {!! html_entity_decode(imageLazyLoad($product->description)) !!}
                    </div>               
            </div>
        @endif
    </section>    
    @if( isComparativeProduct($product) && isset($vendors) && !empty($vendors))
        <?php $total_saving = getSavingAmount($product, $vendors) ?>
        <div id="product_vendor_wrapper">
            <div class="container comparison" id="all_stores">                
                    <h2>{{$product->name}} Price Comparison</h2>
                    <div class="comparisontable bs-example" data-example-id="condensed-table" id="product_vendor">                        
                            @include("v3.product.common.vendors")                        
                    </div>               
            </div>
        </div>
    @else
        <?php $total_saving = getSavingAmount($product) ?>
    @endif

    @if( isset($product->availability) && $product->availability == 'Coming Soon' || !isComparativeProduct($product) )
        <?php $cols = '12' ?>
    @else
        <?php $cols = '9' ?>
    @endif
    <section id="specifications">
        <div class="container">
            <div class="col-md-{{$cols}} pleft pright specificationpadd">
                @if((isset($product->specification) && !empty($product->specification)))
                    <div class="comparison" id="specs">
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
                                    </a>
                                </div>
                            </div>
                            <a class="toggle-btndetails" id="toggle-btndetails">View More</a>
                        </div>
                    </div>
                @endif
                @if(isset($expert_data) && is_array($expert_data))
                    <div class="comparison" id="expert_review">
                        <h2>Expert Reviews</h2>
                        <div class="revied_box">
                            @foreach($expert_data as $data)
                                <div class="spec_box">
                                    <div class="spcsLeft"><span class="specHead">{!! $data->title !!}</span></div>
                                    <div class="reviewscont">{!! $data->content !!}</div>
                                </div>
                            @endforeach
                            @if(isset($expert_profile) && is_object($expert_profile))
                                @php
                                    $socials = [ 'linkedin' => 'licon', 'gplus' => 'gicon', 'facebook' => 'ficon', 'twitter' => 'ticon', 'indiashopps' => 'iicon' ]
                                @endphp                               
                                    <ul class="social">
                                        <div class="author">
                                            Reviewed By: {{$expert_profile->author}}
                                        </div>
                                        @foreach($expert_profile as $social => $link)
                                            @if( array_key_exists($social,$socials) )
                                                <li>
                                                    <a href="{{$link}}" class="scl {{$socials[$social]}}" target="_blank" rel="nofollow"></a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>                                
                            @endif
                        </div>
                    </div>
                @endif
                @if(isset($youtube_url))
                    <div id="youtube_player" class="comparison">
                        <h2>{!! app('seo')->getHeading() !!} Audio & Video</h2>
                        @if(isset($youtube_url_hindi))
                            <span class="hindi btn registrationsubmit change_video" data-url="{{$youtube_url_hindi}}">
                                View Hindi Version
                            </span>
                        @endif
                        <div class="comparisontable" id="yt_player_wrapper">
                            {!! youTubePlayer($main_product->name, $youtube_url) !!}
                        </div>
                    </div>
                @endif
                
                @if($news->isNotEmpty())
                    @include("v3.product.detail.news")
                @endif
                <div class="comparisontable comparison" style="text-align: center">
                    <a href="http://bitly.com/2KcuJ85" title="Install Indishopps Chrome Extension" target="_blank" rel="nofollow">
                        <img src='data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7' data-src="{{asset('assets/v3/images/extension_banner.jpg')}}" alt="Install Indishopps Chrome Extension"/>
                    </a>
                </div>
                @if(isset($compare_predecessor))
                    @include('v3.product.detail.compare_products')
                @endif
                <div class="comparison" id="compare_filte rs">
                    @include('v3.product.common.compare_non')
                </div>
                @if(isset($faqs) && is_array($faqs))
                    <div class="comparison" id="faqs">
                        <h2>Frequently asked questions about {{ucwords($product->name)}}</h2>
                        <div class="comparisontable">
                            @foreach($faqs as $faq)
                                <div class="spec_box question">
                                    <b>Q. </b>{{$faq->question}}
                                    <div class="answer">
                                        {{$faq->answer}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if(isComparativeProduct($main_product))
                    <div id="mobile_reviews">
                        @include('v3.product.common.review')
                    </div>
                @endif
                @if(isComparativeProduct($main_product) and !isComingSoon($product))
                    @include('v3.product.detail.product_review')
                @endif
            </div>
            @if(isComparativeProduct($main_product))
                <div class="col-md-3 pright">
                    @if( !isComingSoon($main_product) )
                        <div class="sidebar sticky" id="all_store_wrapper">
                            <div class="sidebarprodbox">
                                <div class="stickyproimg">
                                    <img class="stickyproimgsize" src="{{getImageNew('')}}" data-src="{{getImageNew($images[0],"XXS")}}" alt="productimg">
                                </div>
                                <div class="stickyproname">{{$main_product->name}}</div>
                            </div>
                            <span id="all_store_price"></span>
                            <a href="#all_stores" class="stickybutton">VIEW ALL Stores</a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </section>  
    <div style="clear:both;"></div>  
    @if(isset($deals) && !empty($deals))
        <section id="deals_on_phone_wrapper" class="sticky-stopper">
            <div class="container trendingdeals">
                <?php $Category = \indiashopps\Category::find($main_product->category_id); ?>
                <h3>Popular {{ucwords($main_product->category)}}</h3>
                <a class="expcat mtop10" href="{{getCategoryUrl($Category)}}">VIEW ALL {{$Category->name}}
                    <span class="arrow">&rsaquo;</span>
                </a>
                <div id="deals_on_phone">
                    @include('v3.product.common.ajax.deals', [ 'products' => $deals ])
                </div>
            </div>
        </section>
    @endif
    @if(isComparativeProduct($main_product))

    @else
        @if( isset($by_vendor_one) && !empty($by_vendor_one) )
            <section id="by_vendor_one_wrapper" class="sticky-stopper">
                <div class="container trendingdeals">
                    <h2 class="mbottom">Similar Product From Amazon</h2>
                    <div id="by_vendor_one">
                        @include('v3.product.common.ajax.deals', [ 'products' => $by_vendor_one ])
                    </div>
                </div>
            </section>
        @endif
        @if( isset($by_vendor_two) && !empty($by_vendor_two) )
            <section id="by_vendor_two_wrapper" class="sticky-stopper">
                <div class="container trendingdeals">
                    <h2 class="mbottom">Similar Product From Flipkart</h2>
                    <div id="by_vendor_two">
                        @include('v3.product.common.ajax.deals', [ 'products' => $by_vendor_two ])
                    </div>
                </div>
            </section>
        @endif
        @if( isset($by_brand) && !empty($by_brand) )
            <section id="by_brand_wrapper" class="sticky-stopper">
                <div class="container trendingdeals">
                    <h2 class="mbottom">Similar Product By Brand</h2>
                    <div id="by_brand">
                        @include('v3.product.common.ajax.deals', [ 'products' => $by_brand, 'brand_widget' => true ])
                    </div>
                </div>
            </section>
        @endif
    @endif
    <div class="modal fade bs-example-modal-lg" id="t_n_c" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document" style="width: 547px;">
            <div id="tnc_content">
                <div class="modal-content content_cb_wrapper">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Cashback Terms & Conditions</h4>
                    </div>
                    <div class="content_cb">
                        <p><strong>Standard Indiashopps Cashback Terms</strong></p>
                        <ul>
                            <li>To ensure your Cashback Rewards gets fully tracked, do not visit any other coupons or
                                price comparison site after you have visited Indiashopps and clicked.
                            </li>
                            <li>Best way to get cashback is to use only coupons provided on Indiashopps.com.</li>
                            <li>Your Cashback will generally be tracked in a span of 4 days after the order is
                                dispatched by the merchant.
                            </li>
                            <li>Cashback is based on various factors like Category of the product , New or Existing
                                users etc. Displayed cashback is highest for that website. Actual will be based on the
                                relevant factors.
                            </li>
                            <li>Your Cashback Rewards will be validated and Finalized within 90 days from your purchase
                                date.
                            </li>
                            <li>For all Cashback questions, you may email
                                <a href="mailto:info@indiashopps.com" target="_blank">info@indiashopps.com</a></li>
                        </ul>
                    </div>
                    <button type="button" class="close popupright10" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="upcoming_notify" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div id="notify_content">
                <div class="modal-content popup2width">
                    <div class="productdetailspopup mtop0">
                        <button type="button" class="close popupright10" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h2>Notify Me When Launched</h2>
                        <p>Currently, the device is yet to be launched. We will inform you as soon as it is available in
                            the market. Please leave your email in the box and get notified.</p>
                        <div class="searchpopup2">
                            <div id="not_message"></div>
                            <div class="input-group">
                                <input type="text" class="form-control searchboxpopup" id="notify_email" placeholder="Your Email Id" value="{{getUserEmail()}}"/>
                                <span class="input-group-btn">
                                    <button class="btn btn-default searchbutton" onclick="subscribe(this)" type="button">SUBMIT</button>
                                </span>
                            </div>
                            <div class="nes_chk">
                                <input type="checkbox" id="c31" name="cc" checked>
                                <label for="c31">
                                    <span></span>
                                    Also, stay up-to-date with new launches, deals, discount and offers !
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var load_image = "<?=get_file_url('images/loader.gif')?>";
        var target = '{{route('compare_competitors')}}';
        var form_data = {_token: '{{csrf_token()}}', product: '{{$prod}}'};
        var stickOffset;

    </script>
    <script type="text/javascript">
        function slider() {
            $('#slider3').Thumbelina({
                orientation: 'vertical',
                $bwdBut: $('#slider3 .prodletop'),
                $fwdBut: $('#slider3 .prodlebottom')
            });

        }
        document.addEventListener('jquery_loaded', function (e) {
            window.onscroll = function () {
                if (window.pageYOffset >= stickytab) {
                    header.classList.add("stickytab");
                } else {
                    header.classList.remove("stickytab");
                }
            };
            var header = document.getElementById("tabstkypro");
            var stickytab = header.offsetTop;
        });
    </script>
    <script>
        function loadRestJS() {
            loadSimpleGallery();
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
                                $('#add_porder').html('ADDED..');
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
                            button.html('ADDED..');
                            setCookie('product_{{$main_product->id}}', 'Added', 1 * 100);
                        },
                        dataType: 'json'
                    });
                }
            });
            @endif
            @endif
            slider();
            loadFontAwesome();
        }

        function subscribe(el) {
            var email = $("#notify_email").val();

            if (ValidateEmail(email)) {
                var product_id = '{{$main_product->id}}';

                $.ajax({
                    method: "GET",
                    url: "{{route('upcoming-notify')}}",
                    data: {email: email, product_id: product_id}
                }).success(function (msg) {
                    $("#not_message").html(msg).css({"color": "green"});
                    setTimeout(function () {
                        $("#upcoming_notify").modal('hide');
                    }, 2000);
                }).error(function (jqXHR) {
                    $("#not_message").html(jqXHR.responseText).css({"color": "red"});
                }).fail(function (jqXHR) {
                    $("#not_message").html(jqXHR.responseText).css({"color": "red"});
                });
            }
            else {
                $("#not_message").html("Please enter valid email").css({"color": "red"});
            }
        }

        function loadFontAwesome() {
            var interval = setInterval(function () {
                if ($("#product_review_form").isInViewport() || $("#product_vendor").isInViewport()) {
                    $("<link/>", {
                        rel: "stylesheet",
                        type: "text/css",
                        href: "https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"
                    }).appendTo("head");
                    clearInterval(interval);
                }
            }, 1500);
        }

        function change_min_max_price(min, max) {
            $.ListingPage.model.vars.min_price = min;
            $.ListingPage.model.vars.max_price = max;
        }

        function loadSimpleGallery() {
            var interval = setInterval(function () {
                if (typeof $ != "undefined") {
                    $('#demo-1 .simthucon img').simpleGallery({
                        loading_image: '/assets/v3/images/loader.gif'
                    });

                    $('#demo-1 .simpbgim').simpleLens({
                        loading_image: '/assets/v3/images/loader.gif'
                    });
                    clearInterval(interval);
                }
            }, 500);
        }

        document.addEventListener('jquery_loaded', function (e) {
            setTimeout(function () {
                var data_set = false;
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

                        if (data_set == false && $("#all_store_wrapper").isInViewport()) {
                            data_set = true;
                            generalSidebarHeight = $sticky.innerHeight();
                            stickyTop = $sticky.offset().top;
                            stickyStopperPosition = $stickyrStopper.offset().top;
                            stopPoint = stickyStopperPosition - generalSidebarHeight - stickOffset;
                            diff = stopPoint + stickOffset;
                        }
                    });
                }
            }, 1500);

            $(document).on('show.bs.dropdown', function () {
                $('#overlay-list').toggleClass("menu-open");
            });
            $(document).on('hide.bs.dropdown', function () {
                $('#overlay-list').toggleClass("menu-open");
            });

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

            $('.panel-group').on('hidden.bs.collapse', toggleIcon);
            $('.panel-group').on('shown.bs.collapse', toggleIcon);

            function toggleIcon(e) {
                $(e.target).prev('.panel-heading').find(".more-less").toggleClass('glyphicon-plus glyphicon-minus');
            }

            $(document).on('click', '.change_video', function () {
                var url = $(this).attr('data-url');
                var old_url = $("#yt_player_wrapper iframe").attr('src');

                $(this).attr('data-url', old_url);

                if ($(this).hasClass('hindi')) {
                    $(this).removeClass('hindi').addClass('english').html('View English Version');
                }
                else {
                    $(this).addClass('hindi').removeClass('english').html('View Hindi Version');
                }

                $("#yt_player_wrapper iframe").attr('src', url);
            });

            $(document).on('change', "#variants", function () {
                var url = $(this).val();

                if (url != '') {
                    window.location.href = url;
                }
            });

            $(document).on('change', '#vendor-colors', function () {
                var all_colors = $(".vendors .colors");

                if ($(this).val().length > 0) {
                    all_colors.fadeOut('fast');
                    $(".vendors ." + $(this).val()).fadeIn('fast');
                }
                else {
                    all_colors.fadeIn('fast');
                }
                setTimeout(function () {$(window).trigger('scroll')}, 250);
                return false;
            });
        });
    </script>
		<style>
        h4,.h4{font-size:16px;font-weight:700;padding-top:15px}
        .checkbox.features label{width:100%}
        .positrelat{position:relative!important}
        #slider3{position:relative;margin:45px 10px;height:300px;display:block}
        .thumbelina{list-style:none;padding:0;margin:0;position:absolute;white-space:nowrap;font-size:0;-webkit-touch-callout:none;-webkit-user-select:none}
        .thumbelina li{padding:5px;line-height:0;margin:0}
        .thumbelina-but{position:absolute;z-index:1;cursor:pointer;color:#888;text-align:center;vertical-align:middle;font-size:14px;font-weight:700;font-family:monospace}
        .thumbelina-but:hover{color:#fff}
        .thumbelina-but.disabled,.thumbelina-but.disabled:hover{color:#ccc;cursor:default;box-shadow:none}
        .thumbelina-but.horiz{width:20px;height:119px;line-height:119px;top:-1px}
        .thumbelina-but.horiz.left{left:-22px;border-radius:5px 0 0 5px}
        .thumbelina-but.horiz.right{right:-22px;border-radius:0 5px 5px 0}
        .aropr{height:17px;display:block;background-image:url(/assets/v3/images/icon-sprite.png)}
        .prodletop{background-position:-46px 37px}
        .prodlebottom{background-position:-47px 22px}
        .thumbelina-but.top{left:5px;top:-20px;height:20px;line-height:20px;width:52px;background:#ff4631;border-radius:5px 5px 0 0}
        .thumbelina-but.bottom{left:5px;bottom:-20px;height:20px;line-height:20px;width:52px;background:#ff4631;border-radius:0 0 5px 5px}
        .use_code{clear:both;font-size:11px;font-weight:700;margin-top:3px;background:#daefde;padding:3px 5px;border:1px dashed #a2bda7;color:#003c0b;display:inline-block}
        .font_weight{font-weight:400!important}
        .width12{width:15%}
        .width8{width:8%}
        .width25{width:25%}
        .width25 a{font-size:12px;clear:both;display:block;padding-top:3px}
        .width21{width:18%}
        .width10{width:10%}
        .nes_chk{margin-top:15px;display:block;text-align:left}
        .nes_chk label{display:block!important}
        .nes_chk input[type="checkbox"] + label{display:block!important;font-size:14px!important}
        #variants{font-weight:700;border-radius:5px;margin:5px 0}
        </style>
@endsection