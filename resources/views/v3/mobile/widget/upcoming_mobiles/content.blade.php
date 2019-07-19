<?php $include_file = $current_path . ".ajax"; ?>
@if(!isset($ajax))
    <div class="whitecolorbg">
        <div class="container">
            <h2>Upcoming Mobiles</h2>
            @include($include_file)
            <a href="{{route('upcoming_mobiles')}}" class="allcateglink">
                VIEW ALL UPCOMING PHONES
                <span class="right-arrow"></span>
            </a>
        </div>
    </div>
@else
    @include($include_file)
@endif