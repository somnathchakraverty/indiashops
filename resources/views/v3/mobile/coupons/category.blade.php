@extends("v3.mobile.master")
@section('head')
    <style>
        #partner_deals li, #recent_offer li { width: 210px; }
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
    <section id="partner_deals">
        <div class="whitecolorbg">
            <div class="container">
                <h1>{{$title}} Coupons, Offers & Promotion Codes - Indiashopps ({{$product_count}})</h1>
                <div class="css-carousel">
                    <ul>
                        @foreach($coupons as $coupon)
                            <?php $coupon = $coupon->_source; ?>
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
                <h2>Get Coupons and Offers For All</h2>
                <div class="bulletpoint">{!! app('seo')->getShortDescription() !!}</div>
                @include('v3.mobile.coupons.everything')
                <a class="allcateglink" href="{{route('coupons_v2')}}">
                    Explore all categories <span class="right-arrow"></span>
                </a>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{get_file_url('mobile/js/front.js')}}" defer></script>
@endsection