@extends('v2.master')
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
@section('meta')
    {!! canonical_url_list() !!}
@endsection
@section('content')
    <div id="cate-wrap">
        <div class="container MT15">
            <div class="col-md-3">
                <div class="sticky-scroll-boxcat">
                    <div class="sub-title"><span>categories</span></div>
                    <div class="shadow-boxcat" style="margin-top:-10px;">
                        <ul class="nav-left">
                            @foreach($categories as $c)
                                <li class="active"><a href="#category{{$c->id}}" class="ssmooth">{{$c->name}} </a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9" id="right-container">
                @if(isset($list_desc) && isset($list_desc->h1))
                    <div class="row whitecolorbglistpage">
                        <h1>{{ $list_desc->h1  }}</h1>
                    </div>
                @endif
                <div class="product-listingbanner">
                    @if( isset($slider[0]->refer_url) && !empty($slider[0]->refer_url) )
                        <a href="{{$slider[0]->refer_url}}" alt="{{$slider[0]->alt}}">
                            <img class="img-responsive" src="{{$slider[0]->image_url}}"/>
                        </a>
                    @else
                        <img class="img-responsive" src="{{$slider[0]->image_url}}">
                    @endif
                </div>
                @foreach( $categories as $c )
                    <div class="sub-title titlecat MT10" id="category{{$c->id}}"><a
                                href="{{route('sub_category',[$cat_name,create_slug($c->name)])}}-price-list-in-india.html">
                            <span>{{$c->name}}</span> </a></div>
                    @if($c->children->isNotEmpty())
                        @foreach( $c->children as $category )
                            <div class="col-md-6">
                                <div class="categories_list_box">
                                    <div class="pull-left MR15"><a
                                                href="{{route('product_list',[$cat_name,create_slug($c->name),create_slug($category->name)])}}-price-list-in-india.html">
                                            <img alt="100%x200" src="{{$category->image}}"
                                                 style="width:60px;margin-right:10px;" class="PR10"/> </a></div>
                                    <aside>
                                        <a href="{{route('product_list',[$cat_name,create_slug($c->name),create_slug($category->name)])}}-price-list-in-india.html">
                                            <h4 class="MB10">{{$category->name}}</h4>
                                        </a> @if(isset($cat_brands))
                                            <ul class="categories-listingnew MT0">
                                                @if(isset($cat_brands->{$category->id}))
                                                    @foreach($cat_brands->{$category->id} as $brand)
                                                        <?php $brand_url = route('brand_category_list', [
                                                                create_slug($brand),
                                                                create_slug($category->group_name),
                                                                create_slug($category->name)
                                                        ]); ?>
                                                        <li><a href="{{$brand_url}}" class="black-link"
                                                               title="{{$brand}}"><i class="fa fa-check"
                                                                                     aria-hidden="true"></i> {{truncate($brand,18)}}
                                                            </a></li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        @endif </aside>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-6">
                            <div class="categories_list_box">
                                <div class="pull-left MR15"><a
                                            href="{{route('sub_category',[$cat_name,create_slug($c->name)])}}-price-list-in-india.html">
                                        <img alt="100%x200" src="{{$c->image}}" style="width:60px;margin-right:10px;"
                                             class="PR10"/> </a></div>
                                <aside>
                                    <a href="{{route('sub_category',[$cat_name,create_slug($c->name)])}}-price-list-in-india.html">
                                        <h4 class="MB10">{{$c->name}}</h4>
                                    </a>
                                </aside>
                            </div>
                        </div>
                    @endif
                @endforeach </div>
            <div class="clearfix"></div>
            @if(isset($list_desc) && isset($list_desc->text))
                <div style="text-align: justify">
                    @if( isset($list_desc->text) )
                        {!! $list_desc->text !!}
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection
@section('script')
    <style>
        .titlecat a {
            color: #fff;
        }

        .titlecat a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        var isExitPopupPage = true;
        var page = 'home_page';
        $(document).ready(function () {
            var top = $('.sticky-scroll-boxcat').offset().top;
            $(window).scroll(function (event) {
                var y = $(this).scrollTop();
                if (y >= top && y <= ($("#right-container").height() - $("#sticky-header").height() - 40)) {
                    $('.sticky-scroll-boxcat').addClass('fixedcat');
                } else {
                    $('.sticky-scroll-boxcat').removeClass('fixedcat');
                }
                $('.sticky-scroll-boxcat').width($('.sticky-scroll-boxcat').parent().width());
            });
        });
    </script>
@endsection