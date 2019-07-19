@extends('v3.mobile.master')
@section('seo_meta')
    <meta name="robots" content="index, follow" />
    <meta name="author" content="Indiashopps" />
    <link rel="canonical" href="http://www.indiashopps.com/sitemap.html" />
@endsection
@section('page_content')
    <section>
        <div class="container">
            {!! Breadcrumbs::render() !!}
        </div>
    </section>
    <div class="container">
        <div class="row">           
                @foreach($categories as $category )                   
                        <div class="sitemaplink">
                            <div class="haddingnamesitemap">
                                <a href="{{route('category_list',[create_slug($category['category']->name)])}}">
                                    {{$category['category']->name}}
                                </a>
                            </div>
                            @if(isset($category['children']))
                                @foreach($category['children'] as $child)
                                    <ul>
                                        <li>
                                            <a href="{{route('sub_category',[create_slug($category['category']->name),create_slug($child['category']->name)])}}-price-list-in-india.html">
                                                {{$child['category']->name}}
                                            </a>
                                            @if(isset($child['children']))
                                                @foreach($child['children'] as $child_last)
                                                    <ul>
                                                        <li>
                                                            <a href="{{route('product_list',[create_slug($category['category']->name),create_slug($child['category']->name),create_slug($child_last['category']->name)])}}-price-list-in-india.html">
                                                                {{$child_last['category']->name}}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                @endforeach
                                            @endif
                                        </li>
                                    </ul>
                                @endforeach
                            @endif
                        </div>                   
                @endforeach           
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="{{get_file_url('mobile/js/front.js')}}" defer></script>
    <script>
        function loadCarousels(){}
        function uiLoaded(){}
    </script>
@endsection