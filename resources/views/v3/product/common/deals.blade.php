<ul class="nav nav-tabs" role="tablist">
    <?php $key = 0; ?>
    @foreach( $tabs as $tab => $text )
        <li role="presentation" class="{{($tab == 'one') ? 'active' : ''}}">
            <a href="#deals_under_{{$tab}}" data-params="{!! $contents[$key++] !!}}" role="tab" data-toggle="tab" {!! getAjaxAttr('deals_under_'.$tab, true ) !!}>{{$text}}</a>
        </li>
    @endforeach
</ul>
<!-- Tab panes -->
<div class="tab-content">
    @foreach( $tabs as $tab => $text )
        <div role="tabpanel" class="tab-pane {{($tab == 'one') ? 'active' : ''}}" id="deals_under_{{$tab}}">
            @if( $tab == 'one' )
                @include('v3.product.common.ajax.deals')
            @endif
        </div>
    @endforeach
</div>