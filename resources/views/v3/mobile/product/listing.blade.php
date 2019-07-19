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
@extends("v3.mobile.master")
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
    <?php $first_products = $products->shift();?>
    {{--@if(!is_null($sliders))--}}
        {{--<div class="banner">--}}
            {{--@if(isset($sliders->refer_url) && filter_var($sliders->refer_url,FILTER_VALIDATE_URL))--}}
                {{--<a href="{{$sliders->refer_url}}" target="_blank">--}}
                    {{--<img class="img-responsive" src="{{$sliders->image_url}}" alt="{{$sliders->alt}}">--}}
                {{--</a>--}}
            {{--@else--}}
                {{--<img class="img-responsive" src="{{$sliders->image_url}}" alt="{{$sliders->alt}}">--}}
            {{--@endif--}}
        {{--</div>--}}
    {{--@endif--}}
    <section>
        <div class="container">
            {!! Breadcrumbs::render() !!}
        </div>
    </section>
    <section>
        <div class="container more_content_wrapper">
            <h1>{{app('seo')->getHeading()}}</h1>
            @if(app('seo')->getShortDescription())
                <div class="more-less-product1 medium">
                    {!! app('seo')->getShortDescription() !!}
                </div>
                <a href="javascript:void(0)" class="moreproduct">Read More <span>&rsaquo;</span></a>
                <div class="line"></div>
            @endif
        </div>
    </section>
    <div id="appliedFilter"></div>
    <section id="product_wrapper">
        <div class="whitecolorbg">
            @if($isSearch)
                @if(isset($first_products) && !is_null($first_products))
                    <div class="searyno">
                            <span id="search_feedback">Did you find what you were looking for ?
                                <a href="javascript:void(0)" class="yes" onclick="searchFeedback(1)">Yes</a>
                                <a href="javascript:void(0)" class="yes" onclick="searchFeedback(0)">No</a>
                            </span>
                    </div>
                @endif
            @endif
            <div class="container">
                @if(isset($first_products) && !is_null($first_products))
                    <h2>{{processListingHeading(get_defined_vars())}}</h2>
                @endif
                <div class="mobilecard2">
                    <ul>
                        @if(isset($first_products) && !is_null($first_products))
                            @foreach($first_products as $product)
                                <li>
                                    @include('v3.mobile.product.card2')
                                </li>
                            @endforeach
                        @else
                            <div class='no-products col-md-12' style='min-height:80px'>
                                <h3>Sorry !!! No products found.. </h3>
                            </div>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        @if(!($isSearch) && isset($child_categories) && $child_categories instanceof \Illuminate\Support\Collection && $child_categories->count() > 0)

            <?php
            $filter = collect($facets)->keys()->first()
            ?>
            <div class="whitecolorbg">
                <div class="container">
                    <h3>Explore More Categories</h3>
                    <div class="product-tabs tabsbornone css-carouseltab padding-btm0">
                        <ul class="tabs tabbrandname" id="brands_slide">
                            @foreach($child_categories as $category )
                                <li class="tab">
                                    <a class="active" href="{{getCategoryUrl($category)}}" target="_blank">
                                        {{strtoupper($category->name)}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        @endif
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
        <?php $Category = \indiashopps\Category::find($category_id);?>
        @if(isset($scat) && !empty($scat) && \indiashopps\Category::hasThirdLevel($Category) && isset($filters->buckets) && !empty($filters->buckets) && count($filters->buckets) > 2 )
            <div class="whitecolorbg">
                <div class="container">
                    <h3>Choose your {{unslug($filter)}}</h3>
                    <div class="product-tabs tabsbornone css-carouseltab padding-btm0">
                        <ul class="tabs tabbrandname" id="brands_slide">
                            @if( $filter == 'brand' && array_key_exists(strtolower($Category->name),config('all_brands')) )
                                @foreach(config('all_brands.'.strtolower($Category->name).'.brands') as $brand )
                                    <li class="tab">
                                        <a href="{{brandProductList($brand,$Category)}}" target="_blank">
                                            {{strtoupper($brand)}}
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                @foreach($filters->buckets as $attr )
                                    @if(!empty($attr->key) && $attr->doc_count >= 5)
                                        <li class="tab">
                                            @if( $filter == 'brand' )
                                                <a href="{{brandProductList($attr->key,$Category)}}" target="_blank">
                                                    {!! strtoupper($attr->key) !!}
                                                </a>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    @if( array_key_exists(strtolower($Category->name),config('all_brands')) )
                        <?php $brands_page = route('category_all_brands', [
                                cs($Category->group_name),
                                cs($Category->name)
                        ]) ?>
                        <a class="allcateglink" href="{{$brands_page}}">
                            VIEW ALL {{config('all_brands.'.strtolower($Category->name).'.text')}} Brands
                            <span class="right-arrow"></span>
                        </a>
                    @endif
                </div>
            </div>
        @endif
        <?php $prods = $products->shift(); ?>
        @if(isset($prods) && !is_null($prods))

            <div class="whitecolorbg">
                <div class="container">
                    <div class="mobilecard2">
                        <ul>
                            @foreach($prods as $product)
                                <li>
                                    @include('v3.mobile.product.card2')
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        @endif
    </section>
    @if(isset($first_products) && !is_null($first_products))
        <div id="load-more-wrapper">
            <a href="#" id="load-more" class="productbutton orangebutton" id="toggle-btndetails2">View More</a>
        </div>
        <section id="listing_snippet_wrapper">
            <div class="whitecolorbg">
                <div class="container">
                    <h3>{{app('seo')->listSnippetTitle(get_defined_vars())}}</h3>
                    @include('v3.listing.ajax.snippet')
                </div>
            </div>
        </section>
    @endif

    @if(isset($first_products) && !is_null($first_products))
        @include('v3.mobile.product.filters')
    @endif
@endsection
@section('scripts')
    <script>
        document.addEventListener('jquery_loaded', function (e) {
            var product_wrapper = $("#product_wrapper");
            var topnavbarHeight = $('header').outerHeight();
            var bottomnavbarHeight = $('tabloans').outerHeight();
            hasScrolled();
            $(window).scroll(function (event) {
                didScroll = true;
            });
            setInterval(function () {
                if (didScroll) {
                    hasScrolled();
                    didScroll = false;
                }
            }, 250);

            $("#applyfilter-toggle").on('click', function (e) {
                e.preventDefault();
                $("#applyfilter").toggleClass("active");
            });

            $("#filter-close").on('click', function (e) {
                e.preventDefault();
                $("#applyfilter").toggleClass("active");
            });

            if (location.search.indexOf('filter=open') > -1) {
                $("#applyfilter").toggleClass("active");
                history.pushState(null, "", location.href.split("?")[0]);
            }

            function hasScrolled() {
                var st = $(this).scrollTop();

                if (st + bottomnavbarHeight < topnavbarHeight) {
                    $('tabloans').removeClass('show_filter').addClass('hide_filter');
                }
                else if (st > lastScrollTop) {
                    $('tabloans').removeClass('show_filter').addClass('hide_filter');
                } else {
                    if (st + $(window).height() < $(document).height()) {
                        $('tabloans').removeClass('hide_filter').addClass('show_filter');
                    }
                }
                lastScrollTop = st;
            }

            $(document).ready(function () {
                $("#openModal").show();
            });

            $(document).on('click', '#brands_slide li a', function () {
                if ($(this).attr('href').indexOf("#") == -1 && $(this).attr('href').length > 0)
                    window.location.href = $(this).attr('href');
            });
        });

        @if($isSearch)
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
    </script>
    <script>
        var load_image = "<?=get_file_url('images/image_loading.gif')?>";
        var sort_by = "<?=@$sort?>";
        var pro_min = {{($minPrice)? $minPrice: 0}};
        var pro_max = {{($maxPrice)? $maxPrice: 0}};
        var target = '{{($target)? $target : ''}}';
        var didScroll;
        var lastScrollTop = 0;
        var delta = 5;
        var topnavbarHeight = 0;
        var bottomnavbarHeight = 0;
    </script>
    <style>
        .overlay_list{position:fixed;width:100%;height:100%;background:rgba(255,43,0,.4);left:0;top:0;z-index:99}
		.center{position:absolute;height:50px;top:50%;left:29%;margin-left:-50px;margin-top:-25px}
		​.overlay_list .loader{height:20px;width:250px}
		.overlay_list .loader--dot{animation-name:loader;animation-timing-function:ease-in-out;animation-duration:3s;animation-iteration-count:infinite;height:12px;width:12px;border-radius:100%;background-color:#000;position:absolute;border:2px solid #fff}
		.overlay_list .loader--dot:first-child{background-color:#8cc759;animation-delay:.5s}
		.overlay_list .loader--dot:nth-child(2){background-color:#8c6daf;animation-delay:.4s}
		.overlay_list .loader--dot:nth-child(3){background-color:#ef5d74;animation-delay:.3s}
		.overlay_list .loader--dot:nth-child(4){background-color:#f9a74b;animation-delay:.2s}
		.overlay_list .loader--dot:nth-child(5){background-color:#60beeb;animation-delay:.1s}
		.overlay_list .loader--dot:nth-child(6){background-color:#fbef5a;animation-delay:0}
		@keyframes loader {
		15%,95%{transform:translateX(0)}
		45%,65%{transform:translateX(230px)}
		}
		.single-fltr{float:left}
		.fltr-label{float:left;font-size:13px;font-weight:700;margin:9px 2px 0 0}
		.single-prop{float:left;margin:6px 5px 0 0}
		div#appliedFilter{background:#fff;width:auto;overflow:hidden}
		div#appliedFilter.applied{padding:10px;margin-top:10px}
		.fltr-remove{margin-left:5px;background:#ff513e;padding:0 5px;color:#fff;font-size:12px;font-weight:700}
		h4,.h4{font-size:16px;font-weight:700;padding-top:15px}
		.checkbox.features label{width:100%}
    </style>
@endsection