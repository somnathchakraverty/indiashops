@extends('v3.layout.cashback')
@section('cashback_section')
    <style type="text/css">
        .E-gift-wallet-form { margin-top: 20px !important }
        label { font-size: 14px; font-weight: 700 !important }
        .btn-outline-primary { color: #fff !important; background: #ff3131 !important; margin: 10px 15px 0 0 !important }
        .bank-tf-form { margin-top: 20px }
        .table-responsive { clear: both }
        .bgcolor { background: #eaeaea; border-radius: 10px; margin-top: 10px; padding: 10px 10px 20px }
        .custom-select { display: inline-block; width: 100%; border-radius: 5px; height: calc(2.25rem + 2px); padding: .375rem 1.75rem .375rem .75rem; line-height: 1.5; color: #495057; vertical-align: middle }
        .text-muted { font-size: 24px; color: #000; padding: 5px 0 }
        .listwith { text-align: center; font-size: 18px }
        .table-filter { margin-top: 50px }
    </style>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane active border-bottom" id="withdraw-tabpan" role="tabpanel">
            <div class="avail-bal-info text-center text-muted">
                <h2 class="text-muted">Available Balance:
                    <i class="fa fa-money"></i> Rs. {{$earnings->sum('amount')-$pending_withdrawal}}
                </h2>

                <ul class="list-inline listwith">
                    <li class="list-inline-item">
                        Cashback: {{($earnings->has('cashback')) ? $earnings->get('cashback')->amount : 0}}
                    </li>
                    <li class="list-inline-item">
                        Rewards: {{($earnings->has('reward')) ? $earnings->get('reward')->amount : 0}}
                    </li>
                </ul>
            </div>
        </div>
        <div class="withdraw-option">
            <div class="row">
                <div class="col-sm-3 mb-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link {{(session()->get('action') != 'bank') ? 'active' : ''}}" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="fa fa-gift"></i>
                            E-Gift/Wallet</a>
                        <a class="nav-link {{(session()->get('action') == 'bank') ? 'active' : ''}}" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Bank
                            Transfer</a>
                        <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Withdraw
                            History</a>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade {{(session()->get('action') != 'bank') ? 'in active' : ''}}" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="row">
                                <div class="col-md-12 mx-auto">

                                    <div class="col-md-12 bgcolor">
                                        <form method="post">
                                            <div class="E-gift-wallet-form">
                                                <div class="form-group">
                                                    <!-- <label for="exampleFormControlSelect1">Store Name</label> -->
                                                    <select class="form-control fildname" name="store" required>
                                                        <option value="">Select store</option>
                                                        <option>Flipkart</option>
                                                        <option>Amazon</option>
                                                        <option>Paytm</option>
                                                        <option>BookMyShow</option>
                                                    </select>
                                                </div>
                                                <div class="form-label-group">
                                                    <label for="email-id">Email</label>
                                                    <input type="email" id="email-id" class="form-control fildname" placeholder="Enter email ID" required name="email">
                                                </div>
                                                <div class="form-label-group">
                                                    <label for="Recever'sName">Receiver's Name</label>
                                                    <input type="text" id="Recever'sName" class="form-control fildname" placeholder="Recever's Name" required name="name">
                                                </div>
                                                <div class="form-label-group">
                                                    <label for="Recever'sPH">Receiver's Phone Number</label>
                                                    <input type="text" id="Recever'sPH" class="form-control fildname" placeholder="Recever's Ph Number" required name="phone_number">
                                                </div>
                                                {{csrf_field()}}
                                                <input type="hidden" name="withdrawal_type" value="wallet"/>
                                                <button type="submit" class="btn btn-outline-primary">SUBMIT</button>
                                            </div>
                                        </form>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade {{(session()->get('action') == 'bank') ? 'in active' : ''}}" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="row">
                                <div class="col-md-12 mx-auto">

                                    <div class="col-md-12 bgcolor">
                                        <div class="bank-tf-form">
                                            <form method="post">
                                                <div class="form-label-group">
                                                    <label for="ac-h-name">Acount Holder Name</label>
                                                    <input type="text" id="ac-h-name" name="account_holder_name" class="form-control fildname" placeholder="Acount Holder Name" required="">
                                                </div>
                                                <div class="form-label-group">
                                                    <label for="bank-name">Bank Name</label>
                                                    <input type="text" id="bank-name" name="bank_name" class="form-control fildname" placeholder="Bank Name" required="">
                                                </div>
                                                <div class="form-label-group">
                                                    <label for="ac-num">Acount Number</label>
                                                    <input type="text" id="ac-num" name="account_number" class="form-control fildname" placeholder="Acount Number" required="">
                                                </div>
                                                <div class="form-label-group">
                                                    <label for="branch-ad">Branch Address</label>
                                                    <input type="text" id="branch-ad" name="branch_address" class="form-control fildname" placeholder="Branch Address" required="">
                                                </div>
                                                <div class="form-label-group">
                                                    <label for="ifc-cod">IFSC Code</label>
                                                    <input type="text" id="ifc-cod" name="ifsc_code" class="form-control fildname" placeholder="IFSC Code" required="">
                                                </div>
                                                {{csrf_field()}}
                                                <input type="hidden" name="withdrawal_type" value="bank"/>
                                                <button type="submit" class="btn btn-outline-primary">Withdraw</button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="withdraw-hs" id="withdrawals">
                                        @include('v3.cashback.include.withdrawals')
                                    </div>
                                </div>
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
            $(document).on('click', '.pagination li a', function () {
                url = $(this).attr('href');
                $.get(url, {type: 'withdrawal', status: $("#wstatus").val()}).done(function (response) {
                    $("#withdrawals").html(response);
                });

                return false;
            });

            $(document).on('change', '#wstatus', function () {
                url = $(this).attr('href');
                $.get(url, {type: 'withdrawal', status: $("#wstatus").val()}).done(function (response) {
                    $("#withdrawals").html(response);
                });

                return false;
            });
        }
    </script>
@endsection