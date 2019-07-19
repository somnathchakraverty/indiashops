@if(isset($products) && !empty($products))
    <div class="trendingdealsprobox">
        @if(isset($brand_widget) && $brand_widget)
            <?php
            $p = $products[0]->_source;

            if (in_array($p->grp, config('listing.brand.groups'))) {
                $brand_url = route('brands.listing', [cs($p->grp), cs($p->brand), cs($p->category)]);
            } else {
                $brand_url = route('brand_category_list', [cs($p->brand), cs($p->grp), cs($p->category)]);
            }
            ?>


            <a class="alltab mtop_35" href="{{$brand_url}}">VIEW ALL {{$p->brand}} {{$p->category}}
                <span class="arrow">&#155;</span>
            </a>

        @endif
        <div class="cs_dkt_si">
            <ul data-items="5">
                @foreach($products as $product)
                    <li class="thumnail">
                        @include('v3.common.product.card', [ 'product' => $product->_source ])
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif