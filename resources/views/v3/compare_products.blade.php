@extends("v3.master")
@php
    if(isset($keys))
    {
        $keys = collect($keys);
        $fkeys = $keys->slice(0, 4);
        $rkeys = $keys->slice(4);
        $products = collect($products);
    }
    else
    {
        $products = [];
    }
@endphp
@section('head')
    @if(hasOneUpcomingProduct($products) )
        <meta name="robots" content="index, follow"/>
    @else
        <meta name="ROBOTS" content="noindex, nofollow">
    @endif
@endsection
@section('page_content')
    <section>
        <div class="container">
            {!! Breadcrumbs::render() !!}
        </div>
    </section>
    @if(isset($error))
        <div class="col-md-12 PL0">
            <div class="shadow-box">
                <div class="alert alert-danger">
                    <?=$error?>
                </div>
            </div>
        </div>
    @else
        <section>
            <div class="container haddingsize">
                <h1>{{app('seo')->getHeading()}}</h1>
                <div class="normelcont">{!! app('seo')->getShortDescription() !!}</div>
                <div class="reviewscartbox">
                    <div class="col-md-3 pleft">
                        <div class="compareboxleft">
                            <h2>COMPARE BY</h2>
                            <div class="listcomparecatnew">
                                <ul>
                                    @foreach($fkeys as $key => $values)
                                        <li>
                                            <a href="#{{create_slug($key)}}">{!! html_entity_decode($key) !!}
                                                <span class="arrowcom">&rsaquo;</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <select class="comparemore gotto">
                                <option value="">MORE</option>
                                @foreach($rkeys as $key => $values)
                                    <option value="{{create_slug($key)}}">
                                        {!! html_entity_decode($key) !!}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <?php $ids = [];?>
                    @foreach($products as $product)
                        <?php $product = $product['details']; ?>
                        <?php $ids[] = $product->id; ?>
                        <div class="col-md-3 pleft pright">
                            <div class="thumnailcomparepage">
                                <div class="closebutcom">
                                    @if(!isset($manual_compare))
                                        <a href="#" data-cat="{{$product->category_id}}" data-prod-id="{{$product->id}}" class="remove_from_compare">
                                            <span class="glyphicon glyphicon-remove">x</span>
                                        </a>
                                    @endif
                                </div>
                                <div class="thumnailimgboxcompare">
                                    <a href="{{product_url_real($product)}}" target="_blank">
                                        <img class="comparepagproductimg" src="{{getImageNew($product->image_url,'S')}}" alt="{{$product->name}} Image">
                                    </a>
                                </div>
                                <div class="stats-containercompare">
                                    <a class="product_name" href="{{product_url_real($product)}}" target="_blank">{{$product->name}}</a>
                                    <div class="str-rtg">
                                        <span style="width:81%" class="str-ratg"></span>
                                    </div>

                                    <div class="product_price">Rs {{number_format($product->saleprice)}}
                                        @if( !empty($product->price) && $product->price > $product->saleprice )
                                            <span>Rs {{number_format($product->price)}}</span>
                                        @endif
                                    </div>
                                </div>
                                @if(!empty($product->lp_vendor))
                                    <a href="{{$product->product_url}}" target="_blank" class="productgotocompare">Buy
                                        on {{config('vendor.name.'.$product->lp_vendor)}}</a>
                                @endif
                            </div>
                        </div>
                        <?php $category_id = $product->category_id; $category_name = $product->category; ?>
                    @endforeach
                    @if( !isset($manual_compare) && $products->count() < 3 )
                        <div class="col-md-3 pleft pright">
                            <div class="thumnailcomparepage border-right">
                                <div class="addamobile">Add {{unslug($category_name)}}</div>
                                <select class="comparemorebrandcom add_compare_brand" category="{{$category_id}}">
                                    <option value="">---SELECT BRAND---</option>
                                </select>
                                <select class="comparemorebrandcom comparestickynone add_compare_model">
                                    <option value="">---SELECT---</option>
                                </select>
                                <a href="javascript:boi" class="addtocomparebuttonright">Add to Compare</a></div>
                        </div>
                    @endif
                    @if( isset($manual_compare) )
                        <button class="productgotocompare add_more_products" data-ids="{{implode(",",$ids)}}">
                            Add more {{unslug($category_name)}}
                        </button>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            @foreach($keys as $section => $features)
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="{{create_slug($section)}}">
                                        <h4 class="panel-title">
                                            <a role="button" class="tabfontsizecompare" data-toggle="collapse" data-parent="#accordion" href="#collapse{{create_slug($section)}}" aria-expanded="true">
                                                <div class="plusicon">
                                                    <i class="more-less glyphicon glyphicon-minus"></i>
                                                </div>
                                                {{html_entity_decode($section)}}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse{{create_slug($section)}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="{{create_slug($section)}}">
                                        <div class="panel-body">
                                            <table class="table table-bordered tablecompare">
                                                <tbody>
                                                <?php $j = 0 ?>
                                                @foreach( $features as $key => $value )
                                                    <tr class="{{( $j++ % 2 == 0 ) ? 'tablebgcom' : ''}}">
                                                        <th class="tablebgcom1">{{$key}}</th>
                                                        @for( $i = 0; $i <count($products); $i++ )
                                                            <td>
                                                                @if( array_key_exists( $section, @$products[$i]['features']) )
                                                                    @if( array_key_exists( $key, @$products[$i]['features'][$section]) )
                                                                        {!! $products->get($i)['features'][$section][$key] !!}
                                                                    @else
                                                                        --
                                                                    @endif
                                                                @else
                                                                    --
                                                                @endif
                                                            </td>
                                                        @endfor
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="similar_compare_wrapper">
            <div class="container">
                <div class="trendingdeals">
                    <h2>Similar Comaprisons</h2>
                </div>
                <div>
                    <!-- Nav tabs -->
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="Phonecompar">
                            <div class="trending-comparison" id="similar_compare"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--THE-STICKY-->
        <div class="container">
            <select-catlist>
                <div class="comparestickyfullbox">
                    <div class="col-md-3 pleft">
                        <div class="comparestickyleftpart">
                            <h2>COMPARE BY</h2>
                            <select class="comparestickyjump gotto">
                                <option value="">Jump to</option>
                                @foreach($keys as $key => $v)
                                    <option value="{{create_slug($key)}}">
                                        {!! html_entity_decode($key) !!}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @foreach($products as $product)
                        <div class="col-md-3 pleft pright">
                            <?php $product = $product['details']; ?>
                            <div class="comparestickycomparepage">
                                <div class="closebutcom">
                                    @if(!isset($manual_compare))
                                        <a href="#" data-cat="{{$product->category_id}}" data-prod-id="{{$product->id}}" class="remove_from_compare">
                                            x
                                        </a>
                                    @endif
                                </div>
                                <div class="comparestickyimgbox">
                                    <a href="{{product_url_real($product)}}" target="_blank">
                                        <img class="comparestickyimgpro" src="{{getImageNew($product->image_url,"XS")}}" alt="{{$product->name}} Image">
                                    </a>
                                </div>
                                <div class="comparestickycomparecont">
                                    <a class="comparestickyproduct_name" href="{{product_url_real($product)}}" target="_blank">{{$product->name}}</a>
                                    <div class="star-ratingreviews">
                                        <div class="str-rtg">
                                            <span style="width:81%" class="str-ratg"></span></div>
                                    </div>
                                    <div class="product_price">Rs {{number_format($product->saleprice)}}
                                        @if( !empty($product->price) && $product->price > $product->saleprice )
                                            <span>Rs {{number_format($product->price)}}</span>
                                        @endif
                                    </div>
                                </div>
                                @if(!empty($product->lp_vendor))
                                    <a href="{{$product->product_url}}" class="comparestickybutton" target="_blank">Buy
                                        on {{config('vendor.name.'.$product->lp_vendor)}}</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </select-catlist>
        </div>
    @endif
@endsection
@section('scripts')
    <style>
        .add_more_products { margin-top: 10% !important; }
    </style>
    <script src="{{get_file_url('js')}}/front.js" defer onload="frontJsLoaded()"></script>
    <script src="{{get_file_url('js')}}/compare.js" defer></script>
    <script src="{{get_file_url('js')}}/jquery.flexisel.js" defer onload="loadCarousel()"></script>
    <script>
        function frontJsLoaded() {
            CONTENT.uri = '{{route('common-ajax')}}';
            var interval = setInterval(function () {
                if (typeof $ != "undefined") {
                    CONTENT.f(true).load('similar_compare', true);
                    @if(!isset($error))
                        getCategoryBrands({{$category_id}});
                    @endif
                    clearInterval(interval);
                }
            }, 500);
        }

        function loadCarousel() {

            var interval = setInterval(function () {
                if (typeof $ != "undefined") {
                    $("#flexisel-compare1").flexisel({
                        infinite: false,
                        visibleItems: 3,
                        itemsToScroll: 3
                    });
                    clearInterval(interval);
                }
            }, 500);
        }

        document.addEventListener('jquery_loaded', function (e) {

            $(window).scroll(function () {
                if ($(window).scrollTop() >= 400) {
                    $('select-catlist').addClass('fixed-comparesticky');
                }
                else {
                    $('select-catlist').removeClass('fixed-comparesticky');
                }
            });

            $(window).scroll(function () {
                if ($(this).scrollTop() > 50) {
                    $('#back-to-top').fadeIn();
                } else {
                    $('#back-to-top').fadeOut();
                }
            });
            /*scroll body to 0px on click*/
            $('#back-to-top').click(function () {
                $('#back-to-top').tooltip('hide');
                $('body,html').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });

            $(document).on('change', '.gotto', function () {
                var height = $("select-catlist").height() + 50;
                var el = $("#collapse" + $(this).val());
                $(this).val('');
                $('html, body').animate({
                    scrollTop: $(el).offset().top - height - 20
                }, 800);
            });

            $('.panel-group').on('hidden.bs.collapse', toggleIcon);
            $('.panel-group').on('shown.bs.collapse', toggleIcon);

            $(document).on('click', '.add_more_products', function () {
                var ids = $(this).attr('data-ids');

                if (typeof ids != 'undefined') {
                    ids = ids.split(",");
                    setCookie('compare_product_list', JSON.stringify(ids), 100);
                    window.location.href = "{{route('compare-products')}}";
                }
                else {
                    alert("Error occured, please contact Admin..!!");
                    window.location.reload();
                }
            });
        });
    </script>
    <script type="text/javascript">
        function toggleIcon(e) {
            $(e.target).prev('.panel-heading').find(".more-less").toggleClass('glyphicon-plus glyphicon-minus');
        }
    </script>
@endsection