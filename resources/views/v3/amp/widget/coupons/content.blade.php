<amp-carousel class="full-bottom" height="145" layout="fixed-height" type="carousel">
    @foreach( $coupons as $coupon )
        <div class="thumnail">
            <a href="{{$coupon->offer_page}}" target="_blank">
                <div class="couponsthumnailimgbox">
                    <amp-img class="couponsproductimg" src="{{getCouponImage($coupon->image,'L')}}" width="110" height="110" alt="{{$coupon->vendor_name}} Image"></amp-img>
                </div>
                <div class="couponsdiscount_name">{{$coupon->title}}</div>
            </a>
        </div>
    @endforeach
</amp-carousel>