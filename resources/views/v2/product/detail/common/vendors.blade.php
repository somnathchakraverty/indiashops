@if(count($vendors)>0)
<div class="whitecolorbg">
    <table class="table table-striped">
        <tbody>
        @foreach( $vendors as $v )
        <?php $vendor = $v->_source; ?>
        <tr>
            <td>
                <img src="{{config('vendor.vend_logo.'.$vendor->vendor )}}" width="60px;">
                <div class="star-ratingtable">
                    <span class="fa fa-star" data-rating="1"></span>
                    <span class="fa fa-star" data-rating="2"></span>
                    <span class="fa fa-star" data-rating="3"></span>
                    <span class="fa fa-star-o" data-rating="4"></span>
                </div>
            </td>
            <td class="emitext">EMI:
                @if( !empty($vendor->emiAvailable) )
                    <b>Yes</b>
                @else
                    <b>No</b>
                @endif
            </td>
            <td>
                @if(!empty($vendor->delivery) && $vendor->delivery != "NULL")
                    Delivery: {{$vendor->delivery}}
                @endif
                <span class="dis-inher">
                    Color:
                    @foreach(explode(";",trim($vendor->color,'"')) as $color)
                        <span class="store_color {{str_slug($color)}}"
                              title="{{ucwords($color)}}">
                        </span>
                    @endforeach
                </span></td>
            <td>
                <b class="sub-title1">Rs. {{number_format($vendor->saleprice)}}</b>
                <span class="dis-inher font-12">
                    <b class="red-color">FREE</b> Shipping
                </span>
            </td>
            <td>
                @if($vendor->track_stock==0)
                    <a type="button" class="btn btn-danger details-btn" target="_blank" href="{{$vendor->product_url}}" onClick="ga('send', 'event', 'shop', 'click');" rel="nofollow">Out Of Stock</a>
                @else
                    <a type="button" class="btn btn-danger details-btn" target="_blank" href="{{$vendor->product_url}}" onClick="ga('send', 'event', 'shop', 'click');" rel="nofollow">SHOP NOW</a>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif
