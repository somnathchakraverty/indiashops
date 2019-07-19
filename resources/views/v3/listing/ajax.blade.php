<?php $products = collect($product)?>
@if(!is_null($products))   
        @if( $page > 1 )
            <h4>PAGE - {{$page}}</h4>
        @endif  
    <div class="catgprofullbox">
        @foreach($products as $product)
            @include('v3.common.product.card2', [ 'product' => $product->_source ])
        @endforeach
    </div>
@endif