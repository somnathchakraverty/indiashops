            <div class="container">
                <div class="find_ph">
                    <div class="hding_top">{!! homeSliderData(0) !!}</div>                   
                    <div class="price_tabba">
                        <span>{!! homeSliderData(2) !!}</span>
                        <ul>
                            @foreach(homeSliderData(0, 'links') as $link)
                                <li>
                                    <a href="{{$link['link']}}">{{$link['text']}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="price_tabba">
                        <span>{!! homeSliderData(3) !!}</span>
                        <ul>
                            @foreach(homeSliderData(1, 'links') as $link)
                                <li>
                                    <a href="{{$link['link']}}">{{$link['text']}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="price_tabba">
                        <span>{!! homeSliderData(4) !!}</span>
                        <ul>
                            @foreach(homeSliderData(2, 'links') as $link)
                                <li class="icon_box">
                                    <a href="{{url($link['link'])}}">
                                        <div class="mob_icon {{cs($link['class'])}}"></div>
                                        {{$link['text']}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                 <!--THE-BANNER-->               
                    <div id="myCarousel" class="new_banner carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            @foreach( $sliders as $key => $slider )
                                <li data-target="#myCarousel" data-slide-to="{{$key}}" class="{{($key == 0) ? 'active' : ''}}"></li>
                            @endforeach
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            @foreach( $sliders as $key => $slider )
                                <?php $image_url = str_replace("http:", "https:", $slider->image_url); ?>                               
                                    @if(isset($slider->refer_url) && !empty($slider->refer_url))
                                        <a class="item {{($key == 0) ? 'active' : ''}}" href="{{$slider->refer_url}}" target="_blank">
                                            @if($key == 0 )
                                                <img src="{{$image_url}}" alt="{{ucwords($slider->alt)}}">
                                            @else
                                                <img src="{{asset('assets/v3/images/banner.jpg')}}" data-src="{{$image_url}}" alt="{{ucwords($slider->alt)}}">
                                            @endif
                                        </a>
                                    @else
                                        <img src="{{$image_url}}" alt="{{ucwords($slider->alt)}}">
                                    @endif
                              
                            @endforeach
                        </div>                        
                    </div>              
                 <!--END-BANNER-->
            </div>