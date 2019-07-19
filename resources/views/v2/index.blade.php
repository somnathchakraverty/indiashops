@extends('v2.master')
@section('meta')
    <link rel="canonical" href="{{Request::url()}}" />
@endsection
@if('description')
@section('meta_description')
    <meta name="description" content="{{$description}}">
    <meta name="robots" content="index, follow" />
    <meta name="author" content="Indiashopps" />
    <meta name="keywords" content="Indiashopps, shopping online India, compare buy online mobile, books online, compare electronics items online, kids items, computers and laptops, fashion online" />
@endsection
@endif
@section('breadcrumbs')
    <section style="background-color:#fff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="sub-menu">
                    <li class="goquicklytextcolor">Go Quickly to <i class="fa fa-arrow-right" aria-hidden="true"></i></li>
                        @foreach($headers->sub_menu as $item)
                            <li><a href="{{$item->menu_link}}">{{$item->menu_name}}</a></li>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('json')
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-4583846445306481",
            enable_page_level_ads: true
        });
    </script>
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "WebSite",
      "name": "Indiashopps",
      "url": "http://www.indiashopps.com/",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "http://www.indiashopps.com/search?search_text={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
    </script>
    <script type="application/ld+json">
    {
    "@context": "http://schema.org",
    "@type": "Organization",
    "url": "http://www.indiashopps.com",
    "sameAs": [
    "https://www.facebook.com/indiashopps",
    "https://plus.google.com/+indiashopps/",
    "https://www.linkedin.com/company-beta/13244853",
    "https://twitter.com/indiashopps",
    "https://www.youtube.com/channel/UC2FUadoNGd6LfZZEuhnRCAg"
    ],
    "logo": "http://www.indiashopps.com/images/v1/indiashopps_logo-final.png",
    "contactPoint": [{
        "@type": "ContactPoint",
        "telephone": "+91-124-4201798",
        "contactType": "customer service"
      }]
    }
    </script>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
             <div class="bannermobile"><img class="img-responsive" src="assets/v2/images/mobile-india-banner4.jpg" /></div>
                <div class="row carousel-holder">
                    <div class="col-md-12">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach( $home->slider as $key => $slider )
                                    <li data-target="#carousel-example-generic" data-slide-to="{{$key}}" class="{{($key==0) ? 'active' :''}}"></li>
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @foreach( $home->slider as $key => $slider )
                                    <div class="item {{($key==0) ? 'active' :''}}">
                                        <a href="{{@$slider->refer_url}}" target="_blank" {{checkLink($slider->refer_url)}}>
                                            <img class="slide-image" src="{{product_image($slider->img_url)}}" alt="{{$slider->alt}}">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>

                </div>


            </div>

        </div>

    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading title">
                        <span>Best Mobile Laptop Camera 2017</span>
                        <ul class="nav nav-tabs" id="first_tab">
                            <li class="active">
                                <a href="#btab1default" data-toggle="tab" class="active"><i
                                            class="{{$home->block1->tab_name[0]->glyphicon_symbol}}"></i>{{$home->block1->tab_name[0]->gadzet_type}}</a></li>
                            <li><a href="#btab2default" data-toggle="tab"><i
                                            class="{{$home->block1->tab_name[1]->glyphicon_symbol}}"></i>{{$home->block1->tab_name[1]->gadzet_type}}</a></li>
                            <li><a href="#btab3default" data-toggle="tab"><i
                                            class="{{$home->block1->tab_name[2]->glyphicon_symbol}}"></i>{{$home->block1->tab_name[2]->gadzet_type}}</a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">

                            <div class="tab-pane fade in active" id="btab1default">
                                @include('v2.home.block1_tab', [ 'carousel' => 1, 'tab' => $home->block1->tab1, 'name' => $home->block1->tab_name[0], 'products' => $products ])
                            </div>

                            <div class="tab-pane fade" id="btab2default">
                                @include('v2.home.block1_tab', [ 'carousel' => 2, 'tab' => $home->block1->tab2, 'name' => $home->block1->tab_name[1], 'products' => $products ])
                            </div>

                            <div class="tab-pane fade" id="btab3default">
                                @include('v2.home.block1_tab', [ 'carousel' => 3, 'tab' => $home->block1->tab3, 'name' => $home->block1->tab_name[2], 'products' => $products ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    </div>
    </div>
    </div>

    </div>
    </div>
    <div class="container">
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading title">
                <span>Smart Wearable, Memory Storage, Headphones & Headsets</span>
                <ul class="nav nav-tabs" id="second_tab">
                    <li class="active"><a href="#tab4default" data-toggle="tab"><i
                                    class="{{$home->block2->tab_name[0]->glyphicon_symbol}}"></i>{{$home->block2->tab_name[0]->gadzet_type}}</a></li>
                    <li><a href="#tab5default" data-toggle="tab"><i
                                    class="{{$home->block2->tab_name[1]->glyphicon_symbol}}"></i>{{$home->block2->tab_name[1]->gadzet_type}}</a></li>
                    <li><a href="#tab6default" data-toggle="tab"><i
                                    class="{{$home->block2->tab_name[2]->glyphicon_symbol}}"></i>{{$home->block2->tab_name[2]->gadzet_type}}</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab4default">
                        @include('v2.home.block2_tab', [ 'carousel' => 4, 'tab' => $home->block2->tab1, 'name' => $home->block2->tab_name[0], 'products' => $products ])
                    </div>

                    <div class="tab-pane fade" id="tab5default">
                        @include('v2.home.block2_tab', [ 'carousel' => 5, 'tab' => $home->block2->tab2, 'name' => $home->block2->tab_name[1], 'products' => $products ])
                    </div>

                    <div class="tab-pane fade" id="tab6default">
                        @include('v2.home.block2_tab', [ 'carousel' => 6, 'tab' => $home->block2->tab3, 'name' => $home->block2->tab_name[2], 'products' => $products ])
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading title">
                <span>Kitchen Appliances, Home Appliances & LED TV 2017</span>
                <ul class="nav nav-tabs" id="third_tab">
                    <li class="active"><a href="#tab7default" data-toggle="tab"><i
                                    class="{{$home->block3->tab_name[0]->glyphicon_symbol}}"></i>{{$home->block3->tab_name[0]->gadzet_type}}</a></li>
                    <li><a href="#tab8default" data-toggle="tab"><i
                                    class="{{$home->block3->tab_name[1]->glyphicon_symbol}}"></i>{{$home->block3->tab_name[1]->gadzet_type}}</a></li>
                    <li><a href="#tab9default" data-toggle="tab"><i
                                    class="{{$home->block3->tab_name[2]->glyphicon_symbol}}"></i>{{$home->block3->tab_name[2]->gadzet_type}}</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab7default">
                        @include('v2.home.block3_tab', [ 'carousel' => 7, 'tab' => $home->block3->tab1, 'name' => $home->block3->tab_name[0], 'products' => $products ])
                    </div>

                    <div class="tab-pane fade" id="tab8default">
                        @include('v2.home.block3_tab', [ 'carousel' => 8, 'tab' => $home->block3->tab2, 'name' => $home->block3->tab_name[1], 'products' => $products ])
                    </div>

                    <div class="tab-pane fade" id="tab9default">
                        @include('v2.home.block3_tab', [ 'carousel' => 9, 'tab' => $home->block3->tab3, 'name' => $home->block3->tab_name[2], 'products' => $products ])
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="container">
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading title">
                <span>Mens Wear, Womens Wear & Kids Wear 2017</span>
                <ul class="nav nav-tabs" id="fourth_tab">
                    <li class="active"><a href="#tab10default" data-toggle="tab"><i
                                    class="{{$home->block4->tab_name[0]->glyphicon_symbol}}"></i>{{$home->block4->tab_name[0]->gadzet_type}}</a></li>
                    <li><a href="#tab11default" data-toggle="tab"><i
                                    class="{{$home->block4->tab_name[1]->glyphicon_symbol}}"></i>{{$home->block4->tab_name[1]->gadzet_type}}</a></li>
                    <li><a href="#tab12default" data-toggle="tab"><i
                                    class="{{$home->block4->tab_name[2]->glyphicon_symbol}}"></i>{{$home->block4->tab_name[2]->gadzet_type}}</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab10default">
                        @include('v2.home.block4_tab', [ 'carousel' => 10, 'tab' => $home->block4->tab1, 'name' => $home->block4->tab_name[0], 'products' => $products ])
                    </div>

                    <div class="tab-pane fade" id="tab11default">
                        @include('v2.home.block4_tab', [ 'carousel' => 11, 'tab' => $home->block4->tab2, 'name' => $home->block4->tab_name[1], 'products' => $products ])
                    </div>

                    <div class="tab-pane fade" id="tab12default">
                        @include('v2.home.block4_tab', [ 'carousel' => 12, 'tab' => $home->block4->tab3, 'name' => $home->block4->tab_name[2], 'products' => $products ])
                    </div>
                </div>
            </div>
        </div>


    </div>

  @if(isset($blogs))
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <span>Top Blogs</span>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 PR0">
                <div id="blog" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        @foreach($blogs as $key => $blog)
                            <li data-target="#blog" data-slide-to="{{$key}}" class="active"></li>
                        @endforeach
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        @foreach($blogs as $key => $blog)
                            <?php
                                $re = '/upload\/(.*)\//';
                                $replacement = 'upload/w_570,h_492,c_scale,q_auto,f_auto/';
                                $image = preg_replace($re, $replacement, ltrim($blog->path,"."));
                                $image = str_replace('http', 'https', $image);
                            ?>
                            <div class="item {{($key==0) ? 'active' : ''}}">
                             <a href="{{url('blog/'.$blog->post_name)}}">
                                <img style="height:492px;" class="blogobigim" src="{{$image}}" alt="{{$blog->post_title}}">
                             </a>
                                <div class="carousel-caption custom-caption">
                                    <a href="{{url('blog/'.$blog->post_name)}}">
                                        <h3>{{$blog->post_title}}</h3>
                                    </a>
                                    <p>{!! $blog->post_content !!}</p>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>


            </div>
            <div class="col-md-6 PL0">
                <ul class="blog">
                    @foreach($blogs as $key => $blog)
                        <?php
                            $re = '/upload\/(.*)\//';
                            $replacement = 'upload/w_570,h_492,c_scale,q_auto,f_auto/';
                            $image = preg_replace($re, $replacement, ltrim($blog->path,"."));
                            $image = str_replace('http', 'https', $image);
                        ?>
                        <li>
                         <a href="{{url('blog/'.$blog->post_name)}}">
                            <div class="thumbnail custom-thumbnail">
                                <img alt="{{$blog->post_title}}" style="width:137px; height:120px;" src='{{$image}}'>
                            </div>
                         </a>
                            <aside>
                               <a href="{{url('blog/'.$blog->post_name)}}">
                                    <h4>{{$blog->post_title}}</h4>
                                </a>
                                <p>{!! $blog->post_content !!}</p>
                            </aside>

                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
  @endif
@endsection
@section('footer_content')
    @include('v2.footer.description')
@endsection
@section('script')
    <script>
        var isExitPopupPage = true;
        var page = 'home_page';

        $(document).ready(function() {
            var index = [1,2,3,4,5,6,7,8,9,10,11,12];
            $.each(index,function(i,id){
                    var owl1 = $("#owl-demo"+id);

                    owl1.owlCarousel({
                        items: 4,
                        itemsDesktop: [1000, 5],
                        itemsDesktopSmall: [900, 3],
                        itemsTablet: [600, 2],
                        itemsMobile: false
                    });
                    $("#owl-demo"+id).parent().find(".customNavigation .next").click(function() {
                        console.log(owl1);
                        owl1.trigger('owl.next');
                    });
                    $("#owl-demo"+id).parent().find(".customNavigation .prev").click(function() {
                        owl1.trigger('owl.prev');
                    });
                });

            var ids = ['first', 'second', 'third', 'fourth'];

            automateTabs(ids);
            });

    function automateTabs( ids )
    {
        var active_tab = 1, el = '';
        setInterval(function(){
            active_tab++;
            if( active_tab > 3 )
            {
                active_tab = 1;
            }

            $.each(ids,function(i,cls){
                el = "#"+cls+"_tab li:eq("+(active_tab-1)+") a";

                $(el).tab( "show" );
            });
        },10000);
    }
    </script>
@endsection