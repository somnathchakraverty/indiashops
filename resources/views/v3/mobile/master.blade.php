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
    <link rel="search" type="application/opensearchdescription+xml" href="/indiashopps_osd.xml" title="IndiaShopps Search : Compare Mobiles and Laptops Price in India"/>
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
    <style type="text/css">
        {!! file_get_contents(base_path('resources/views').'/v3/mobile/common/header.css')  !!}
    </style>
    {!! getWidgetsAboveTheFoldResources() !!}
    <script>
        var completion = [];
        @if(versionChanged())
            localStorage.clear();
        @endif
    </script>
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
</head>
<body>
<!--THE-HEADER-->
<header>
    <div class="topheader">
        <div class="container">
            <div class="top-bar">
                <a href="javascript:void(0)" id="menu-toggle"></a>
                <div class="logopart">
                    <a href="{{url('/')}}" class="logoimg">
                    </a>
                </div>
                <a href="javascript:void(0)" class="searicon"></a>
                @if(Auth::check())

                    <a href="{{route('myaccount')}}" class="usericimg"></a>
                @else

                    <a href="{{route('login_v2')}}" class="usericimg"></a>

                @endif
                <a href="https://play.google.com/store/apps/details?id=com.indiashopps.android&referrer=source%3DSite" target="_blank" class="appimg"></a>
            </div>
            <form action="{{$headers->url}}" id="main_search" style="display:none;">
                <div class="inputboxheader">
                    <input class="search-header {{($headers->type != 'coupons') ? 'auto_search' : ''}}" placeholder="Search" name="search_text" type="text">
                    <button class="searchbutton" type="submit">
                        <span class="searchicon"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</header>
<!--END-HEADER-->
<main>
    @if ( array_key_exists( 'page_content', View::getSections() ) )
        <div prefix="og: http://ogp.me/ns#" itemscope itemtype="{{getSchemaType()}}">
            {!! getStructuredDataJson(get_defined_vars()) !!}
            @yield('page_content')
        </div>
    @else
        <div class="gifbg" id="page_loader">
            <div class="gificon">
                <img src="{{raw_content('assets/v2/mobile/base64/loader')}}" alt="loader" width="50" height="50">
            </div>
        </div>
        <div id="main_content"></div>
    @endif
<!--THE-PART-12-->
    @if(app('seo')->getContent())
        <section>
            <div class="categorilistbox bulletpoint" id="footer_content">
                {!! app('seo')->getContent() !!}
            </div>
        </section>
@endif
<!--FOOTER STARTS-->
    <section>
        <div class="whitecolorbg">
            <div class="container">
                <div class="link">
                    <ul>
                        <li><a href="{{url('/')}}">Home</a></li>
                        <li><a href="{{url('upcoming-mobiles-in-india')}}">Upcoming Mobiles</a></li>
                        <li><a href="http://www.indiashopps.com/blog" target="_blank">Blog News</a></li>
                        <li><a href="{{url('about-us')}}">About US</a></li>
                        <li><a href="{{url('contact-us')}}">Contact US</a></li>
                        <li><a href="{{url('xiaomi-redmi-note-6-pro-price-in-india-10202451')}}">Redmi Note 6 Pro</a>
                        </li>
                        <li><a href="{{url('realme-2-pro-price-in-india-10202679')}}">Realme 2 Pro</a></li>
                        <li><a href="{{url('realme-c1-price-in-india-10203870')}}">Realme C1</a></li>
                        <li><a href="{{url('xiaomi-mi-8-pro-price-in-india-10180861')}}">Xiaomi Mi 8 Pro</a></li>
                        <li><a href="{{url('oneplus-6t-price-in-india-10201674')}}">Oneplus 6T</a></li>
                        <li><a href="{{url('motorola-moto-g7-price-in-india-10202674')}}">Motorola Moto G7</a></li>
                    </ul>
                </div>
                <div class="link" style="padding-top:30px;">
                    <ul>
                        <li><a href="http://www.indiashopps.com/loans" target="_blank">Loans</a></li>
                        <li><a href="{{url('career')}}">Careers</a></li>
                        <li><a href="{{url('/electronics/prices/42-inch-led-tv-price-list')}}">42 Inch LED TV</a></li>
                        <li><a href="{{url('/mobile/prices/mobile-phones-below-5000-price-list')}}">Phones Below
                                5000</a></li>
                    </ul>
                </div>
                <div class="link">
                    <h3>Contact</h3>
                    <span>Email : <a href="mailto:info@indiashopps.com&subject=query">info@indiashopps.com</a></span>
                    <div class="social">
                        <ul>
                            <li><a href="https://www.facebook.com/indiashopps/" target="_blank" class="faceico"></a>
                            </li>
                            <li><a href="https://plus.google.com/+Indiashopps" target="_blank" class="googic"></a></li>
                            <li><a href="https://twitter.com/indiashopps" target="_blank" class="twittico"></a></li>
                            <li><a href="mailto:info@indiashopps.com&subject=query" class="mailico"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="newsletter">
                    <h3>Join our Newsletter</h3>
                    <p>Never miss any deals on anything</p>
                    <input type="email" class="search-header marginbottom30" placeholder="Enter your email">
                    <div class="bottonsearch margin0">
                        <button class="searchbutton subscribebutton" type="submit">Subscribe</button>
                    </div>
                    <h3>Add to Chrome</h3>
                    <p>10x Fast Experience</p>
                    <a href="https://chrome.google.com/webstore/detail/indiashopps/pgoackgjjkpbkjoomkklkofbhpkbeboc?hl=en" target="_blank" class="googplay"></a>
                </div>

            </div>
        </div>
    </section>
    <!--END-PART-12-->
    <!--THE-PART-13-->
