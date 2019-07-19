<?php $include_file = $current_path . ".ajax"; ?>
@if(!isset($ajax))
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation">
            <a href="#below_ten" role="tab" data-toggle="tab">Below &#8377; 10,000</a>
        </li>
        <li role="presentation">
            <a href="#below_fifteen" role="tab" data-toggle="tab">&#8377; 10,000 - 15,000</a>
        </li>
        <li role="presentation">
            <a href="#below_twenty" role="tab" data-toggle="tab">&#8377; 15,000 - 20,000</a>
        </li>
        <li role="presentation">
            <a href="#below_twentyfive" role="tab" data-toggle="tab">&#8377; 20,000 - 30,000</a>
        </li>
        <li role="presentation" class="active">
            <a href="#above_thirty" role="tab" data-toggle="tab">Above &#8377; 30,000</a>
        </li>
    </ul>
    <?php $i = 0; $last_key = (count((array)$vendors) - 2); ?>
    @foreach($vendors as $section => $s_products)
        @if($section != 'below_thirty')
            <div class="tab-pane {{($i++==$last_key) ? 'active' : ''}}" id="{{$section}}">
                @include($include_file, [ 'vendors' => $s_products ])
            </div>
        @endif
    @endforeach
@else
    @include($include_file)
@endif