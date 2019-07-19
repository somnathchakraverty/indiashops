<title>Purchase Order Detail - Created on : {{$order->getDate()}}</title>
<style type="text/css">
    .c-lable span strong { font-size: 18px; }
    .border-bottom { width: 94%; padding: 10px 0px; clear: both; border-top: 2px dashed #e8e9e9 !important; border-bottom: none !important; }
    .list-unstyled { margin-top: 10px; }
    .hmb-5 { font-size: 25px; }
    .c-lable-data span { font-size: 16px; }
    .claim-messages { clear: both; margin-top: 20px; display: block; float: left; width: 100%; }
    .text-muted strong { font-size: 20px; color: #000 !important; padding: 10px 0; }
    .text-muted { padding: 0px 0px !important; }
    .font-weight-bold { font-size: 17px; color: #000; font-weight: bold; }
    .rounded { clear: both; float: left; }
    .btn-orange {color:#fff!important;background:#ff3131!important;margin-top:10px!important;padding:6px;border-radius:4px;display:inline-block;text-align:center!important;font-size:12px!important;font-weight:300!important;}
    #ajax_loader { position: absolute; top: 0px; width: 100%; height: 100%; background: rgba(0, 0, 0, .5); padding: 7% 0 0 35%; color: #fff; font-size: 28px; font-weight: 600 }
    #product_list { position: relative }
    .quantity input { text-align: center }
    .pright td { text-align: right }
</style>
<section class="v-m-cb-claims">
    <div class="container" style="font-size:14px;font-family:Verdana, Arial, Helvetica, sans-serif, circular, 'Circular Std Black';">
        <h2 class="hmb-5">Purchase Order Detail</h2>
        <ul class="list-unstyled mb-5">
            <li class="media p-2 border-top border-bottom">
                <div class="c-lable">
                    <span><strong>Created On:</strong></span>
                </div>
                <div class="media-body">
                    <div class="c-lable-data">
                        <span>{{$order->getDate()}}</span>
                    </div>
                </div>
            </li>
            <li class="media p-2 my-3 border-top border-bottom">
                <div class="c-lable">
                    <span><strong>No of Products:</strong></span>
                </div>
                <div class="media-body">
                    <div class="c-lable-data">
                        <span>{{$order->totalProducts()}}</span>
                    </div>
                </div>
            </li>
            <li class="media p-2 my-3 border-top border-bottom">
                <div class="c-lable">
                    <span><strong>Order Total:</strong></span>
                </div>
                <div class="media-body">
                    <div class="c-lable-data">
                        <span>Rs. {{number_format($order->total_price,2)}}</span>
                    </div>
                </div>
            </li>
            <li class="media p-2 my-3 border-top border-bottom">
                <div class="c-lable">
                    <span><strong>Total Saving:</strong></span>
                </div>
                <div class="media-body">
                    <div class="c-lable-data">
                        <span>Rs {{number_format($order->total_savings,2)}}</span>
                    </div>
                </div>
            </li>
            <li class="media p-2 my-3 border-top border-bottom">
                <div class="c-lable">
                    <span><strong>Status:</strong></span>
                </div>
                <div class="media-body">
                    <div class="c-lable-data">
                        <span>{{$order->getStatus()}}</span>
                    </div>
                </div>
            </li>
        </ul>
        <div class="claim-messages" id="product_list">
            <p class="text-muted"><strong style="font-size:25px;color:#000;padding:10px 0;">Products</strong></p>
            <div class="table-responsive text-center" style="border:2px dashed #f5f5f5;width:99%;font-size:14px;background:#efefef;font-family:Verdana, Arial, Helvetica, sans-serif, circular, 'Circular Std Black';">
                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Product Name</th>
                        <th scope="col" style="text-align:center;">Image</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Quantities</th>
                        <th scope="col">Total</th>
                        <th scope="col">Cashback</th>
                        <th scope="col">Store</th>
                    </tr>
                    </thead>
                    <tbody id="order_products">
                    @if($order->products->count() > 0)
                        @foreach($order->products as $product)
                            <tr class="border-bottom">
                                <td>
                                    <i class=""></i> {{$product->product_name}}
                                </td>
                                <td style="text-align:center;margin:auto;">
                                    <img src="{{getImageNew($product->product_image, "XXS")}}" style="max-height: 50px;"/>
                                </td>
                                <td>Rs {{number_format($product->product_price)}}</td>
                                <td class="quantity" title="Click outside to update..">
                                    {{($product->quantity)}}
                                </td>
                                <td>Rs {{number_format($product->product_price * $product->quantity)}}</td>
                                <td>Rs {{number_format($product->cashback * $product->quantity, 2)}}</td>
                                <td>{{config('vendor.name.'.$product->vendor)}}</td>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<link type="text/css" rel="stylesheet" href="{{getCssFile()}}">
<script>
    window.onload = function () {
        window.print();
    }
</script>