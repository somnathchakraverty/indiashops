@extends('v3.amp.master')
@section('head')
    <link rel="canonical" href="{{str_replace("amp/","",Request::url())}}"/>
@endsection
@section('page_content')
    <!--THE-BANNER-->
    @if( isset($sliders) && !empty($sliders) )
        @include('v3.amp.slider', [ 'slider' => collect($sliders)->first() ])
    @endif
    <!--END-BANNER-->
    <amp-state id="shortDesc">
        <script type="application/json">
            {
                "top" : {
                    "class" : "hidden"
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
    @foreach( $childs as $child_key => $child )
        <?php $data = $child->getProducts(); ?>
        <?php
        $remove = ['price_ranges', 'saleprice_min', 'grp', 'saleprice_max', 'filters_all', 'vendor'];
        $facets = $data->get('filters');
        $products = $data->get('products');

        foreach ($remove as $attr) {
            if (isset($facets->{$attr})) {
                unset($facets->{$attr});
            }
        }
        if (isset($facets) && count($facets) > 0) {
            foreach ($facets as $key => $value) {
                if (!is_object($value)) {
                    unset($facets->{$key});
                }
            }
        }

        $filters = collect($facets)->first();
        ?>
        @if(isset($products) && !empty($products) && count($products) > 0 )
            <!--THE PRODUCTS-->
            <section>
                <div class="whitecolorbg">
                    <div class="container">
                     <h2>{{$child->name}}</h2>
                        <amp-carousel class="full-bottom" height="350" layout="fixed-height" type="carousel">
                            @foreach($products as $product)
                                @include('v3.common.product.amp.card')
                            @endforeach
                        </amp-carousel>
                        <div class="allcateglink">
                            <a href="{{getCategoryUrl($child)}}">
                                VIEW ALL {{$child->name}}<i class="fa fa-angle-right right-arrow"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        @if(isset($filters) && !is_null($filters) && isset($filters->buckets) && count($filters->buckets) > 0 && \indiashopps\Category::hasThirdLevel($child))
            <!--BRAND FILTERS-->
            <?php
            $category = $child->name;
            $filter = collect($facets)->keys()->first()
            ?>
            <section>
                <div class="whitecolorbg">
                    <div class="container">
                     <h2>Explore {{$child->name}} by {{unslug($filter)}}</h2>
                        <amp-carousel class="full-bottom" height="35" layout="fixed-height" type="carousel">
                            <div class="brandnameamp">
                                <ul>
                                    @if( array_key_exists(strtolower($category),config('all_brands')) )
                                        @foreach(config('all_brands.'.strtolower($category).'.brands') as $brand )
                                            <li>
                                                <a href="{{brandProductList($brand,$child)}}" target="_blank">
                                                    {{strtoupper($brand)}}
                                                </a>
                                            </li>
                                        @endforeach
                                    @else
                                        @foreach($filters->buckets as $attr )
                                            @if(!empty($attr->key) && $attr->doc_count >= 5)
                                                <li>
                                                    @if( $filter == 'brand' )
                                                        <a href="{{brandProductList($attr->key,$child)}}" target="_blank">
                                                            {{strtoupper($attr->key)}}
                                                        </a>
                                                    @else
                                                        <a href="{{getCategoryUrl($child)}}#{{$filter}}={{$attr->key}}" target="_blank">
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
                        @if( array_key_exists(strtolower($category),config('all_brands')) )
                            <?php $brands_page = route('category_all_brands', [
                                    cs($child->group_name),
                                    cs($child->name)
                            ]) ?>
                            <div class="allcateglink">
                                <a href="{{$brands_page}}">
                                    VIEW ALL {{config('all_brands.'.strtolower($category).'.text')}} Brands<i class="fa fa-angle-right right-arrow"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @endif
    @endforeach
@endsection