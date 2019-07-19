<div class="css-carousel">   
        <ul>
            @foreach($products as $product )
                <li>
                    @include('v3.mobile.product.card', [ 'product' => $product ])
                </li>
            @endforeach
        </ul> 
</div>