@if($order->products->count() > 0)
    @foreach($order->products as $product)
        <tr class="border-bottom">
            <td>
                <a href="javascript:void(0)" title="Delete Product" onclick="confirmAction('delete',{product_id:'{{$product->id}}'})">
                    <i class="fa fa-trash orange"></i>&nbsp;
                </a>
                {{$product->product_name}}
            </td>
            <td>
                <img src="{{getImageNew($product->product_image, "XXS")}}" style="max-height: 50px;"/>
            </td>
            <td>Rs {{number_format($product->product_price)}}</td>
            <td class="quantity" title="Click outside to update..">
                @if($order->status != \indiashopps\Models\PurchaseOrder::STATUS_CLOSED)
                    <input type="number" class="quantity_input" value="{{($product->quantity)}}" id="{{$product->id}}" name="quantity" min="1"/>
                @else
                    {{($product->quantity)}}
                @endif
            </td>
            <td>Rs {{number_format($product->product_price * $product->quantity)}}</td>
            <td>Rs {{number_format($product->cashback * $product->quantity, 2)}}</td>
            <td>{{config('vendor.name.'.$product->vendor)}}</td>
            <td>
                @php

                    if( $product->comp == '1' )
                    {
                        $product_url = route('product_detail_v2',[cs($product->product_name),$product->product_id]);
                    }
                    else
                    {
                        $product_url = route('product_detail_non',[$product->product_group,cs($product->product_name),$product->product_id, $product->vendor]);
                    }
                @endphp
                <a href="{{$product_url}}" title="View Detail" class="btn btn-orange" target="_blank">
                    View
                </a>
                <a href="{{$product->out_url}}" title="View Detail" class="btn btn-orange out_url" target="_blank">
                    Buy Now
                </a>
            </td>
        </tr>
    @endforeach
    <tr class="pright">
        <td colspan="4">
            <strong>Order Total</strong>
        </td>
        <td colspan="4">
            Rs. {{number_format($order->total_price,2)}}
        </td>
    </tr>
    @if($order->total_cashback>0)
        <tr class="pright">
            <td colspan="4">
                <strong>Total Cashback</strong>
            </td>
            <td colspan="4">
                Rs {{number_format($order->total_cashback,2)}}
            </td>
        </tr>
    @endif
    @if($order->total_savings>0)
        <tr class="pright">
            <td colspan="4">
                <strong>Total Saving</strong>
            </td>
            <td colspan="4">
                Rs {{number_format($order->total_savings,2)}}
            </td>
        </tr>
    @endif
@else
    <tr>
        <td colspan="6">No Product(s)</td>
    </tr>
@endif