</main>
<footer>
    <div class="container">
        <div class="footertab">{{--<a href="#">Terms</a> | --}}<a href="{{route('privacy_policy')}}">Privacy</a> |
            <a href="{{route('sitemap_v2')}}">SiteMap</a> © {{date('Y')}}
            IndiaShopps . All rights reserved.
        </div>
    </div>
</footer>
<a href="#" id="back-to-top" title="Back to top">&uarr;</a>
<div id="main_menu">
    {!! $header_menu !!}
</div>
<!--END-PART-13-->
<!--FOOTER ENDS-->
<?php
$page_section = (is_null(Request::route())) ? '' : Request::route()->getName();
$params = (is_null(Request::route())) ? '{}' : json_encode(Request::route()->parameters());
?>
<script src="{{asset('assets/v3/mobile')}}/js/jquery_2.2.4.min.js" defer onload="loadPageScripts()"></script>
<script src="{{getJsFile()}}" defer onload="restJs()"></script>
<script type="text/javascript">
    function loadPageScripts() {

        var event = new Event('jquery_loaded');
        document.dispatchEvent(event);
    }

    window.addEventListener('load', function () {
        var JS = document.createElement('script');
        JS.src = "{{asset('assets/v3/mobile')}}/js/materialize.min.js";
        document.body.appendChild(JS);

        var l = document.createElement('link');
        l.rel = 'stylesheet';
        l.href = '{{mix('build/mobile/css/app.css')}}';
        document.body.appendChild(l);

        getMenu();

        var interval = setInterval(function () {
            if (typeof Materialize != 'undefined') {
                materialize();
                clearInterval(interval);
            }
        }, 200);
    });

    function restJs() {
        if (typeof uiLoaded == 'function') {
            uiLoaded();
        }
        if (typeof lazyLoad == 'function') {
            lazyLoad();
        }

        if (typeof restJsLoaded == 'function') {
            restJsLoaded();
        }
    }

    var completion = [];
    var loader_image = '<img class="loadergif" src="{{asset('assets/v3')}}/images/loader.gif" alt="loading..." />';
    var base_url = '{!! route('home_v2') !!}';
    var amz_session = '{{env('AMAZON_SESSION_ID')}}';
    var img_url = '{{url("/images")}}';
    var alvendors = JSON.parse('<?=json_encode(config("vendor")) ?>');
    var composer_url = '<?=composer_url("")?>';
    var ajax_url = '<?=url('/')?>';
    var templateUrl = '{{route("notify_html")}}';
    var environment = '{{env('APP_ENV')}}';
    var manual_open = false;
    var page_section = '{{$page_section}}';
    var params = JSON.parse('{!! $params !!}');
    var hasAjaxPage =
            {{ ( isset($page_content) && !empty($page_content) ) ? 'false;' : 'true;' }}
    var loggedIn = Boolean({{(auth()->check()) ? 1 : 0}});
