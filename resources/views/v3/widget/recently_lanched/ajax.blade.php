<div class="trendingdealsprobox heighttop">
    <div class="cs_dkt_si">
        <ul data-items="5">
            @foreach($products as $product)
                <li class="thumnail">
                    @include('v3.common.product.card')
                </li>
            @endforeach
        </ul>
    </div>
</div>