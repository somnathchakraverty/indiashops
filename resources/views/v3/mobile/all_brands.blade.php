@extends('v3.mobile.master')
<style>
    .allcategorieslist { margin: 10px; padding: 0; width: 94%; background: #fff; position: relative; display: inline-block; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1); overflow: hidden; }
    .allcategorieslist h2 { width: 100%; float: left; margin: 0px; background: #e8e8e8; padding: 5px 0px 5px 15px; margin-bottom: 10px; }
    .allcategorieslist h2 a { color: #000; }
    .allcategorieslist ul { margin: 0; padding: 0; display: block; }
    .allcategorieslist ul li { width: 100%; margin: 0px; padding: 0px; display: inline-block; list-style: none; }
    .allcategorieslist ul li a { width: 97%; margin: 0; color: #6d6d6d; padding: 5px; font-size: 14px; font-weight: bold; display: inline-block; list-style: none; text-decoration: none; }
    select { width: 100%; background-color: #fff; padding: 10px }
</style>
@section('page_content')
    <section>
        <div class="container">
            {!! Breadcrumbs::render() !!}
        </div>
    </section>
    <div class="container">
        <h1>{{config('all_brands.'.$category.'.text')}} Brands</h1>
    </div>
    @php
        $keys = [
            'price' => 'Mobile Price List - By Price',
            'feature' => 'Mobile Price List - By Features',
            'mix' => 'Mobile Other Price List',
            'upcoming' => 'Upcoming Mobiles'
        ]
    @endphp
    <div class="container" style="text-align: center">
        <select id="brand_letters" class="form-control">
            <option value="all">All</option>
            @foreach($brands as $g => $g_brands)
                <option value="{{cs($g)}}">{{ucwords($g)}}</option>
            @endforeach
            @foreach($links as $key => $l)
                <option value="{{cs($keys[$key])}}">{{$keys[$key]}}</option>
            @endforeach
        </select>
    </div>
    <div class="whitecolorbg">
        <div class="container">
            @foreach($brands as $g => $g_brands)
                <div class="allcategorieslist" id="{{cs($g)}}">
                    <h2>
                        <a href="javascript:void(0)">
                            {{strtoupper($g)}}
                        </a>
                    </h2>
                    <?php $childs = count($g_brands); ?>
                    @if( $childs > 0 )
                        <?php $child = 1; ?>
                        <ul>
                            @foreach( $g_brands as $brand )
                                <?php $brand_url = route('brands.listing', [
                                        cs($group),
                                        cs($brand),
                                        cs($category)
                                ]) ?>
                                <li>
                                    <a href="{{$brand_url}}">
                                        {{ucwords($brand)}} {{ucwords($category)}} Price List
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
            @foreach($links as $key => $l)
                <div class="allcategorieslist" id="{{cs($keys[$key])}}">
                    <h2>
                        <a href="javascript:void(0)">
                            {{$keys[$key]}}
                        </a>
                    </h2>
                    <?php $count = count($l); ?>
                    @if( $count > 0 )
                        <ul>
                            @foreach( $l as $link )
                                <li>

                                    <a href="{{$link->get('link')}}">
                                        {{$link->get('text')}}
                                    </a>
                                </li>
                            @endforeach
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
        function loadCarousels() {}
        function uiLoaded() {}
        function restJsLoaded() {
            $(document).on('change', "#brand_letters", function () {
                var id = $(this).val();

                if (id == 'all') {
                    $(".allcategorieslist").fadeIn();
                }
                else {
                    $(".allcategorieslist").fadeOut('fast');
                    setTimeout(function () {
                        $("#" + id).fadeIn();
                    }, 200);
                }
                return false;
            });
        }
    </script>
@endsection