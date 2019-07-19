<div class="css-carousel">
        <ul>
            @foreach( $slides as $slide )
                <li>
                    @if(isset($slide->refer_url))
                        <a class="womenthumnail" href="{{$slide->refer_url}}" target="_blank">
                            @endif
                                <img class="womenthumnailimg" src="{{getImageNew('')}}" data-src="{{$slide->image_url}}" alt="{{$slide->alt}}">
                                <div class="imgboxtextwomen">
                                    <div class="catnamewomen">{{$slide->alt}}</div>
                                </div>
                            @if(isset($slide->refer_url))
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>    
</div>