@extends('v3.mobile.master')
@section('page_content')
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
                @foreach(homeSliderData(1, 'links') as $link)
                        <a href="{{$link['link']}}" class="icon_box_mob">  <span>{{$link['text']}}</span> </a>
                @endforeach
            </ul>

        </div>
    </div>

    <div class="container">
        <div class="budget">{!! homeSliderData(4) !!}</div>
        <div class="css-carousel padd_bottom">
            @foreach(homeSliderData(2, 'links') as $link)
                <a href="{{$link['link']}}" class="icon_box">
                    <div class="mob_icon {{cs($link['class'])}}"></div>
                    <span>{{$link['text']}}</span>
                </a>
            @endforeach
        </div>
    </div>
    <!--THE-BANNER-->
    @if(!is_null($msliders))
        <div class="banner carbann" id="banner">
            <ul>
                @foreach($msliders as $key => $slider)
                    <li class="{{($key != 0) ? 'banner_loading' : ""}}">
                        @if(isset($slider->refer_url) && filter_var($slider->refer_url,FILTER_VALIDATE_URL))
                            <a href="{{$slider->refer_url}}" target="_blank">
                                @if($key == 0)
                                    <img class="img-responsive" src="{{$slider->image_url}}" alt="{{$slider->alt}}">
                                @else
                                    <img class="img-responsive" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="{{$slider->image_url}}" alt="{{$slider->alt}}">
                                @endif
                            </a>
                        @else
                            <img class="img-responsive" src="{{$slider->image_url}}" alt="{{$slider->alt}}">
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    <!--END-BANNER-->
    {!! $home_content !!}
    <!-- Modal Structure -->
    @if(false)
        <div id="fraudPopup" class="modal">
            <div class="modal-content">
                <img src="{{asset('assets/v3/images/fraud_new.png')}}" width="100%" alt="Fraud Warning Indiashopps"/>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green">Close</a>
            </div>
        </div>
    @endif
@endsection
@section('scripts')
    <style>
        .modal-close { background-image: linear-gradient(to left, #ff774c, #ff3131) !important; float: left; padding: 10px; color: #fff; border-radius: 5px; font-weight: 600; letter-spacing: 2px; }
    </style>
    <script>
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + "; " + expires + ";path=/;";
        }

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1);
                if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
            }
            return "";
        }
        function uiLoaded() {}
        function MLoaded() {
            if (!getCookie('fraudPopupShown')) {
                setTimeout(function () {
                    $("#fraudPopup").modal();
                    $("#fraudPopup").modal('open');
                }, 1500);
                setCookie("fraudPopupShown", "yes", 0.16);
                processLazyLoad();
            }
        }
        function restJsLoaded() {
            $("#banner").cssCarousel({
                autoplay: true,
                infinite: true,
                itemScroll: 1,
                navigation: false,
                interval: 5000,
                slide: function (slider) {}
            });
        }
    </script>
@endsection