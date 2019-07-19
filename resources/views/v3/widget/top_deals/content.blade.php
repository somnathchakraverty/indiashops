<?php $include_file = $current_path . ".ajax"; ?>
@if(!isset($ajax))
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#top_deals_acc_headphones" role="tab" data-toggle="tab">Headphones</a>
        </li>
        <li role="presentation">
            <a href="#top_deals_acc_speakers" role="tab" data-toggle="tab">Speakers</a>
        </li>
        <li role="presentation">
            <a href="#top_deals_acc_smart_wearables" role="tab" data-toggle="tab">Smart Wearables</a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <?php $i=0; ?>
        @foreach($products as $section => $s_products)
            <div class="tab-pane {{($i++==0) ? 'active' : ''}}" id="top_deals_acc_{{$section}}">
                @include($include_file, [ 'products' => $s_products ])
            </div>
        @endforeach
    </div>
@else
    @include($include_file)
@endif