@extends('v3.master')
@section('seo_meta')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="fragment" content="!">
    <meta name="ROBOTS" content="noindex">
    <link rel="canonical" href="{{Request::url()}}"/>
@endsection
@if( isset($name) )
@section('title')
    <title>{{$name}}</title>
@endsection
@section('meta_description')
    <meta name="description" content="{{$name}}"/>
@endsection
@endif
@section('page_content')
    <div class="container">
        <div class="discontinueblock">
            We're sorry, the product you are looking for has been discontinued. We recommend you to browse through
            our featured categories
        </div>

        @if(count($products) > 0)
            <div class="trendingdeals">
            <h2>Popular {{collect($products)->first()->_source->category}}</h2>
            <div class="catgprofullbox">
                @foreach($products as $key => $p )
                    <?php $product = $p->_source; ?>
                    <?php
                    if (!empty(json_decode($product->image_url))) {
                        $images = json_decode($product->image_url);
                    } else {
                        $images[0] = $product->image_url;
                    }
                    ?>
                    @include('v3.common.product.card2')
                    @if( $key >= 7 )
                        <?php break; ?>
                    @endif
                    <?php unset($products[$key]) ?>
                @endforeach
            </div>
             </div>
        @endif
        <?php $products = array_values(array_filter($products));?>
        @if(count($products) > 0)
            <div class="trendingdeals">
                <h2>Popular {{collect($products)->first()->_source->parent_category}}</h2>
            <div class="catgprofullbox">
                @foreach($products as $key => $p )
                    <?php $product = $p->_source; ?>
                    <?php
                    if (!empty(json_decode($product->image_url))) {
                        $images = json_decode($product->image_url);
                    } else {
                        $images[0] = $product->image_url;
                    }
                    ?>
                    @include('v3.common.product.card2')
                    @if( $key >= 7 )
                        <?php break; ?>
                    @endif
                    <?php unset($products[$key]) ?>
                @endforeach
            </div>
            </div>
        @endif
    </div>
@endsection
@section('scripts')
<style>
.thumnail{width:240px!important;}
.thumnail:hover{width:240px!important;}
</style>
@endsection