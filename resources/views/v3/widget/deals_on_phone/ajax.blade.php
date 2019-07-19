<div class="trendingdealsprobox heighttop">   
        <ul class="brandbox nav nav-tabstabs" role="tablist">
            <?php $key = 1; ?>
            @foreach($vendors as $vendor => $p )
                <li role="presentation" class="{{($key == 1) ? 'active' : ''}}">
                    <a href="#brn-tab-{{$section}}-{{$tab}}-{{$key++}}" role="tab" data-toggle="tab" class="phonetableft">                    
                        <div class="brdlog {{$vendor}}"></div>
                    </a>
                </li>
            @endforeach
        </ul>  
    <?php $key = 1; ?>
    @foreach($vendors as $vendor => $p )
        @php
            $product = collect($p)->first();
            $brand_url = route('brands.listing',[
                cs($product->grp),
                cs($vendor),
                cs($product->category),
            ]);
        @endphp
        <div class="tab-pane {{($key == 1) ? 'active' : ''}}" id="brn-tab-{{$section}}-{{$tab}}-{{$key++}}">
            <div class="tabbrandbottom">
                <a class="alltab phones" href="{{$brand_url}}">
                    VIEW ALL {{ucwords($vendor)}} PHONES
                    <span class="arrow">&rsaquo;</span>
                </a>
                <div class="cs_dkt_si">
                    <ul data-items="4">
                        @foreach($p as $product)
                            <li class="thumnail">
                                @include('v3.common.product.card', [ 'product' => $product ])
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
</div>