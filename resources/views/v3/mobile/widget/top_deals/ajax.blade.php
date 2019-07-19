@include('v3.mobile.product.carousel')
@if(isset($key))
    <?php $category = \indiashopps\Category::find(collect($products)->first()->category_id); ?>
    <a href="{{getCategoryUrl($category)}}" class="allcateglink">
        View All {{unslug($section)}}
        <span class="right-arrow"></span>
    </a>
@endif