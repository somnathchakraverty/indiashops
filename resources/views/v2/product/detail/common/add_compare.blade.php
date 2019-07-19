@if(isset($products) && count($products) > 0)
<div class="whitecolorbg">
    <div class="sub-title"><span>People who viewed <strong>{{$name}}</strong> also viewed</span></div>
    <div class="addcomparephonelist" id="add_comp_wrapper">
        <ul>
            @foreach($products as $key => $product)
                <?php $p = $product->_source; unset($product); ?>
                <li class="comp-product">
                    <div class="addcomphone col-md-12">
                        <a href="{{product_url($p)}}" target="_blank" title="{{$p->name}}" data-toggle="tooltip">
                            <img src="{{getImageNew($p->image_url,'S')}}" alt="mobile"
                                 style="max-height: 100px; width: auto">
                        </a>
                    </div>
                    <div class="clearfix"></div>                  
                        <h2><a href="{{product_url($p)}}" target="_blank" title="{{$p->name}}" data-toggle="tooltip">{{truncate($p->name,15)}}</a></h2>                   
                    @if($p->saleprice > 0)
                        <span class="price_comp">Rs. {{number_format($p->saleprice)}}</span>
                    @else
                        <span class="price_comp">NA</span>
                    @endif
                    <div class="col-md-12">
                        <label class="reviewslinkadd" style="margin-bottom: 15px;">
                            <input type="checkbox" cat="{{$p->category_id}}" prod-id="{{$p->id}}"
                                   class="add_compare_detail add-to-compare">
                            Add to Compare</label>
                    </div>
                </li>
                @if($key >= 8)
                    <?php break; ?>
                @endif
            @endforeach
        </ul>
    </div>
</div>
@endif