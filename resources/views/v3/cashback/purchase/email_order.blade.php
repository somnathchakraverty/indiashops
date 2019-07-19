<div style="font-size:14px;font-family:Verdana, Arial, Helvetica, sans-serif, circular, 'Circular Std Black';">
Hi {{auth()->user()->name}},<br/><br/>

Please find below the Order Detail as requested..<br/>
<section class="v-m-cb-claims">
    <div class="container">
        <h2 class="hmb-5">Purchase Order Detail</h2>
        <ul class="list-unstyled mb-5">
            <li class="media p-2 border-top" style="border-bottom:2px dashed #e0e0e0;margin-bottom:10px;">
                <div class="c-lable">
                    <span><strong>Created On:</strong></span>
                </div>
                <div class="media-body" style="padding:8px 0px;">
                    <div class="c-lable-data">
                        <span>{{$order->getDate()}}</span>
                    </div>
                </div>
            </li>
            <li class="media p-2 my-3 border-top" style="border-bottom:2px dashed #e0e0e0;margin-bottom:10px;">
                <div class="c-lable">
                    <span><strong>No of Products:</strong></span>
                </div>
                <div class="media-body" style="padding:8px 0px;">
                    <div class="c-lable-data">
                        <span>{{$order->totalProducts()}}</span>
                    </div>
                </div>
            </li>
            <li class="media p-2 my-3 border-top" style="border-bottom:2px dashed #e0e0e0;margin-bottom:10px;">
                <div class="c-lable">
                    <span><strong>Order Total:</strong></span>
                </div>
                <div class="media-body" style="padding:8px 0px;">
                    <div class="c-lable-data">
                        <span>Rs. {{number_format($order->total_price,2)}}</span>
                    </div>
                </div>
            </li>
            <li class="media p-2 my-3 border-top" style="border-bottom:2px dashed #e0e0e0;margin-bottom:10px;">
                <div class="c-lable">
                    <span><strong>Total Saving:</strong></span>
                </div>
                <div class="media-body" style="padding:8px 0px;">
                    <div class="c-lable-data">
                        <span>Rs {{number_format($order->total_savings,2)}}</span>
                    </div>
                </div>
            </li>
            <li class="media p-2 my-3 border-top" style="border-bottom:2px dashed #e0e0e0;margin-bottom:10px;">
                <div class="c-lable">
                    <span><strong>Status:</strong></span>
                </div>
                <div class="media-body" style="padding:8px 0px;">
                    <div class="c-lable-data">
                        <span>{{$order->getStatus()}}</span>
                    </div>
                </div>
            </li>
        </ul>
        <div class="claim-messages" id="product_list">
            <p class="text-muted" style="font-size:20px;padding-top:10px;"><strong>Products</strong></p>
            <div class="table-responsive text-center">
                <table class="table" style="font-size:15px;border:2px dashed #e0e0e0;width:100%;padding:15px;background:#fbfbfb;">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col" style="text-align:left; padding:3px 10px;">Product Name</th>
                        <th scope="col" style="text-align:center; padding:3px 10px;">Image</th>
                        <th scope="col" style="text-align:center; padding:3px 10px;">Unit Price</th>
                        <th scope="col" style="text-align:center; padding:3px 10px;">Quantities</th>
                        <th scope="col" style="text-align:center; padding:3px 10px;">Total</th>
                        <th scope="col" style="text-align:center; padding:3px 10px;">Cashback</th>
                        <th scope="col" style="text-align:center; padding:3px 10px;">Store</th>
                    </tr>
                    </thead>
                    <tbody id="order_products">
                    @if($order->products->count() > 0)
                        @foreach($order->products as $product)
                            <tr class="border-bottom">
                                <td style="text-align:left;">
                                    <i class=""></i> {{$product->product_name}}
                                </td>
                                <td style="text-align:center;margin:auto;">
                                    <img src="{{getImageNew($product->product_image, "XXS")}}" style="max-height: 50px;"/>
                                </td>
                                <td style="text-align:center;">Rs {{number_format($product->product_price)}}</td>
                                <td class="quantity" title="Click outside to update.." style="text-align:center;">
                                    {{($product->quantity)}}
                                </td>
                                <td style="text-align:center;">Rs {{number_format($product->product_price * $product->quantity)}}</td>
                                <td style="text-align:center;">Rs {{number_format($product->cashback * $product->quantity, 2)}}</td>
                                <td style="text-align:center;">{{config('vendor.name.'.$product->vendor)}}</td>
                            </tr>
                        @endforeach
                        <tr class="pright">
                            <td colspan="4" style="text-align:right;">
                                <strong>Order Total</strong>
                            </td>
                            <td colspan="4" style="text-align:left;padding-left:30px">
                                Rs. {{number_format($order->total_price,2)}}
                            </td>
                        </tr>
                        @if($order->total_cashback>0)
                            <tr class="pright">
                                <td colspan="4" style="text-align:right;">
                                    <strong>Total Cashback</strong>
                                </td>
                                <td colspan="4" style="text-align:left;padding-left:30px">
                                    Rs {{number_format($order->total_cashback,2)}}
                                </td>
                            </tr>
                        @endif
                        @if($order->total_savings>0)
                            <tr class="pright">
                                <td colspan="4" style="text-align:right;">
                                    <strong>Total Saving</strong>
                                </td>
                                <td colspan="4" style="text-align:left;padding-left:30px">
                                    Rs {{number_format($order->total_savings,2)}}
                                </td>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <td colspan="6">No Product(s)</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
</div>