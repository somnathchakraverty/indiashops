<ul id="part44" class="carousel" data-items="1.5">
    @foreach( $slides as $slide )
    <li>
        @if(isset($slide->refer_url))
            <a href="{{$slide->refer_url}}" target="_blank">
        @endif

        <div class="womenthumnail">
            <img class="womenthumnailimg" src="{{$slide->image_url}}" alt="{{$slide->alt}}">
            <div class="imgboxtextwomen">
                <div class="catnamewomen">{{$slide->alt}}</div>
            </div>
        </div>

        @if(isset($slide->refer_url))
            </a>
        @endif
    </li>
    @endforeach
</ul>