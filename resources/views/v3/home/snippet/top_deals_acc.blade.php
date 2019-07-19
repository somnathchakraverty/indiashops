<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#top_deals_acc_headphone" aria-controls="top_deals_acc_headphone" role="tab" data-toggle="tab">Headphones</a>
    </li>
    <li role="presentation">
        <a href="#top_deals_acc_speakers" aria-controls="top_deals_acc_speakers" role="tab" data-toggle="tab" {!! getAjaxAttr('top_deals_acc_speakers') !!}>Speakers</a>
    </li>
    <li role="presentation">
        <a href="#top_deals_acc_memory" aria-controls="top_deals_acc_memory" role="tab" data-toggle="tab" {!! getAjaxAttr('top_deals_acc_memory') !!}>Memory Disks</a>
    </li>
    <li role="presentation">
        <a href="#top_deals_acc_smart" aria-controls="top_deals_acc_smart" role="tab" data-toggle="tab" {!! getAjaxAttr('top_deals_acc_smart') !!}>Smart Wearables</a>
    </li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="top_deals_acc_headphone">
        @include('v3.home.snippet.ajax.top_deals_acc')
    </div>
    <div role="tabpanel" class="tab-pane" id="top_deals_acc_speakers"></div>
    <div role="tabpanel" class="tab-pane" id="top_deals_acc_memory"></div>
    <div role="tabpanel" class="tab-pane" id="top_deals_acc_smart"></div>
</div>