<ul class="nav nav-tabs" role="tablist">
    <?php $i = 0; ?>
    @foreach( $tabs as $key => $products )
        <li role="presentation" class="{{($i == 0) ? 'active' : ''}}">
            <a href="#deals_under_{{create_slug($key)}}_{{$i++}}" role="tab" data-toggle="tab">{{ucwords($key)}}</a>
        </li>
    @endforeach
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <?php $i = 0; ?>
    @foreach( $tabs as $key => $products )
        <div role="tabpanel" class="tab-pane {{($i == 0) ? 'active' : ''}}" id="deals_under_{{create_slug($key)}}_{{$i++}}">
            <?php $category = \indiashopps\Category::where('id', $products->first()->category_id)->first() ?>
           
                <a class="alltab" href="{{getCategoryUrl($category)}}">VIEW ALL {{$key}}
                    <span class="arrow">&#155;</span>
                </a>
          
            @include('v3.product.common.ajax.accessories')
        </div>
    @endforeach
</div>