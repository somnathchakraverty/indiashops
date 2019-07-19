@extends('v3.layout.cashback')
@section('cashback_section')
    <style type="text/css">
        .c-lable span strong { font-size: 18px; }
        .cashback { padding-left: 0px; }
        .border-bottom { width:94%; padding: 10px 0px; clear: both; border-top: 2px dashed #e8e9e9 !important; border-bottom: none !important; }
        .list-unstyled { margin-top: 10px; }
        .hmb-5 { font-size: 25px; }
        .c-lable-data span { font-size: 16px; }
        .claim-messages { clear: both; margin-top: 20px; display: block; float: left; width: 100%; }
        .text-muted strong { font-size: 20px; color: #000 !important; padding: 10px 0; }
        .text-muted { padding: 0px 0px !important; }
        .font-weight-bold { font-size: 17px; color: #000; font-weight: bold; }
        .rounded { clear: both; float: left; }
        .btn-orange { color: #fff !important; background: #ff3131 !important; margin: 10px 15px 0px 0px !important; }
        #ajax_loader { position: absolute; top: 0px; width: 100%; height: 100%; background: rgba(0, 0, 0, .5); padding: 7% 0 0 35%; color: #fff; font-size: 28px; font-weight: 600 }
        #product_list { position: relative }
        .quantity input { text-align: center }
        .pright td:first-child { text-align: right }
        .orange { color: #ff3131 }
    </style>
    <section class="v-m-cb-claims">
        <div class="container">
            <h2 class="hmb-5">Purchase Order Detail</h2>
            <ul class="list-unstyled mb-5">
                <li class="media p-2 border-top border-bottom">
                    <div class="c-lable">
                        <span><strong>Purchase Order ID:</strong></span>
                    </div>
                    <div class="media-body">
                        <div class="c-lable-data">
                            <span>{{$order->id}}</span>
                        </div>
                    </div>
                </li>
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
                <p class="text-muted"><strong>Products</strong></p>
                <div class="table-responsive text-center">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Product Name</th>
                            <th scope="col">Image</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Quantities</th>
                            <th scope="col">Total</th>
                            <th scope="col">Cashback</th>
                            <th scope="col">Store</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody id="order_products">
                        @include('v3.cashback.purchase.products')
                        </tbody>
                    </table>
                    <div class="col-md-12">
                        <div class="text-right">
                            <a href="?print" target="_blank" class="btn btn-orange">Print Order</a>
                            <a href="?email" class="btn btn-orange" onclick="return confirm('Send Email..??')">Email
                                Order</a>
                            @if($order->status == \indiashopps\Models\PurchaseOrder::STATUS_OPEN)
                                @if(auth()->user()->isAdmin() && session()->has('has_approver'))
                                    <a href="javascript:void(0)" class="btn btn-orange" data-toggle="modal" data-target="#approval">Get
                                        Approval</a>
                                @endif
                                @if( userHasAccess('purchase.approve') )
                                    <a href="?approve" class="btn btn-orange" onclick="return confirm('Are you sure..??')">Approve</a>
                                    <a href="?reject" class="btn btn-orange" onclick="return confirm('Are you sure..??')">Reject</a>
                                    <a href="?close" class="btn btn-orange" onclick="return confirm('Are you sure..??')">
                                        Close Order
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div id="ajax_loader" style="display: none">Updating.. Please wait...!</div>
            </div>
        </div>
    </section>
    <div id="approval" class="modal fade bs-example-modal-lg">
        <div class="modal-dialog modal-lg" role="document" style="width: 547px;">
            <div class="modal-content popup2width">
                <button type="button" class="close popupright2" data-dismiss="modal" aria-label="Close" id="close_modal">
                    <span aria-hidden="true">×</span>
                </button>
                <div class="productdetailspopup mtop0" style="padding-top: 15px">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="p-info-wrapp border p-3">
                                <form method="post">
                                    <div class="form-row">
                                        <div class="col-sm-12">
                                            <div class="form-label-group">
                                                <label for="f-name">Email</label>
                                                <input type="email" required id="f-name" name="email" class="form-control fildname" placeholder="Approver's Email" required="">
                                            </div>
                                            <div style="padding: 15px 0 10px 0;">
                                                {{csrf_field()}}
                                                <input type="hidden" name="action" value="new_user"/>
                                                <button type="submit" class="btn btn-outline-primary">Send Email
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('section_scripts')
    <script>
        function loadRestJS() {
            $(document).on("change", ".quantity_input", function () {
                var product_id = $(this).attr('id');
                var quantity = $(this).val();
                var cart_id = '{{$order->id}}';

                $("#ajax_loader").show();
                $.ajax({
                    url: '{{route('cashback.update-prod-qty')}}',
                    data: {pid: product_id, qty: quantity, 'cart_id': cart_id},
                    success: function () {
                        $("#ajax_loader").hide();
                        window.location.reload();
                    },
                    dataType: 'json'
                });
            });
        }
    </script>
@endsection