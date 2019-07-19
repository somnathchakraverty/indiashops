<div class="table-filter">
    <div class="col-sm-3 pull-right mb-3">
        <select class="custom-select" id="wstatus">
            <option {{($status == '') ? 'selected' : ''}} value="">All</option>
            <option {{($status == 'requested') ? 'selected' : ''}} value="requested">Requested</option>
            <option {{($status == 'paid') ? 'selected' : ''}} value="paid">Paid</option>
            <option {{($status == 'processing') ? 'selected' : ''}} value="processing">Processing</option>
            <option {{($status == 'rejected') ? 'selected' : ''}} value="rejected">Rejected</option>
        </select>
    </div>
</div>
<div class="table-responsive" id="withdrawal_history">
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Withdraw ID</th>
            <th scope="col">Mode</th>
            <th scope="col">Amount</th>
            <th scope="col">Transaction Reference No.</th>
            <th scope="col">Note</th>
            <th scope="col">Status</th>
        </tr>
        </thead>
        <tbody>
        @if($withdrawals->count()>0)
            @foreach($withdrawals as $w)
                <tr class="border-bottom">
                    <td>{{\Carbon\Carbon::parse($w->withdrawal_request_date)->format("d-M-Y")}}</td>
                    <td>{{$w->withdrawal_id}}</td>
                    <td>{{ucwords($w->mode)}}</td>
                    <td>{{number_format($w->amount,2)}}</td>
                    <td>{{$w->payment_reference_number}}</td>
                    <td>{{$w->payment_note}}</td>
                    <td>{{strtoupper($w->status)}}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5">No data</td>
            </tr>
        @endif
        </tbody>
    </table>
    <nav aria-label="Page navigation example">
        {!! $withdrawals->render() !!}
    </nav>
</div>