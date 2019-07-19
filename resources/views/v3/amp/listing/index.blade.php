<?php $products = collect($product)->chunk(16); ?>
<?php $snippet = collect($product)->chunk(10)->first(); ?>
@extends('v3.amp.master')
@section('head')
    {!! $rel_next_prev !!}
    @if(isset($page) && $page > 1 )
        <meta name="ROBOTS" content="noindex">
    @else
        <meta name="robots" content="index, follow"/>
        <meta name="author" content="IndiaShopps"/>
    @endif
    {!! canonical_url_list() !!}
    <link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--c--{{$scat}}"/>
@endsection
@section('page_content')
    <!--THE-BANNER-->
    {{--@if( isset($sliders) && !empty($sliders) )--}}
        {{--@include('v3.amp.slider', [ 'slider' => collect($sliders)->first() ])--}}
    {{--@endif--}}
    <amp-state id="shortDesc">
        <script type="application/json">
            {
                "top" : {
                    "class" : "hidden-content"
                }
            }
        </script>
    </amp-state>
    <section>
        <div class="container">
            {!! Breadcrumbs::render() !!}
        </div>
    </section>
    <section>
        <div class="container">
            <h1 class="textcenter">{!! app('seo')->getHeading() !!}</h1>
            @if(app('seo')->getShortDescription())
                <div [class]="shortDesc.top.class" class="hidden-content">
                    {!! removeInlineStyle1(app('seo')->getShortDescription()) !!}
                </div>
                <button id="show-more-button" [class]="shortDesc.top.class" class="shown" on="tap:AMP.setState({shortDesc: {top : {class: ''}}})">
                    Read More
                </button>
            @endif
            <div class="line"></div>
        </div>
    </section>
    <!--END-SECTION-1-->
    <!--THE-SECTION-2-->
    <section>
        <div class="whitecolorbg">
            <div class="container">
                <h2>{{processListingHeading(get_defined_vars())}}</h2>
                <div class="mobilecard2">
                    <ul>
                        <li>
                            @foreach($products->shift() as $product)
                                @include('v3.common.product.amp.card2')
                            @endforeach
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--END-SECTION-2-->
    <!--THE-SECTION-3-->
    @if(!($isSearch) && isset($child_categories) && $child_categories instanceof \Illuminate\Support\Collection && $child_categories->count() > 0)
        <section>
            <div class="whitecolorbg">
                <div class="container">
                    <h2>Explore More Categories</h2>
                    <amp-carousel class="full-bottom" height="35" layout="fixed-height" type="carousel">
                        <div class="brandnameamp">
                            <ul>
                                @foreach($child_categories as $category )
                                    <li>
                                        <a href="{{getCategoryUrl($category)}}" target="_blank">
                                            {{strtoupper($category->name)}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </amp-carousel>
                </div>
            </div>
        </section>
    @endif
    <?php
    $pfilters = clone $facets;
    $remove = ['price_ranges', 'saleprice_min', 'grp', 'saleprice_max', 'filters_all', 'vendor'];

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
    <?php $category = \indiashopps\Category::find($scat); ?>
    @if(isset($scat) && !empty($scat) && \indiashopps\Category::hasThirdLevel($category) && isset($filters->buckets) && !empty($filters->buckets) && count($filters->buckets) > 2 )
        <section>
            <div class="whitecolorbg">
                <div class="container">
                    <h2>Choose your {{unslug($filter)}}</h2>
                    <amp-carousel class="full-bottom" height="35" layout="fixed-height" type="carousel">
                        <div class="brandnameamp">
                            <ul>
                                @if( $filter == 'brand' && array_key_exists(strtolower($category->name),config('all_brands')) )
                                    @foreach(config('all_brands.'.strtolower($category->name).'.brands') as $brand )
                                        <li>
                                            <a href="{{brandProductList($brand,$category)}}" target="_blank">
                                                {{strtoupper($brand)}}
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    @foreach($filters->buckets as $attr )
                                        @if(!empty($attr->key) && $attr->doc_count >= 5)
                                            <li>
                                                @if( $filter == 'brand')
                                                    <a href="{{brandProductList($attr->key,$category)}}" target="_blank">
                                                        {{strtoupper($attr->key)}}
                                                    </a>
                                                @else
                                                    <a href="{{str_replace("amp/","",getCategoryUrl($category))}}#{{$filter}}={{$attr->key}}" target="_blank">
                                                        {{strtoupper($attr->key)}}
                                                    </a>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </amp-carousel>
                    @if( $filter == 'brand' && array_key_exists(strtolower($category->name),config('all_brands')) )
                        <?php $brands_page = route('category_all_brands', [
                                cs($category->group_name),
                                cs($category->name)
                        ]) ?>
                        <div class="allcateglink">
                            <a href="{{$brands_page}}">
                                VIEW ALL {{config('all_brands.'.strtolower($category->name).'.text')}}
                                Brands<i class="fa fa-angle-right right-arrow"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif
    <!--END-SECTION-3-->
    <!--THE-SECTION-4-->
    <?php $prods = $products->shift();?>
    @if(isset($prods) && !is_null($prods))
        <section>
            <div class="whitecolorbg">
                <div class="container">
                    <div class="mobilecard2">
                        <ul>
                            <li>
                                @foreach($prods as $product)
                                    @include('v3.common.product.amp.card2')
                                @endforeach
                            </li>
                        </ul>
                    </div>
                    {!! str_replace("javascript:void","#",$markup) !!}
                </div>
            </div>
        </section>
    @endif
    <!--END-SECTION-4-->
    <section>
        <div class="whitecolorbg">
            <div class="container">
                <h3>{{app('seo')->listSnippetTitle(get_defined_vars())}}</h3>
                <div class="pricetablecat" id="specifications">
                    <div class="more-less-toggledetails">
                        @include('v3.listing.ajax.snippet')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="filterstab">
        <a href="{{str_replace("amp/", "",Request::url())}}?filter=open" class="productbutton buyorangebutton">FILTERS</a>
    </div>
@endsection