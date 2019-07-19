@if(isset($key))
    <?php $category = \indiashopps\Category::find(collect($products)->first()->category_id); ?>

    <a class="alltab" href="{{getCategoryUrl($category)}}">View All {{unslug($section)}}
        <span class="arrow">&rsaquo;</span>
    </a>

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