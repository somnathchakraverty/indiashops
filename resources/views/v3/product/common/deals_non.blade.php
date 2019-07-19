<ul class="nav nav-tabs" role="tablist">
    <?php $key = 0; $map = ['one', 'two', 'three']?>
    @foreach( $tabs as $tab => $text )
        <li role="presentation" class="{{($tab == 'one') ? 'active' : ''}}">
            <a href="#deals_under_{{$tab}}" role="tab" data-toggle="tab">{{$text}}</a>
        </li>
    @endforeach
</ul>
<!-- Tab panes -->
<div class="tab-content">
    @foreach( $tabs as $tab => $text )
        <div role="tabpanel" class="tab-pane {{($tab == 0) ? 'active' : ''}}" id="deals_under_{{$tab}}">
            <?php $var = ${'deals_'.$map[$tab]}; ?>
            @include('v3.product.common.ajax.deals_non', [ 'deals' => $var ])
        </div>
    @endforeach
</div>