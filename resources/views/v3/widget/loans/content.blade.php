<?php $include_file = $current_path . ".ajax"; ?>
@if(!isset($ajax))
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#personal_loan" role="tab" data-toggle="tab">Personal Loan</a>
        </li>
        <li role="presentation">
            <a href="#home_loan" role="tab" data-toggle="tab">Home Loan</a>
        </li>
        <li role="presentation">
            <a href="#car_loan" role="tab" data-toggle="tab">Car Loan</a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <?php $i = 0 ?>
        @foreach($loans as $loan_type => $t_loans)
            <div role="tabpanel" class="tab-pane {{($i++==0) ? 'active' : ''}}" id="{{$loan_type}}_loan">
                @include($include_file, [ 'loans' => $t_loans ])
            </div>
        @endforeach
    </div>
@else
    @include($include_file)
@endif