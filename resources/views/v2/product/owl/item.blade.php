@foreach($products as $pro)
    <div class="item">
        <div class="thumbnail">
            <?php $product = $pro->_source; ?>
            <a target="_blank" title="{{$product->name}}" href="{{product_url($pro)}}"> <img alt="{{$product->name}}" title="{{$product->name}}" src="{{getImageNew($product->image_url,'S')}}" class="productmobimlefttop"> </a>
            <div class="caption"> <a target="_blank" title="{{$product->name}}" href="{{product_url($pro)}}">
                    <h5>{{truncate($product->name,15)}}</h5>
                </a>
                <div class="phoneratting">
                    <div class="star-rating"> <span class="fa fa-star" data-rating="1"></span> <span class="fa fa-star" data-rating="2"></span> <span class="fa fa-star" data-rating="3"></span> <span class="fa fa-star" data-rating="4"></span> <span class="fa fa-star-o" data-rating="5"></span> </div>
                </div>
                <p>
                <!--<a href="{{product_url($pro)}}" class="btn btn-primary btn-product-primary " role="button">View</a>-->
                    <a href="{{product_url($pro)}}" title="{{$product->name}}" target="_blank" class="btn btn-default btn-product" role="button"> Rs. {{number_format($product->saleprice)}} </a> </p>
            </div>
        </div>
    </div>
@endforeach