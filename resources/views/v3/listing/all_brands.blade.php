@extends('v3.master')
@section('page_content')
    <div class="container">
        {!! Breadcrumbs::render() !!}
    </div>
    <div class="container">
        <div class="headdingcat">
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
        <div style="text-align:center;background:#fff;padding:0px;margin-top:20px;border-radius:5px;">
            <ul class="pagination">
                <li class="page-item"><a class="page-link all_brands" href="#all">All</a></li>
                @foreach($brands as $g => $g_brands)
                    <li class="page-item"><a class="page-link single_brand" href="#{{cs($g)}}">{{ucwords($g)}}</a></li>
                @endforeach
                @foreach($links as $key => $l)
                    <li class="page-item">
                        <a class="page-link single_brand" href="#{{cs($keys[$key])}}">{{$keys[$key]}}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="container">
            <div class="row">
                <div id="columns">
                    @foreach($brands as $g => $g_brands)
                        <div class="pin" id="{{cs($g)}}">
                            <div class="sitemaplink">
                                <div class="haddingnamesitemap">
                                    <a href="javascript:void(0)">
                                        {{strtoupper($g)}}
                                    </a>
                                </div>
                                <?php $childs = count($g_brands); ?>
                                @if( $childs > 0 )
                                    @foreach( $g_brands as $brand )
                                        <ul>
                                            <li>
                                                <?php $brand_url = route('brands.listing', [
                                                        cs($group),
                                                        cs($brand),
                                                        cs($category)
                                                ]) ?>
                                                <a href="{{$brand_url}}">
                                                    {{ucwords($brand)}} {{ucwords($category)}} Price List
                                                </a>
                                            </li>
                                        </ul>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @foreach($links as $key => $l)
                        <div class="pin" id="{{cs($keys[$key])}}">
                            <div class="sitemaplink">
                                <div class="haddingnamesitemap">
                                    <a href="javascript:void(0)">
                                        {{$keys[$key]}}
                                    </a>
                                </div>
                                <?php $count = count($l); ?>
                                @if( $count > 0 )
                                    @foreach( $l as $link )
                                        <ul>
                                            <li>
                                                <a href="{{$link->get('link')}}">
                                                    {{$link->get('text')}}
                                                </a>
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
    </div>
@endsection
@section('scripts')
    <style>
        .sitemaplink ul{ clear:both }
        .pagination > li > a, .pagination > li > span { padding: 6px 6px !important; font-size: 16px !important; font-weight: bold !important; color: #000 !important; }
        .pagination { margin: 10px 0px 3px 0px !important; }
		#columns{margin-top:30px;}
		.haddingnamesitemap a{padding:0px 0px 0px 10px; margin:0px;}
		.sitemaplink{min-height:100px;}
    </style>
    <script src="{{get_file_url('js/front.js')}}" defer></script>
    <script>
        function loadRestJS() {
            $(document).on('click', ".single_brand, .all_brands", function () {
                var id = $(this).attr('href');
                var block_id = $(id).attr('id');

                if (typeof block_id == 'undefined') {
                    $(".pin").fadeIn();
                }
                else {
                    $(".pin").fadeOut('fast');
                    setTimeout(function () {
                        $(id).fadeIn();
                    }, 200);
                }
                return false;
            });
        }
    </script>
@endsection