<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#price1" aria-controls="price1" role="tab" data-toggle="tab">Below Rs. 10,000</a>
    </li>
    <li role="presentation">
        <a href="#deal_under_ten" aria-controls="price2" role="tab" data-toggle="tab" {!! getAjaxAttr('deal_under_ten') !!}>Rs. 10,000 - 15,000</a>
    </li>
    <li role="presentation">
            <a href="#deal_under_twenty" aria-controls="price3" role="tab" data-toggle="tab" {!! getAjaxAttr('deal_under_twenty') !!}>Rs. 15,000 - 20,000</a>
    </li>
    <li role="presentation">
        <a href="#deal_under_thirty" aria-controls="price4" role="tab" data-toggle="tab" {!! getAjaxAttr('deal_under_thirty') !!}>Rs. 20,000 - 30,000</a>
    </li>
    <li role="presentation">
        <a href="#deal_above_thirty" aria-controls="price5" role="tab" data-toggle="tab" {!! getAjaxAttr('deal_above_thirty') !!}>Above Rs. 30,000</a>
    </li>
</ul>
<div role="tabpane2" class="tab-pane active" id="price1">
    @include("v3.home.snippet.ajax.deals_on_phone")
</div>
<div role="tabpane2" class="tab-pane" id="deal_under_ten"></div>
<div role="tabpane2" class="tab-pane" id="deal_under_twenty"></div>
<div role="tabpane2" class="tab-pane" id="deal_under_thirty"></div>
<div role="tabpane2" class="tab-pane" id="deal_above_thirty"></div>