<?php $opened = false; ?>
@foreach($coupons as $key => $coupon )
    @if($key%5 == 0)
        <?php $opened = true; ?>
        <div class="border-bottom">
            @endif
            <?php $coupon = $coupon->_source ?>
            <div class="thumnail couthumnail coupon_thum" data-in-page="{{route('category_page_v2',[create_slug($coupon->category)])}}" data-type="{{isset($coupon->code) && !empty($coupon->code) ? "coupon" : "promotion"}}" data-out-page="{{route('coupon_out_page',[$coupon->offerid])}}" data-code="{{base64_encode($coupon->code)}}">
                {{--<div class="usedtodaytext">235 Used today</div>--}}
                <div class="couponsofferbox">                   
                        {{--<div class="flatdis">Flat</div>--}}
                        <?php $parts = explode('|', $coupon->offer_name); ?>
                        <div class="coudiscountname">{{$parts[0]}}
                            @if(isset($parts[1]))
                                <span>{{$parts[1]}}</span>
                            @endif
                        </div>
                  
                    <div class="couponsicon"><img src="{{get_file_url('images')}}/coupons/coupons_icon.png" alt="icon">
                    </div>
                </div>
                <div class="stats-container stats-containercoup">
                    <div class="couponsproduct_name">{{$coupon->title}}</div>
                </div>
                <div class="productbutton">View {{( $coupon->type == 'coupon' ) ? 'Code' : 'Offer' }}</div>
            </div>
            @if( ($key != 0 && ($key+1) % 5 == 0) || ( $key + 1 == count($coupons) && $opened ) )
                <?php $opened = false; ?>
        </div>
    @endif
@endforeach