<section id="compare_pred_wrapper">
    <div class="comparison">
        <h2>Compare with Predecessor</h2>
        <div class="col-md-12">
            <div class="pro_comp">
                <h2>COMPARE BY</h2>
            </div>
            @foreach($compare_predecessor['products'] as $product)

                <?php $product = $product['details']; ?>
                <div class="pro_comppro">
                    <div class="comparestickyimgbox">
                        <a href="{{product_url($product)}}" target="_blank">
                            <img class="comparestickyimgpro" src="{{getImageNew($product->image_url,"XS")}}" alt="{{$product->name}} Image">
                        </a>
                    </div>
                    <div class="pro_box">
                        <a class="comppro_name" href="{{product_url($product)}}" target="_blank">
                            {{$product->name}}
                        </a>
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
                        <a href="{{$product->product_url}}" class="comparestickybutton com_butttop" target="_blank" rel="nofollow">
                            Buy on {{config('vendor.name.'.$product->lp_vendor)}}
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <?php $index = 0; ?>
            @foreach($compare_predecessor['keys'] as $section => $features)
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="{{create_slug($section)}}">
                        <h4 class="panel-title">
                            <a role="button" class="tabfontsizecompare" data-toggle="collapse" href="#collapse{{create_slug($section)}}" aria-expanded="true">
                                <div class="plusicon">
                                    <i class="more-less glyphicon glyphicon-{{($index==0) ? 'minus' : 'plus'}}"></i>
                                </div>
                                {{html_entity_decode($section)}}
                            </a>
                        </h4>
                    </div>
                    <div id="collapse{{create_slug($section)}}" class="panel-collapse collapse {{($index++==0) ? 'in' : ''}}" role="tabpanel" aria-labelledby="{{create_slug($section)}}">
                        <div class="panel-body">
                            <table class="table table-bordered tablecompare">
                                <tbody>
                                <?php $j = 0 ?>
                                @foreach( $features as $key => $value )
                                    <tr class="{{( $j++ % 2 == 0 ) ? 'tablebgcom' : ''}}">
                                        <th class="tablebgcom1">{{$key}}</th>
                                        @for( $i = 0; $i <count($compare_predecessor['products']); $i++ )
                                            <td>
                                                @if( array_key_exists( $section, @$compare_predecessor['products'][$i]['features']) )
                                                    @if( array_key_exists( $key, @$compare_predecessor['products'][$i]['features'][$section]) )
                                                        {!! $compare_predecessor['products'][$i]['features'][$section][$key] !!}
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
</section>
<style>
    .com_butttop { margin-top: -25px !important; }
</style>