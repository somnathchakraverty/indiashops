<div class="container">
    <?php $category_id = $product->category_id?>
    <?php $Category = \indiashopps\Category::find($category_id); ?>
</div>
<div class="whitecolorbg">
    <div class="container">
        <h3>Popular {{ucwords($Category->name)}}</h3>
        <div id="deals_products">
            @include('v3.mobile.product.deals', [ 'products' => $deals ])
        </div>
        <a class="allcateglink" href="{{getCategoryUrl($Category)}}">VIEW ALL {{$Category->name}}
            <span class="right-arrow"></span>
        </a>
    </div>
</div>
