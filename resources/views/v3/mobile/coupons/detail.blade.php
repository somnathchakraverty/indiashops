@extends("v3.mobile.master")
@section('head')
<style>
#partner_deals li, #recent_offer li{width:210px;}
</style>
@endsection
@section('page_content')
    <!--THE-BANNER-->
    @if(isset($slider) && !is_null($slider))
        <div class="banner">
            @if(isset($slider->refer_url) && filter_var($slider->refer_url,FILTER_VALIDATE_URL))
                <a href="{{$slider->refer_url}}" target="_blank">
                    <img class="img-responsive" src="{{$slider->image_url}}" alt="{{$slider->alt}}">
                </a>
            @else
                <img class="img-responsive" src="{{$slider->image_url}}" alt="{{$slider->alt}}">
            @endif
        </div>
    @endif
    <!--END-BANNER-->
    <?php $coupon = collect($coupons)->first()->first();?>
    <section>
        <div class="whitecolorbg">
            <div class="container">
                <h1>{{$product_count}} {{ucwords($vendor_name)}} Coupons, Offers and Deals available today</h1>
                <div class="couponsbrandlogo">
                    <img class="coubeandlogo" src="{{getCouponImage($coupon->_source->image_url,"L")}}" alt="{{$vendor_name}} logo"/>
                </div>
                <p class="small">
                    {{app('seo')->getShortDescription()}}
                </p>
            </div>
        </div>
    </section>
    <!--THE-PART-4-->
    <section>
        <div class="whitecolorbg">
            <div class="container">
                <h2>Best Coupons today</h2>
                <div class="product-tabs martop8">
                    <ul class="tabs" id="part-tab-1">
                        <?php $i = 0; ?>
                        @foreach($coupons as $type => $tcoupons )
                            @if( isset($facets->type) )
                                <?php $c_count = 0; ?>
                                @foreach($facets->type->buckets as $t)
                                    @if( $t->key == $type )
                                        <?php $c_count = $t->doc_count; ?>
                                    @endif
                                @endforeach
                            @endif
                            <li class="tab">
                                <a class="{{($i++==0) ? 'active' : ''}}" href="#{{$type}}">
                                    {{ucwords($type)}} Codes ({{$c_count}})
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <?php $i = 0; ?>
                @foreach($coupons as $type => $tcoupons )
                    <div class="tab-content" id="{{$type}}">
                        <div class="mobilecard2 martop30">
                            <ul>
                                @foreach($tcoupons as $coupon)
                                    <?php $coupon = $coupon->_source; ?>
                                    <?php $parts = explode('|', $coupon->offer_name); ?>
                                    <li>
                                        <div class="thumnailcard">
                                            <div class="usedtodaytext">{{ucwords($coupon->category)}}</div>
                                            <div class="couponsofferbox">
                                                <div class="couofferstextbox">
                                                    <div class="flatdis">
                                                        @if(stripos($coupon->offer_name,"off") !== false)
                                                            Flat
                                                        @endif
                                                    </div>
                                                    <div class="coudiscountname">{{$coupon->offer_name}}</div>
                                                </div>
                                                <div class="couponsicon">
                                                    <img src="{{get_file_url('images')}}/coupons/coupons_icon.png" alt="icon">
                                                </div>
                                            </div>
                                            <div class="coupcont">
                                                <div class="couponsproduct_name">
                                                    {{$coupon->title}}
                                                </div>
                                            </div>
                                            <div class="productbutton">
                                                View {{( $coupon->type == 'coupon' ) ? 'Code' : 'Offer' }}</div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--END-PART-4-->
    <!--THE-PART-5-->
    <section id="recent_offer">
        <div class="whitecolorbg">
            <div class="container">
                <h2>Recently used offers</h2>
                <div class="css-carousel">                   
                        <ul>
                            @foreach($recent_offers as $offer)
                                <?php $coupon = $offer->_source; ?>
                                <li>
                                    <div class="thumnail coupon_thum" type="{{isset($coupon->code) && !empty($coupon->code) ? "coupon" : "promotion"}}" outurl="{{$coupon->offer_page}}" inpage="{{route('category_page_v2',[create_slug($coupon->category)])}}" code="{{$coupon->code}}">
                                        <div class="usedtodaytext">{{$coupon->offer_name}}</div>
                                        <div class="loansthumnailimgbox couponsparheight">
                                            <img class="productimg" src="{{$coupon->image_url}}" alt="{{$coupon->vendor_name}} coupon">
                                        </div>                                        
                                            <div class="couponsproduct_name">
                                                {{$coupon->description}}                                           
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                  
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="whitecolorbg">
            <div class="container">
                <h2>Coupons from your favourite stores</h2>
                <div class="css-carousel">                   
                        <ul>
                            @foreach( $scoupons as $coupon )
                                <li class="product">
                                    <div class="thumnail coupon_thum" type="{{isset($coupon->code) && !empty($coupon->code) ? "coupon" : "promotion"}}" outurl="{{$coupon->offer_page}}" inpage="{{route('category_page_v2',[create_slug($coupon->category)])}}" code="{{$coupon->code}}">
                                        <div class="couponsthumnailimgbox">
                                            <img class="couponsproductimg" data-src="{{getCouponImage($coupon->image,'L')}}" alt="{{$coupon->vendor_name}} Image">
                                        </div>
                                        <div class="couponsdiscount_name">{{$coupon->title}}</div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="whitecolorbg">
            <div class="container">
                <h1>Find Coupons for Everything</h1>
                @include('v3.mobile.coupons.everything')
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{get_file_url('mobile/js/front.js')}}" defer></script>
@endsection