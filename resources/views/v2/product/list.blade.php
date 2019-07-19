@if(!isset($ajax))
@extends('v2.master')
    @section('breadcrumbs')
        <section style="background-color:#fff;">
            <div class="container">
                {!! Breadcrumbs::render() !!}
                @if( isset($total_products) && !empty($total_products) && is_numeric($total_products) && $page > 0 )
                <span>
                    <strong><em>Showing {{(($page-1)*30)+1}} - {{(($page-1)*30)+count($product)}} of {{$total_products}} </em> results</strong>
                </span>
                @endif
            </div>
        </section>
    @endsection
    @section('meta')
        @if(isset($canonical) && !empty($canonical))
            <link rel="canonical" href="{{$canonical}}" />
        @else
            {!! canonical_url_list() !!}
        @endif

        @if( $book )
            <link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--c--<?=$scat?>--576" />
        @else
            <link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--c--<?=$scat?>" />
        @endif
    @endsection
    @if(isset($meta_data) && !empty($meta_data['keywords']))
        @section('keywords')
            <meta name="keywords" content="<?=$meta_data['keywords']?>">
        @endsection
    @endif
    @if(isset($keywords) && !empty($keywords))
        @section('keywords')
            <meta name="keywords" content="<?=$keywords?>">
        @endsection
    @endif

    @if(isset($description))
        @section('meta_description')
            <meta name="description" content="{{$description}}" /> <!-- Description from controller -->
        @endsection
    @endif
@section('content')
    <?php $route = (Request::route()) ? Request::route()->getName() : ''; ?>
    <div class="container MT15">
        <!---THE-LEFT-PART- -->
        <div class="col-md-3">
            @include('v2.product.common.left_filter', ['aggr' => $facets ])
        </div>
        <!---END-LEFT-PART--->
        <!---THE-RIGHT-PART--->
        <div class="col-md-9">
            @if($isSearch && empty($category_id) && $route == 'search' )
                <?php $showModal = true; ?>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Please select Category to find product you looking for !</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="searchboxbutton">
                                    <div class="buttonlistsearch">
                                        <ul>
                                            @foreach( $facets->grp->buckets as $key => $c )
                                                @foreach( $c->category_id->buckets as $k => $ct )
                                                    <?php $url = route('search_new',[create_slug($ct->category->buckets[0]->key),create_slug($query),'']); ?>
                                                <li><a href="{{$url}}" class="selectbutton">
                                                        {{urldecode($query)}} (in <em>{{ucwords($c->key).", ".ucwords($ct->category->buckets[0]->key)}})</em>
                                                    </a>
                                                </li>
                                                <?php
                                                if( $k >= 3 )
                                                    break;
                                                ?>
                                                @endforeach
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($text))
                <?php $desc_text = $text; ?>
            @elseif(isset($list_desc) && isset($list_desc->text))
                <?php $desc_text = str_replace("{{cat}}",strtolower($c_name),$list_desc->text); ?>
            @elseif(isset($meta_data['meta']))
                <?php $desc_text = str_replace("{{cat}}",strtolower($c_name),$meta_data['meta']); ?>
            @endif

            @include('v2.product.common.list_desc', ['c_name' => $c_name] )
            <div class="row" id="slide-banner">
                <div class="">
                    <div class="btn-group">
                        <a href="#" id="grid" class="btn btn-sm {{(!isset($_COOKIE['product-list-style']) || $_COOKIE['product-list-style'] != 'list' ) ? 'active' : ''}}">
                            <span class="glyphicon glyphicon-th"></span>Grid</a>
                        <a href="#" id="list" class="btn btn-sm {{(isset($_COOKIE['product-list-style']) && $_COOKIE['product-list-style'] == 'list' ) ? 'active' : ''}}">
                            <span class="glyphicon glyphicon-th-list"></span>List</a>
                    </div>
                </div>
                @if(isset($slider) && is_object($slider))
                    <div class="product-listingbanner">
                        @if( isset($slider->refer_url) && !empty($slider->refer_url) )
                            <a href="{{$slider->refer_url}}" alt="{{$slider->alt}}">
                                <img class="img-responsive" src="{{$slider->image_url}}">
                            </a>
                        @else
                            <img class="img-responsive" src="{{$slider->image_url}}">
                        @endif
                    </div>
                @endif
                <div id="appliedFilter"></div>
                <div id="product_wrapper">
                    <div id="products" class="row list-group">
@endif
                        @include('v2.product.single', [ 'products' => $product, 'book' => @$book, 'isMobile' => $isMobile ])
                        <div class="col-md-12">
                            @include('v2.product.common.pagination',[ 'pagination' => $markup ])
                        </div>
@if(!isset($ajax))
                    </div>
                    @include('v2.product.common.snippet')
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        @if(isset($page) && $page == 1 )
            <?php $has_text = false; ?>
            <div style="text-align: justify">
                @if( isset($desc_text) )
                    {!! $desc_text !!}
                @endif
            </div>
        @endif
        <div class="mobilefilterpart">
        <filter class="filter-down">
            <a href="javascript:void" class="filterbut" id="applyfilter-toggle"><i class="fa fa-filter" aria-hidden="true"></i> Filter</a>
           
        </filter>
