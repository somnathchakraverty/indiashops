@extends('v2.master')
<?php
    $big_cat = ['Shoes','Ethnic Clothing','Clothing', 'Bags', 'Accessories', 'Lingerie & Sleepwear'];

    foreach( $categories as $key => $category )
    {
        if( in_array( $category->name, $big_cat ) )
        {
            $lcategories[] = $category;
            unset($categories[$key]);
        }
    }

    $categories = array_values($categories->toArray());
?>
@section('breadcrumbs')
    <section style="background-color:#fff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="sub-menu">
                        <li><a href="{{route("home_v2")}}">Home</a> >> <a href="#">{{ucwords($c_name)}}</a></li>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@if(isset($meta) && is_object($meta))
@section('meta_description')
    <meta name="description" content="{{$meta->description}}">
@endsection
@elseif(isset($description) && !empty($description))
@section('meta_description')
    <meta name="description" content="{{$description}}">
@endsection
@endif
@if(isset($title))
@section('title')
    <title>{{$title}}</title>
@endsection
@endif
@section('content')
    @foreach( $lcategories as $key => $category )
        @include('v2.category.common.block')
    @endforeach
    <div class="fullbgnewtop">
        <div class="container">
        @foreach( $categories as $category )
            @include('v2.category.common.listblock')
        @endforeach
        </div>
    </div>
    <div class="clearfix"></div>
    @if(isset($list_desc) && isset($list_desc->text))
        <div class="fullbgnewtop">
            <div style="text-align: justify" class="container">
                <div class="whitecolorbg">
                    @if( isset($list_desc->text) )
                        {!! $list_desc->text !!}
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection
@section('script')
<script src="{{asset('assets/v2/')}}/js/modernizr.custom.63321.js"></script>
<script type="text/javascript" src="{{asset('assets/v2/')}}/js/jquery.elastislide.js"></script>
<script type="text/javascript">
    @foreach( $lcategories as $category )
        $( '#carousel-{{create_slug($category->name)}}' ).elastislide({
            autoplay : true,
            autoplaytime : 6000,
            minItems : '{{(isMobile()) ? 1 : 4 }}',
        });
    @endforeach
</script>
@endsection