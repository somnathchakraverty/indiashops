@if(isset($products) && !empty($products))
    <div class="trendingdealsprobox">
        <div class="cs_dkt_si">
            <ul data-items="5">
                @foreach($products as $product)
                    <li class="thumnail">
                        @include('v3.common.product.card', [ 'product' => $product ])
                    </li>
                @endforeach
            </ul>
            
            <span class="prev"></span>
            <span class="next"></span>
        </div>
    </div>
@endif