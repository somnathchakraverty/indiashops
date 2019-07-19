@if(isset($deals) && !empty($deals))
    <div class="trendingdealsprobox">
        @if(isset($brand_widget) && $brand_widget)
            <?php
            $p = $deals[0]->_source;
            $brand_url = route('brand_category_list', [cs($p->brand), cs($p->grp), cs($p->category)]); ?>

            <a class="alltab" href="{{$brand_url}}">VIEW ALL {{$p->brand}} Products
                <span class="arrow">&rsaquo;</span>
            </a>

        @endif
        <div class="cs_dkt_si">
            <ul data-items="5">
                @foreach($deals as $deal)
                    <li class="thumnail">
                        @include('v3.common.product.card', [ 'product' => $deal->_source ])
                    </li>
                @endforeach
            </ul>           
        </div>
    </div>
@endif