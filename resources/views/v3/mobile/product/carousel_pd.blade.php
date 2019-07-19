<div class="css-carousel">
    <ul>
        @foreach($products as $product )
            @php
                if(isset($product->_source))
                {
                    $product = $product->_source;
                }

                if(isComparativeProduct($product) && isset($product->specification) && isset($main_product) && !empty($main_product))
                {
                    $compare_url = route('compare-mobiles',[cs($main_product->name." ".$main_product->id),cs($product->name." ".$product->id)]);
                }
                else
                {
                    $compare_url = false;
                }
            @endphp
            <li>
                @include('v3.mobile.product.card', [ 'product' => $product, 'compare_url' => $compare_url ])
            </li>
        @endforeach
    </ul>
</div>