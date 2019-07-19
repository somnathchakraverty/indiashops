<?php $include_file = $current_path . ".ajax"; ?>
@if(!isset($ajax))
    <!-- Tab panes -->
    <div class="whitecolorbg">
        <div class="container">       
        <h2>Top Deals on Accessories</h2>
        <div class="product-tabs">
            <div class="css-carouseltab padding-btm0">               
                    <ul class="tabs">
                        <li class="tab">
                            <a class="active" href="#top_deals_acc_headphones">Headphones</a>
                        </li>
                        <li class="tab">
                            <a href="#top_deals_acc_speakers">Speakers</a>
                        </li>
                        <li class="tab">
                            <a href="#top_deals_acc_smart_wearables">Smart Wearables</a>
                        </li>
                    </ul>               
            </div>
        </div>
  
            @foreach($products as $section => $s_products)
                <div class="tab-content" id="top_deals_acc_{{$section}}">
                    @include($include_file, [ 'products' => $s_products ])
                </div>
            @endforeach
        </div>
    </div>
@else
    @include($include_file)
@endif