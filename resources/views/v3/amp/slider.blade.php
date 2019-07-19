<?php
if (isset($slider) && is_array($slider)) {
    $slider = (object)$slider;
}
?>
@if(isset($home_content) && !empty($home_content))
    <div class="container">
        <div class="find_ph">
            <div class="hding_top">{!! homeSliderData(0) !!}</div>
        <!-- <div class="sub_hding_top">{!! homeSliderData(1) !!}</div>-->
            <div class="price_tabba">
                <div class="budget">{!! homeSliderData(2) !!}</div>
                <ul>
                    @foreach(homeSliderData(0, 'links') as $link)
                        <li>
                            <a href="{{$link['link']}}">{{$link['text']}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
    <div class="budget">{!! homeSliderData(3) !!}</div>
    <div class="css-carousel padd_bottom">
        <ul class="bgcolonone">
            <amp-carousel class="full-bottom" height="55" layout="fixed-height" type="carousel">
                @foreach(homeSliderData(1, 'links') as $link)
                    <a href="{{$link['link']}}" class="icon_box_mob">  <span>{{$link['text']}}</span> </a>
                @endforeach
            </amp-carousel>
        </ul>
        </div>
    </div>

    <div class="container">
        <div class="budget">{!! homeSliderData(4) !!}</div>
        <div class="css-carousel padd_bottom">
            <amp-carousel class="full-bottom" height="100" layout="fixed-height" type="carousel">
                @foreach(homeSliderData(2, 'links') as $link)
                    <a href="{{$link['link']}}" class="icon_box">
                        <div class="mob_icon {{cs($link['class'])}}"></div>
                        <span>{{$link['text']}}</span>
                    </a>
                @endforeach
            </amp-carousel>
        </div>
    </div>
@endif
@if(isset($sliders) && !is_null($sliders))
    <div class="banner">
        <amp-carousel layout="responsive" width="400" class="full-bottom" height="200" type="slides" controls loop autoplay delay="4000">
            @foreach($sliders as $slider)
                <div class="slide">
                    @if(isset($slider->refer_url) && filter_var($slider->refer_url,FILTER_VALIDATE_URL))
                        <a href="{{$slider->refer_url}}" target="_blank">
                            <amp-img layout="responsive" src="{{$slider->image_url}}" alt="{{$slider->alt}}" width="400" height="200"></amp-img>
                        </a>
                    @else
                        <amp-img layout="responsive" src="{{$slider->image_url}}" alt="{{$slider->alt}}" width="400" height="200"></amp-img>
                    @endif
                </div>
            @endforeach
        </amp-carousel>
    </div>
@endif