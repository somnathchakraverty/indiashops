<ul class="nav nav-tabs" role="tablist">
    <?php $i = 0; ?>
    @foreach( $cat_tabs as $key => $products )
        <li role="presentation" class="{{($i == 0) ? 'active' : ''}}">
            <a href="#deals_under_{{create_slug($key)}}_{{$i++}}" role="tab" data-toggle="tab">{{ucwords($key)}}</a>
        </li>
    @endforeach
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <?php $i = 0; ?>
    @foreach( $cat_tabs as $key => $products )
        <div role="tabpanel" class="tab-pane {{($i == 0) ? 'active' : ''}}" id="deals_under_{{create_slug($key)}}_{{$i++}}">
            @if( !in_array($main_product->category_id, config('vendor.remove_brand_link')) )
                <?php $category = \indiashopps\Category::where('id', $products->first()->category_id)->first() ?>
                
                    <a class="explore-all-categori mtop10" href="{{getCategoryUrl($category)}}">VIEW ALL {{$key}}
                        <span class="arrow">&rsaquo;</span>
                    </a>
               
            @endif
            @include('v3.product.common.ajax.accessories')
        </div>
    @endforeach
</div>