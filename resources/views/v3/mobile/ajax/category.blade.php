<?php
$remove = ['price_ranges', 'saleprice_min', 'grp', 'saleprice_max', 'filters_all', 'vendor'];
$facets = $data->get('filters');
$products = $data->get('products');
foreach ($remove as $attr) {
    if (isset($facets->{$attr})) {
        unset($facets->{$attr});
    }
}

foreach ($facets as $key => $value) {
    if (!is_object($value)) {
        unset($facets->{$key});
    }
}

$filters = collect($facets)->first();
?>
@if(isset($products) && !empty($products) && count($products) > 0 )
    <div class="whitecolorbg">
        <div class="container">
            <h2>{{$child->name}}</h2>
            @include('v3.mobile.product.carousel')
            @if($child->id==351)
                <a href="{{getCategoryUrl($child)}}" class="allcateglink" title="Mobile Phones Price List">
                    VIEW ALL {{$child->name}}
                    <span class="right-arrow"></span>
                </a>
            @else
                <a href="{{getCategoryUrl($child)}}" class="allcateglink">
                    VIEW ALL {{$child->name}}
                    <span class="right-arrow"></span>
                </a>
            @endif
        </div>
    </div>
    <section>
        @if(isset($filters) && !is_null($filters) && \indiashopps\Category::hasThirdLevel($child))
            <?php
            $category = $child->name;
            $filter = collect($facets)->keys()->first()
            ?>
            <div class="whitecolorbg">
                <div class="container">
                    <h3>Explore {{ucwords($category)}} by {{unslug($filter)}}</h3>
                    <div class="product-tabs tabsbornone css-carouseltab padding-btm0">
                        <ul class="tabs tabbrandname">
                            @if( array_key_exists(strtolower($category),config('all_brands')) )
                                @foreach(config('all_brands.'.strtolower($category).'.brands') as $brand )
                                    <li class="tab">
                                        <a class="active" href="{{brandProductList($brand,$child)}}" target="_blank">
                                            {{strtoupper($brand)}}
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                @foreach($filters->buckets as $attr )
                                    @if(!empty($attr->key) && $attr->doc_count >= 5)
                                        @if( $filter == 'brand')
                                            <li class="tab">
                                                <a class="active" href="{{brandProductList($attr->key,$first->category)}}" target="_blank">
                                                    {!! strtoupper($attr->key) !!}
                                                </a>
                                            </li>
                                        @else
                                            <li class="tab">
                                                <a href="{{getCategoryUrl($first->category)}}?{{$filter}}={{$attr->key}}" target="_blank">
                                                    {!! strtoupper($attr->key) !!}
                                                </a>
                                            </li>
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    @if( array_key_exists(strtolower($category),config('all_brands')) )
                        <?php $brands_page = route('category_all_brands', [cs($child->group_name), cs($child->name)]) ?>
                        <a class="allcateglink" href="{{$brands_page}}">
                            VIEW ALL {{config('all_brands.'.strtolower($category).'.text')}} Brands <span class="right-arrow"></span>
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </section>
@endif
