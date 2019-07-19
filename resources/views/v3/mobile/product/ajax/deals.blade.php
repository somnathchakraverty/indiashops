<section>
    <div class="container">
        <?php $Category = \indiashopps\Category::find($category_id); ?>
        <h2>Top Deals on {{ucwords($Category->name)}}</h2>
        <div class="product-tabs">
            <ul class="tabs carousel" id="part-tab-1" data-items="2.2" data-scroll="1">
                <?php $key = 0; ?>
                @foreach( $tabs as $tab => $text )
                    <li class="tab">
                        <a class="{{($tab == 'one') ? 'active' : ''}} ajax_load" href="#deals_under_{{$tab}}" data-params="{!! $contents[$key++] !!}}" {!! getAjaxAttr('deals_under_'.$tab, true ) !!}>
                            {{$text}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="whitecolorbg">
        <div class="container">
            @foreach( $tabs as $tab => $text )
                <div class="tab-content {{($tab == 'one') ? 'active' : ''}}" id="deals_under_{{$tab}}">
                    @if( $tab == 'one' )
                        @include("v3.mobile.product.ajax.deals_ajax")
                    @endif
                </div>
            @endforeach
           
                <a class="allcateglink" href="{{getCategoryUrl($Category)}}">VIEW ALL {{$Category->name}}
                    <span class="right-arrow"></span>
                </a>
            
        </div>
    </div>
    <script>
        $("ul.tabs").tabs();
    </script>
</section>