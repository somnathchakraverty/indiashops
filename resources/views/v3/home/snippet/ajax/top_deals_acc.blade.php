@if(isset($key))
    <?php $category = \indiashopps\Category::find(collect($products)->first()->category_id); ?>
    <div class="alltab">
        <a href="{{getCategoryUrl($category)}}">View All {{unslug($key)}}
            <span class="glyphicon glyphicon-menu-right arrow" aria-hidden="true"></span>
        </a>
    </div>
@endif
<div class="trendingdealsprobox">
<div class="cs_dkt_si">
    <ul>
        @foreach($products as $product)
            <li class="thumnail">
                @include('v3.common.product.card', [ 'product' => $product ])
            </li>
        @endforeach
    </ul>
</div>
</div>