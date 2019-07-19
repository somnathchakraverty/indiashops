@if(@$ajax != 'true' )
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(isset($title))
        <title>{{$title}}</title>
        <meta property="og:title" content="{{$title}}"/>
    @elseif ( array_key_exists( 'title', View::getSections() ) )
        @yield('title')
    @else
        @include('v2.product.common.meta',[ get_defined_vars() ])
    @endif

    @if(isset($page) && !empty($page) && $page > 1)
        <meta name="ROBOTS" content="noindex">
    @endif

    @if ( array_key_exists( 'meta_description', View::getSections() ) )
        @yield('meta_description')
    @else
        @include('v2.product.common.description',[ get_defined_vars() ])
    @endif
    @if(isset($list_desc) && isset($list_desc->keywords))
        <meta name="keywords" content="{!! html_entity_decode($list_desc->keywords) !!}">
    @elseif(isset($list_desc) && isset($list_desc->keyword))
        <meta name="keywords" content="{!! html_entity_decode($list_desc->keyword) !!}">
    @elseif ( array_key_exists( 'keywords', View::getSections() ) )
        @yield('keywords')
    @else
        @if(isset($meta) && !empty($meta->keyword))
            <meta name="keywords" content="<?=$meta->keyword?>">
        @elseif(isset($meta) && !empty($meta->keywords))
            <meta name="keywords" content="<?=$meta->keywords?>">
        @elseif(isset($cat))
            <meta name="keywords"
                  content="online, <?=$cat?>, list, compare, quality, prices, store, india, cheap,brand, search, buy, website, shopping, lowest, best deals">
        @endif
    @endif
    @yield('meta')
    <link rel="dns-prefetch" href="http://images.indiashopps.com">
    <link rel="dns-prefetch" href="https://rukminim1.flixcart.com">
    <link rel="dns-prefetch" href="http://ecx.images-amazon.com">
    <link rel="dns-prefetch" href="https://n3.sdlcdn.com">
    <meta itemprop="image" content="{{secureAssets('assets/v2/')}}/images/indiashopps_logo-final.png">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@IndiaShopps">
    <meta name="twitter:creator" content="@IndiaShopps">
    <meta name="twitter:image" content="{{secureAssets('assets/v2/')}}/images/indiashopps_logo-final.png">
    <meta name="twitter:image:src" content="{{secureAssets('assets/v2/')}}/images/indiashopps_logo-final.png">
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{Request::url()}}"/>
    <meta property="og:image" content="{{secureAssets('assets/v2/')}}/images/indiashopps_logo-final.png"/>
    <meta property="og:site_name" content="IndiaShopps | Buy | Compare Online"/>
    <meta property="fb:admins" content="100000220063668"/>
    <meta property="fb:app_id" content="1656762601211077"/>
    <link href="{{secureAssets('assets/v2/')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{secureAssets('assets/v2/')}}/css/style.css" rel="stylesheet">
    <link rel="icon" href="{{secureAssets('assets/v2/images/favicon.png')}}" type="image/png" sizes="16x16">
    <link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/pgoackgjjkpbkjoomkklkofbhpkbeboc">
    @yield('json')
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
</head>
<body>
<div class="overlay" id="overlay"></div>
<div class="navbar-fixed-top--">
    <section class="top-bg">
        <div class="container bg-trans">
            <div class="row MB20">
                <div class="col-md-6">
                    <div class="mgtopnew">
                        <div id="google_translate_element"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    @if( show_loans_dropdown() )
                        <div class="loanmenutop">
                            <ul>
                                <li class="dropdown loanmenutopnew">
                                    <a href="http://www.indiashopps.com/loan" class="dropdown-toggle colorcomisoon"
                                       data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">
                                        <span class="neon">Coming Soon</span> Loans<span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menuloan">
                                        <li>
                                            <a href="http://www.indiashopps.com/loans" target="_blank">Loans</a></li>
                                        <li>
                                            <a href="http://www.indiashopps.com/home-loan" target="_blank">Home Loan</a>
                                        </li>
                                        <li>
                                            <a href="http://www.indiashopps.com/car-loan" target="_blank">Car Loan</a>
                                        </li>
                                        <li>
                                            <a href="http://www.indiashopps.com/personal-loan" target="_blank">Personal
                                                Loan</a>
                                        </li>
                                        <li>
                                            <a href="http://www.indiashopps.com/used-car-loan" target="_blank">Used Car
                                                Loan</a>
                                        </li>
                                        <li>
                                            <a href="http://www.indiashopps.com/loans/learning"
                                               target="_blank">Learning</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    @endif
                    <div class="topnavirightnew">
                        <ul class="top-link pull-right">
                            <li><a href="{{url('most-compared-mobiles.html')}}">Compare Phones</a></li>
                            <li><a href="http://www.indiashopps.com/blog">Blogs</a></li>
                            <li class="appdow">
                                <i class="fa fa-android top-f" aria-hidden="true"
                                   style="color:#fff;float:left;margin:-1px 5px 0px 0px;"></i>
                                <a href="https://play.google.com/store/apps/details?id=com.indiashopps.android&referrer=source%3DSite"
                                   target="_blank">
                                    Download App
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <header class="StickyHeader" id="sticky-header">
        <section class="header-bg">
            <div class="container bg-trans">
                <div class="row">
                    <div class="col-md-2 logo-box ">
                        <a href="/" title="India's Best Shopping Comparison Site">
                            <img class="logomobile" src="{{secureAssets('assets/v2/')}}/images/indiashopps_logo-final.png" alt="indiashopps"/>
                        </a>                         
                    </div>
                    <div class="col-md-9">
                        <form class="form_search" id="searchbox" action="{{$headers->url}}" method="get">
                            <div class="input-group MT8">
                                @if( isset($headers->type) && $headers->type == 'coupons' )
                                    <?php $search_class = ''; ?>
                                @else
                                    <?php $search_class = 'auto_search'; ?>
                                @endif
                                <input type="text" required name="search_text"
                                       class="form-control search-input input-width {{$search_class}}"
                                       placeholder="{{$headers->title}}" value="{{Request::get('search_text')}}">
                                <select name="cat_id" class="form-control input-width1 category_id">
                                    <option value="0">Select</option>
                                    @foreach($headers->search as $item)
                                        <option value="{{strtolower($item->name)}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-btn">
                                <button class="btn btn-default search-btn buttonsearchnew" type="submit">
                                    <i class="fa fa-search" aria-hidden="true"></i> Search
                                </button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-1 pull-right PL0 PR0"> @if(Auth::check())
                            <div class="user dropdown">
                                <a href="{{url('myaccount')}}" class="dropdown-toggle" data-toggle="dropdown">
                                    <div class="icon-user">
                                        <i class="fa fa-user-circle top-f"
                                           aria-hidden="true"></i> {{explode(" ",Auth::user()->name)[0]}}
                                    </div>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{newUrl('myaccount')}}">My Account</a>
                                    </li>
                                    <li>
                                        <a href="{{newUrl('user/logout')}}">Logout</a>
                                    </li>
                                </ul>
                            </div>
                        @else <a href="{{route('login_v2')}}">
                                <div class="icon-user">
                                    <i class="fa fa-user-circle top-f" aria-hidden="true"></i> Sign In
                                </div>
                            </a> @endif </div>
                </div>
            </div>
        </section>
    </header>
    <nav class="navbar navbar-inverse navbar-fixed" role="navigation">
        <div class="container bg-trans">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="col-xs-12 col-md-3 col-sm-4">
                <div class="pt_vegamenu categories-link">
                    <span class="cat-name pt_vmegamenu_title">
                        <span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span> <label class="onlymobile">Categories
                        <i class="fa fa-caret-down" aria-hidden="true"></i></label>
                    </span>
                    <div id="pt_vmegamenu" class="pt_vegamenu_cate" style="display: none"> {!! $cat_menu !!} </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav pt_custommenu">
                    @foreach($headers->main_menu as $item)
                        <li class="dropdown">
                            <a href="{{$item->menu_link}}" class="dropdown-toggle"
                               data-toggle="{{ (isset($item->submenu)) ? 'dropdown' : '' }}" href="#" role="button"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="{{$item->font}}" aria-hidden="true"></i> {{$item->menu_name}}

                                @if(isset($item->submenu)) <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                @foreach($item->submenu as $menu)
                                    <li>
                                        <a target="_blank" href="{{$menu->menu_link}}">{{ucwords($menu->menu_name)}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            @else </a> @endif </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
    @yield('breadcrumbs') </div>
@endif

@yield('content')

@if(@$ajax != 'true' )
    <footer class="footer">
        <div class="container">
            @yield('footer_content')
            @if( isHomePage() )
                <div class="row">
                    @if ( array_key_exists( 'footer_links', View::getSections() ) )
                        @yield('footer_links')
                    @else
                        {{--@include('v2.footer.links')--}}
                    @endif
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
        <p class="copyright">Copyright &copy; 2017 Indiashopps.com - All Rights Reserved.</p>
        <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" data-placement="left">
            <span class="fa fa-angle-double-up" style="font-size:24px;"></span>
        </a>
        @if( !isMobile() )
            <span class="socialicon">
                <a href="https://www.facebook.com/indiashopps" target="_blank" class="ifacebook icon-circle"
                   title="Facebook" rel="nofollow"><i class="fa fa-facebook"></i>
                </a>
                <a href="https://twitter.com/IndiaShopps" target="_blank" class="itwittter icon-circle"
                   title="Twitter" rel="nofollow"><i class="fa fa-twitter"></i>
                </a>
                <a href="https://plus.google.com/+Indiashopps/" target="_blank" class="igoogle icon-circle"
                   title="Google+" rel="nofollow"><i class="fa fa-google-plus"></i>
                </a>
                <a href="https://www.linkedin.com/company/indiashopps" target="_blank" class="iLinkedin icon-circle"
                   title="Linkedin" rel="nofollow"><i class="fa fa-linkedin"></i>
                </a>
            </span>
        @endif
    </footer>
    <div id="compare-now" class="compare-holder" style="display: none;">
        <a href="javascript:void(0)" id="compare-text">Compare Now (0)</a>
    </div>
    <div class="sideMenu">
        <div class="padding">
            <div class="col-md-12 col-sm-12 no-margin">
                <div class="col-md-10 col-sm-10">
                    <div id="compare-button"></div>
                    <!--<h2 class="compare-heading compare-headingright">Here is your compare list</h2>-->
                </div>
                <div class="col-md-2 col-sm-2">
                    <p><a href="#" class="closeTrigger"> <i class="fa fa-times btn-sm"></i> </a></p>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div id="compare-product-list"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12">
        <div id="compare-product-list"></div>
    </div>
    </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="exit_popup">
        <div class="modal-dialog modal-lg" role="document">
            <div class="container">
                <button type="button" class="close closebutpopupright" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <div class="popupbgcolor" id="poup_content">
                    <div class="container">
                        <div class="col-md-11">
                            <br/><br/><br/><br/>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                     aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                            </div>
                            <h3>Loading Best Offers for you..</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="web_notify" style="display: none;"></div>
    <div id="web_subscribe" class="top_hide">
        <div class="content">
            <div class="row">
                <div class="col-xs-3">
                    <div class="image">
                        <img src="{{secureAssets('assets/v2/')}}/images/indiashopps_bag.jpg"/>
                    </div>
                </div>
                <div class="col-xs-9">
                    <div class="heading">Receive updates, stay informed!</div>
                    <div class="info">We promise you will find best Deals !!</div>
                    <div class="buttons">
                        <a href="{{secureUrl(route('notify_subscribe'),true)}}" class="btn allow" id="allow_notify">ALLOW</a>
                        <a href="javascript:;" class="btn later close_web_notify">Later</a>
                    </div>
                </div>
            </div>
            <div class="close_btn close_web_notify">X</div>
        </div>
    </div>
    <link href="{{secureAssets('assets/v2/')}}/css/vegamenu.css" rel="stylesheet">
    <link href="{{secureAssets('assets/v2/')}}/css/owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="{{secureAssets('assets/v2/')}}/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{secureAssets('assets/v2/')}}/css/main.css" type="text/css"/>
    @if($is_mobile)
        <link href="{{secureAssets('assets/v2/')}}/css/responsive.css" rel="stylesheet">
    @endif
    <script>
        var base_url = '{{url("/")}}';
        var img_url = '{{url("/images")}}';
        var alvendors = JSON.parse('<?=json_encode(config("vendor")) ?>');
        var composer_url = '<?=composer_url("")?>';
        var ajax_url = '<?=url('/')?>';
        var amz_session = '{{env('AMAZON_SESSION_ID')}}';
        var templateUrl = '{{route("notify_html")}}';
        var environment = '{{env('APP_ENV')}}';
    </script>
    <link href="{{secureAssets('assets/v2/')}}/css/font-awesome.min.css" rel="stylesheet">
    <script src="{{secureAssets('assets/v2/')}}/js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="{{secureAssets('assets/v2/')}}/css/jquery-ui.css"/>
    <script type="text/javascript" src="{{secureAssets('assets/v2/')}}/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="{{secureAssets('assets/v2/')}}/js/main.js"></script>
    <script src="{{secureAssets('assets/v2/')}}/js/bootstrap.min.js"></script>
    <script src="{{secureAssets('assets/v2/')}}/js/bootstrap-select.min.js"></script>
    <script src="{{secureAssets('assets/v2/')}}/js/owl.carousel.min.js"></script>
    <script src="{{secureAssets('assets/v2/')}}/js/vegamenu.js"></script>
    <script src="{{secureAssets('assets/v2/')}}/js/compare.js"></script>
    <link rel="stylesheet" type="text/css" href="{{secureAssets('assets/v2/')}}/css/compare.css"/>
    @yield('script')
    @include('v2.common.styles')
    @include('v2.common.scripts')
    <script src="{{secureAssets('assets/v2/')}}/js/notify.js"></script>
</body>
</html>
@endif