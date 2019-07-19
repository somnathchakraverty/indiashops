<!DOCTYPE HTML>
<?php setUpGlobals(get_defined_vars()['__data']); ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if( app('seo') instanceof \indiashopps\Support\SEO\SeoData )
        <title>{!! app('seo')->getTitle() !!}</title>
        <meta name="description" content="{!! app('seo')->getDescription() !!}"/>
        <meta name="keywords" content="{!! app('seo')->getKeywords() !!}"/>
    @else
        <title>{!! @$title !!}</title>
    @endif
    @yield('seo_meta')
    {!! canonical_url_list() !!}
    <link rel="search" type="application/opensearchdescription+xml" href="/indiashopps_osd.xml"
          title="IndiaShopps Search : Compare Mobiles and Laptops Price in India"/>
    <meta name="og:url" property="og:url" content="{{Request::url()}}"/>
    <meta name="og:site_name" property="og:site_name" content="IndiaShopps"/>
    <meta name="og:type" property="og:type" content="website"/>
    @if ( array_key_exists( 'opengraph', View::getSections() ) )
        @yield('opengraph')
    @else
        <meta property="og:image" content="{{secureAssets('assets/v2/')}}/images/indiashopps_logo-final.png"/>
        <meta name="og_description" property="og:description" content="{!! app('seo')->getDescription() !!}"/>
    @endif
    <link type="text/css" rel="icon" href="{{asset('assets/v3')}}/images/favicon.png"/>
    <link rel="dns-prefetch" href="https://images.indiashopps.com">
    <link rel="dns-prefetch" href="https://rukminim1.flixcart.com">
    <link rel="dns-prefetch" href="http://ecx.images-amazon.com">
    <link rel="dns-prefetch" href="https://n3.sdlcdn.com">
    <meta property="fb:admins" content="100000220063668"/>
    <meta property="fb:app_id" content="1656762601211077"/>
    <link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/pgoackgjjkpbkjoomkklkofbhpkbeboc">
    @yield('json')
    @yield('head')
    {!! getWidgetsAboveTheFoldResources() !!}
    <script>
        var completion = [];
        @if(versionChanged())
            localStorage.clear();
        @endif
    </script>
    <style>
        {!! file_get_contents(base_path('resources/views').'/v3/common/header.css')  !!}
        @yield('page_css')
    </style>
    @if( env('APP_ENV') == 'production' && env('DISABLE_ANALYTICS', false) !== false )
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                            (i[r].q = i[r].q || []).push(arguments)
                        }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
            ga('create', 'UA-69454797-1', 'auto');
            ga('send', 'pageview');
        </script>
    @endif
    {!! getHeadTagContent() !!}
    @if(isHomePage())
        {!! getStructuredDataJson(get_defined_vars()) !!}
    @endif
