<?php $opened = false; ?>
@foreach($coupons as $key => $coupon)
    <?php $coupon = $coupon->_source ?>
    @if($key%4 == 0)
        <?php $opened = true; ?>
        <div class="border-bottom">
            @endif

            <div class="thumnail couthumnail2 coupon_thum" data-in-page="{{route('category_page_v2',[create_slug($coupon->category)])}}" data-type="{{isset($coupon->code) && !empty($coupon->code) ? "coupon" : "promotion"}}" data-out-page="{{route('coupon_out_page',[$coupon->offerid])}}" data-code="{{base64_encode($coupon->code)}}">
                <div class="couponsthumnailimgbox">
                    <img class="couponsproductimg" src="{{getImageNew('')}}" data-src="{{getCouponImage($coupon->image_url,"L")}}" alt="coupons">
                </div>
                <div class="couponsdiscount_name">{{implode(" ",explode("|",$coupon->offer_name))}}</div>
            </div>

            @if( ($key != 0 && ($key+1) % 4 == 0) || ( $key + 1 == count($coupons) && $opened ) )
                <?php $opened = false; ?>
        </div>
    @endif
@endforeach
<div class="button" style="text-align: center;height: 50px;padding-top: 9px;">
    @if(isset($page) && $page > 1)
        <a href="javascript:void(0)" class="btn btn-default registrationsubmit" id="prev-page">Prev</a>
    @endif

    @if(count($coupons) == config('app.listPerPage'))
        <a href="javascript:void(0)" class="btn btn-default registrationsubmit" id="next-page">Next</a>
    @endif
</div>