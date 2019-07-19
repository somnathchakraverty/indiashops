<?php $cat = \indiashopps\Category::find(collect($products)->first()->category_id) ?>
<div class="trendingdealsprobox">
    <ul id="flexiselDemo3" class="carousel" data-items="2" data-scroll="1">
        @foreach($products as $product)
            <li>
                @include('v3.common.product.card', [ 'product' => $product ])
            </li>
        @endforeach
    </ul>
</div>
<div class="allcateglink">
    <a href="{{getCategoryUrl($cat)}}" target="_blank">
        VIEW ALL {{$cat->name}}
        <img class="right-arrow" src="{{asset('assets/v3/mobile')}}/images/right-arrow-2.png" alt="arrow" width="20" height="20">
    </a>
</div>