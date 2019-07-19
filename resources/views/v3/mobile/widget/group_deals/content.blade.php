<?php $include_file = $current_path.".ajax";?>
@if(!isset($ajax))
    <div class="whitecolorbg">
        <div class="container">       
        <h2>Top deals to sizzle up your presence</h2>
        <div class="product-tabs marginbottom20">
            <ul class="tabs" id="part-tab-8">
                @foreach( $groups as $key => $group )
                    @if($key == 0)
                        <li class="tab">
                            <a class="active" href="#group_deals_ajax_{{create_slug($group)}}">{{unslug($group)}}</a>
                        </li>
                    @else
                        <li class="tab">
                            <a href="#group_deals_ajax_{{create_slug($group)}}" {!! getAjaxAttr('group_deals_ajax') !!} data-sub-sec="{{create_slug($group)}}">{{unslug($group)}}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
   
            <?php $key = 0; ?>
            @foreach( $slides as $section => $s_group )
                <div role="tabpane2" class="tab-pane {{$key++==0 ? 'active' : ''}}" id="group_deals_ajax_{{create_slug($section)}}">
                    @include($include_file,[ 'slides' => $s_group ])
                </div>
            @endforeach
        </div>
    </div>
@else
    @include($include_file)
@endif