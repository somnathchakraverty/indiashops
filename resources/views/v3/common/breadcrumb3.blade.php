@if(!isset($_SERVER['HTTP_HOST']))
    <?php $_SERVER['HTTP_HOST'] = 'localhost'; ?>
    <?php $_SERVER['REQUEST_URI'] = ''; ?>
@endif
@if ($breadcrumbs)
    <div class="css-carouseltab padding-btm0">
        <ul class="breadcrumb">
            @if($breadcrumbs[0]->title == "amp")
                @foreach ($breadcrumbs as $key => $breadcrumb)
                    @if ($breadcrumb->url && $key != $breadcrumbs->keys()->last() && $key != $breadcrumbs->keys()->first())
                        <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                    @elseif(!$breadcrumbs->keys()->first() && $breadcrumb->title != 'amp')
                        <li class="active">{{ $breadcrumb->title }}</li>
                    @endif
                @endforeach
            @else
                <?php $position = 1; ?>
                @foreach ($breadcrumbs as $key => $breadcrumb)
                    @if ($breadcrumb->url && $key != $breadcrumbs->keys()->last() )
                        <li>
                            <a href="{{ url($breadcrumb->url) }}">
                                <span>{{ $breadcrumb->title }}</span>
                            </a>
                        </li>
                    @else
                        <li class="active"><span>{{ $breadcrumb->title }}</span></li>
                    @endif
                @endforeach
            @endif
        </ul>

    </div>
@endif
