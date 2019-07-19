@if(is_collection($sliders) && $sliders->count() > 0)
    <section>
        <div class="banner">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators couponsbannertext">
                    @foreach($sliders as $key => $slider)
                        <?php $alt = collect(explode("|", $slider->alt)) ?>
                        <li data-target="#myCarousel" data-slide-to="{{$key}}" class="{{($key == 0) ? 'active' :""}}">
                            <span>{!! $alt->shift() !!}</span>
                            <p class="banneroffdic">{!! $alt->shift() !!}</p>
                        </li>
                    @endforeach
                </ol>
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    @foreach($sliders as $key => $slide)
                        <div class="item {{($key == 0) ? 'active' :""}}">
                            @if( isset($slide->refer_url) && !empty($slide->refer_url) )
                                <a href="{{$slide->refer_url}}" target="_blank">
                                    <img class="img-responsive" src="{{$slide->image_url}}" alt="{{$slide->alt}}">
                                </a>
                            @else
                                <img class="img-responsive" src="{{$slide->image_url}}" alt="{{$slide->alt}}">
                            @endif
                        </div>
                    @endforeach
                </div>
                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <div class="chevron-left"></div>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <div class="chevron-right"></div>
                    <span class="sr-only">Next</span>
                </a></div>
        </div>
    </section>
@endif