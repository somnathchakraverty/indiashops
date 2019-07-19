@extends('v2.master')
@section('breadcrumbs')
    <section style="background-color:#fff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="sub-menu">
                        <li><a href="{{route("home_v2")}}">Home</a> >>  <a href="#">About US</a> </li>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('title')
    <title>All Categories List - Indiashopps</title>
@endsection
@section('meta_description')
    <meta name="description" content="Indiashopps Categories List - Browse and Compare List of all categories with their prices, features and specification in india" />
@endsection
@section('content')
    <div class="container">
        <div class="row PL0">
            <div class="sub-title MT10"> <span>All Categories</span></div>
            <?php $count = 1; ?>
            @foreach($categories as $category)
                <div class="allcategorieslist">
                    <?php $parent_url = newUrl().create_slug( $category['category']->name ); ?>
                    <?php
                        $icons = [ '' => '', ]
                    ?>
                    <h2>
                        <a href="{{$parent_url}}">
                            <span>
                                <i class="fa fa-{{config('vendor.category_icons.'.create_slug($category['category']->name))}}" aria-hidden="true"></i>
                            </span> {{$category['category']->name}}
                        </a>
                    </h2>
                    <?php $childs = count($category['children']); ?>
                    @if( $childs > 0 )
                    <?php $child = 1; ?>
                    <ul>
                        @foreach( $category['children'] as $c_cat )
                            <?php $child_url = $parent_url."/".seoUrl(create_slug( $c_cat['category']->name )); ?>
                            <li><a href="{{$child_url}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> {{$c_cat['category']->name}}</a></li>
                            <?php
                            if( $child == 4 )
                                break;
                            else
                                $child++;
                            ?>
                        @endforeach
                        <li><a href="{{$parent_url}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> View All</a></li>
                    </ul>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection