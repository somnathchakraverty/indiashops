<section id="compare_pred_wrapper">
    <amp-position-observer on="enter:priceHide.start;" layout="nodisplay"></amp-position-observer>
    <amp-position-observer on="enter:specsHide.start;" layout="nodisplay"></amp-position-observer>
    <amp-position-observer on="enter:faqHide.start;" layout="nodisplay"></amp-position-observer>
    <amp-position-observer on="enter:detailsHide.start;" layout="nodisplay"></amp-position-observer>
    <amp-position-observer on="enter:reviewHide.start;" layout="nodisplay"></amp-position-observer>
    <amp-position-observer on="enter:compareShow.start;" layout="nodisplay"></amp-position-observer>
    <amp-position-observer on="enter:videoHide.start;" layout="nodisplay"></amp-position-observer>
    <?php
    $keys = collect($compare_predecessor['keys']);
    $fkeys = $keys->slice(0, 4);
    $rkeys = $keys->slice(4);
    $products = collect($compare_predecessor['products']);
    ?>
    <div class="whitecolorbg">
        <div class="container">
        <h2>Compare with Predecessor</h2>
            <div class="whitecolorbgcompare">
                <div class="container">
                    @foreach($products as $key => $product)
                        <?php $product = $product['details']; ?>
                        <div class="thumnailcomparepage {{($key>0) ? 'borderright' : ''}}">
                            <div class="thumnailimgboxcompare">
                                <a href="{{product_url($product)}}" target="_blank">
                                    <amp-img class="comparepagproductimg" src="{{getImageNew($product->image_url,'XXS')}}" width="60" height="104" alt="{{$product->name}}"></amp-img>
                                </a>
                            </div>
                            <div class="stats-containercompare">
                                <a class="product_name com_pro" href="{{product_url($product)}}" target="_blank">
                                    {{$product->name}}
                                </a>
                                <div class="product_price">Rs {{number_format($product->saleprice)}}</div>
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
                                                <th colspan="2">{{$key}}</th>
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

                </div>
            </div>
        </div>
    </div>
    <amp-position-observer on="enter:priceHide.start;" layout="nodisplay"></amp-position-observer>
    <amp-position-observer on="enter:specsHide.start;" layout="nodisplay"></amp-position-observer>
    <amp-position-observer on="enter:faqHide.start;" layout="nodisplay"></amp-position-observer>
    <amp-position-observer on="enter:detailsHide.start;" layout="nodisplay"></amp-position-observer>
    <amp-position-observer on="enter:reviewHide.start;" layout="nodisplay"></amp-position-observer>
    <amp-position-observer on="enter:compareShow.start;" layout="nodisplay"></amp-position-observer>
    <amp-position-observer on="enter:videoHide.start;" layout="nodisplay"></amp-position-observer>
</section>