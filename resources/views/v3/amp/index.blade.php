@extends('v3.amp.master')
@section('head')
    <link rel="canonical" href="{{canonical_url()}}" />
    <meta name="robots" content="index, follow" />
    <meta name="author" content="IndiaShopps" />
@endsection
@section('page_content')
    <!--THE-BANNER-->
    @if( isset($sliders) && !empty($sliders) )
        @include('v3.amp.slider')
    @endif
    <!--END-BANNER-->

    @if(isset($home_content))
        {!! $home_content !!}
    @endif
@endsection