@extends("v3.master")
@section('page_css')
    {!! file_get_contents(base_path('assets/v3/css/coupons.css')) !!}
@endsection
@section('page_content')
    <!--THE-BANNER-->
    @include('v3.coupons.sliders')
    <!--END-BANNER-->
    <div class="container">
        {{Breadcrumbs::render()}}
    </div>
    <section>
        <div class="container trendingdeals">
            <?php $coupon = collect($coupons)->first();?>
            <h1>{{$product_count}} {{ucwords($vendor_name)}} Coupons, Offers and Deals available today</h1>
            @if(app('seo')->getShortDescription() || count($coupons) > 0)
                <div class="catgprofullbox p15">
                    <div class="col-md-2">
                        @if(count($coupons) > 0)
                            <div class="couponsbrandlogo">
                                <img class="coubeandlogo" src="{{getImageNew('')}}" data-src="{{getCouponImage($coupon->_source->image_url,"L")}}" alt="brand logo">
                            </div>
                        @endif
                    </div>
                    <div class="col-md-10">
                        <div class="normelcont">{{app('seo')->getShortDescription()}}</div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <section>
        <div class="container trendingdeals">
            @if(count($coupons) > 0)
                <div class="col-md-3">
                    @include('v3.coupons.left_filter')
                </div>
                <div class="col-md-9">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        @if( isset($facets->type) )
                            <li role="presentation" class="active">
                                <a href="#Coupons" aria-controls="Coupons" role="tab" data-toggle="tab">
                                    Promotions Codes ({{$product_count}})
                                </a>
                            </li>
                        @endif
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content" id="right_container">
                        <div role="tabpanel" class="tab-pane active" id="Coupons">
                            <div id="appliedFilter"></div>
                            <div class="cou_lst_prt" id="product_wrapper">
                                @include('v3.coupons.listing_card')
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="Deals">
                            <div class="catgprofullbox" id="vendor_coupons"></div>
                        </div>
                    </div>
                    <div class="pricetablebox" id="listing_snippet_wrapper">
                        <h3>
                            {{app('seo')->couponSnippetTitle(get_defined_vars())}}
                        </h3>
                        <div class="pricetablecat" id="listing_snippet">
                            @include('v3.coupons.snippet')
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-12">
                    <h4>No coupon(s) found for {{ucwords($vendor_name)}}</h4>
                </div>
            @endif
        </div>
    </section>
    <section>
        <div class="clearbothcont">
            <div class="categorilistbox bulletpoint">
                @if(!empty($description))
                    {!! $description !!}
                @endif
            </div>
        </div>
    </section>
    <section id="coupons_wrapper">
        <div class="container trendingdeals">
            <h2>Coupons from your favourite stores</h2>
            <a class="explore-all-categori mtop" href="{{route('coupons_v2')}}">VIEW ALL Coupons
                <span class="arrow">&#155;</span>
            </a>
            <div id="coupons"></div>
        </div>
    </section>
    <section>
        <div class="container trendingdeals">
            <h2>Find Coupons for Everything</h2>
            <a class="explore-all-categori" href="#">Explore all categories
                <span class="arrow">&#155;</span></a>
            <div class="trendingdealsprobox">
                <div class="categorilistcoupons cs_dkt_si">
                    @include('v3.coupons.everything')
                </div>
            </div>
        </div>
    </section>

@endsection
@section('scripts')
    <script>
        var load_image = "<?=get_file_url('images/loader.gif')?>";
        var sort_by = "<?=@$sort?>";
        var product_wrapper = document.getElementById("product_wrapper");
        var pro_min = 0;
        var pro_max = 0;
        var target = '';
    </script>
    <script src="{{get_file_url('js')}}/front.js" defer onload="frontJsLoaded()"></script>
    <script src="{{get_file_url('js')}}/jquery.flexisel.js" defer onload="loadCarousel()"></script>
    <script src="{{get_file_url('js')}}/couponlist.js" defer onload="filterLoaded()"></script>
    <script type="text/javascript">
        function loadCarousel() {}
        function filterLoaded() {}
        function restJs() {
            setTimeout(function () {
                $(".cs_dkt_si").cssCarousel();
            }, 1000);
        }
    </script>
    <script>
        function frontJsLoaded() {
            var home_ajax_url = '{{route('v3_ajax_home')}}';
            CONTENT.uri = home_ajax_url;
            CONTENT.load('coupons', true);
        }
    </script>
    <style>
        .catgprofullbox.p15 { width: 100%; }
        .overlay_list { position: fixed; width: 100%; height: 100%; background: rgba(255, 43, 0, .4); left: 0; top: 0; z-index: 99 }
        .center { position: absolute; height: 50px; top: 50%; left: 50%; margin-left: -50px; margin-top: -25px }
        ​.overlay_list .loader { height: 20px; width: 250px }
        .overlay_list .loader--dot { animation-name: loader; animation-timing-function: ease-in-out; animation-duration: 3s; animation-iteration-count: infinite; height: 20px; width: 20px; border-radius: 100%; background-color: #000; position: absolute; border: 2px solid #fff }
        .overlay_list .loader--dot:first-child { background-color: #8cc759; animation-delay: .5s }
        .overlay_list .loader--dot:nth-child(2) { background-color: #8c6daf; animation-delay: .4s }
        .overlay_list .loader--dot:nth-child(3) { background-color: #ef5d74; animation-delay: .3s }
        .overlay_list .loader--dot:nth-child(4) { background-color: #f9a74b; animation-delay: .2s }
        .overlay_list .loader--dot:nth-child(5) { background-color: #60beeb; animation-delay: .1s }
        .overlay_list .loader--dot:nth-child(6) { background-color: #fbef5a; animation-delay: 0s }
        @keyframes loader {
            15%, 95% { transform: translateX(0) }
            45%, 65% { transform: translateX(230px) }
        }
        .single-fltr { float: left }
        .fltr-label { float: left; font-size: 16px; font-weight: 700; margin: 7px 10px 0 0 }
        .single-prop { float: left; margin: 7px 15px 0 0 }
        .single-prop:hover { float: left; margin: 7px 15px 0 0; cursor: pointer; text-decoration: line-through }
        div#appliedFilter { background: #fff; width: auto; overflow: hidden }
        div#appliedFilter.applied { padding: 10px; margin-top: 60px }
        .fltr-remove { margin-left: 5px; background: #c7003d; padding: 5px 10px; color: #fff }
        h4, .h4 { font-size: 16px; font-weight: 700; padding-top: 15px }
        .checkbox.features label { width: 100% }
    </style>
@endsection