</script>
<script>
    function processLazyLoad() {
        afterJquery(function () {
            $('img[data-src]').lazyLoadXT({
                throttle: 0,
            });
        });
    }

    function materialize() {
        afterJquery(function () {
            if (typeof MLoaded == 'function') {
                MLoaded();
            }

            $("ul.tabs").on('click.tabs', function () {
                processLazyLoad();
            })
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
    ;

    function lazyLoad() {
        afterJquery(function () {

        });
        processLazyLoad();
    }
    document.addEventListener('jquery_loaded', function (e) {

        @if(isset($has_ajax_page) && $has_ajax_page)
            loadPageContent();
        @endif

        $(document).on('click', '#menu-close, #menu-toggle', function () {
            $("#sidebar-menu").toggleClass("active");
        });

        processLazyLoad();

        $(document).ajaxComplete(function () {
            processLazyLoad();
        });

        $(document).on('click', '#main-menu li.has-sub > a', function () {

            var element = $(this).parent('li');
            if (element.hasClass('open')) {
                if (element.hasClass('first_level')) {
                    element.removeClass('open');
                    element.find('li').removeClass('open');
                    element.find('ul').slideUp();
                    return false;
                }
            } else {
                element.addClass('open');
                element.children('ul').slideDown();
                element.siblings('li').children('ul').slideUp();
                element.siblings('li').removeClass('open');
                element.siblings('li').find('li').removeClass('open');
                element.siblings('li').find('ul').slideUp();
                return false;
            }
        });

        $(".moreproduct").on('click', function () {
            var wrapper = $(this).closest('.more_content_wrapper');
            var element = wrapper.find('.more-less-product1');

            if (element.hasClass('show')) {
                element.removeClass('show');

                if (typeof $(this).attr('data') != "undefined") {
                    $(this).html($(this).attr('data'));
                }
                else {
                    $(this).html("Read More <span>&rsaquo;</span>");
                }

                $('html, body').animate({
                    scrollTop: wrapper.offset().top - $('header').height()
                }, 200);
            }
            else {
                element.addClass('show');
                $(this).html("Show Less <span>&rsaquo;</span>");
            }
        });

        $('.searicon').click(function () {
            $("#main_search").slideToggle('fast');
        });
    });

    function loadPageContent() {
        if (typeof page_section !== 'undefined') {

            var data = {
                'page_type': 'mobile_pages',
                'page_section': page_section
            };

            var data = $.extend({}, data, params);

            $.ajax({
                url: "{{route('get_mobile_ajax_page')}}",
                type: "get",
                data: data,
                success: function (response) {
                    $("#page_loader").remove();
                    if (typeof response == 'string') {
                        $("#main_content").html(response);
                    }
                    else if (typeof response == 'object') {
                        if (typeof response.html != 'undefined') {
                            $("#main_content").html(response.html);
                        }

                        if (typeof response.metadata != 'undefined') {
                            $("head").append(response.metadata);
                        }

                        if (typeof response.footer_content != 'undefined' && response.footer_content != null) {
                            $("#footer_content").html(response.footer_content);
                        }
                        else {
                            $("#footer_content").remove();
                        }
                    }
                },
                error: function (xhr) {
                }
            });
        }
    }

    function getMenu() {
        var $url = '{{(auth()->check()) ? route('main-menu-html') : route('mobile-menu-html')}}';
        if (localStorage.getItem("menu_html")) {
            $("#main_menu").html(html);
            $("#sidebar-menu").show();
            return true;
        }

        $.get($url, function (html) {
            if (html.length > 0) {
                $("#main_menu").html(html);
                $("#sidebar-menu").show();
                localStorage.setItem('menu_html', html);
            }
        });
    }
</script>
@yield('scripts')
{!! getWidgetsFooterResources() !!}
{!! getFooterContent() !!}
</body>
</html>