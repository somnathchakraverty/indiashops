<?php $opened = false; ?>
<div class="catgprofullbox" style="margin-top:15px;">
    @foreach($coupons as $key => $coupon )
        <?php $coupon = $coupon->_source ?>
        @if($key%5 == 0)
            <?php $opened = true; ?>
            <div class="border-bottom">
                @endif

                <div class="thumnail couthumnail coupon_thum" data-in-page="{{route('category_page_v2',[create_slug($coupon->category)])}}" data-type="{{isset($coupon->code) && !empty($coupon->code) ? "coupon" : "promotion"}}" data-out-page="{{route('coupon_out_page',[$coupon->offerid])}}" data-code="{{base64_encode($coupon->code)}}">
                    {{--<div class="usedtodaytext">235 Used today</div>--}}
                    <div class="couponsthumnailimgbox">
                        <img class="couponsproductimg" src="{{getImageNew('')}}" data-src="{{getCouponImage($coupon->image_url,"L")}}" alt="">
                    </div>
                    <div class="stats-container">
                        <div class="couponsproduct_name">{{$coupon->title}}</div>
                    </div>
                    <div class="productbutton">View {{( $coupon->type == 'coupon' ) ? 'Code' : 'Offer' }}</div>
                </div>

                @if( ($key != 0 && ($key+1) % 5 == 0) || ( $key + 1 == count($coupons) && $opened ) )
                    <?php $opened = false; ?>
            </div>
        @endif
    @endforeach
    {{--<a href="#" class="couponsallbutton">view More offers</a>--}}
</div>