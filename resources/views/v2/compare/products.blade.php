@extends('v2.master')
@section('breadcrumbs')
<section style="background-color:#fff;">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="sub-menu">
          <li><a href="{{route("home_v2")}}">Home</a> >> <a href="#">Compare Products</a> </li>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('content')
<div class="container">
  <div class="row"> @if(!isset($error))
    <div class="col-md-9 PL0">
      <div class="sub-title MT10" style="margin-top:17px;">
        <span> @foreach( $products as $key =>  $product )
          @if( $key != 0 )
          {{" v/s "}}
          @endif
          {{$product['details']->name}}
          @endforeach </span>
        {{--
        <div class="pull-right">--}}
          {{--
          <select class="form-control filter-select gray-border1">
            --}}
                            {{--
            <option>Mustard</option>
            --}}
                            {{--
            <option>Ketchup</option>
            --}}
                            {{--
            <option>Relish</option>
            --}}
                        {{--
          </select>
          --}}
          {{--</div>
        --}} </div>
      <div class="shadow-box PB40">

            <div class="pull-right"> <img class="img-responsive" src="{{asset('assets/v2/')}}/images/compare-mobile.jpg">
              <!--<div class="com-left"> <b>Apple iPhone 6</b>
                <p>Rs, 33,799</p>
              </div>-->
            </div>

          <!--<div class="col-md-6">
            <div class="pull-left ML50">
              <div class="com-right"> <b>Apple iPhone 6</b>
                <p>Rs, 33,799</p>
              </div>
              <img src="{{asset('assets/v2/')}}/images/com-phone.png"> </div>
          </div>-->

      </div>
    </div>
    <div class="col-md-3 PR0 PL0">
      <div class="sub-title MT10" style="margin-top:17px;"><span>Mobiles</span></div>
      <div class="shadow-box vertical-carousel">
        <div class="panel panel-default" style="min-height: 200px; margin-bottom: 10px;border: none;" >
          <?php $range = array( 5000, 10000, 15000, 20000, 25000 ); ?>
          <ul class="best_phones_under">
            @foreach( $range as $r )
            <li> <a href="{{route('bestphones',[$r])}}" title="Best Mobile Phones Under Rs. {{$r}}">Best Mobile Phones Under Rs. {{$r}}</a> </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 PL0 PR0">
        <div class="shadow-box P0">
          <div class="bs-example" data-example-id="bordered-table">
            <table class="table table-bordered" id="specification">
              <tbody>
                <tr>
                  <td width="12%"><div class="btn-group">
                      <button type="button" class="btn btn-primary dropdown-toggle btn-comparelist" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Jump <span class="hidden-xxs">to</span> <span class="caret"></span> </button>
                      <ul class="dropdown-menu">
                        <?php foreach( $keys as $cat_key => $key ): ?>
                        <?php $href = str_replace(" ", "-", strtolower( $cat_key ) ); ?>
                        <li><a href="#<?=$href?>" class="ssmooth">
                          <?=$cat_key?>
                          </a></li>
                        <?php endforeach; ?>
                      </ul>
                    </div></td>
                  <?php $percent = (88/count($products)); ?>
                  @foreach( $products as $product )
                  <?php
                                        if( $product['details']->vendor == 0 ):
                                            $plink = route('product_detail_v2', [create_slug($product['details']->name),$product['details']->id]);
                                        else:
                                            $plink = route('product_detail_v2', [create_slug($product['details']->name),$product['details']->id]);
                                        endif;
                                        ?>
                  <td width="<?=$percent?>%" align="middle"><div class="col-md-4 col-sm-4"> <a href="<?=$plink?>"> <img src="{{getImageNew($product['details']->image_url,"S")}}" class="img-responsive" style="width:80px;margin:10px auto;"/> </a> </div>
                    <div class="col-md-8 col-sm-8">
                      <p class="product-title product-titlemobname"> <a href="<?=$plink?>">
                        <?=$product['details']->name?>
                        </a> </p>
                      <p class="compare-price-color">Rs.
                        <?=number_format( $product['details']->saleprice )?>
                      </p>
                      <p> <span prod-id="<?=$product['details']->id?>" class="btn btn-danger remove-product btn-xs compare-pricebutton">Remove</span> </p>
                    </div></td>
                  @endforeach </tr>
              @foreach( $keys as $section => $features )
              <tr>
                <?php $href = str_replace(" ", "-", strtolower( $section ) ); ?>
                <th colspan="{{count($products)+1}}" id="{{$href}}"><b>{{$section}}</b></th>
              </tr>
              @foreach( $features as $key => $value )
              <tr>
                <td>{{$key}}</td>
                @for( $i = 0; $i
                  <count($products); $i++ )

                <td> @if( array_key_exists( $section, @$products[$i]['features']) )
                  @if( array_key_exists( $key, @$products[$i]['features'][$section]) )
                  {!! $products[$i]['features'][$section][$key] !!}
                  @else
                  --
                  @endif
                  @else
                  --
                  @endif </td>
                @endfor </tr>
              @endforeach
              @endforeach
                </tbody>

            </table>
          </div>
        </div>
      </div>
    </div>
    @else
    <div class="col-md-12 PL0">
      <div class="shadow-box">
        <div class="alert alert-danger">
          <?=$error?>
        </div>
      </div>
    </div>
    @endif </div>
</div>
@endsection
@section('script')
<style>
        ul.best_phones_under{ padding: 0px; }
        .best_phones_under li{ list-style: none; }
        .highlight {
            border-bottom: 3px double red;
            color: #D30900;
            cursor: pointer;
            font-weight: bold;
        }
</style>
<script type="text/javascript">
        $(document).ready(function(){
            $.ajax({
                url: '<?=newUrl('json/mobile_specs.json')?>',
                type: "GET",
                dataType: "json",
                success: function (specifications) {

                    var oldHtml = $('#specification').html();
                    var newHtml = oldHtml;

                    $.each( specifications, function( word, definition ){

                        newHtml = newHtml.replaceAll( word,"<span class='highlight' data-toggle='tooltip' title='"+definition+"'>"+word+"</span>");
                    });

                    $('#specification').html( newHtml );
                    $('[data-toggle="tooltip"]').tooltip()
                }
            });
        });

        String.prototype.replaceAll = function(search, replacement) {
            var target = this;
            return target.replace(new RegExp(search, 'ig'), replacement);
        };
    </script>
@endsection