@extends('v3.master')
@section('page_content')
    <section>
        <div class="container">
            {!! Breadcrumbs::render() !!}
        </div>
    </section>
    <div class="container">
        <div class="row">
            <div class="col-md-9" id="left-column">
                <div class="sub-title">Most Compared Mobiles</div>
                <div class="product-listingbanner">
                    <img style="width:100%;" class="img-responsive" src="{{asset('assets/v2/')}}/images/compare-mobile.jpg" alt="compare-mobile">
                </div>
                <div class="mostcomparemobilist">
                    <ul>
                        <?php foreach( $list as $l ):
                        $group = explode(":", $l);
                        if(array_key_exists($group[0], $products) && array_key_exists($group[1], $products)):
                        $img1 = getImage($products[$group[0]]->image_url, $products[$group[0]]->vendor);
                        $img2 = getImage($products[$group[1]]->image_url, $products[$group[1]]->vendor);
                        $url = newUrl("compare-mobiles");
                        $url .= "/" . create_slug($products[$group[0]]->name . " " . $products[$group[0]]->id) . "/" . create_slug($products[$group[1]]->name . " " . $products[$group[1]]->id)
                        ?>
                        <li>
                            <div class="commobim">
                                <div class="mobileincom">
                                    <img class="mostcompareimgpro" src="{{$img1}}" alt="mobile-name"></div>
                                <div class="comvs">V/S</div>
                                <div class="mobileincom">
                                    <img class="mostcompareimgpro" src="{{$img2}}" alt="mobile-name"></div>
                            </div>
                            <h4>{{$products[$group[0]]->name}} <span>V/S</span> {{$products[$group[1]]->name}}</h4>
                            <div class="comparebuttnbg"><a href="{{$url}}" class="comparebut">Compare</a></div>
                        </li>
                        <?php endif;?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 PL0">
                <div class="sub-title">Mobiles</div>
                <ul class="product-listtopmobile">
                    <?php $range = array(5000, 10000, 15000, 20000, 25000); ?>
                    @foreach( $range as $r )
                        <li class="" P15>
                            <aside>
                                <a href="{{route('bestphones',[$r])}}" title="Best Mobile Phones Under Rs. {{$r}}">Best
                                    Mobile Phones Under Rs. {{$r}}</a>
                            </aside>
                        </li>
                    @endforeach
                </ul>
                <div id="slider_form_sticky_wrapper">
                    <div id="right-column" class="sticky-scroll-boxcat">
                        <div class="sub-title"><span>Compare Phones</span></div>
                        <div class="compareselectop">
                            <div class="selectboxcolor">
                                <form id="compare_mobiles">
                                    <select class="form-control selectrightpart compare_mobiles" id="mobile1">
                                        <option value="">-----SELECT-----</option>
                                    </select>
                                    <div class="comvsrightpart">V/S</div>
                                    <select class="form-control selectrightpart compare_mobiles" id="mobile2">
                                        <option value="">-----SELECT-----</option>
                                    </select>
                                    <button type="submit" class="comparebut" style="margin-top:10px;">Compare</button>
                                    <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{get_file_url('js')}}/front.js"></script>
    <script>
        $(document).ready(function () {
            CONTENT.compare_url = '<?=newUrl('compare_mobiles.json')?>';
            CONTENT.compare.load();

            $(window).scroll(function () {
                if (($(window).scrollTop() + 100) > $("#slider_form_sticky_wrapper").offset().top && $(window).width() >= 768 && $(window).scrollTop() < $("#left-column").height() - $("#right-column").height()) {
                    $("#right-column").addClass("fixedcat");
                }
                else {
                    $("#right-column").removeClass("fixedcat");
                }
            });

            $("#compare_mobiles").submit(function () {
                var com_url = '<?=newUrl("compare-mobiles")?>';
                var m1 = $("#mobile1").val();
                var m2 = $("#mobile2").val();

                if (m1.length > 0 && m2.length > 0) {
                    var next_url = com_url + "/" + m1 + "/" + m2;
                    location.href = next_url;
                }

                return false;
            });
        });
    </script>
    <style>
        #right-column { top: 60px; -webkit-transition: all .5s ease-in-out; -moz-transition: all .5s ease-in-out; -o-transition: all .5s ease-in-out; -ms-transition: all .5s ease-in-out; transition: all .5s ease-in-out; }
        #right-column.fixedcat { position: fixed; top: 90px; -webkit-transition: all .5s ease-in-out; -moz-transition: all .5s ease-in-out; -o-transition: all .5s ease-in-out; -ms-transition: all .5s ease-in-out; transition: all .5s ease-in-out; }
        .sub-title { margin-top: 0px !important; }
        .product-listingbanner { background: #FFF; padding: 5px; overflow: hidden; margin-bottom: 15px; display: block; margin-top: -1px; }
        .mostcomparemobilist { display: block; margin: 0; padding: 0; }
        .mostcomparemobilist ul { display: block; margin: 0; padding: 0; }
        .mostcomparemobilist ul li { list-style: none; display: inline-block; margin: 5px 0px 15px 0px; border: 5px solid #e6e6e6; padding: 5px; background: #fff; width: 49.6%; overflow: hidden; }
        .compareboxmobile { background: #FFF; margin: 0; padding: 10px; display: inline-block; width: 49.6%; }
        .commobim { margin: 15px auto; text-align: center; }
        .mobileincom { display: inline-block; }
        .comvs { margin: auto; background: #c50903; text-align: center; width: 35px; height: 35px; font-size: 14px; line-height: 36px; color: #fff; border-radius: 50%; display: inline-block; }
        .mostcomparemobilist h4 { text-align: center; color: #000; font-size: 15px; font-weight: bold; }
        .mostcomparemobilist span { color: #ff0000; font-weight: bold; }
        .mostcompareimgpro { max-width: 100px !important; max-height: 140px !important; }
        .comparebuttnbg { background: #f2f2f2; margin: 0; padding: 5px; }
        .comparebut { background-image: linear-gradient(to left, #ff3131, #ff774c) !important; text-align: center; font-size: 16px; font-weight: bold; color: #fff; padding: 10px; margin: auto; display: block; width: 100%; border: none; }
        .comparebut:hover { background-image: linear-gradient(to left, #ff774c, #ff3131) !important; text-align: center; font-size: 16px; font-weight: bold; color: #fff; padding: 10px; margin: auto; display: block; text-decoration: none; }
        .bestmobilelist { color: #000; text-align: left; font-size: 14px; display: block; text-decoration: none !important; }
        .bestmobilelist a:hover { color: #e40046 !important; text-align: left; font-size: 14px; display: block; text-decoration: none !important; }
        .compareselectop { background: #ff734b4a; margin-top: -10px; padding: 10px; }
        .selectboxcolor { background: #f9fcfd; padding: 10px; border-radius: 5px; }
        .comvsrightpart { margin: 10px auto; background: #c50903; text-align: center; width: 35px; height: 35px; font-size: 14px; line-height: 36px; color: #fff; border-radius: 50%; display: block; }
        .selectrightpart { font-size: 14px; color: #000; border-radius: 0px; }
        .product-listtopmobile { list-style: none; padding: 0px; }
        .product-listtopmobile li { display: inline-block; border-bottom: 1px solid #f4f4f6; width: 100%; padding: 10px; margin-top: 5px; background: #fff; }
        .product-listtopmobile li a { display: inline-block; width: 100%; font-size: 14px; color: #000; font-weight: bold; text-decoration: none; }
        .product-listtopmobile li a:hover { color: #ff3131; }
        .product-listtopmobile aside { padding-top: 0px; }
    </style>
@endsection