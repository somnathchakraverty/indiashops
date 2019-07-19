@if(isset($coupons) && !empty($coupons) && is_array($coupons))
<ul id="flexiselDemo13" class="carousel" data-items="5">
    @foreach($coupons as $coupon)
        <?php $coupon = $coupon->_source ?>
    <li>
        <div class="thumnail coupon_thum" data-in-page="{{route('category_page_v2',[create_slug($coupon->category)])}}" data-type="{{isset($coupon->code) && !empty($coupon->code) ? "coupon" : "promotion"}}" data-out-page="{{route('coupon_out_page',[$coupon->offerid])}}" data-code="{{base64_encode($coupon->code)}}">
            <div class="loansthumnailimgbox couponsparheight">
                <img class="couponsproductimg" src="{{getImageNew('')}}" data-src="{{getCouponImage($coupon->image_url,"L")}}" alt="amazon">
            </div>
            <div class="loans-container coupons-container">
                <div class="couponsproduct_name2">{{$coupon->title}}</div>
                {{--<div class="usedtodaytext">235 Used today</div>--}}
            </div>
        </div>
    </li>
    @endforeach
</ul>
@endif