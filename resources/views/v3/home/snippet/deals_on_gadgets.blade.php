<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#gadget_tablets" aria-controls="gadget_tablets" role="tab" data-toggle="tab">Tablets</a>
    </li>
    <li role="presentation">
        <a href="#gadget_laptops" aria-controls="gadget_laptops" role="tab" data-toggle="tab" {!! getAjaxAttr('gadget_laptops') !!}>Laptops</a>
    </li>
    <li role="presentation">
        <a href="#gadget_cameras" aria-controls="gadget_cameras" role="tab" data-toggle="tab" {!! getAjaxAttr('gadget_cameras') !!}>Cameras</a>
    </li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="gadget_tablets">
        @include('v3.home.snippet.ajax.deals_on_gadget')
    </div>
    <div role="tabpanel" class="tab-pane" id="gadget_laptops"></div>
    <div role="tabpanel" class="tab-pane" id="gadget_cameras"></div>
</div>