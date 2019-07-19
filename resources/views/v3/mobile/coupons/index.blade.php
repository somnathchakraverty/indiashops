@extends("v3.mobile.master")
@section('head')
<style>
#partner_deals li, #recent_offer li{width:210px;}
</style>
@endsection
@section('page_content')
    <!--THE-BANNER-->
    @if(!is_null($slider))
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
    <!--THE-PART-1-->
    <section>
        <div class="whitecolorbg">
            <div class="container">
                <h2>Find Coupons for Everything</h2>
                @include('v3.mobile.coupons.everything')
            </div>
        </div>
    </section>
    <!--END-PART-1-->
    <!--THE-PART-2-->
    <section id="partner_deals">
        <div class="whitecolorbg">
            <div class="container">
                <h2>Deals from partners website</h2>                
                    <div class="css-carousel">                        
                            <ul>
                                @foreach( $partner_deals as $deal )
                                    <li>                                       
                                            <a class="thumnail" href="{{route('vendor_page_v2',[create_slug($deal->key)])}}" target="_blank">
                                                <div class="loansthumnailimgbox">
                                                    <img class="productimg" src="{{get_file_url("images/coupons/logos/".create_slug($deal->key).".jpg")}}" alt="{{ucwords($deal->key)}}"/>
                                                </div>
                                                <div class="loans-container">
                                                    <div class="product_name textcenter" onclick="window.open('{{route('vendor_page_v2',[create_slug($deal->key)])}}')">{{$deal->doc_count}}
                                                        Offers
                                                    </div>
                                                    <div class="rate-starts" onclick="window.open('{{route('vendor_page_v2',[create_slug($deal->key)])}}')">
                                                        Cashback upto 60%
                                                    </div>
                                                </div>
                                                <span class="productbutton">Explore Offers</span>
                                            </a>                                       
                                    </li>
                                @endforeach
                            </ul>
                       
                    </div>
               
            </div>
        </div>
    </section>
    <!--END-PART-2-->
    <!--THE-PART-3-->
    <section>
        <div class="whitecolorbg">
            <div class="container">
                <h2>Coupons from your favourite stores</h2>
                <div class="css-carousel">                   
                        <ul>
                            @foreach( $coupons as $coupon )
                                <li>
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
    <!--END-PART-3-->
    <!--THE-PART-4-->
    <section>
        <div class="whitecolorbg">
            <div class="container">
                <h2>Best Coupons today</h2>
                <div class="product-tabs martop8 css-carouseltab padding-btm0">                                      
                            <ul class="tabs" id="part-tab-1">
                                <?php $i = 0 ?>
                                @foreach($categories as $category => $coupons)
                                    <li class="tab">
                                        <a class="{{($i++==0) ? 'active' : ''}}" href="#{{$category}}">{{unslug($category)}}</a>
                                    </li>
                                @endforeach
                            </ul>
                </div>
                @foreach($categories as $category => $coupons)
                    <div class="tab-content" id="{{$category}}">
                        <div class="mobilecard2 martop30">
                            <ul>
                                @foreach($coupons as $coupon)
                                    <?php $coupon = $coupon->_source; ?>
                                    <li>
                                        <div class="thumnailcard coupon_thum" type="{{isset($coupon->code) && !empty($coupon->code) ? "coupon" : "promotion"}}" outurl="{{$coupon->offer_page}}" inpage="{{route('category_page_v2',[create_slug($coupon->category)])}}" code="{{$coupon->code}}">
                                            <div class="usedtodaytext">{{$coupon->offer_name}}</div>
                                            <div class="couponsthumnailimgbox">
                                                <img class="couponsproductimg" src="{{$coupon->image_url}}" alt="{{$coupon->vendor_name}} coupon">
                                            </div>
                                            <div class="coupcont">
                                                <div class="couponsproduct_name">
                                                    {{$coupon->description}}
                                                </div>
                                            </div>
                                            <div class="productbutton2">View offer</div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        {{--<a href="#" class="productbutton orangebutton" id="toggle-btndetails2">View More</a></div>--}}
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
@endsection
@section('scripts')
    <script src="{{get_file_url('mobile/js/front.js')}}" defer></script>
@endsection