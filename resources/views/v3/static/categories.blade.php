@extends('v3.master')
@section('page_content')
    <div class="container">
        {!! Breadcrumbs::render() !!}
    </div>
    <div class="container">
    <div class="headdingcat"><h1>All Categories</h1></div>
        <div class="catgprofullbox">            
            <?php $count = 1; ?>
            @foreach($categories as $category)
                <div class="allcategorieslist">
                    <?php $parent_url = newUrl().create_slug( $category['category']->name ); ?>
                    <?php
                    $icons = [ '' => '', ]
                    ?>
                    <h2>
                        <a href="{{$parent_url}}">
                            <span>&raquo;</span> {{$category['category']->name}}
                        </a>
                    </h2>
                    <?php $childs = count($category['children']); ?>
                    @if( $childs > 0 )
                        <?php $child = 1; ?>
                        <ul>
                            @foreach( $category['children'] as $c_cat )
                                <?php $child_url = $parent_url."/".seoUrl(create_slug( $c_cat['category']->name )); ?>
                                <li><a href="{{$child_url}}">&raquo; {{$c_cat['category']->name}}</a></li>
                                <?php
                                if( $child == 4 )
                                    break;
                                else
                                    $child++;
                                ?>
                            @endforeach
                            <li><a href="{{$parent_url}}">&raquo; View All</a></li>
                        </ul>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection