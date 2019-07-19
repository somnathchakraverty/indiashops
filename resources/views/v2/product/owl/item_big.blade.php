@foreach($products as $pro)
    <?php $product = $pro->_source ?>
    <div class="item">
        <div class="noncomproductnew">
            <div class="noncomimgfixed">
                <a href="{{product_url($pro)}}" title="{{$product->name}}">
                    <img alt="{{$product->name}} Image" title="{{$product->name}}" src="{{getImageNew($product->image_url,'S')}}" class="noncomproductsizenew">
                </a>
            </div>
            <div class="captionnoncom">
                <h5>{{truncate($product->name,15)}}</h5>
                <div class="phoneratting">
                    <div class="star-rating">
                        <span class="fa fa-star" data-rating="1"></span> <span class="fa fa-star" data-rating="2"></span> <span class="fa fa-star" data-rating="3"></span> <span class="fa fa-star" data-rating="4"></span> <span class="fa fa-star-o" data-rating="5"></span>
                    </div>
                </div>
                <a href="{{product_url($pro)}}" title="{{$product->name}}" target="_blank" class="nonpricebtn-product" role="button"> Rs. {{number_format($product->saleprice)}} </a>
            </div>
        </div>
    </div>
@endforeach