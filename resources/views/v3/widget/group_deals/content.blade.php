<?php $include_file = $current_path.".ajax";?>
@if(!isset($ajax))
    <ul class="nav nav-tabs" role="tablist">
        <?php $i=0; ?>
        @foreach( $groups as $key => $group )
            <li role="presentation" class="{{$i++==0 ? 'active' : ''}}">
                <a href="#group_deals_ajax_{{create_slug($group)}}" role="tab" data-toggle="tab">{{unslug($group)}}</a>
            </li>
        @endforeach
    </ul>
    <?php $i=0; ?>
    @foreach( $slides as $section => $s_group )
        <div class="tab-pane {{$i++==0 ? 'active' : ''}}" id="group_deals_ajax_{{create_slug($section)}}">
            @include($include_file,[ 'slides' => $s_group ])
        </div>
    @endforeach
@else
    @include($include_file)
@endif