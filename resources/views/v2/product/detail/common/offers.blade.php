<?php $index = 0 ?>
<?php $product = $data->similar_prod->hits->hits; ?>
@foreach($product as $pro)
    <?php $product = $pro->_source; $index++; ?>
    @if( ($index)%6 == 1 )
        <div class="item {{( $index == 1) ? 'active' : '' }}"> @endif
            @if( ($index)%2 == 1 )
                {!! '<div class="row">' !!}
            @endif
            <div class="col-sm-6">
                <div class="gray-border shadow-box MT0 boxsizefixed">
                    <div class="center-imgpro">
                        <a href="{{product_url($pro)}}">
                            <img alt="100%x200" src="{{getImageNew($product->image_url,'S')}}" class="offersboximgsizenew"/>
                        </a>
                    </div>
                    <aside class="PT15 ML0 contbottomfixed">
                        <a href="{{product_url($pro)}}" class="font-12 contnormelrightpart"> {{$product->name}} </a>
                        <div class="phoneratting2">
                            <div class="star-rating">
                                <span class="fa fa-star" data-rating="1"></span>
                                <span class="fa fa-star" data-rating="2"></span>
                                <span class="fa fa-star" data-rating="3"></span>
                                <span class="fa fa-star" data-rating="4"></span>
                                <span class="fa fa-star-o" data-rating="5"></span>
                            </div>
                        </div>
                        <span class="price font-12">Rs.{{number_format($product->saleprice)}}</span>
                    </aside>
                </div>
            </div>
            @if( ($index)%2 == 0 )
        </div>
    @endif
    @if( ($index)%6 == 0 )
        {!! '</div>' !!}
    @endif
@endforeach
@if( ($index)%2 != 0)
    {!! '</div>' !!}
@endif
@if( ($index)%6 != 0)
    {!! '</div>' !!}
@endif