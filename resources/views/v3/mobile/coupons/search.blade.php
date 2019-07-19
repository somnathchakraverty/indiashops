@extends("v3.mobile.master")
@section('head')
<style>
#partner_deals li, #recent_offer li{width:210px;}
</style>
@endsection
@section('page_content')
    <section>
        <div class="whitecolorbg">
            <div class="container">
                <h2>Find Coupons for Everything</h2>
                @include('v3.mobile.coupons.everything')               
                <a class="allcateglink" href="{{route('coupons_v2')}}">
                    Explore all categories <span class="right-arrow"></span>
                </a>
            </div>
            
        </div>
    </section>
    <section>
        <div class="whitecolorbg">
            <div class="container">
                <h2>{{ucwords($query)}} Coupons, Offers & Promotion Codes - Indiashopps ({{$product_count}})</h2>
                <div class="mobilecard2">
                    @if(isset($coupons) && count($coupons) > 0)
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
                    @else
                        Sorry!! No Coupon(s) found your query. !
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section id="recent_offer">
        <div class="whitecolorbg">
            <div class="container" >
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