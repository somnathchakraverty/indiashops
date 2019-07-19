@extends('v3.mobile.master')
<style>
.allcategorieslist{margin:10px;padding:0;width:94%;background:#fff;position:relative;display:inline-block;box-shadow:0 1px 3px 0 rgba(0, 0, 0, 0.1);overflow:hidden;}
.allcategorieslist h2{width:100%;float:left;margin:0px;background:#e8e8e8;padding:5px 0px 5px 15px;margin-bottom:10px;}
.allcategorieslist h2 a{ color:#000;}
.allcategorieslist ul{margin:0;padding:0;display:block;}
.allcategorieslist ul li{width:100%;margin:0px;padding:0px;display:inline-block;list-style:none;}
.allcategorieslist ul li a{width:97%;margin:0;color:#6d6d6d;padding:5px;font-size:14px;font-weight:bold;display:inline-block;list-style:none;text-decoration:none;}
</style>
@section('page_content')
    <section>
        <div class="container">
            {!! Breadcrumbs::render() !!}
        </div>
    </section>
    <div class="container">
        <h1>All Categories</h1>
        </div>
        <div class="whitecolorbg">
        <div class="container">       
            <?php $count = 1; ?>
            @foreach($categories as $category)
                <div class="allcategorieslist">
                    <?php $parent_url = newUrl() . create_slug($category['category']->name); ?>
                    <?php
                    $icons = ['' => '',]
                    ?>
                    <h2>
                        <a href="{{$parent_url}}">
                            <span> 
                            &raquo;
                            </span> {{$category['category']->name}}
                        </a>
                    </h2>
                    <?php $childs = count($category['children']); ?>
                    @if( $childs > 0 )
                        <?php $child = 1; ?>
                        <ul>
                            @foreach( $category['children'] as $c_cat )
                                <?php $child_url = $parent_url . "/" . seoUrl(create_slug($c_cat['category']->name)); ?>
                                <li><a href="{{$child_url}}">&raquo; {{$c_cat['category']->name}}</a></li>
                                <?php
                                if ($child == 4) break; else
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
@section('scripts')
    <script src="{{get_file_url('js/front.js')}}" defer></script>
    <script>
        function loadCarousels(){}
        function uiLoaded(){}
    </script>
@endsection