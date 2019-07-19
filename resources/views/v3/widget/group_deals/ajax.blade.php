<div class="trendingdealsprobox">
    <div class="cs_dkt_si">
        <ul data-items="4">
            @foreach( $slides as $slide )
                <li>
                    @if(isset($slide->refer_url))
                        <a href="{{$slide->refer_url}}" target="_blank">
                            @endif                            
                                <img class="wothuimg" src="{{getImageNew("","M")}}" data-src="{{$slide->image_url}}" alt="{{$slide->alt}}">                           
                            <div class="imbowo">
                                <span>{{$slide->alt}}</span>
                            </div>
                            @if(isset($slide->refer_url))
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>