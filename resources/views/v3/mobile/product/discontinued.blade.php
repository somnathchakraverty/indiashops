<section>
    <div class="whitecolorbg">
        <div class="container">
            <div class="discontinueblock">
                We're sorry, the product you are looking for has been discontinued. We recommend you to browse through
                our featured categories
            </div>
            @if(count($products) > 0)
                <h1>
                    <span>Popular {{collect($products)->first()->_source->category}}</span>
                </h1>
                <div class="mobilecard2">
                    <ul>
                        @foreach($products as $key => $p )
                            <?php $product = $p->_source; ?>
                            <?php
                            if (!empty(json_decode($product->image_url))) {
                                $images = json_decode($product->image_url);
                            } else {
                                $images[0] = $product->image_url;
                            }
                            ?>
                            <li>
                                @include('v3.mobile.product.card2')
                            </li>
                            @if( $key >= 7 )
                                <?php break; ?>
                            @endif
                            <?php unset($products[$key]) ?>
                        @endforeach
                    </ul>
                </div>
            @endif
            <?php $products = array_values(array_filter($products));?>
            @if(count($products) > 0)
                <div class="sub-title">
                    <span>Popular {{collect($products)->first()->_source->parent_category}}</span></div>

                <div class="mobilecard2">
                    <ul>
                        @foreach($products as $key => $p )
                            <?php $product = $p->_source; ?>
                            <?php
                            if (!empty(json_decode($product->image_url))) {
                                $images = json_decode($product->image_url);
                            } else {
                                $images[0] = $product->image_url;
                            }
                            ?>
                            <li>
                                @include('v3.mobile.product.card2')
                            </li>
                            @if( $key >= 7 )
                                <?php break; ?>
                            @endif
                            <?php unset($products[$key]) ?>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</section>
<script src="{{get_file_url('mobile/js/front.js')}}"></script>