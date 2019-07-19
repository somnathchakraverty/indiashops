<section>
    <div class="whitecolorbg">
        <div class="container">
            <h2>Competitors for {{$product->name}}</h2>
            @include("v3.mobile.product.carousel_pd", [ 'products' => $compare_products, "main_product" => $product ])
        </div>
    </div>
</section>