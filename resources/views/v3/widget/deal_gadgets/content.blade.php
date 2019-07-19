<?php $include_file = $current_path.".ajax"; ?>
@if(!isset($ajax))
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#gadget_tablets" aria-controls="gadget_tablets" role="tab" data-toggle="tab">Tablets</a>
    </li>
    <li role="presentation">
        <a href="#gadget_laptops" aria-controls="gadget_laptops" role="tab" data-toggle="tab">Laptops</a>
    </li>
    <li role="presentation">
        <a href="#gadget_cameras" aria-controls="gadget_cameras" role="tab" data-toggle="tab">Cameras</a>
    </li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <?php $i = 0; ?>
    @foreach($products as $section => $s_products)
        <div class="tab-pane {{($i++==0) ? 'active' : ''}}" id="gadget_{{$section}}">
            @include($include_file, [ 'products' => $s_products ])
        </div>
    @endforeach
</div>
@else
    @include($include_file)
@endif