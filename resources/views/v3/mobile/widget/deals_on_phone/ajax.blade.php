<div class="product-tabs">
    <div class="css-carouseltab margintop">
        <ul class="tabs tabbrandname" data-items="4" data-scroll="2" id="part-tab-2">
            <?php $key = 1; ?>
            @foreach($vendors as $vendor => $p )
                <li class="tab">
                    <a class="{{($key == 1) ? 'active' : ''}}" href="#brntab{{$section}}{{$tab}}{{$key}}">{{ucwords($vendor)}}</a>
                </li>
                <?php $key++; ?>
            @endforeach
        </ul>
    </div>
</div>
<?php $key = 1; ?>
@foreach($vendors as $vendor => $p )
    <div class="tab-content" id="brntab{{$section}}{{$tab}}{{$key}}" style="{{($key > 1) ? 'display:none' : ''}}">
        <?php $id = 'part-' . $section . '-' . $tab . '-' . $vendor ?>
        @include('v3.mobile.product.carousel', ['products'=> $p])
        <a href="{{url('/mobile/mobiles-price-list-in-india.html')}}" class="allcateglink">
            VIEW ALL {{ucwords($vendor)}} PHONES
            <span class="right-arrow"></span>
        </a>
    </div>
    <?php $key++; ?>
@endforeach