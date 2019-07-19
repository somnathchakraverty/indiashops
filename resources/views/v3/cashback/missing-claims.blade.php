@extends('v3.layout.cashback')
@section('cashback_section')
    <style type="text/css">
        .hmb-5 { font-size: 24px; padding: 15px 0px; text-align: center; display: block; }
    </style>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane active" id="missing-cb-claim-tabpan" role="tabpanel">
            <section class="m-cb-claims">
                <h2 class="hmb-5">Missing Cashback Claims</h2>
                <div class="table-responsive text-center">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Claim Date</th>
                            <th scope="col">Merchant</th>
                            <th scope="col">Click Date</th>
                            <th scope="col">Claim ID</th>
                            <th scope="col">Status</th>
                            <th scope="col">Details</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($tickets->count() > 0)
                            @foreach($tickets as $t)
                                <tr class="border-bottom">
                                    <td>{{\Carbon\Carbon::parse($t->raised_date)->format('d-M-Y')}}</td>
                                    <td>{{config('vendor.name.'.$t->vendor_id)}}</td>
                                    <td>{{\Carbon\Carbon::parse($t->click_time)->format('d M, Y')}}</td>
                                    <td>{{$t->ticket_id}}</td>
                                    <td>{{ucwords($t->status)}}</td>
                                    <td>
                                        <a href="{{route('cashback.claim.detail',[$t->ticket_id])}}">
                                            <i class="fa fa-newspaper-o"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">No data</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                        {!! $tickets->render() !!}
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