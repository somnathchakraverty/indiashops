<?php $include_file = $current_path . ".ajax"; ?>
@if(!isset($ajax))
    <div class="whitecolorbg">
        <div class="container">
            <h2>Top Deals on phones</h2>
            @include($include_file)
        </div>
    </div>
@else
    @include($include_file)
@endif