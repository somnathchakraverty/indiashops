@extends('v2.master')
@section('breadcrumbs')
    <section style="background-color:#fff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="sub-menu">
                        <li><a href="{{route("home_v2")}}">Home</a> >>  <a href="#">Most Compared Phones</a> </li>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 PL0" id="left-column">
                <div class="sub-title MT10"> <span>Most Compared Mobiles</span></div>
                <div class="product-listingbanner"><img class="img-responsive" src="{{asset('assets/v2/')}}/images/compare-mobile.jpg"></div>
                <div class="mostcomparemobilist">
                    <ul>
                        <?php foreach( $list as $l ):
                        $group = explode(":", $l );
                        $img1 = getImage( $products[$group[0]]->image_url, $products[$group[0]]->vendor );
                        $img2 = getImage( $products[$group[1]]->image_url, $products[$group[1]]->vendor );
                        $url = newUrl("compare-mobiles");
                        $url .= "/".create_slug($products[$group[0]]->name." ".$products[$group[0]]->id)."/".create_slug($products[$group[1]]->name." ".$products[$group[1]]->id)
                        ?>
                        <li>
                            <div class="commobim">
                                <div class="mobileincom"><img src="{{$img1}}" alt="mobile-name" style="width:50px;"></div>
                                <div class="comvs">V/S</div>
                                <div class="mobileincom"><img src="{{$img2}}" alt="mobile-name" style="width:50px;"></div>
                            </div>
                            <h4>{{$products[$group[0]]->name}} <span>V/S</span> {{$products[$group[1]]->name}}</h4>
                            <div class="comparebuttnbg"><a href="{{$url}}" class="comparebut">Compare</a></div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 PL0" >
                    <div class="sub-title" style="margin-top:10px;"><span>Mobiles</span></div>
                    <ul class="product-listtopmobile">
                        <?php $range = array( 5000, 10000, 15000, 20000, 25000 ); ?>
                        @foreach( $range as $r )
                            <li class=""P15>
                                <aside>
                                    <a href="{{route('bestphones',[$r])}}" title="Best Mobile Phones Under Rs. {{$r}}">Best Mobile Phones Under Rs. {{$r}}</a>
                                </aside>
                            </li>
                        @endforeach
                    </ul>
                <div id="slider_form_sticky_wrapper">
                    <div id="right-column" class="sticky-scroll-boxcat">
                        <div class="sub-title" style="margin-top:10px;"><span>Compare Phones</span></div>
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
                                    <input type="hidden" value="{{csrf_token()}}" name="_token" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            CONTENT.compare_url = '<?=newUrl('compare_mobiles.json')?>';
            CONTENT.compare.load();

            $(window).scroll(function(){
                if( ($(window).scrollTop() + 100) > $("#slider_form_sticky_wrapper").offset().top && $(window).width() >= 768 && $(window).scrollTop() < $("#left-column").height() - $("#right-column").height() )
                {
                    $("#right-column").addClass("fixedcat");
                }
                else
                {
                    $("#right-column").removeClass("fixedcat");
                }
            });

            $("#compare_mobiles").submit(function(){
                var com_url = '<?=newUrl("compare-mobiles")?>';
                var m1 = $("#mobile1").val();
                var m2 = $("#mobile2").val();

                if( m1.length > 0 && m2.length > 0 )
                {
                    var next_url = com_url+"/"+m1+"/"+m2;
                    location.href = next_url;
                }

                return false;
            });
        });
    </script>
    <style>
        #right-column{ top: 60px; -webkit-transition:all .5s ease-in-out;-moz-transition:all .5s ease-in-out;-o-transition:all .5s ease-in-out;-ms-transition:all .5s ease-in-out;transition:all .5s ease-in-out; }
        #right-column.fixedcat{ position: fixed; top: 90px; -webkit-transition:all .5s ease-in-out;-moz-transition:all .5s ease-in-out;-o-transition:all .5s ease-in-out;-ms-transition:all .5s ease-in-out;transition:all .5s ease-in-out;  }
    </style>
@endsection