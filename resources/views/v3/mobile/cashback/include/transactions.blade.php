<table class="table">
    <thead class="thead-light">
    <tr>
        <th scope="col">Date</th>
        <th scope="col">Details</th>
        <th scope="col">Type</th>
        <th scope="col">Amount</th>
        <th scope="col">Status</th>
    </tr>
    </thead>
    <tbody>
    @if($transactions->count()>0)
        @foreach($transactions as $t)
            <tr class="border-bottom">
                <td>{{\Carbon\Carbon::parse($t->transaction_time)->format('d-M-Y')}}</td>
                <td>{{ucfirst($t->cashback_type)}}
                    on {{config('vendor.name.'.$t->vendor_id)}} Order
                </td>
                <td>{{ucfirst($t->cashback_type)}}</td>
                <td>Rs. {{number_format($t->cashback_amount,2)}}</td>
                <td>{{ucfirst($t->status)}}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5">No data</td>
        </tr>
    @endif
    </tbody>
</table>
<nav>
    {!! $transactions->render() !!}
</nav>