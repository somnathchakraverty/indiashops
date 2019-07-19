@extends('v3.layout.cashback')
@section('cashback_section')
<style type="text/css">
.missing-cb-title h2{font-size:30px;color:#000;padding:15px 0}
.missing-cb-title p{font-size:15px;text-align:center;color:#000}
.bgcolor{background:#eaeaea;border-radius:10px;margin-top:10px;padding:10px 10px 20px}
.E-gift-wallet-form{margin-top:20px!important}
label{font-size:14px;font-weight:700!important}
small{font-size:14px;font-weight:700!important}
.btn-outline-primary{color:#fff!important;background:#ff3131!important;margin:10px 15px 0 0 !important}
.font-weight-bold{font-weight:700!important;padding-top:20px}
</style>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane active" id="missing-cb-tabpan" role="tabpanel">
            @if($clicks->count()>0)
                <div class="missing-cb-title text-center mb-4">
                    <h2>Missing Cashback</h2>
                    <p class="text-muted">Missing any cashback? Simply add a new cashback ticket with details of your
                        transaction.</p>
                </div>
                <div class="missing-cash-form p-3 bg-white rounded">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="col-md-12 bgcolor">
                                <p class="text-center font-weight-bold">
                                    Please provide us the details below to track the missing cashback.
                                </p>
                                <form method="post">
                                    <div class="form-row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <select class="form-control fildnamenew2" required name="store" id="vendor">
                                                    <option value="">Select Stores</option>
                                                    @foreach($clicks as $vendor_id => $c)
                                                        <option value="{{$vendor_id}}">{{config('vendor.name.'.$vendor_id)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <select class="form-control fildname" name="click_out_time" required id="out_times">
                                                    <option>Select Store First</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-label-group mb-0">
                                                <label for="order-id">Order/Transaction ID</label> <span><small>( Ex 12345678 )</small></span>
                                                <input type="text" id="order-id" name="order_id" class="form-control fildname" placeholder="Order/Transection ID" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-label-group mb-0">
                                                <label for="t-date">Date of transection</label> <span><small>( DD/MM/YYYY )</small></span>
                                                <input type="date" id="t-date" name="transaction_date" class="form-control fildname" placeholder="Date Of Transection" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="mode">Select Mode</label>
                                                <select class="form-control fildname" id="mode" required>
                                                    <option value="">Select the mode shopping</option>
                                                    <option>Website</option>
                                                    <option>Promotional</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-label-group">
                                                <label for="amount">Amount paid</label>
                                                <input type="number" id="amount" name="amount" class="form-control fildname" placeholder="Amount paid" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea class="form-control post-message" name="message" placeholder="Write Your Message"></textarea>
                                        </div>
                                    </div>
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-outline-primary float-right">SUBMIT
                                    </button>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
            @else
                <h3>No Clicks found..!!</h3>
            @endif
        </div>
    </div>
@endsection
@section('section_scripts')
    <script>
        var clicks = JSON.parse('{!! $clicks->toJSON() !!}');

        function loadRestJS()
        {
            $(document).on('change',"#vendor",function(){
                if($(this).val() != '')
                {
                    var options = clicks[$(this).val()];
                    var html = '<option value="">--Select Out Time--</option>';
                    $.each(options,function(i,option){
                        html += "<option value='"+(option.clicked_id)+"'>"+option.click_time+"</option>";
                    });
                }
                else {
                    var html = '<option value="">--Select Store First--</option>';
                }

                $("#out_times").html(html);
            });
        }
    </script>
@endsection