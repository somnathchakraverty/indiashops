@extends('v2.master')
@section('title')
    <title> Sitemap - Indiashopps</title>
@endsection
@section('meta_description')
    <meta name="description" content="Complete Indiashopps Sitemap" />
    <meta name="keywords" content="sitemap, indiashopps sitemap, complete indiashopps sitemap" />
    <meta name="robots" content="index, follow" />
    <meta name="author" content="Indiashopps" />
    <link rel="canonical" href="http://www.indiashopps.com/sitemap.html" />
@endsection
@section('breadcrumbs')
    <section style="background-color:#fff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="sub-menu">
                        <li><a href="{{route("home_v2")}}">Home</a> >> Sitemap</li>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('content')
    <div class="container">
        <div class="row PL0">
            <!--<div class="sub-title MT10"> <span>Sitemap</span></div> -->
            <div id="columns">
                @foreach($categories as $category )
                    <div class="pin">
                        <div class="sitemaplink">
                            <div class="haddingnamesitemap">
                            <a href="{{route('category_list',[create_slug($category['category']->name)])}}">
                                <span>
                                    <i class="fa fa-{{config('vendor.category_icons.'.create_slug($category['category']->name))}}"
                                       aria-hidden="true"></i>
                                </span> {{$category['category']->name}}
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