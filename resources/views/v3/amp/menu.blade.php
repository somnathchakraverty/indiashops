<amp-accordion class="sidebar-menu">
    <?php $i = 1; ?>
        <section>
            <h4>
                <i class="bg-green-dark fa fa-home"></i>
                <a href="{{route('amp.home')}}">
                    Home
                </a>
            </h4>
            <ul></ul>
        </section>
    @foreach( $categories as $parent )
        <section>
            <h4>
                <i class="bg-green-dark fa fa-bolt"></i>
                {{$parent['category']->name}}
                <i class="fa fa-angle-down"></i>
            </h4>
            <ul>
                @if(collect($parent['children'])->isNotEmpty())
                    <?php $key = 1; ?>
                    @foreach( $parent['children'] as $second )
                    <li>
                        <a href="{{getCategoryUrl($second['category'])}}">
                            <i class="fa fa-angle-right"></i>{{$second['category']->name}}
                        </a>
                        @if(collect($second['children'])->isNotEmpty())
                        <div class="submenulist">
                            <ul>
                                <?php $i = 1; ?>
                                @foreach( $second['children'] as $third )
                                    <li>
                                        <a href="{{getCategoryUrl($third['category'])}}">
                                            {{$third['category']->name}}
                                        </a>
                                    </li>
                                    <?php
                                        if( $i > 4 )
                                            break;

                                        $i++;
                                    ?>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </li>
                    @endforeach
                @endif
            </ul>
        </section>
    @endforeach
</amp-accordion>