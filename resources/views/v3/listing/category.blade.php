<?php

$prod = new \stdClass;
$prod->cat = $category_id;
$prod = Crypt::encrypt(($prod));
?>
@extends('v3.master')
@section('head')
    <link rel="amphtml" href="{{route('amp.category_list',[$cat_name])}}"/>
@endsection
@section('page_content')
    @if(isset($sliders) && $sliders->count() > 0)
        <div class="banner">
            <div id="slide-banner" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($sliders as $key => $slide)
                        <div class="item {{($key==0) ? 'active' : ''}}">
                            @if( isset($slide->refer_url) && !empty($slide->refer_url) )
                                <a href="{{$slide->refer_url}}" target="_blank">
                                    <img class="silider100" src="{{$slide->image_url}}" alt="{{$slide->alt}}">
                                </a>
                            @else
                                <img class="silider100" src="{{$slide->image_url}}" alt="{{$slide->alt}}">
                            @endif
                        </div>
                    @endforeach
                </div>
                <!-- Left and right controls -->
                <a class="left carousel-control" href="#slide-banner" data-slide="prev">
                    <div class="chevron-left"></div>
                <!--<img class="glyphicon glyphicon-chevron-right chevron-left" src="{{secureAssets('assets/v3/')}}/images/arrow-left-new.png" alt="arrow">-->
                    <span class="sr-only">Previous</span> </a>
                <a class="right carousel-control" href="#slide-banner" data-slide="next">
                    <div class="chevron-right"></div>
                    <span class="sr-only">Next</span> </a></div>
        </div>
    @endif

    <div class="container">
        {!! Breadcrumbs::render() !!}
    </div>

    <div class="container trendingdeals">
        <h1>{!! app('seo')->getHeading() !!}</h1>
        <div class="normelcont">
            {!! app('seo')->getShortDescription() !!}
        </div>
    </div>
    @foreach( $childs as $child_key => $child )
        <section id="category_widget_{{$child_key}}">
            <div class="container trendingdeals">
                <?php
                $data = $child->getProducts();
                ?>
                @include('v3.listing.ajax.category')
            </div>
        </section>

    @endforeach

@endsection
@section('scripts')
    <script>
        function loadCarousel() {}

        var form_data = {_token: '{{csrf_token()}}', product: '{{$prod}}'};

        function frontJsLoaded() {
            CONTENT.uri = '{{route('listing-ajax-v3')}}';
        }
    </script>

@endsection