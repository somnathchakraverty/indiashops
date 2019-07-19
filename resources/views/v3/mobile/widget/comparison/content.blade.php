<?php $include_file = $current_path . ".ajax"; ?>
@if(!isset($ajax))
    <!-- Tab panes -->
    <div class="whitecolorbg">       
        <div class="container">
        <h2>Trending Comparison</h2>
            @foreach( $products as $section => $s_products )
                <div class="tab-content" id="trending_comp_{{$section}}">
                    @include($include_file, ['products' => $s_products])
                </div>
            @endforeach           
                <a href="{{route('most-compared')}}" class="allcateglink">
                    View All Comparisons
                   <span class="right-arrow"></span>
                </a>            
        </div>
    </div>
@else
    @include($include_file)
@endif
