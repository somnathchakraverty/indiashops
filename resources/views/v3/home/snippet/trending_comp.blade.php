<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#trending_comp_phone" aria-controls="trending_comp_phone" role="tab" data-toggle="tab">Phone</a>
    </li>
    <li role="presentation">
        <a href="#trending_comp_laptops" aria-controls="trending_comp_laptops" role="tab" data-toggle="tab" {!! getAjaxAttr('trending_comp_laptops') !!}>Laptops</a>
    </li>
    <li role="presentation">
        <a href="#trending_comp_cameras" aria-controls="trending_comp_cameras" role="tab" data-toggle="tab" {!! getAjaxAttr('trending_comp_cameras') !!}>Cameras</a>
    </li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="trending_comp_phone">
        @include('v3.home.snippet.ajax.trending_comp')
    </div>
    <div role="tabpanel" class="tab-pane" id="trending_comp_laptops"></div>
    <div role="tabpanel" class="tab-pane" id="trending_comp_cameras"></div>
</div>