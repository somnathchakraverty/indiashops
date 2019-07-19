<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#top_deals_women" aria-controls="top_deals_women" role="tab" data-toggle="tab">Women</a>
    </li>
    <li role="presentation">
        <a href="#top_deals_mens" aria-controls="top_deals_mens" role="tab" data-toggle="tab" {!! getAjaxAttr('top_deals_mens') !!}>Mens</a>
    </li>
    <li role="presentation">
        <a href="#top_deals_kids" aria-controls="top_deals_kids" role="tab" data-toggle="tab" {!! getAjaxAttr('top_deals_kids') !!}>Kids</a>
    </li>
    <li role="presentation">
        <a href="#top_deals_home_decor" aria-controls="top_deals_home_decor" role="tab" data-toggle="tab" {!! getAjaxAttr('top_deals_home_decor') !!}>Home Decor</a>
    </li>
</ul>
<div class="tab-content">
<div role="tabpane2" class="tab-pane active" id="top_deals_women">
    <?php $category = "Women's"; ?>
    @include('v3.home.snippet.ajax.top_deals')
</div>
<div role="tabpane2" class="tab-pane" id="top_deals_mens"></div>
<div role="tabpane2" class="tab-pane" id="top_deals_kids"></div>
<div role="tabpane2" class="tab-pane" id="top_deals_home_decor"></div>
</div>