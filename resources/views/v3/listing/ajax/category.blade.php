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

    <h2>{{$child->name}}</h2>
    @if($child->id==351)
        <a class="expcat" href="{{getCategoryUrl($child)}}" title="Mobile Phones Price List">
            VIEW ALL {{$child->name}}
            <span class="arrow">&rsaquo;</span>
        </a>
    @else
        <a class="expcat" href="{{getCategoryUrl($child)}}">VIEW ALL {{$child->name}}
            <span class="arrow">&rsaquo;</span>
        </a>
    @endif

    <div class="catgprofullbox">
        <div class="cs_dkt_si">
            <ul data-items="5">
                @foreach($products as $product)
                    <li class="thumnail">
                        @include('v3.common.product.card')
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @if(isset($filters) && !is_null($filters) && \indiashopps\Category::hasThirdLevel($child) && count($filters->buckets) > 0)
        <?php
        $category = $child->name;
        $filter = collect($facets)->keys()->first()
        ?>
        <div class="trendingdeals">
            <h3>Explore {{ucwords($category)}} by {{unslug($filter)}}</h3>
            @if( array_key_exists(strtolower($category),config('all_brands')) )
                <?php $brands_page = route('category_all_brands', [cs($child->group_name), cs($child->name)]) ?>
                <a class="expcat" href="{{$brands_page}}">
                    VIEW ALL {{config('all_brands.'.strtolower($category).'.text')}} Brands<span class="arrow">&rsaquo;</span>
                </a>
            @endif
            <div class="brandlogobox">
                <div class="cs_brd_si">
                    <ul data-items="5">
                        @if( array_key_exists(strtolower($category),config('all_brands')) )
                            @foreach(config('all_brands.'.strtolower($category).'.brands') as $brand )
                                <li>
                                    <a class="thumnail" href="{{brandProductList($brand,$child)}}" target="_blank">
                                        <div class="rammobilebox">{{strtoupper($brand)}}</div>
                                    </a>
                                </li>
                            @endforeach
                        @else
                            @foreach($filters->buckets as $key => $attr )
                                @if(!empty($attr->key) && $attr->doc_count >= 5)
                                    <li>
                                        @if( $filter == 'brand' )
                                            <a class="thumnail" href="{{brandProductList($attr->key,$child)}}" target="_blank">
                                                <div class="rammobilebox">{{strtoupper($attr->key)}}</div>
                                            </a>
                                        @else
                                            <a class="thumnail" href="{{getCategoryUrl($child)}}#{{$filter}}={{urlencode($attr->key)}}" target="_blank">
                                                <div class="rammobilebox">{{strtoupper($attr->key)}}</div>
                                            </a>
                                        @endif
                                    </li>
                                @endif
                                @if($key >= 6)
                                    @break
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    @endif
@endif