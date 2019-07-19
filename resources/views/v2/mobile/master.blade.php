<!DOCTYPE HTML>
<html>
<head>
    <?php
        if(!is_null(Request::route()))
        {
            $route = Request::route()->getName();
        }
        else
        {
            $route = '';
        }
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" rel="icon" href="{{asset('assets/v2/mobile')}}/images/favicon.png">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="dns-prefetch" href="http://images.indiashopps.com">
    <link rel="dns-prefetch" href="https://rukminim1.flixcart.com">
    <link rel="dns-prefetch" href="http://ecx.images-amazon.com">
    <link rel="dns-prefetch" href="https://n3.sdlcdn.com">
    @if(isset($title))
        <title>{{$title}}</title>
        <meta property="og:title" content="{{$title}}"/>
    @endif
    @if(isset($description))
        <meta name="description" content="{!! $description !!}">
    @endif
    @if($route == 'home_v2')
        <meta name="robots" content="index, follow" />
        <meta name="author" content="Indiashopps" />
        <meta name="keywords" content="Indiashopps, shopping online India, compare buy online mobile, books online, compare electronics items online, kids items, computers and laptops, fashion online" />
        <meta itemprop="image" content="{{secureAssets('assets/v2/')}}/images/indiashopps_logo-final.png">
        <meta name="twitter:image" content="{{secureAssets('assets/v2/')}}/images/indiashopps_logo-final.png">
        <meta name="twitter:image:src" content="{{secureAssets('assets/v2/')}}/images/indiashopps_logo-final.png">
        <meta property="og:image" content="{{secureAssets('assets/v2/')}}/images/indiashopps_logo-final.png"/>
    @endif
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@IndiaShopps">
    <meta name="twitter:creator" content="@IndiaShopps">
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{Request::url()}}"/>
    <meta property="og:site_name" content="IndiaShopps | Buy | Compare Online"/>
    <meta property="fb:admins" content="100000220063668"/>
    <meta property="fb:app_id" content="1656762601211077"/>
    <link rel="icon" href="{{secureAssets('assets/v2/images/favicon.png')}}" type="image/png" sizes="16x16">
    <link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/pgoackgjjkpbkjoomkklkofbhpkbeboc">
    <script>
        var completion = [];
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
    <script type="application/ld+json">
            {
              "@context": "http://schema.org",
              "@type": "WebSite",
              "name": "IndiaShopps",
              "alternateName": "Indiashopps - India Shops here...",
              "url": "http://www.indiashopps.com"
            }
    </script>
    @if( env('APP_ENV') == 'production' )
        <script>
            (function (h, o, t, j, a, r) {
                h.hj = h.hj || function () {
                            (h.hj.q = h.hj.q || []).push(arguments)
                        };
                h._hjSettings = {hjid: 599060, hjsv: 5};
                a = o.getElementsByTagName('head')[0];
                r = o.createElement('script');
                r.async = 1;
                r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
                a.appendChild(r);
            })(window, document, '//static.hotjar.com/c/hotjar-', '.js?sv=');
        </script>
    @endif
