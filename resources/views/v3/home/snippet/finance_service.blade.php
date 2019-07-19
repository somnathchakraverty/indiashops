<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#personal_loan" aria-controls="personal_loan" role="tab" data-toggle="tab">Personal Loan</a>
    </li>
    <li role="presentation">
        <a href="#home_loan" aria-controls="home_loan" role="tab" data-toggle="tab" {!! getAjaxAttr('home_loan') !!}>Home Loan</a>
    </li>
    <li role="presentation">
        <a href="#car_loan" aria-controls="car_loan" role="tab" data-toggle="tab" {!! getAjaxAttr('car_loan') !!}>Car Loan</a>
    </li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="Personal-Loan">
        @include('v3.home.snippet.ajax.finance_service')
    </div>
    <div role="tabpanel" class="tab-pane" id="home_loan"></div>
    <div role="tabpanel" class="tab-pane" id="car_loan"></div>
</div>