</head>
<body>
{!! getBodyTagContent() !!}
<!--THE-PART-1-->
<header>
    <div class="headerbg">
        <div class="container">
            <div class="col-md-2 pleft">
                <a href="{{url('/')}}" class="logoind"></a>
            </div>
            <div class="col-md-7 pleft">
                <form class="form_search" id="searchbox" action="{{$headers->url}}" method="get">
                    @if( isset($headers->type) && $headers->type == 'coupons' )
                        <?php $search_class = ''; $search = "Search Coupons"?>
                    @else
                        <?php $search_class = 'auto_search'; $search = "Search anything..."?>
                    @endif
                    <div class="input-group">
                        <span class="searchicon"></span>
                        <input type="text" class="form-control Search-anything {{$search_class}}" name="search_text"
                               placeholder="{{$search}}" @if(isset($query)) value="{{urldecode($query)}}" @endif />
                    <span class="input-group-btn">
                        <button class="btn btn-default searchbutton orange-button" type="submit">SEARCH</button>
                    </span>
                    </div>
                </form>
            </div>
            <div class="col-md-3 pright">               
                <a class="mobileapp" href="https://play.google.com/store/apps/details?id=com.indiashopps.android&referrer=source%3DSite" target="_blank">
                   <span class="appicon"></span>Mobile App</a>
                <div class="myaccount">
                   <span class="usericon"></span> 
                    <span>
                        @if(Auth::check())
                            <ul>
                                <li class="dropdown">
                                    <a href="{{url('myaccount')}}" class="dropdown-toggle" data-toggle="dropdown"
                                       role="button"
                                       aria-haspopup="true" aria-expanded="false">
                                         Account <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu top0px">
                                        <li>
                                           <a href="{{route('myaccount')}}">
                                                My Profile
                                           </a>
                                        </li>
                                        <li>
                                            <a href="{{route('cashback.earnings')}}">
                                                Cashbacks
                                           </a>
                                        </li>
                                        <li>
                                        <a href="{{route('logout')}}">
                                                Logout
                                           </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        @else
                            <a href="{{route('login_v2')}}">
                                Sign In
                            </a>
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>
</header>
<main>
    <!--END-PART-1-->
    <!--THE-PART-2-->
    <div class="navibg">
        <div class="container">
            <div class="col-md-2 cd-dropdown-wrapper Rectangle-3 pleft">                
                    <a class="cd-dropdown-trigger" href="javascript:void(0)">
                        <span class="naviiconnew"></span>
                        All Categories
                    </a>
                    <nav class="cd-dropdown menu-bottom">                       
                        <ul class="cd-dropdown-content" id="main_menu">
                            {!! $header_menu !!}
                        </ul>
                    </nav>                
            </div>
            <div class="col-md-10 navimenu">              
                    <ul>
                        @foreach($headers->main_menu as $item)
                            <?php $item = (object)$item ?>
                            <li class="dropdown">
                                <a href="{{url($item->menu_link)}}" class="dropdown-toggle"
                                   data-toggle="{{ (isset($item->submenu)) ? 'dropdown' : '' }}" role="button"
                                   aria-haspopup="true" aria-expanded="false">
                                    {{$item->menu_name}}

                                    @if(isset($item->submenu)) <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    @foreach($item->submenu as $menu)
                                        <li>
                                            <a target="_blank"
                                               href="{{$menu->menu_link}}">{{ucwords($menu->menu_name)}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                @else </a> @endif </li>
                        @endforeach
                        <li>
                            <a class="amazon_sale" target="_blank" href="{{route('register_v2')}}">CashBack</a>
                        </li>
                    </ul>                
            </div>
        </div>
    </div>
    <!--END-PART-2-->
    <!--THE-PART-3-->
    <div prefix="og: http://ogp.me/ns#" lang="en" itemscope itemtype="{{getSchemaType()}}">
        @if(!isHomePage())
            {!! getStructuredDataJson(get_defined_vars()) !!}
        @endif
        @yield('page_content')
    </div>

    @if(app('seo')->getContent())
        <section>
            <div class="clearbothcont">
                <div class="categorilistbox bulletpoint">
                    {!! app('seo')->getContent() !!}
                </div>
            </div>
        </section>
    @endif

    @yield('below_content')

    {{-- FOOTER AREA START--}}
    <section>
        <div class="linkbg">
            <div class="container">
                <div class="col-md-3 link">                   
                        <ul>
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li><a href="{{url('upcoming-mobiles-in-india')}}">Upcoming Mobiles</a></li>
                            <li><a href="http://www.indiashopps.com/blog" target="_blank">Blog News</a></li>
                            <li><a href="{{url('about-us')}}">About US</a></li>
                            <li><a href="{{url('contact-us')}}">Contact US</a></li>
                        </ul>                    
                </div>
                <div class="col-md-3 link">                   
                        <ul>
                            <li><a href="{{url('xiaomi-redmi-note-6-pro-price-in-india-10202451')}}">Redmi Note 6
                                    Pro</a></li>
                            <li><a href="{{url('realme-2-pro-price-in-india-10202679')}}">Realme 2 Pro</a></li>
                            <li><a href="{{url('realme-c1-price-in-india-10203870')}}">Realme C1</a></li>
                            <li><a href="{{url('xiaomi-mi-8-pro-price-in-india-10180861')}}">Xiaomi Mi 8 Pro</a></li>
                            <li><a href="{{url('oneplus-6t-price-in-india-10201674')}}">Oneplus 6T</a></li>
                            <li><a href="{{url('motorola-moto-g7-price-in-india-10202674')}}">Motorola Moto G7</a></li>
                        </ul>                    
                </div>
                <div class="col-md-3 link">                   
                        <ul>
                            <li><a href="http://www.indiashopps.com/loans" target="_blank">Loans</a></li>
                            <li><a href="{{url('career')}}">Careers</a></li>
                            <li><a href="{{url('/electronics/prices/42-inch-led-tv-price-list')}}">42 Inch LED TV</a>
                            </li>
                            <li><a href="{{url('/mobile/prices/mobile-phones-below-5000-price-list')}}">Phones Below
                                    5000</a></li>
                        </ul>                    
                </div>
                <div class="col-md-3 link">                    
                        <h3>Contact</h3>
                        <span>Email : <a href="mailto:info@indiashopps.com&subject=query">info@indiashopps.com</a></span>                       
                            <ul class="social">
                                <li><a href="https://www.facebook.com/indiashopps/" class="scl ficon" target="_blank"></a>
                                </li>
                                <li><a href="https://plus.google.com/+Indiashopps" class="scl gicon" target="_blank"></a>
                                </li>
                                <li><a href="https://twitter.com/indiashopps" class="scl ticon" target="_blank"></a></li>
                                <li><a href="mailto:info@indiashopps.com&subject=query" class="scl eicon"></a></li>
                            </ul>                       
                   
                </div>
                <div class="newsletter">
                    <div class="col-md-8">
                        <h3>Join our Newsletter</h3>
                        <p>Never miss any deals on anything</p>
                        <div class="input-group">
                            <input type="email" class="form-control newsletterbox" id="subs_email"
                                   placeholder="Enter your Email">
                            <button class="btn btn-theme" type="button" id="subscribe_button_footer">Subscribe</button>
                        </div>
                        <div id="success" style="display:none" class="alert alert-success"></div>
                        <div id="errors" style="display:none" class="alert alert-danger"></div>
                    </div>
                    <div class="col-md-4">
                        <h3>Add to Chrome</h3>
                        <p>10x Fast Experience</p>
                        <a href="https://chrome.google.com/webstore/detail/indiashopps/pgoackgjjkpbkjoomkklkofbhpkbeboc?hl=en" class="googleplay" target="_blank"></a>
                    </div>
                </div>
                <!--<div class="shipping"></div>-->
            </div>
        </div>
    </section>
    @if(!isHomePage())
        <div class="compare-widget" id="compare-widget">
            @include("v3.common.compare-widget")
        </div>
@endif

@include('v3.common.web_subscribe')
<!--THE-PART-14-->
</main>
<footer>
    <div class="container">
        <div class="footertab">{{--<a href="#">Terms</a> | --}}<a href="{{route('privacy_policy')}}">Privacy</a> |
            <a href="{{route('sitemap_v2')}}">SiteMap</a> © {{date('Y')}}
            IndiaShopps . All rights reserved.
        </div>
    </div>
</footer>
@include("v3.common.exit_popup.modal")
<a id="back-to-top" href="javascript:void(0)" class="btn btn-primary btn-lg back-to-top orange-button" role="button"
   title="" data-toggle="tooltip" data-placement="left"><span
            class="glyphiascon">&#8593;</span></a>
<!--END-PART-14-->
{{-- FOOTER AREA START--}}
<script>
    var loader_image = '<img class="loadergif" src="{{asset('assets/v3')}}/images/loader.gif" alt="loading..." />';
</script>

<link type="text/css" rel="stylesheet" href="{{getCssFile()}}">
<script src="{{asset('assets/v3')}}/js/jquery_2.2.4.min.js" defer onload="loadPageScripts()"></script>
<script src="{{secureAssets('assets/v2/')}}/js/jquery-ui.min.js" defer></script>
<script src="{{getJsFile()}}" defer onload="restJs()"></script>
<script>
    var base_url = '{!! route('home_v2') !!}';
    var amz_session = '{{env('AMAZON_SESSION_ID')}}';
    var img_url = '{{url("/images")}}';
    var alvendors = JSON.parse('<?=json_encode(config("vendor")) ?>');
    var composer_url = '<?=composer_url("")?>';
    var ajax_url = '<?=url('/')?>';
    var templateUrl = '{{route("notify_html")}}';
    var environment = '{{env('APP_ENV')}}';
    var manual_open = false;
    var onDevServer = {!! ( env('APP_ENV') == 'production' ) ? 'false' : 'true' !!};
    var loggedIn = Boolean({{(auth()->check()) ? 1 : 0}});
    function loadPageScripts() {
        var event = new Event('jquery_loaded');
        document.dispatchEvent(event);
    }
    function restJs() {
        bsLoad();
        processLazyLoad();

        if (typeof loadRestJS == 'function') {
            loadRestJS();
        }

        $(".cs_dkt_si").cssCarousel();
        $(".cs_brd_si").cssCarousel();

        getMenu();
    }
    function bsLoad() {
        afterJquery(function () {
            if (typeof bootstrapLoaded == 'function') {
                bootstrapLoaded();
            }

            if (typeof loadCarousel == 'function') {
                loadCarousel();
            }

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                processLazyLoad();
            })
        });
    }

    document.addEventListener('jquery_loaded', function (e) {
        $(document).on('mouseenter', '.cd-dropdown-wrapper', function () {
            $(".menu-bottom").removeClass("menu-bottom");
            $('.cd-dropdown-trigger').addClass('dropdown-is-active');
            $('.cd-dropdown').addClass('dropdown-is-active');
            $(".dropdown").removeClass('open');

            $(".cd-dropdown-content li.has-children:eq(2) a").addClass("is-active");
            $(".cd-dropdown-content li.has-children:eq(2) ul").addClass("is-active");

            manual_open = true;
            $(window).scroll();
        });
        $(document).on('mouseleave', '.cd-dropdown-wrapper', function () {
            $('.cd-dropdown-trigger').removeClass('dropdown-is-active');
            $('.cd-dropdown').removeClass('dropdown-is-active');
        });

        $(document).on('mouseenter', '.cd-dropdown-content li.has-children', function () {
            if (manual_open) {
                manual_open = false;
                $(".cd-dropdown-content li.has-children:eq(2) a").removeClass("is-active");
                $(".cd-dropdown-content li.has-children:eq(2) ul").removeClass("is-active");
            }
        });

        $(document).on('scroll', function (e) {
            $("li.dropdown").removeClass('open');
        });
        $(document).on('click', "#subscribe_button_footer", function () {
            if ($('#subs_email').val() == '') {
                $('#errors').html('Please enter Your Email to subscribe..').fadeIn().delay(2000).fadeOut();
            }
            else if (ValidateEmail($('#subs_email').val())) {
                $.get(ajax_url + "/ajax-content/subscribe?email=" + $('#subs_email').val());
                $('#subs_email').val('');
                $('#success').html('Email Successfully Subscribed..!').fadeIn().delay(2000).fadeOut();
            }
            else {
                $('#errors').html('Please enter correct Email to subscribe..').fadeIn().delay(2000).fadeOut();
            }
        });

        $(document).ajaxComplete(function () {
            processLazyLoad();
            imgError();
        });

        imgError();

        $(document).on('click', '.goto', function () {
            var href = $(this).attr('data-href');
            if (typeof href != 'undefined') {
                var el = $("#" + href);

                if (typeof el.attr('id') != 'undefined') {
                    $('body,html').animate({
                        scrollTop: (el.offset().top - 90)
                    }, 800);
                }
            }
        });
    }, false);

    function imgError() {
        $("img").on("error", function () {
            $(this).attr('src', '/assets/v1/images/imgNoImg.png');
        });
    }

    function afterJquery(callback) {
        if (typeof callback === 'function') {
            var cinterval = setInterval(function () {
                if (typeof $ !== 'undefined') {
                    callback();
                    clearInterval(cinterval);
                }
            }, 1000);
        }
    }

    function processLazyLoad() {
        afterJquery(function () {
            $('img[data-src]').lazyLoadXT({
                throttle: 0,
            });
        });
    }

    function getMenu() {
        var $url = '{{route('main-menu-html')}}';
        if (typeof(localStorage.main_menu) !== "undefined") {
            $("#main_menu").html(localStorage.main_menu);
            $.fn.menuJs($);
        }
        else{
            $.get($url, function (html) {
                if (html.length > 0) {
                    $("#main_menu").html(html);
                    $.fn.menuJs($);
                    localStorage.main_menu = html;
                }
            });
        }
        
    }

    function ValidateEmail(mail) {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
            return (true);
        }
        return (false);
    }
</script>
@yield('scripts')
{!! getWidgetsFooterResources() !!}
{!! getFooterContent() !!}
{!! hasExitPopup(get_defined_vars()) !!}
</body>
</html>