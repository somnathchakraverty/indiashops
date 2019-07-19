<div class="whitecolorbg">
    <div class="container">   
        <h2>Coupons for your delight</h2>    
        <div class="css-carousel">
                <ul>
                    @foreach( $coupons as $coupon )
                        <li>
                            <div class="thumnail" type="{{isset($coupon->code) && !empty($coupon->code) ? "coupon" : "promotion"}}" outurl="{{$coupon->offer_page}}" inpage="{{route('category_page_v2',[create_slug($coupon->category)])}}" code="{{$coupon->code}}">
                                <div class="couponsthumnailimgbox">
                                    <img class="couponsproductimg" data-src="{{getCouponImage($coupon->image,'L')}}" alt="{{$coupon->vendor_name}} Image">
                                </div>
                                <div class="couponsdiscount_name">{{$coupon->title}}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>           
        </div>       
            <a href="{{route('coupons_v2')}}" target="_blank"  class="allcateglink">
                VIEW ALL Coupons
               <span class="right-arrow"></span>
            </a>       
    </div>
</div>