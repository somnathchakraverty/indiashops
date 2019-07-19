<?php
$prod = new \stdClass;
$prod->cat = $category_id;
$prod = Crypt::encrypt(($prod));
?>
@extends('v3.mobile.master')
@section('page_content')
    <?php $slider = $sliders->first(); ?>
    @if(!is_null($slider))
        <div class="banner">
            @if(isset($slider->refer_url) && filter_var($slider->refer_url,FILTER_VALIDATE_URL))
                <a href="{{$slider->refer_url}}" target="_blank">
                    <img class="img-responsive" src="{{$slider->image_url}}" alt="{{$slider->alt}}">
                </a>
            @else
                <img class="img-responsive" src="{{$slider->image_url}}" alt="{{$slider->alt}}">
            @endif
        </div>
    @endif
    <section>
        <div class="container">
            {!! Breadcrumbs::render() !!}
        </div>
    </section>   
        <div class="container more_content_wrapper">
            <h1>{!! app('seo')->getHeading() !!}</h1>
            <div class="more-less-product1 small">
                {!! app('seo')->getShortDescription() !!}
            </div>
            <a href="javascript:void(0)" class="moreproduct">Read More <span>&rsaquo;</span></a>
        </div>   
    @foreach( $childs as $child_key => $child )
            <section id="category_widget_{{$child_key}}">
                <?php
                $data = $child->getProducts();
                ?>
                @include('v3.mobile.ajax.category')
            </section>
    @endforeach
@endsection
@section('scripts')
    <script type="text/javascript">
        var form_data = {_token: '{{csrf_token()}}', product: '{{$prod}}'};
        function uiLoaded() {}
        document.addEventListener('jquery_loaded', function (e) {
            $(document).on('click', 'a', function () {
                if ($(this).attr('href').indexOf("#") == -1 && $(this).attr('href').length > 0)
                    window.location.href = $(this).attr('href');
            });
        });
    </script>
@endsection