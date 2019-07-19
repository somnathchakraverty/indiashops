@extends('v3.mobile.layout.cashback')
@section('cashback_section')
<style type="text/css">
h4, .h4{font-size:18px!important;font-weight:bold!important;margin:0;padding-top:17px;}
</style>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane in active" id="cashback-tabpan" role="tabpanel">
            <!-- cashback-inner-tab -->
          
                
                    <ul class="tabs nav-pills">
                    <li class="tab">
                        <a class="nav-link active" href="#v-pills-home">
                            User Overview
                        </a>
                    </li>
                    <li class="tab">
                        <a class="nav-link" href="#v-pills-profile">
                            Transaction Log
                        </a>
                    </li>
                    </ul>
               
                
                    <div id="v-pills-tabContent">
                        <div class="tab-pane fade active in" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                           
                               
                                    <div class="v-card">
                                        <div class="v-card-title">
                                            <i class="fa fa-tag text-muted"></i>
                                            <h4>Confirmed </h4>
                                        </div>
                                        <div class="avail-bal float-right">
                                            <h4>
                                                Rs. {{($cashback->has('approved')) ? number_format($cashback->get('approved')->amount) : 0}}
                                            </h4>
                                        </div>
                                    </div>
                              
                              
                                    <div class="v-card">
                                        <div class="v-card-title">
                                            <i class="fa fa-tag text-muted"></i>
                                            <h4>Pending </h4>
                                        </div>
                                        <div class="avail-bal float-right">
                                            <h4>
                                                Rs. {{($cashback->has('pending')) ? number_format($cashback->get('pending')->amount) : 0}}</h4>
                                        </div>
                                    </div>
                            
                               
                                    <div class="v-card">
                                        <div class="v-card-title">
                                            <i class="fa fa-tag text-muted"></i>
                                            <h4>Declined </h4>
                                        </div>
                                        <div class="avail-bal float-right">
                                            <h4>
                                                Rs. {{($cashback->has('declined')) ? number_format($cashback->get('declined')->amount) : 0}}</h4>
                                        </div>
                                    </div>
                              
                              
                                    <div class="v-card">
                                        <div class="v-card-title">
                                            <i class="fa fa-tag text-muted"></i>
                                            <h4>Paid </h4>
                                        </div>
                                        <div class="avail-bal float-right">
                                            <h4>Rs. {{number_format($paid,2)}}</h4>
                                        </div>
                                    </div>
                                
                           
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="table-responsive" id="transactions">
                                @include('v3.mobile.cashback.include.transactions')
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
                $.get(url, {type: 'transaction'}).done(function (response) {
                    $("#transactions").html(response);
                });

                return false;
            });
        }
    </script>
@endsection