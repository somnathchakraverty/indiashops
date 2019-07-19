<?php $include_file = $current_path . ".ajax"; ?>
@if(!isset($ajax))

    <!-- Tab panes -->
    <div class="tab-content">
        <?php $i=0; ?>
        @foreach( $products as $section => $s_products )
            <div class="tab-pane {{($i++==0) ? 'active' : ''}}" id="trending_comp_{{$section}}">
                @include($include_file, ['products' => $s_products])
            </div>
        @endforeach
    </div>
@else
    @include($include_file)
@endif