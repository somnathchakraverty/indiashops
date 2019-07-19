@if(isset($vendors) && is_array($vendors) && !empty($vendors))
    <div class="whitecolorbg padding15px">
        <div class="container">
            <h2>{{$product->name}} Price Comparison</h2>
            <div class="more-less-product4">
                <table class="table table-condensed">
                    <tbody>
                    @foreach($vendors as $v)
                        <?php $v = $v->_source; ?>
                        <tr>
                            <td>
                                <div class="vendorlogo">
                                    <img class="vendorlogoimg" alt="{{config('vendor.name.'.$v->vendor)}} Logo" src="{{getImageNew('')}}" data-src="{{config('vendor.vend_logo.'.$v->vendor)}}">
                                    <div class="cas_bak">
                                        @if($v->vendor == 3 && isset($v->cb_allowed) && empty($v->cb_allowed))
                                            No Cashback
                                        @else
                                            {{getCashbackText($v->vendor)}}
                                        @endif
                                    </div>
                                    <span class="tandc modal-trigger" data-target="t_n_c">
                                        <i class="fa fa-info-circle"></i>
                                    </span>
                                </div>
                                @if(isset($v->delivery) && !empty($v->delivery))
                                    <div class="delivery">{{$v->delivery}}</div>
                                @endif
                            </td>
                            <td>
                                <div class="flprice">
                                    @if( $v->track_stock == 1 )
                                        &#8377; {{number_format($v->saleprice)}}
                                    @else
                                        Out Of Stock
                                    @endif
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
                                </div>
                                @if(isset($v->color) && !empty($v->color))
                                    <div class="delivery">
                                        <span class="{{create_slug($v->color)}}-color" title="{{$v->color}}"></span>
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($v->track_stock == 1)
                                    <a href="{{productAffLink($main_product, $v->ref_id)}}" target="_blank" class="productgoto">go to
                                        store</a>
                                @else
                                    <a href="{{productAffLink($main_product, $v->ref_id)}}" target="_blank" class="productgoto">Out Of
                                        Stock</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <a class="toggle-btndetails moreproduct allcateglink" id="toggle-btndetails4">
                VIEW ALL Prices <span>&rsaquo;</span>
            </a>
        </div>
    </div>
@endif