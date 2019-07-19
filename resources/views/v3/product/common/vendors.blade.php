@if(isset($vendors) && !empty($vendors))
    <table class="table table-condensed vendors">
        <thead>
        <tr>
            <th>STORE NAME</th>
            <th>
                @foreach($vendors as $v)
                    @php
                        $v = $v->_source;
                        if( isset($v->color) )
                        {
                            $colors[] = strtolower($v->color);
                        }
                    @endphp
                @endforeach
                <select id="vendor-colors">
                    <option value="">All Colors</option>
                    @if( isset($colors) )
                        <?php $colors = array_unique($colors); ?>
                        @foreach($colors as $color)
                            <option value="{{cs($color)}}">{{ucwords($color)}}</option>
                        @endforeach
                    @endif
                </select>
            </th>
            <th>PRICE</th>
            <th>DELIVERY</th>
            <th>free shipping</th>
            <th>Rating</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($vendors as $v)
            <?php $v = $v->_source; ?>
            <tr class="colors {{isset($v->color) ? cs($v->color) : ''}}">
                <td class="width12">
                    <img class="vendorlogoimg" src="{{getImageNew('')}}" data-src="{{config('vendor.vend_logo.'.$v->vendor)}}" alt="{{config('vendor.name.'.$v->vendor)}} Logo">
                    <br/>
                    <div class="cas_bak">
                        @if($v->vendor == 3 && isset($v->cb_allowed) && empty($v->cb_allowed))
                            No Cashback
                        @else
                            {{getCashbackText($v->vendor)}}
                        @endif
                    </div>
                    <span class="tandc" data-target="#t_n_c" data-toggle="modal">
                        <i class="fa fa-info-circle"></i>
                    </span>
                </td>
                <td class="width8">
                    <div class="prodetails">
                        @if(isset($v->color))
                            {{ucwords($v->color)}}
                        @endif
                    </div>
                </td>
                <td class="width25">
                    <div class="flprice">
                        @if( $v->track_stock == 1 )
                            Rs {{number_format($v->saleprice)}}
                        @else
                            Out Of Stock
                        @endif
                    </div>
                    @if(isComparativeProduct($product) && ($v->track_stock == 1))
                        @if($v->vendor == 3)
                           <a href="{{env('AMAZON_OFFER_LISTING')}}{{$v->product_id}}" target="_blank">View All Offers</a>
                        @elseif($v->vendor == 1)
                            <a href="{{env('FLIPKART_OFFER_LISTING')}}{{$v->product_id}}" target="_blank">View All Offers</a>
                        @endif
                     @endif   
    @if(isset($v->code) && !empty($v->code))
        <div class="use_code font_weight">Use Coupon {{$v->code}} & buy at best price.</div>
    @endif
</td>
<td class="width21">
    @if(isset($v->delivery))
        <div class="delivery">{{(!is_null($v->delivery))? $v->delivery : ''}}</div>

    @endif
</td>
<td class="width12">
    <div class="free-shipping">
        <span class="glysdphicon-ok">&#9989;</span></div>
</td>
<td class="width12">
    @if(isset($v->rating))
        <div class="str-rtg">
            <span style="width:{{percent($v->rating,5)}}%" class="str-ratg"></span>
        </div>
    @endif
</td>
<td class="width10">
    @if($v->track_stock == 1)
        <a href="{{productAffLink($main_product, $v->ref_id)}}" target="_blank" class="productgoto {{(!getCashbackText($v->vendor, false) || ($v->vendor == 3 && isset($v->cb_allowed) && empty($v->cb_allowed))) ? 'no_cb' : ''}}" rel="nofollow">
            go to store
        </a>
    @else
        <a href="{{productAffLink($main_product, $v->ref_id)}}" target="_blank" class="productgoto no_cb">Out
            Of Stock</a>
    @endif
</td>
</tr>
@endforeach
</tbody>
</table>
@endif