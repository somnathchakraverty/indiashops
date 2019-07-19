@extends('v3.master')
@section('head')
    <meta name="robots" content="index, follow"/>
    <meta name="author" content="IndiaShopps"/>
    <link rel="amphtml" href="{{route('amp.home')}}"/>
@endsection
@section('page_content')
    <section class="split_banner">
        @include('v3.home.slider')
    </section>
    @if(isset($home_content))
        {!! $home_content !!}
    @endif
@endsection
@section('scripts')
    <script>
        var home_ajax_url = '{{route('v3_ajax_home')}}';

        function loadRestJS() {
            $.fn.CONTENT.uri = home_ajax_url;
            $.fn.CONTENT.load('trending_of_the_day', true);
        }
        function bootstrapLoaded() {
            $('#myCarousel').on('slide.bs.carousel', function () {
                $(this).find(".active img").lazyLoadXT();
            });
        }
    </script>
@endsection