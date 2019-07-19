<?php $include_file = $current_path.".ajax"; ?>
@if(!isset($ajax))
<div class="whitecolorbg">
<div class="container">
        <h2>Top Deals on gadgets</h2>
        <div class="product-tabs">
            <ul class="tabs">
                <li class="tab"><a class="active" href="#gadget_tablets">Tablets</a></li>
                <li class="tab"><a href="#gadget_laptops" {!! getAjaxAttr('gadget_laptops') !!}>Laptops</a></li>
                <li class="tab"><a href="#gadget_cameras" {!! getAjaxAttr('gadget_cameras') !!}>Cameras</a></li>
            </ul>
        </div>
    
    @foreach($products as $section => $s_products)
        <div role="tabpanel" class="tab-pane active" id="gadget_{{$section}}">
            @include($include_file, [ 'products' => $s_products ])
        </div>
    @endforeach
</div>
</div>
@else
    @include($include_file)
@endif