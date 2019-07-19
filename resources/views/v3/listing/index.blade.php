<?php $products = collect($product)->chunk(16); ?>
<?php $snippet = collect($product)->chunk(10)->first();?>
<?php

$prod = new \stdClass;
$prod->c_name = (isset($c_name)) ? $c_name : null;
$prod->brand = (isset($brand)) ? $brand : null;
$prod->title = (isset($title)) ? $title : null;
$prod->parent = (isset($parent)) ? $parent : null;
$prod->child = (isset($child)) ? $child : null;
$prod->h1 = (isset($h1)) ? $h1 : null;
$prod->cat = (isset($scat)) ? $scat : null;
$prod = Crypt::encrypt(($prod));
?>
@extends('v3.master')
@section('head')
    {!! $rel_next_prev !!}
    @if(isset($page) && $page > 1 || $isSearch )
        <meta name="ROBOTS" content="noindex, nofollow">
    @else
        <meta name="robots" content="index, follow"/>
        <meta name="author" content="IndiaShopps"/>
    @endif
    {!! ampListingCanonical() !!}
    <link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--c--{{$scat}}" />
@endsection
@section('page_content')
   
    <!--BREADCRUMB-->
    <div class="container">
        {!! Breadcrumbs::render() !!}
    </div>
    <!--BREADCRUMB-->
    <section>
        <div class="container" id="right_container">
            <div class="col-md-6 pleft">
                <h1>{!! app('seo')->getHeading() !!}</h1>
            </div>
            <div class="col-md-6 pright">
                {{--SORTING OPTION--}}
                <div class="cattab" id="sorting_options">
                    <ul class="nav nav-tabs catgnav-tabs" role="tablist">
                        <li class="sort">Sort by</li>
                        <li role="presentation" class="active">
                            <a href="#newest-first" aria-controls="product_wrapper" role="tab" data-toggle="tab" aria-expanded="false" class="fltr__src" data-field="sort" data-value="">Newest
                                First</a>
                        </li>
                        <li role="presentation" class="">
                            <a href="#price-high" aria-controls="product_wrapper" role="tab" data-toggle="tab" aria-expanded="false" class="fltr__src" data-field="sort" data-value="p-d">Price
                                High to Low</a>
                        </li>
                        <li role="presentation" class="">
                            <a href="#price-low" aria-controls="product_wrapper" role="tab" data-toggle="tab" aria-expanded="false" class="fltr__src" data-field="sort" data-value="p-a">
                                Price low to high
                            </a>
                        </li>
                    </ul>
                </div>
                {{--SORTING OPTION--}}
            </div>
            {{--SHORT DESCRIPTION--}}
            <div class="normelcont bulletpoint">
                {!! app('seo')->getShortDescription() !!}
            </div>
            {{--SHORT DESCRIPTION--}}
            <div class="filterpositiontop">
                <?php $first_products = $products->shift();?>
                @php
                    if(isset($first_products) && !is_null($first_products))
                    {
                        $cols = 9;
                    }
                    else
                    {
                        $cols = 12;
                    }
                @endphp
                <div class="col-md-{{$cols}} pright filterpositionright">
                    <!-- Tab panes -->
                    <div class="catproductlistright">
                        @if(($isSearch) && isset($search_id))
                            @if(isset($first_products) && !is_null($first_products))
                                <div class="searyno">
                                    <span id="search_feedback">Did you find what you were looking for ?
                                        <a href="javascript:void(0)" class="yes" onclick="searchFeedback(1)">Yes</a>
                                        <a href="javascript:void(0)" class="yes" onclick="searchFeedback(0)">No</a>
                                    </span>
                                </div>
                            @endif
                        @endif
                        <div id="appliedFilter"></div>
                        <div id="product_wrapper">
                            @if(isset($first_products) && !is_null($first_products))
                                <h2>{{processListingHeading(get_defined_vars())}}</h2>
                            @endif

                            <div class="catgprofullbox">
                                @if(isset($first_products) && !is_null($first_products))
                                    @foreach($first_products as $product)
                                        @include('v3.common.product.card2', [ 'product' => $product->_source ])
                                    @endforeach
                                @else
                                    <div class='no-products col-md-12' style='min-height:120px'>
                                        <h3>
                                            @if($isSearch)
                                                Currently, the "{{$search_text}}" is not available.
                                            @else
                                                Currently, the {{ucwords($brand)}} {{ucwords($c_name)}} is not
                                                available.
                                                Thanks for your endurance.
                                            @endif
                                        </h3>
                                    </div>
                                @endif
                            </div>

                            <div class="comparison">
                                @if(!($isSearch) && isset($child_categories) && $child_categories instanceof \Illuminate\Support\Collection && $child_categories->count() > 0)
                                    {{--BRAND FILTERS--}}
                                    <h3>Explore More Categories</h3>
                                    <div class="brandlogobox">
                                        <div class="cs_brd_si">
                                            <ul data-items="4">
                                                @foreach($child_categories as $category )
                                                    <li>
                                                        <a class="thumlist" href="{{getCategoryUrl($category)}}" target="_blank">
                                                            <div class="rammobilebox">{{strtoupper($category->name)}}</div>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="comparison">
                                @if(isset($custom_pages) && count($custom_pages) > 0)
                                    {{--BRAND FILTERS--}}
                                    @if(isset($c_name))
                                        <h3>{{$c_name}} under your Budget</h3>
                                    @endif
                                    <div class="brandlogobox">
                                        <div class="cs_brd_si">
                                            <ul data-items="4">
                                                @foreach($custom_pages as $custom_page )
                                                    <li>
                                                        <a class="thumlist" href="{{$custom_page->getUrl()}}" target="_blank">
                                                            <div class="rammobilebox">{{unslug($custom_page->slug)}}</div>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <?php
                            $pfilters = clone $facets;
                            $remove = [
                                    'price_ranges',
                                    'saleprice_min',
                                    'grp',
                                    'saleprice_max',
                                    'filters_all',
                                    'vendor'
                            ];

                            foreach ($remove as $attr) {
                                if (isset($pfilters->{$attr})) {
                                    unset($pfilters->{$attr});
                                }
                            }

                            foreach ($pfilters as $key => $value) {
                                if (!is_object($value) || $key != 'brand') {
                                    unset($pfilters->{$key});
                                }
                            }

                            $filters = collect($pfilters)->first();
                            $filter = collect($pfilters)->keys()->first();
                            ?>
                            <div class="comparison">
                                <?php $category = \indiashopps\Category::find($scat); ?>
                                @if( \indiashopps\Category::hasThirdLevel($category) && isset($filters->buckets) && !empty($filters->buckets) && count($filters->buckets) > 2 )
                                    {{--BRAND FILTERS--}}
                                    <h3>Choose your {{unslug($filter)}}</h3>
                                    @if( $filter == 'brand' && array_key_exists(strtolower($category->name),config('all_brands')) )
                                        <?php $brands_page = route('category_all_brands', [
                                                cs($category->group_name),
                                                cs($category->name)
                                        ]) ?>
                                        <a class="expcat" href="{{$brands_page}}">
                                            VIEW ALL {{config('all_brands.'.strtolower($category->name).'.text')}}
                                            Brands<span class="arrow">&rsaquo;</span>
                                        </a>
                                    @endif
                                    <div class="brandlogobox">
                                        <div class="cs_brd_si">
                                            <ul data-items="4">
                                                @if( $filter == 'brand' && array_key_exists(strtolower($category->name),config('all_brands')) )
                                                    @foreach(config('all_brands.'.strtolower($category->name).'.brands') as $brand )
                                                        <li>
                                                            <a class="thumlist" href="{{brandProductList($brand,$category)}}" target="_blank">
                                                                <div class="rammobilebox">{{strtoupper($brand)}}</div>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                    <?php unset($brand); ?>
                                                @else
                                                    @foreach($filters->buckets as $attr )
                                                        @if(!empty($attr->key) && $attr->doc_count >= 5)
                                                            <li>
                                                                @if( $filter == 'brand' )
                                                                    <a class="thumlist" href="{{brandProductList($attr->key,$category)}}" target="_blank">
                                                                        <div class="rammobilebox">{{strtoupper($attr->key)}}</div>
                                                                    </a>
                                                                @else
                                                                    <a class="thumlist" href="{{getCategoryUrl($category)}}#{{$filter}}={{rawurlencode($attr->key)}}" target="_blank">
                                                                        <div class="rammobilebox">{{strtoupper($attr->key)}}</div>
                                                                    </a>
                                                                @endif
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            {{--BRAND FILTERS--}}

                            {{--PRODUCT LIST AFTER BRAND FILTER--}}
                            <div class="col-md-4 pright">
                                &nbsp;
                            </div>
                            <div class="catgprofullbox">
                                <?php $prods = $products->shift();?>
                                @if(isset($prods) && !is_null($prods))
                                    @foreach($prods as $product)
                                        @include('v3.common.product.card2', [ 'product' => $product->_source ])
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        @if(isset($prods) && !is_null($prods))
                            <div class="showingitems" id="load_more_wrapper">
                                Showing <span id="product_range_count">1 - 32</span> out of
                                <span id="total_products_load">{{$total_products}}</span> items
                                <a href="javascript:void(0)" class="load-more" id="load-more">Load More</a>
                            </div>
                        @endif

                        @if(isset($first_products) && !is_null($first_products) && !$isSearch)
                            <div class="pricetablebox" id="listing_snippet_wrapper">
                                <h3>
                                    {{app('seo')->listSnippetTitle(get_defined_vars())}}
                                </h3>
                                <div class="pricetablecat" id="listing_snippet">
                                    @include('v3.listing.ajax.snippet')
                                </div>
                            </div>
                        @endif
                        @section('below_content')
                    </div>
                </div>
                {{--LEFT FILTER--}}
                <div class="col-md-3 pleft filterpositionleft">
                    @if(isset($first_products) && !is_null($first_products))
                        @include('v3.listing.left_filter')
                    @endif
                </div>
                {{--LEFT FILTER--}}
            </div>
        </div>
    </section>
    <!--THE-PART-14-->
