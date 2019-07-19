@foreach( $product as $single )
    @if( isPricelist($single->_source->category_id) )
        <?php $isComparative = true; break; ?>
    @endif
@endforeach
@foreach( $product as $single )
<?php
    $pro    = $single->_source;
    $imgsize= imageSizeByCategory($pro->category_id);
    $img    = getImageNew($pro->image_url,$imgsize);
    $proURL = product_url($single);
    $comparative = false;
    $class = (isset($_COOKIE['product-list-style']) && $_COOKIE['product-list-style'] == 'list' ) ? 'list-group-item' : 'grid-group-item';
    $pclass= ($isComparative) ? 'comp-detailimsize' : 'non-comp-detailimsize';
?>
<div class="item col-md-4 {{$class}}">
    <div class="thumbnaillistpro">
        <div class="probox">
        <div class="productimageboxlist">
            <a href="{{$proURL}}">
                <img alt="{{$pro->name}}" src="{{$img}}" class="{{$pclass}}" style="margin-bottom:15px;" onerror="imgError(this)"/>
            </a>
            </div>
            <div class="caption">
                <h4 class="group inner list-group-item-heading product-headingnew">
                    <a href="{{$proURL}}" data-toggle="tooltip" title="{{$pro->name}}">
                        {{$pro->name}}
                    </a>
                </h4>
                @if(isset($pro->mini_spec) && ( isPricelist($pro->category_id) ) )
                    <?php $spec = getMiniSpec($pro->mini_spec) ?>
                   
                    <div class="descriptionprodlist">
                    <ul>
                        {!! $spec !!}
                    </ul>
                    </div>
                @endif
                <div class="starratingnew">
                    <div class="starpro">
                    <a href="#" class="pull-center">
                     <i class="fa fa-star rating" aria-hidden="true"></i></a>
                            <i class="fa fa-star rating" aria-hidden="true"></i></a>
                            <i class="fa fa-star rating" aria-hidden="true"></i></a>
                            <i class="fa fa-star rating" aria-hidden="true"></i></a>
                            <i class="fa fa-star-half-o rating" aria-hidden="true"></i></a>
                    </div>
                    <p class="lead pricepro">
                        @if($pro->saleprice>0)
                            Rs. {{number_format( $pro->saleprice )}}
                        @else
                            N/A
                        @endif
                    </p>
                    <?php if( !empty( $pro->discount ) ): ?>
                        <span class="label label-success product-disc"><?=$pro->discount?>% OFF</span><br/><br/>
                    <?php endif; ?>
                    @if( isPricelist($pro->category_id) && !$isMobile )
                        <?php $comparative = true; ?>
                        <a class="btn btn-success" href="javascript:void" style="margin-top:-10px;">
                            <label>
                                <input type="checkbox" cat="{{$pro->category_id}}" prod-id="{{$pro->id}}" class="add-to-compare" style="margin:4px 5px 0px 0px;float:left;">Add to Compare</label>
                        </a>
                    @else
                        <a class="btn btn-success" href="{{$proURL}}" style="margin-top:-10px;">
                            <label> View Detail </label>
                        </a>
                    @endif
                </div>
               
            </div>
        </div>
    </div>
</div>
@endforeach
