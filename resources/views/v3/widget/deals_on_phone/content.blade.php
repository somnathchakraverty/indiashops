<?php $include_file = $current_path . ".ajax"; ?>
@if(!isset($ajax))
    <?php $i = 0; $last_key = (count((array)$vendors) - 2); ?>
    @include($include_file)
@else
    @include($include_file)
@endif