@if(isset($products) && count($products) > 0)
<div class="whitecolorbg">
    <div class="sub-title"><span>"<b>{{ucwords($name)}}</b>" is most compared with</span></div>
    <div class="comparetowpro">
        <ul>
            @foreach($products as $product)
            <?php $p = $product->_source ?>
            <li>
                <div class="comparephonetowlist">
                    <div class="image">
                        <a href="{{route('product_detail_v2',[create_slug($name),$id])}}" target="_blank" title="{{$name}}" data-toggle="tooltip">
                            <img src="{{getImageNew($image,'S')}}" class="imgsizenewpro" alt="mobile" />
                        </a>
                    </div>
                    <div class="comorparenew">
                    <a href="{{route('product_detail_v2',[create_slug($name),$id])}}" target="_blank" title="{{$name}}" data-toggle="tooltip">
                        <h2 title="{{$name}}" data-toggle="tooltip">{{truncate($name,15)}}</h2>
                    </a>
                    <span>Rs. {{number_format($saleprice)}}</span>
                    </div>
                    </div>
                <div class="comparephonetowlist">
                    <div class="image">
                        <a href="{{product_url($p)}}" title="{{$p->name}}" data-toggle="tooltip">
                            <img src="{{getImageNew($p->image_url,"S")}}" class="imgsizenewpro" alt="mobile" onerror="imgError(this)">
                        </a>
                    </div>
                    <div class="comorparenew">
                    <a href="{{product_url($p)}}" title="{{$p->name}}" data-toggle="tooltip">
                        <h2 title="{{$p->name}}" data-toggle="tooltip">{{truncate($p->name,15)}}</h2>
                    </a>
                    @if($p->saleprice > 0)
                        <span>Rs. {{number_format($p->saleprice)}}</span>
                    @else
                        <span>NA</span>
                    @endif
                    </div>
                </div>
                <div class="vscomtow">vs</div>
                <a href="{{route('compare-mobiles',[create_slug($name."-".$id),create_slug($p->name."-".$p->id)])}}" class="towcompprolink" target="_blank">Compare</a></li>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endif