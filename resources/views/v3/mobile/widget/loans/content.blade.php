<?php $include_file = $current_path . ".ajax"; ?>
@if(!isset($ajax))
    <!-- Tab panes -->
    <div class="whitecolorbg">
        <div class="container">       
        <h2>Finance Services</h2>
        <div class="product-tabs">
            <ul class="tabs">
                <li class="tab">
                    <a href="#personal_loan" class="active">Personal Loan</a>
                </li>
                <li class="tab">
                    <a href="#home_loan">Home Loan</a>
                </li>
                <li class="tab">
                    <a href="#car_loan">Car Loan</a>
                </li>
            </ul>
        </div>
  
            @foreach($loans as $loan_type => $t_loans)
                <div class="tab-content" id="{{$loan_type}}_loan">
                    @include($include_file, [ 'loans' => $t_loans ])
                </div>
            @endforeach
        </div>
    </div>
@else
    @include($include_file)
@endif