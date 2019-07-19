@foreach($products as $product )
    @include('v3.common.product.amp.card', [ 'product' => $product ])
@endforeach