@endsection

<!--THE-PART-14-->
@endsection
@section('scripts')
    <script>
        var load_image = "<?=get_file_url('images/loader.gif')?>";
        var sort_by = "<?=@$sort?>";
        var product_wrapper = document.getElementById("product_wrapper");
        var pro_min = {{($minPrice)? $minPrice: 0}};
        var pro_max = {{($maxPrice)? $maxPrice: 0}};
        var target = '{{($target)? $target : ''}}';

        function loadCarousel() {}

        function bootstrapLoaded() {
            $('#slide-banner').on('slide.bs.carousel', function () {
                $(this).find(".active img").lazyLoadXT();
            });
        }

        @if($isSearch)
        @if(isset($search_id))
        function searchFeedback($isGood) {
            var search_url = '{{route('search-feedback', [$search_id,5])}}';

            search_url = search_url.replace('/5', "/" + $isGood);
            $('#search_feedback').html("Thank you for your feedback..!!");
            setTimeout(function () {
                $(".searyno").fadeOut();
            }, 2000);

            if ($isGood == 0) {
                $.get(search_url);
            }
        }
        @endif
        @endif
    </script>
    <script>
        function loadRestJS() {
            frontJsLoaded();
        }

        function frontJsLoaded() {
            var interval = setInterval(function () {
                if (typeof $ != "undefined") {
                    var didScroll;
                    var lastScrollTop = 0;
                    var delta = 5;
                    var navbarHeight = $('filter').outerHeight();
                    $(window).scroll(function (event) {
                        didScroll = true;
                    });
                    setInterval(function () {
                        if (didScroll) {
                            hasScrolled();
                            didScroll = false;
                        }
                    }, 250);
                    function hasScrolled() {
                        var st = $(this).scrollTop();
                        if (Math.abs(lastScrollTop - st) <= delta)
                            return;
                        if (st > lastScrollTop && st > navbarHeight) {
                            $('filter').removeClass('filter-down').addClass('filter-up');
                        } else {
                            if (st + $(window).height() < $(document).height()) {
                                $('filter').removeClass('filter-up').addClass('filter-down');
                            }
                        }
                        lastScrollTop = st;
                    }

                    clearInterval(interval);
                }
            }, 500);
        }
    </script>
    <style>
        .overlay_list { position: fixed; width: 100%; height: 100%; background: rgba(255, 43, 0, .4); left: 0; top: 0; z-index: 999; }
        .center { position: absolute; height: 50px; top: 50%; left: 50%; margin-left: -50px; margin-top: -25px }
        ​.overlay_list .loader { height: 20px; width: 250px }
        .overlay_list .loader--dot { animation-name: loader; animation-timing-function: ease-in-out; animation-duration: 3s; animation-iteration-count: infinite; height: 20px; width: 20px; border-radius: 100%; background-color: #000; position: absolute; border: 2px solid #fff }
        .overlay_list .loader--dot:first-child { background-color: #8cc759; animation-delay: .5s }
        .overlay_list .loader--dot:nth-child(2) { background-color: #8c6daf; animation-delay: .4s }
        .overlay_list .loader--dot:nth-child(3) { background-color: #ef5d74; animation-delay: .3s }
        .overlay_list .loader--dot:nth-child(4) { background-color: #f9a74b; animation-delay: .2s }
        .overlay_list .loader--dot:nth-child(5) { background-color: #60beeb; animation-delay: .1s }
        .overlay_list .loader--dot:nth-child(6) { background-color: #fbef5a; animation-delay: 0 }
        @keyframes loader {
            15%, 95% { transform: translateX(0) }
            45%, 65% { transform: translateX(230px) }
        }
        .single-fltr { float: left; border: 1px solid #dadada; margin: 0 5px; border-radius: 4px; padding: 0 5px 5px; overflow: hidden }
        .fltr-label { float: left; font-size: 13px; font-weight: 700; margin: 6px 5px 0 0 }
        .single-prop { float: left; margin: 3px 1px 0 0 }
        .single-prop:hover { float: left; margin: 3px 1px 0 0; cursor: pointer; text-decoration: line-through }
        div#appliedFilter { background: #fff; width: auto; overflow: hidden; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); border-radius: 5px !important; }
        div#appliedFilter.applied { padding: 10px; margin-top: 70px }
        .fltr-remove { margin-left: 5px; background: #9e9e9e; padding: 2px 7px; color: #fff; border-radius: 50% !important; font-size: 14px !important; }
        h4, .h4 { font-size: 16px; font-weight: 700; padding-top: 15px }
        .checkbox.features label { width: 100% }
    </style>
@endsection