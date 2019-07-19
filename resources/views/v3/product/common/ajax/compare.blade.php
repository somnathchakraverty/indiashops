@if( isset($products) && is_array($products) )
<div class="cs_dkt_si">
    <ul data-items="3">
        @foreach($products as $product)
            <?php $product = $product->_source; ?>
            <li class="compprolistboxli">
                <div class="comparelistboxpdp">
                    <div class="comparelistproimg">
                        <img class="comparison-producttowimg" src="{{getImageNew($product->image_url,"S")}}" alt="{{$product->name}} Image">
                    </div>
                    <div class="comparelisttow-container">
                        <div class="product_namecomp">{{$product->name}}</div>
                        <div class="startingfrom">Starting From</div>
                        <div class="pricecompto">Rs {{number_format($product->saleprice)}}</div>
                    </div>
                    <div class="fulfucontnew">
                        @if(isset($product->mini_spec))
                            @foreach(miniSpecs($product->mini_spec,6) as $spec)
                                @if(!empty($spec))
                                    <div class="comproductfu"><span>&#9989;</span> {!! $spec !!}</div>
                                @endif
                            @endforeach
                        @endif
                        <a href="{{product_url($product)}}" target="_blank" class="read-more">Read more</a>
                    </div>
                    <a data-cat="{{$product->category_id}}" data-prod-id="{{$product->id}}" class="adtocardbuttonpdp add_to_compare">Add
                        to Compare</a>
                </div>
            </li>
        @endforeach
    </ul>
    </div>
@endif