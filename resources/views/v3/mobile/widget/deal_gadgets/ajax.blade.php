<?php $cat = \indiashopps\Category::find(collect($products)->first()->category_id) ?>
<div class="trendingdealsprobox">
    @include('v3.mobile.product.carousel')
</div>

    <a href="{{getCategoryUrl($cat)}}" target="_blank"  class="allcateglink">
        VIEW ALL {{$cat->name}}
        <span class="right-arrow"></span>
    </a>
