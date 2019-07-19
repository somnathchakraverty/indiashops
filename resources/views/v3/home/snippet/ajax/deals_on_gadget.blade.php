<div class="trendingdealsprobox">
<div class="cs_dkt_si">
    <ul>
        @foreach($products as $product)
            <li class="thumnail">
                @include('v3.common.product.card', [ 'product' => $product ])
            </li>
        @endforeach
    </ul>
    </div>
</div>