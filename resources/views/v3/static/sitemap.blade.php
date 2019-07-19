@extends('v3.master')
@section('seo_meta')
    <meta name="robots" content="index, follow" />
    <meta name="author" content="Indiashopps" />
@endsection
@section('page_content')
    <div class="container">
        {!! Breadcrumbs::render() !!}
    </div>
    <div class="container">
        <div class="row">            
            <div id="columns">
                @foreach($categories as $category )
                    <div class="pin">
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
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('footer_links')

@endsection