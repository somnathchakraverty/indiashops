    <div class="user-dash-info linkbg p-3 rounded mb-5">
        <div class="row">
            <div class="col-md-1">
                <div class="user-pro-pic text-center mb-3 mb-sm-0">
                    <img class="" src="{{asset('assets/v3/images')}}/user-icon.jpg">
                </div>
            </div>
            <div class="col-md-11">
            <div class="my-auto">
                <div class="user-pro-info pb-2 mb-2 border-bottom">
                    <strong>{{\Auth::user()->name}}</strong>
                    ({{\Auth::user()->email}})
                    <strong>Joined On</strong>
                    {{\Carbon\Carbon::parse(\Auth::user()->join_date)->format('dS M, Y')}}
                </div>
                @if(userHasAccess('cashback.earnings'))
                    <div class="user-earning-details">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <strong>Available Earnings</strong>
                                Rs. {{($earnings->has('approved')) ? ( $earnings->get('approved')->amount - $pending_withdrawal ) : 0}}
                            </li>
                            <li class="list-inline-item">
                                <strong>Pending Earnings </strong>
                                Rs. {{($earnings->has('pending')) ? $earnings->get('pending')->amount : 0}}
                            </li>
                            <li class="list-inline-item">
                                <strong>Lifetime Earnings</strong>
                                Rs. {{$earnings->sum('amount')}}
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
             </div>
        </div>
    </div>