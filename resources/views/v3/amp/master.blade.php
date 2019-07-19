<!doctype html>
<html amp lang="en">
<head>
    <?php setUpGlobals(get_defined_vars()['__data']); ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    @if( app('seo') instanceof \indiashopps\Support\SEO\SeoData )
        <title>{!! app('seo')->getTitle() !!}</title>
        <meta name="description" content="{!! app('seo')->getDescription() !!}"/>
        <meta name="keywords" content="{!! app('seo')->getKeywords() !!}"/>
    @else
        <title>{!! @$title !!}</title>
    @endif
    @yield('seo_meta')
    <link rel="search" type="application/opensearchdescription+xml" href="/indiashopps_osd.xml" title="IndiaShopps Search : Compare Mobiles and Laptops Price in India"/>
    <meta name="og:url" property="og:url" content="{{Request::url()}}"/>
    <meta name="og:site_name" property="og:site_name" content="IndiaShopps"/>
    <meta name="og:type" property="og:type" content="website"/>
    @if ( array_key_exists( 'opengraph', View::getSections() ) )
        @yield('opengraph')
    @else
        <meta property="og:image" content="{{secureAssets('assets/v2/')}}/images/indiashopps_logo-final.png"/>
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
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <script async="" custom-element="amp-font" src="https://cdn.ampproject.org/v0/amp-font-0.1.js"></script>
    <script async="" custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
    <script async="" custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>
    <script async="" custom-element="amp-accordion" src="https://cdn.ampproject.org/v0/amp-accordion-0.1.js"></script>
    <script async="" custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
    <script async="" custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>
    <script async="" custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
    <script async custom-element="amp-selector" src="https://cdn.ampproject.org/v0/amp-selector-0.1.js"></script>
    <script async custom-element="amp-bind" src="https://cdn.ampproject.org/v0/amp-bind-0.1.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i">
    <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"/>
    <style amp-custom>
        body a { color: #00008b; display: inline; text-decoration: none }
        strong { font-size: 16px; color: #000 }
        .sidebar-menu a { color: #3a3a3a }
        .container p { text-align: justify; margin-top: 10px }
        .breadcrumb { background: 0 0; margin-bottom: 15px; line-height: 28px; font-size: 12px; font-weight: 400; height: 30px; overflow: hidden; text-overflow: ellipsis; display: block; -webkit-line-clamp: 1; -webkit-box-orient: vertical }
        .breadcrumb > li { display: inline-block; color: #b4b6b8 }
        .breadcrumb > li + li:before { padding: 0 2px; color: #ccc; content: "\00a0/\00a0" }
        :before, :after { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box }
        .breadcrumb a { display: inline-block; color: #24272c }
        .emptystar { width: 81%; background: url(/assets/v3/amp/images/star-rating-sprite.png) repeat-x; height: 16px }
        .halfstar { width: 48%; background: url(/assets/v3/amp/images/star-rating-sprite.png) 0 100% repeat-x; float: left; height: 16px }
        .fullstar { width: 81%; background: url(/assets/v3/amp/images/star-rating-sprite.png) 0 100% repeat-x; float: left; height: 16px }
        .star-ratingreviews { width: 100%; margin: 5px 0 4px }
        .star-ratings-sprite { width: 81px; overflow: hidden }
        .greycolor { background: url(/assets/v3/amp/images/star-rating-sprite.png) repeat-x; height: 16px; width: 17px; margin-right: 0; display: inline-block }
        .star-ratings-sprite-rating { float: left; height: 16px }
        #footer_content { opacity: .9; font-size: 14px; font-weight: 300; text-align: left; color: #1f2228; line-height: 18px; padding: 10px 15px; margin-top: 20px }
        .css-carouseltab { display: flex; overflow-x: auto; scroll-behavior: smooth; -webkit-overflow-scrolling: touch; padding-bottom: 10px }
        .css-carouseltab::-webkit-scrollbar { height: 0 }
        .css-carouseltab::-webkit-scrollbar-thumb { background: #ddd; border-radius: 0; -moz-border-radius: 0 }
        .css-carouseltab::-webkit-scrollbar-track { background: transparent }
        .css-carouseltab > ul { flex-shrink: 0; margin: 0; transform-origin: center center; transform: scale(1); transition: transform .5s; position: relative; display: flex; justify-content: center; align-items: center }
        .css-carouseltab > ul:target { transform: scale(0.8) }
        .padding-btm0 { padding-bottom: 0 }
        .hidden-content { height: 48px; overflow: hidden }
        .hidden-content.small { height: 46px }
        #show-more-button, #show-more-button1 { display: none }
        #show-more-button.shown, #show-more-button1.shown { display: inline-block; background: #ff4037; color: #fff; padding: 5px 10px; font-size: 14px; border-radius: 3px; float: right; margin: 10px 0; cursor: pointer }
        .exten { margin: 13px 0px 0px 0px; padding: 0px; }
        .newsletter p { margin: 3px 0px; padding: 0px; }
        <?php $css_file = (isset($css_file) ? $css_file : '') ?>
        {!! getAmpPageCss($css_file) !!}
    </style>
    @include("v3.amp.boilerplate")
    @if( env('APP_ENV') == 'production' )
        <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    @endif
</head>
<body>
@if( env('APP_ENV') == 'production' )
    <amp-analytics type="googleanalytics">
        <script type="application/json">
            {
              "vars": {
                "account": "UA-69454797-1"
              },
              "triggers": {
                "trackPageview": {
                  "on": "visible",
                  "request": "pageview"
                }
              }
            }

        </script>
    </amp-analytics>
@endif
<!--THE-HEADER-->
<header>
    <button class="header-icon-1" on='tap:sidebar.open'><i class="fa fa-navicon"></i></button>
    <div class="logotop">
        <a href="{{route('amp.home')}}">
            <amp-img src="{{asset('assets/v3/amp/images')}}/logo.png" alt="Welcome" width="95px" height="32px" class="header-logo"></amp-img>
        </a>
    </div>
    <span class="header-icon-2">
        <a href="https://play.google.com/store/apps/details?id=com.indiashopps.android&referrer=source%3DSite" class="appdownload" target="_blank">
            <i class="fa fa-download right25"></i>
        </a>
        <a href="{{route('login_v2')}}" class="appdownload">
            <i class="fa fa-user-o"></i>
        </a>
    </span>
    <div class="content">
        <form action="{{route('search')}}" method="GET" class="contactForm" target="_top" custom-validation-reporting="show-all-on-submit">
            <fieldset>
                <div class="formFieldWrap pull-left">
                    <input type="text" name="search_text" value="" class="contactField" id="contactNameField"/>
                </div>
                <div class="formSubmitButtonErrorsWrap contactFormButton pull-left">
                    <button class="buttonWrap button bg-green-dark contactSubmitButton" type="submit">
                        <i class="fa fa-search fa-searchcolor" aria-hidden="true"></i>
                    </button>
                </div>
            </fieldset>
        </form>
    </div>
</header>
<!--THE-MENU-->
<amp-sidebar id="sidebar" layout="nodisplay" side="left">
    <div class="sidebar-header">
        <div class="clear"></div>
    </div>
    <p class="sidebar-divider">
        <span class="navigation">Navigation</span>
        <a href="#" on="tap:sidebar.close">
            <i class="fa fa-times closeicon"></i>
        </a>
    </p>
    {!! $header_menu !!}
</amp-sidebar>
<!--END-MENU-->
<!--END-HEADER-->

{{--########CONTENT PART START##########--}}
<div prefix="og: http://ogp.me/ns#" lang="en" itemscope itemtype="{{getSchemaType()}}">
    {!! getStructuredDataJson(get_defined_vars()) !!}
    @yield('page_content')
</div>
{{--########CONTENT PART END##########--}}

@if(app('seo')->getContent())
    <section>
        <div class="categorilistbox bulletpoint" id="footer_content">
            {!! removeInlineStyle1(app('seo')->getContent()) !!}
        </div>
    </section>
@endif
<section>
    <div class="linkbg">
        <div class="container">
            <div class="link">
                <ul>
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('upcoming-mobiles-in-india')}}">Upcoming Mobiles</a></li>
                    <li><a href="https://www.indiashopps.com/blog" target="_blank">Blog News</a></li>
                    <li><a href="{{url('about-us')}}">About US</a></li>
                    <li><a href="{{url('contact-us')}}">Contact US</a></li>
                </ul>
            </div>
            <div class="link">
                <ul>
                    <li><a href="{{url('xiaomi-redmi-note-6-pro-price-in-india-10202451')}}">Redmi Note 6 Pro</a></li>
                    <li><a href="{{url('realme-2-pro-price-in-india-10202679')}}">Realme 2 Pro</a></li>
                    <li><a href="{{url('realme-c1-price-in-india-10203870')}}">Realme C1</a></li>
                    <li><a href="{{url('xiaomi-mi-8-pro-price-in-india-10180861')}}">Xiaomi Mi 8 Pro</a></li>
                    <li><a href="{{url('oneplus-6t-price-in-india-10201674')}}">Oneplus 6T</a></li>
                    <li><a href="{{url('motorola-moto-g7-price-in-india-10202674')}}">Motorola Moto G7</a></li>
                </ul>
            </div>
            <div class="link">
                <ul>
                    <li><a href="https://www.indiashopps.com/loans" target="_blank">Loans</a></li>
                    <li><a href="{{url('career')}}">Careers</a></li>
                    <li><a href="{{url('/electronics/prices/42-inch-led-tv-price-list')}}">42 Inch LED TV</a></li>
                    <li><a href="{{url('/mobile/prices/mobile-phones-below-5000-price-list')}}">Phones Below 5000</a>
                    </li>
                </ul>
            </div>
            <div class="link">
                <h3>Contact</h3>
                        <span>Email : <a href="mailto:info@indiashopps.com&subject=query">info@indiashopps
                                .com</a></span>
                <div class="social">
                    <ul>
                        <li>
                            <a href="https://www.facebook.com/indiashopps/"><i class="fa fa-facebook-square fontsize" aria-hidden="true"></i></a>
                        </li>
                        <li>
                            <a href="https://plus.google.com/+Indiashopps"><i class="fa fa-google-plus-square fontsize" aria-hidden="true"></i></a>
                        </li>
                        <li>
                            <a href="https://twitter.com/indiashopps"><i class="fa fa-twitter-square fontsize" aria-hidden="true"></i></a>
                        </li>
                        <li>
                            <a href="mailto:info@indiashopps.com&subject=query"><i class="fa fa-envelope-square fontsize" aria-hidden="true"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="newsletter">
                <h3 class="textcenter exten">Join our Newsletter</h3>
                <p>Never miss any deals on anything</p>
                <input type="email" class="search-header marginbottom10" placeholder="Enter your email">
                <div class="bottonsearch margin0">
                    <button class="searchbutton subscribebutton" type="submit">Subscribe</button>
                </div>
                <h3 class="textcenter exten">Add to Chrome</h3>
                <p>10x Fast Experience</p>
                <a href="https://chrome.google.com/webstore/detail/indiashopps/pgoackgjjkpbkjoomkklkofbhpkbeboc?hl=en" class="textcenter" target="_blank">
                    <amp-img src="{{asset('assets/v3/amp/images')}}/add_chrome.png" width="154" height="32" alt="google"></amp-img>
                </a></div>
        </div>
    </div>
</section>
<footer>
    <div class="container">
        <div class="footertab"><a href="{{route('privacy_policy')}}">Privacy</a> |
            <a href="{{route('sitemap_v2')}}">SiteMap</a> © {{date('Y')}} IndiaShopps . All rights reserved.
        </div>
    </div>
</footer>
{!! getWidgetsFooterResources() !!}
{!! getFooterContent() !!}
</body>
</html>