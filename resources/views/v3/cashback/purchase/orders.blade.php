@extends('v3.layout.cashback')
@section('cashback_section')
    <style type="text/css">
        .hmb-5 { font-size: 24px; padding: 15px 0px; text-align: center; display: block; }
        .btn-outline-primary { color: #fff !important; background: #ff3131 !important; margin: 10px 15px 0px 0px !important; }
        .bgcolor { background: #eaeaea; border-radius: 10px; margin-top: 30px; padding: 0 10px 20px }
    </style>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane active" id="missing-cb-claim-tabpan" role="tabpanel">
            <section class="m-cb-claims">
                <h2 class="hmb-5">All Purchase Orders</h2>
                @if(!$hasOrder)
                    <div class="row">
                        <div class="col-md-12">
                            <a class="btn btn-outline-primary" href="?create_order">Create New Order</a>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                @endif
                <div class="table-responsive text-center">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Created On</th>
                            <th scope="col">No of Products</th>
                            <th scope="col">Order Total</th>
                            <th scope="col">Total Saving</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($orders->count() > 0)
                            @foreach($orders as $order)
                                <tr class="border-bottom">
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->getDate()}}</td>
                                    <td>{{$order->totalProducts()}}</td>
                                    <td>Rs. {{number_format($order->total_price,2)}}</td>
                                    <td>Rs. {{number_format($order->total_savings,2)}}</td>
                                    <td>{{$order->getStatus()}}</td>
                                    <td>
                                        <a href="{{route('cashback.purchase.orders',[$order->id])}}" title="View Detail">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">No Order(s)</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                        {!! $orders->render() !!}
                    </nav>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('section_scripts')
    <script>
        function loadRestJS() {

        }
    </script>
@endsection