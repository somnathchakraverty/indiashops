@if(!isset($ajax))
    <div class="col-md-6 pleft mtop10">
        <div class="input-group">
            <div class="input-group-btn search-panel">
                <select name="cat_id" class="All-Categories">
                    <option value="0">All Coupons</option>
                    @foreach($cats as $cat)
                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="searchicon"></div>
            <div class="search_wrapper">
                <input type="text" class="form-control Search-anything Searchbgcolor" name="x" placeholder="Search anything...">
                <div class="clear_search" data-section="coupons" style="display: none">&nbsp;</div>
            </div>
            <span class="input-group-btn">
                <button class="btn btn-default searchbutton buttonbgcolor section_search" data-section="coupons" type="button">SEARCH</button>
            </span></div>
    </div>
    <div class="couponsdealsbox" id="coupons_search">
        @endif
        <div class="cs_dkt_si">
            <ul>
                @foreach( $coupons as $coupon )
                    <li>
                        <?php
                        $data['type'] = isset($coupon->code) && !empty($coupon->code) ? "coupon" : "promotion";
                        $data['outurl'] = $coupon->offer_page;
                        $data['inpage'] = route('category_page_v2', [create_slug($coupon->category)]);
                        $data['code'] = $coupon->code;
                        ?>

                        <div class="thumnail coupon_thum" data-src="{{json_encode($data)}}" data-in-page="{{route('category_page_v2',[create_slug($coupon->category)])}}" data-type="{{isset($coupon->code) && !empty($coupon->code) ? "coupon" : "promotion"}}" data-out-page="{{route('coupon_out_page',[$coupon->offerid])}}" data-code="{{base64_encode($coupon->code)}}">
                            <div class="couponsthumnailimgbox">
                                <img class="couponsproductimg" src="{{getImageNew("","M")}}" data-src="{{getCouponImage($coupon->image,'L')}}" alt="{{$coupon->vendor_name}} Image">
                            </div>
                            <div class="couponsdiscount_name">{{$coupon->title}}</div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        @if(!isset($ajax))
    </div>
@endif
<style>
    .clear_search { position: absolute; right: 18%; top: 3px; z-index: 99 }
    .clear_search:before { content: "x"; font-size: 25px; font-weight: bold; }
    .clear_search:hover { cursor: pointer; }
</style>