<?php $chunk_products = collect($products)->chunk(8); ?>
@if($chunk_products->count()>0)
    <?php $Category = \indiashopps\Category::find(collect($products)->first()->_source->category_id) ?>
@endif
@extends('v3.amp.master')
@section('head')
    <link rel="canonical" href="{{$canonical}}"/>
    <meta name="robots" content="noindex, nofollow"/>
@endsection
@section('page_content')
    <!--THE-BANNER-->
    @if( isset($sliders) && !empty($sliders) )
        @include('v3.amp.slider', [ 'slider' => collect($sliders)->first() ])
    @endif
    <div class="container">
        {!! Breadcrumbs::render('discontinue_amp', $name) !!}
    </div>
    <!--END-BANNER-->
    <section>
        <div class="whitecolorbg">
            <div class="container">
                <div class="discontinueblock">
                    We're sorry, the product you are looking for has been discontinued. We recommend you to browse
                    through
                    our featured categories
                </div>
            </div>
        </div>
    </section>
    @if(isset($chunk_products) && !empty($chunk_products) && count($chunk_products) > 0 )
        <section>
            <div class="container">
                <h1 class="textcenter">
                    <span>Popular {{$Category->name}}</span>
                </h1>
                <p>{!! app('seo')->getShortDescription() !!}</p>
                <div class="line"></div>
            </div>
        </section>
        <!--END-SECTION-1-->
        <!--THE PRODUCTS-->
        <section>
            <div class="whitecolorbg">
                <div class="container">
                    <amp-carousel class="full-bottom" height="350" layout="fixed-height" type="carousel">
                        @foreach($chunk_products->shift() as $product)
                            @include('v3.common.product.amp.card')
                        @endforeach
                    </amp-carousel>
                </div>
            </div>
        </section>
    @endif
    @if(isset($chunk_products) && !empty($chunk_products) && count($chunk_products) > 0 )
        <!--THE PRODUCTS-->
        <section>
            <div class="whitecolorbg">
                <div class="container">
                    <amp-carousel class="full-bottom" height="350" layout="fixed-height" type="carousel">
                        @foreach($chunk_products->shift() as $product)
                            @include('v3.common.product.amp.card')
                        @endforeach
                    </amp-carousel>
                    <div class="allcateglink">
                        <a href="{{getCategoryUrl($Category)}}">
                            VIEW ALL {{$Category->name}}<i class="fa fa-angle-right right-arrow"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection