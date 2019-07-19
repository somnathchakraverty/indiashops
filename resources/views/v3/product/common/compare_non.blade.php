@if( isset($compare_products) && is_array($compare_products) && count($compare_products) > 0 )
        <h2>Competitors for {{$product->name}}</h2>
    <div class="comparisontable" id="right_container">      
            <div class="comparelistboxpdp">
                <a class="comparelistproimg">
                    <img class="comparison-producttowimg" src="{{getImageNew('')}}" data-src="{{getImageNew($product->image_url,"S")}}" alt="{{$product->name}} Image">
                </a>
                <div class="comparelisttow-container">
                    <a class="product_namecomp">{{$product->name}}</a>
                    <span class="startingfrom">Starting From</span>
                    <span class="pricecompto">{{env('CURRENCY_CODE')}} {{number_format($product->saleprice)}}</span>
                </div>
                <ul class="comproductfu">
                    <div class="thisphone"></div>
                    @if(isset($product->mini_spec))
                        @foreach(miniSpecs($product->mini_spec,6) as $spec)
                            @if(!empty($spec))
                                <li><span>&#9989;</span> {!! $spec !!}</li>
                            @endif
                        @endforeach
                    @endif
                </ul>
                <a href="#specifications" class="adtocardbuttonpdp">See specs</a>
            </div>
            <div class="comtowprorightpart" id="compare_wrapper">
                <div class="cs_brd_si">
                    <ul data-items="3">
                        @foreach($compare_products as $product)
                            <?php $product = $product->_source; ?>
                            <li>
                                <div class="comparelistboxpdp">                                  
                                        <a class="comparelistproimg" href="{{product_url($product)}}">
                                            <img class="comparison-producttowimg" src="{{getImageNew('')}}" data-src="{{getImageNew($product->image_url,"S")}}" alt="{{$product->name}} Image">
                                        </a>                                   
                                    <div class="comparelisttow-container">
                                        <a class="product_namecomp" href="{{product_url($product)}}">
                                            {{$product->name}}
                                        </a>
                                        <span class="startingfrom">Starting From</span>
                                        <span class="pricecompto">{{env('CURRENCY_CODE')}} {{number_format($product->saleprice)}}</span>
                                    </div>
                                   
                                    <ul class="comproductfu">
                                        @if(isset($product->mini_spec))
                                            @foreach(miniSpecs($product->mini_spec,6) as $spec)
                                                @if(!empty($spec))
                                                    <li><span>&#9989;</span> {!! $spec !!}</li>
                                                @endif
                                            @endforeach
                                        @endif
                                        </ul>
                                   
                                    @if(isComparativeProduct($product) && isset($product->specification))
                                        @php
                                            $compare_url = route('compare-mobiles',[cs($main_product->name." ".$main_product->id),cs($product->name." ".$product->id)])
                                        @endphp
                                        <a class="adtocardbuttonpdp" href="{{$compare_url}}" target="_blank">
                                            Compare Now
                                        </a>
                                    @else
                                        <a class="adtocardbuttonpdp" href="{{product_url($product)}}" target="_blank">
                                            Details
                                        </a>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        
    </div>
    <style>
        .androidpart li { padding: 2px 0px; }
        input[type="checkbox"] + label { font-size: 12px !important; }
        .btn-danger { font-size: 12px !important; padding: 3px !important; float: right !important; font-weight: bold !important; }
        .top63 { top: 63px !important; width: 172px; }
    </style>
@endif