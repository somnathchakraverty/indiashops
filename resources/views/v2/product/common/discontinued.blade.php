@extends('v2.master')
@section('meta')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="fragment" content="!">
    <meta name="ROBOTS" content="noindex">
    <link rel="canonical" href="{{Request::url()}}" />
@endsection
@if( isset($name) )
    @section('title')
        <title>{{$name}}</title>
    @endsection
    @section('meta_description')
        <meta name="description" content="{{$name}}" />
    @endsection
@endif
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="discontinueblock">
                We're sorry, the product you are looking for has been discontinued. We recommend you to browse through
                our featured categories
            </div>
        </div>
        <div class="row">
            @if(count($products) > 0)
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="sub-title"><span>Popular {{collect($products)->first()->_source->category}}</span></div>
                </div>
                @foreach($products as $key => $p )
                    <?php $product = $p->_source; ?>
                    <?php
                    if (!empty(json_decode($product->image_url))) {
                        $images = json_decode($product->image_url);
                    } else {
                        $images[0] = $product->image_url;
                    }
                    ?>
                    <div class="col-md-3">
                        <div class="thumbnail thumbnaildis">
                            <a href="{{product_url($p)}}" title="{{$product->name}}">
                                <img class="productmobimleft2" alt="{{$product->name}} Image" title="{{$product->name}}"
                                     src="{{$images[0]}}" onerror="imgError(this)">
                            </a>
                            <div class="caption">
                                <a href="{{product_url($p)}}" title="{{$product->name}}">
                                    <h5>{{truncate($product->name,30)}}</h5>
                                </a>
                                <div class="phoneratting">
                                    <div class="star-rating">
                                        <?php
                                        $repeat = rand(3, 5);
                                        $star = '<span class="fa fa-star"></span>';
                                        $starb = '<span class="fa fa-star-o"></span>';

                                        echo str_repeat($star, $repeat);
                                        echo str_repeat($starb, (5 - $repeat));
                                        ?>
                                    </div>
                                </div>
                                <p><a href="#" class="btn btn-default btn-product" role="button">
                                        Rs. {{number_format($product->saleprice)}} </a></p>
                            </div>
                        </div>
                    </div>
                    @if( $key >= 7 )
                        <?php break; ?>
                    @endif
                    <?php unset($products[$key]) ?>
                @endforeach
            </div>
            @endif
            <?php $products = array_values(array_filter($products));?>
            @if(count($products) > 0)
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="sub-title">
                        <span>Popular {{collect($products)->first()->_source->parent_category}}</span></div>
                </div>
                @foreach($products as $key => $p )
                    <?php $product = $p->_source; ?>
                    <?php
                    if (!empty(json_decode($product->image_url))) {
                        $images = json_decode($product->image_url);
                    } else {
                        $images[0] = $product->image_url;
                    }
                    ?>
                    <div class="col-md-3">
                        <div class="thumbnail thumbnaildis">
                            <a href="{{product_url($p)}}" title="{{$product->name}}">
                                <img class="productmobimleft2" alt="{{$product->name}} Image" title="{{$product->name}}"
                                     src="{{$images[0]}}" onerror="imgError(this)">
                            </a>
                            <div class="caption">
                                <a href="{{product_url($p)}}" title="{{$product->name}}">
                                    <h5>{{truncate($product->name,30)}}</h5>
                                </a>
                                <div class="phoneratting">
                                    <div class="star-rating">
                                        <?php
                                        $repeat = rand(3, 5);
                                        $star = '<span class="fa fa-star"></span>';
                                        $starb = '<span class="fa fa-star-o"></span>';

                                        echo str_repeat($star, $repeat);
                                        echo str_repeat($starb, (5 - $repeat));
                                        ?>
                                    </div>
                                </div>
                                <p><a href="#" class="btn btn-default btn-product" role="button">
                                        Rs. {{number_format($product->saleprice)}} </a></p>
                            </div>
                        </div>
                    </div>
                    @if( $key >= 7 )
                        <?php break; ?>
                    @endif
                    <?php unset($products[$key]) ?>
                @endforeach
            </div>
            @endif
        </div>
    </div>
@endsection