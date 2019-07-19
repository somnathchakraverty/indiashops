<?php $products = collect($product); ?>
<section>
    <div class="whitecolorbg">
        <div class="container">
            <div class="mobilecard2">
                <ul>
                    @foreach($products as $product)
                        <li>
                            @include('v3.mobile.product.card2')
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>