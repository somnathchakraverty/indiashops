<div class="product-tabs">
    <ul class="tabs tabbrandname carousel" data-items="4" data-scroll="2" id="part-tab-2">
        <?php $key = 1; ?>
        @foreach($vendors as $vendor => $p )
            <li class="tab">
                <a class="{{($key == 1) ? 'active' : ''}}" href="#brntab{{$section}}{{$tab}}{{$key}}">{{ucwords($vendor)}}</a>
            </li>
            <?php $key++; ?>
        @endforeach
    </ul>
</div>
<?php $key = 1; ?>
@foreach($vendors as $vendor => $p )
    <div class="tab-content" id="brntab{{$section}}{{$tab}}{{$key}}" style="{{($key > 1) ? 'display:none' : ''}}">
        <ul id="part-{{$section}}-{{$tab}}-{{$vendor}}" class="carousel" data-items="1.5">
            @foreach($p as $product)
                <li>
                    @include('v3.common.product.card', [ 'product' => $product ])
                </li>
            @endforeach
        </ul>
    </div>
    <?php $key++; ?>
@endforeach
<script>
    $("ul.tabs").tabs();
</script>