@if(isset($products) && count($products) > 0)
<div class="whitecolorbg">
    <div class="sub-title"><span>{{ucwords($name)}} -  Coupon, Offers</span></div>
    <div class="couponlistnewpage">
        <ul>
            @foreach($products as $key => $coupon)
            <li>
                <?php $c = $coupon->_source ?>
                <div class="coupon">
                    <div class="scissors"><i class="fa fa-scissors"></i></div>
                    <a href="{{route('vendor_page_v2',[$c->vendor_name])}}?code={{$c->promo}}" target="_blank" data="{{encrypt($c)}}" out-url="{{$c->offer_page}}" onClick="ga('send', 'event', 'coupon', 'click');" class="get-code">
                        <div class="coupon__tag">{{str_replace('|',' ',$c->offer_name)}}</div>
                        <div class="coupon__body">
                            <div class="coupon__logo">
                                <img src="{{$c->image_url}}" alt="coupon logo" style="width:80px;" />
                            </div>
                            <div class="coupon__title">{{$c->category}}</div>
                            <div class="coupon__value">
                                {{($c->type=='coupon') ? 'Discount Coupons' : 'Deals & Promotion'}}
                            </div>
                        </div>
                    </a>
                </div>
            </li>
            @endforeach
        </ul>
        <a class="btn btn-success margin-top couponbutnew" href="{{route('vendor_page_v2',[$c->vendor_name])}}" target="_blank">More Coupon Offers</a>
    </div>
</div>
@endif
