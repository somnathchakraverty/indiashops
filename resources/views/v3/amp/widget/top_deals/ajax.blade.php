<ul id="part40" class="carousel" data-items="1.5" data-scroll="1">
    @foreach($products as $product)
        <li>
            @include('v3.common.product.card', [ 'product' => $product ])
        </li>
    @endforeach
</ul>
@if(isset($key))
    <?php $category = \indiashopps\Category::find(collect($products)->first()->category_id); ?>
    <div class="allcateglink">
        <a href="{{getCategoryUrl($category)}}">
            View All {{unslug($key)}} <img class="right-arrow"src="{{asset('assets/v3/mobile')}}/images/right-arrow-2.png" alt="arrow" width="20" height="20">
        </a>
    </div>
@endif