</div>

    </div>
@endsection
@section('script')
    <script>
        var load_image = "<?=newUrl('images/v1/loading.gif')?>";
        var sort_by = "<?=@$sort?>";
        var product_wrapper = $( "#product_wrapper" );
        var pro_min = {{($minPrice)? $minPrice: 0}};
        var pro_max = {{($maxPrice)? $maxPrice: 0}};
        var target = '{{($target)? $target : ''}}';
        var isMobile = {{(isMobile()) ? 'true' : 'false'}};
        $( document ).ready(function(){
            $(document).on("mouseenter",".product-items",function(){
                $(this).addClass("hovered");
            });
            $(document).on("mouseleave",".product-items",function(){
                $(this).removeClass("hovered");
            });

            @if(isset($showModal))
                $("#myModal").modal('show');
            @endif
        });
        $(document).ready(function () {
            $('#list').click(function (event) {
                event.preventDefault();
                $('#grid').removeClass('active');
                $(this).addClass('active');
                $('#products .item').addClass('list-group-item');
                $('#products .item').removeClass('grid-group-item');
                $('#products').hide().fadeIn();

                setCookie('product-list-style',"list",100);
            });
            $('#grid').click(function (event) {
                event.preventDefault();
                $('#list').removeClass('active');
                $(this).addClass('active');
                $('#products .item').removeClass('list-group-item');
                $('#products .item').addClass('grid-group-item');
                $('#products').hide().fadeIn();

                setCookie('product-list-style',"grid",100);
            });

            $('#product-left-fixed-menu li.active').addClass('open').children('ul').show();
            $('#product-left-fixed-menu li.has-sub>a').on('click', function() {
                $(this).removeAttr('href');
                var a = $(this).parent('li');
                if (a.hasClass('open')) {
                    a.removeClass('open');
                    a.find('li').removeClass('open');
                    a.find('ul').slideUp(200,function(){ $(window).resize(); });
                } else {
                    a.addClass('open');
                    a.children('ul').slideDown(200,function(){ $(window).resize(); });
                }
            });
        });
    </script>
    <script src="{{asset('assets/v2/')}}/js/bootstrap-select.min.js"></script>
    <script src="{{asset('assets/v2/')}}/js/owl.carousel.min.js"></script>
    <script src="{{asset('assets/v2/')}}/js/jquery.nanoscroller.js"></script>
    <script src="{{asset('assets/v2/')}}/js/productlist.js"></script>
    <script>
        $(document).ready(function () {
            function toggleChevron(e) {
                $(e.target)
                    .prev('.panel-heading')
                    .find("i.indicator")
                    .toggleClass('fa-toggle-on');
            }

            $('#accordion').on('hidden.bs.collapse', toggleChevron);
            $('#accordion').on('shown.bs.collapse', toggleChevron);

            $(".nano").nanoScroller({ alwaysVisible: true });
            $(".nano1").nanoScroller({ alwaysVisible: true,paneClass: 'scrollPane'});

            $('[data-toggle="tooltip"]').tooltip();

            $(document).on('click','#toggle-btn',function(){
                if($('.more-less-toggle').hasClass('show'))
                {
                    $('.more-less-toggle').removeClass('show');
                    $(this).html("Show More");
                }
                else
                {
                    $('.more-less-toggle').addClass('show');
                    $(this).html("Show Less");
                }
            });
        });
    </script>
    <script>
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('filter').outerHeight();
    $(window).scroll(function(event){
        didScroll = true;
    });
    setInterval(function() {
        if (didScroll){hasScrolled();didScroll = false;}
    }, 250);
    function hasScrolled() {
        var st = $(this).scrollTop();
        if(Math.abs(lastScrollTop - st) <= delta)
            return;
        if (st > lastScrollTop && st > navbarHeight){
            $('filter').removeClass('filter-down').addClass('filter-up');
        } else {
            if(st + $(window).height() < $(document).height()) {
                $('filter').removeClass('filter-up').addClass('filter-down');
            }
        }
        lastScrollTop = st;
    }
</script>
<script> 
    $("#filter-close").click(function(e) {
    e.preventDefault();
    $("#applyfilter").toggleClass("active");
  });
  $("#applyfilter-toggle").click(function(e) {
    e.preventDefault();
    $("#applyfilter").toggleClass("active");
  });  
  </script>
    <style type="text/css">
        #product-left-fixed-menu {width:95%;height:100%;overflow:hidden;}
        #product-left-fixed-menu > ul > li > ul {max-height:215px;overflow:hidden;}
        .ui-slider-handle.ui-state-default {position:absolute!important;background:#D70D00!important;}
        .col-md-11 {padding-right:0px;}
        .checkbox+.checkbox, .radio+.radio {margin-top:0px;}
    </style>
@endsection
@endif