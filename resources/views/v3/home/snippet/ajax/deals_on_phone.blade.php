<div class="trendingdealsprobox heighttop">
    <div class="brandbox">
        <ul class="nav nav-tabstabs" role="tablist">
            <?php $key = 1; ?>
            @foreach($vendors as $vendor => $p )
                <li role="presentation" class="{{($key == 1) ? 'active' : ''}}">
                    <a href="#brn-tab-{{$section}}-{{$tab}}-{{$key}}" aria-controls="price-{{$section}}-{{$key}}-{{$key++}}" role="tab" data-toggle="tab" class="phonetableft">
                        <!--<img src="{{asset('assets/v3')}}/images/brand_logo/{{$vendor}}.png" alt="{{$vendor}}">-->
                        <div class="{{$vendor}}"></div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <?php $key = 1; ?>
    @foreach($vendors as $vendor => $p )
        <div role="tabpane2" class="tab-pane {{($key == 1) ? 'active' : ''}}" id="brn-tab-{{$section}}-{{$tab}}-{{$key++}}">
        <div class="tabbrandbottom">
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