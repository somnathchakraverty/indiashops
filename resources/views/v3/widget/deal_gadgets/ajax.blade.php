<?php $cat = \indiashopps\Category::find(collect($products)->first()->category_id) ?>
<a class="alltab" href="{{getCategoryUrl($cat)}}" target="_blank">
    VIEW ALL {{$cat->name}} <span class="arrow">&rsaquo;</span>
</a>
<div class="trendingdealsprobox">
    <div class="cs_dkt_si">
        <ul data-items="5">
            @foreach($products as $product)
                <li class="thumnail">
                    @include('v3.common.product.card', [ 'product' => $product ])
                </li>
            @endforeach
        </ul>
    </div>
</div>