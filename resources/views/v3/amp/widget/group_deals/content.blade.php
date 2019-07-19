<amp-selector role="tablist" layout="container" class="ampTabContainer">
    @foreach( $slides as $section_name => $sections )
        <div role="tab" class="tabButton tab40px tableft15" selected option="a">{{unslug($section_name)}}</div>
        <div role="tabpanel" class="tabContent">
            <amp-carousel class="full-bottom" height="225" layout="fixed-height" type="carousel">
                @foreach($sections as $section)
                    <div class="thumnail">
                        @if(isset($section->refer_url))
                            <a href="{{$section->refer_url}}" target="_blank">
                        @endif

                        <amp-img class="womenthumnailimg" src="{{$section->image_url}}" width="200" height="221" alt="{{$section->alt}}"></amp-img>
                        <div class="imgboxtextwomen">
                            <div class="catnamewomen">{{$section->alt}}</div>
                        </div>

                        @if(isset($section->refer_url))
                            </a>
                        @endif
                    </div>
                @endforeach
            </amp-carousel>
        </div>
    @endforeach
</amp-selector>