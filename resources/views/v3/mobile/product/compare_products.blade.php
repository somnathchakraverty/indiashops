<section id="compare_pred_wrapper">
	<?php
        $keys = collect($compare_predecessor['keys']);
        $fkeys = $keys->slice(0, 4);
        $rkeys = $keys->slice(4);
        $products = collect($compare_predecessor['products']);
    ?>
    <div class="whitecolorbg">
    <div class="container trendingdeals">
        <div id="compare_pred">
            <h2>Compare with Predecessor</h2>
        </div>
       
            <div class="whitecolorbgcompare">
            <div class="container">
                    @foreach($products as $key => $product)
                        <?php $product = $product['details']; ?>
                        <div class="thumnailcomparepage {{($key>0) ? 'borderright' : ''}}">
                            <div class="thumnailimgboxcompare">
                                <a href="{{product_url($product)}}" target="_blank">
                                    <img class="comparepagproductimg" src="{{getImageNew($product->image_url,'XXS')}}" alt="productimg">
                                </a>
                            </div>
                            <div class="stats-containercompare">                           
                                    <a class="product_name com_pro" href="{{product_url($product)}}" target="_blank">
                                        {{$product->name}}
                                    </a>
                                <div class="product_price com_pric">Rs {{number_format($product->saleprice)}}</div>
                            </div>
                            @if(!empty($product->lp_vendor))
                                <a href="{{$product->product_url}}" class="comparestickybutton com_butttop" target="_blank" rel="nofollow">
                                    Buy on {{config('vendor.name.'.$product->lp_vendor)}}
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
      <div class="summary">Summary</div>
        <div class="whitecolorbg" id="specificationstable">
            <div class="container">
                <div class="comparedetails1">
                    <div class="comparetable">
                        @foreach($compare_predecessor['keys'] as $section => $features)
                            <div class="parent_div">
                                <div class="parent_heading">{{html_entity_decode($section)}}</div>
                                <table>
                                    <?php $j = 0 ?>
                                    <tbody>
                                    @foreach( $features as $key => $value )
                                        <tr>
                                            <th colspan="2" style="font-size:14px!important;">{{$key}}</th>
                                        </tr>
                                        <tr>
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
                        @endforeach
                    </div>
                </div>                
                    <a class="allcateglink" href="javascript:void(0)" id="toggle-btndetails">View More <span class="right-arrow"></span></a>               
            </div>
        </div>
    </div>
    </div>
</section>    
<style>
.com_pro{width:120px;font-size:13px;-webkit-line-clamp:3;height:53px;}
.thumnailcomparepage{height:200px;}
.parent_heading{text-align:center;font-size:16px;font-weight:bold;padding:15px 0px;}
.comparedetails1{overflow:hidden!important;max-height:330px!important;clear:both!important;}
.comparedetails1.show{max-height:inherit!important;}
.comparetable td{font-weight:500;padding:10px 15px;color:#404040!important;font-size:13px!important;}
.comparetable th{padding:10px 0px;}
</style>