<style type="text/css">
.gifbg,body{margin:0}
.gifbg{background:#fff;padding:0;width:100%;height:100%;position:fixed;z-index:99}
.gificon{margin:auto;padding:0;align-items:center;display:block;text-align:center;vertical-align:middle;top:30%;position:relative}
.topheader{width:100%;background:#e40046;top:0;z-index:999;position:fixed;transition:top .2s ease-in-out}
.fullwidthheader{padding:10px;overflow:hidden}
#menu-toggle{float:left;z-index:1;margin-top:7px}
.logo{margin:0;text-align:left;display:block}
.signin,.signin a{float:right;margin-top:2px}
.searchtop{width:100%;margin:auto}
.search-header{width:100%;margin-top:10px;height:30px;padding:0 10px;border:none;float:left;font-size:14px;color:#000}
.inputboxheader{width:90%;margin:0;padding:0;float:left}
.searchbutton{background:#000;border:none;height:30px;line-height:30px;margin-top:10px;width:100%;text-align:center}
.bottonsearch{float:left;width:10%}
.logopart,.navileftpart{width:30%;float:left}
.userpart{width:40%;float:left}
.searchicon{padding:0;margin:0}
</style>
</head>
<body>
<!--THE-HEADER-->
<header>
    <div class="topheader">
        <div class="fullwidthheader">
            <div class="navileftpart">
                <span id="menu-toggle">
                    <img src="{{raw_content('assets/v2/mobile/base64/menu')}}" alt="Navi Icon">
                </span>
            </div>
            <div class="logopart">
                <a href="{{route('home_v2')}}">
                    <img class="logo" src="{{raw_content('assets/v2/mobile/base64/logo')}}" alt="logo">
                </a>
            </div>
            <div class="userpart">
                <div class="signin">
                    <a href="{{route('login_v2')}}"><img src="{{raw_content('assets/v2/mobile/base64/signin')}}" alt="User"></a>
                </div>
            </div>
            <form class="form_search">
                <div class="searchtop">
                    <div class="inputboxheader">
                        <input class="search-header autocomplete_head" placeholder="Search" name="srch-term" type="text">
                    </div>
                    <div class="bottonsearch">
                        <button class="searchbutton" type="submit">
                            <img class="searchicon" src="{{raw_content('assets/v2/mobile/base64/search')}}"
                                 alt="Search">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</header>
<!--END-HEADER-->
<!--THE-GIF-->
<div class="gifbg" id="page_loader">
    <div class="gificon">
        <img src="{{raw_content('assets/v2/mobile/base64/loader')}}" alt="loader" width="50" height="50">
    </div>
</div>
<div id="main_content">
    @if( isset($page_content) && !empty($page_content) )
        {!! $page_content !!}
    @endif
</div>
<!--END-GIF-->
<!--THE-NAV-->
<div id="sidebar-wrapper">
    @include('v2.mobile.menu')
</div>
<?php $page_section = (is_null(Request::route())) ? '' : Request::route()->getName();
$params = (is_null(Request::route())) ? '{}' : json_encode(Request::route()->parameters());
?>
<footer>
    <div class="panel-footer">
        <div class="container">
            @if(isHomePage())
                @if( $page_section == 'home_v2' )
                    @include('v2.footer.description')
                @endif
                <div class="row">
                    {{--@include('v2.footer.links')--}}
                </div>
            @endif
            <div class="row">
                <div class="quicklinksbottom">
                    <a href="{{url('about-us')}}">About us |</a>
                    <a href="{{url('contact-us')}}">Contact us |</a>
                    <a href="{{url('career')}}">Career</a>
                    @if ( array_key_exists( 'footer_links', View::getSections() ) )
                        @yield('footer_links')
                    @else
                        <a href="{{route('sitemap_v2')}}"> | Sitemap</a>
                    @endif
                </div>
            </div>
        </div>
        <p class="copyright">Copyright © 2017 Indiashopps.com - All Rights Reserved.</p>
    </div>
</footer>
<!--END-FOOTER-->
<!--THE-BOTTOM-TAB-->
@if(isHomePage())
    <tabloans class="show">
        <div class="loanstabbg">
            <ul class="loanstab">
                <li>
                    <a href="{{url('loans')}}">
                        <span class="glyphicon glyphicon-piggy-bank margin-right" aria-hidden="true"></span> Loans
                    </a></li>
                <li>
                    <a href="{{url('coupons')}}" style="border:none;">
                        <span class="glyphicon glyphicon-tags margin-right" aria-hidden="true"></span> Coupons
                    </a></li>
            </ul>
        </div>
    </tabloans>
@endif
<script>
    var page_section = '{{$page_section}}';
    var params = JSON.parse('{!! $params !!}');
</script>
<style>
    .ui-autocomplete.ui-widget {
        top: 93px!important;
        left: 0px!important;
        width: 100%!important;
        font-size: 1.2em!important;
    }
</style>
<script>
    var asset_url = '{{asset('assets/v2/mobile')}}/';
    var fstyles = ['bootstrap.css'];
    var sstyles = ['style.css', 'font-awesome.css', 'font.css', 'jquery-ui.min.css'];
    var corejs = "{!! raw_content('assets/v2/mobile/corejs', true) !!}";
    var hasAjaxPage = {{ ( isset($page_content) && !empty($page_content) ) ? 'false;' : 'true;' }}

    window.onload = function () {

        fstyles.forEach(function (style) {
            var st = document.createElement("link");
            st.rel = "stylesheet";
            st.type = "text/css";
            st.href = asset_url + "css/" + style;
            document.body.appendChild(st);
        });

        var s = document.createElement("script");
        s.type = "text/javascript";
        s.src = asset_url + "js/jquery_1.11.3.min.js";
        document.body.appendChild(s);

        s.addEventListener('load', function () {
            var s = document.createElement("script");
            s.type = "text/javascript";
            s.src = asset_url + "js/jquery.mobile.touch.min.js";
            document.body.appendChild(s);

            var s = document.createElement("script");
            s.type = "text/javascript";
            s.src = asset_url + "js/bootstrap.min.js";
            document.body.appendChild(s);

            var ui = document.createElement("script");
            ui.type = "text/javascript";
            ui.src = asset_url + "js/jquery-ui.min.js";
            document.body.appendChild(ui);

            ui.addEventListener('load', function (){
                var send = false;
                var box = false;
                function completed(el)
                {
                    try{
                        $(el).autocomplete('option', 'source', completion[1]);
                        $(el).autocomplete("search");
                        $("#autocomplete").remove();
                        box = el;
                    }
                    catch(e)
                    {
                        /*$.get(ajax_url+"/ajax-content/autocomplete.html");*/
                        console.log(e)
                    }
                }

                $( "form .autocomplete_head" ).autocomplete({
                    minLength: 2,
                    source: completion,
                    select: function( event, ui ) {
                        $( "form .autocomplete_head" ).val( ui.item.label );
                        $(box).closest('form').submit();
                        return false;
                    }
                });

                var url = 'http://completion.amazon.co.uk/search/complete?method=completion&mkt=44571&r=0V5Z5KRFA2VES2FWP7C3&s=260-7407111-5555819&c=&p=Gateway&l=en_IN&sv=desktop&client=amazon-search-ui&x=String&search-alias=aps';
                var timeout;

                $(document).on('keyup',"form .autocomplete_head",function(e){
                    keys = [37,38,39,40,16,17,18];

                    if($.inArray(e.keyCode,keys) > -1)
                        return false;
                    search_box = $(this);
                    send = false;
                    clearTimeout(timeout);
                    var timeout = setTimeout(function(){
                        send = true;
                        if(send)
                        {
                            var script = document.createElement('script');
                            script.onload = function() {
                                completed(search_box);
                            };
                            script.src = url+"&q="+$(search_box).val();
                            script.id = 'autocomplete';

                            document.getElementsByTagName('head')[0].appendChild(script);
                        }
                    },600);
                });
            });

            $(document).on('submit','form.form_search',function(e){
                var search_text = $(this).find('.autocomplete_head').val();
                var cat_id = $(this).find('.category_id').val();
                var ajax_url = '{{url('/')}}';

                if( typeof cat_id == "undefined" )
                {
                    cat_id = 0;
                }

                var search_url  = ajax_url+"/search/"+cat_id+"/"+create_slug(search_text);
                window.location = search_url;

                return false;
            });

            var s = document.createElement("script");
            s.type = "text/javascript";
            s.text = corejs;
            document.body.appendChild(s);

            if( hasAjaxPage )
            {
                loadPageContent();
            }
            else
            {
                afterPageLoaded();
            }
        }, false);
    };

    function loadPageContent() {
        if (typeof page_section !== 'undefined') {

            var data = {
                'type': 'mobile_pages',
                'page_section': page_section
            };

            var data = $.extend({}, data, params);

            $.ajax({
                url: "{{route('get_mobile_ajax_page')}}",
                type: "get",
                data: data,
                success: function (response) {
                    if( typeof response == 'string')
                    {
                        $("#main_content").html(response);
                    }
                    else if( typeof response == 'object' )
                    {
                        if( typeof response.html != 'undefined' )
                        {
                            $("#main_content").html(response.html);
                        }

                        if( typeof response.metadata != 'undefined' )
                        {
                            $("head").append(response.metadata);
                        }
                    }
                    afterPageLoaded();
                },
                error: function (xhr) {
                }
            });
        };
    };

    function afterPageLoaded()
    {
        $("#page_loader").remove();
        setTimeout(function(){
            sstyles.forEach(function (style) {
                var st = document.createElement("link");
                st.rel = "stylesheet";
                st.type = "text/css";
                st.href = asset_url + "css/" + style;
                document.body.appendChild(st);
            });
        },800);

        $(document).on('click','#main_content, .logopart, .userpart',function(){
            $("#sidebar-wrapper").removeClass('active');
        });
    }

    function validateForm(form) {
        var error = '';

        for (var i = 0; i < form.elements.length; i++) {
            var el = form.elements[i];

            if (el.value === '' && el.hasAttribute('required')) {
                error = '<p>' + ucfirst(el.name) + ' is required.</p>';
                $('.errors').append(error).show();
            }

            var mail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            if (el.value !== '' && el.type == 'email' && !mail.test(el.value)) {
                var error = '<p>Invalid Email</p>';
                $('.errors').append(error).show();
            }

            if (el.value !== '' && el.type == 'tel' && !(el.value.length == 10)) {
                error = '<p>Invalid Mobile Number</p>';
                $('.errors').append(error).show();
            }
        }

        return error;
    }

    function sendFormRequest(form, method, callback) {
        if (typeof method == 'undefined') {
            method = 'get'
        }

        $.ajax({
            url: "{{route('get_mobile_ajax_page')}}",
            type: method,
            data: $(form).serialize(),
            success: function (response) {
                $('#loadergif').hide();

                if (typeof response.errors !== 'undefined') {
                    $.each(response.errors, function (i, error) {
                        var error = '<p>' + error + '</p>';
                        $('.errors').append(error).show();
                    });
                }
                else {
                    if (typeof callback == 'function') {
                        callback(response);
                        form.reset();
                        if (typeof response.redirect_to !== 'undefined') {
                            window.location.href = response.redirect_to;
                        }
                    }
                }
            }
        });
    }
    function ucfirst(str, force) {
        str = force ? str.toLowerCase() : str;
        return str.replace(/(\b)([a-zA-Z])/,
                function (firstLetter) {
                    return firstLetter.toUpperCase();
                });
    }
    function create_slug( str )
    {
        str = str.toLowerCase();
        str = str.replace(/\s/g , "-");
        str = encodeURIComponent( str );
        return str;
    }
</script>
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'hi,kn,mr,pa,sd,ta,te,en',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            gaTrack: true,
            gaId: 'UA-69454797-1'
        }, 'google_translate_element');
    }
</script>
<!-- Facebook Pixel Code -->
<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '324999011227767');
    fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
               src="https://www.facebook.com/tr?id=324999011227767&ev=PageView&noscript=1"
    /></noscript>
<!-- End Facebook Pixel Code -->
</body>
</html>
