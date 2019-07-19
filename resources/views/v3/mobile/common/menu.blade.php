<div id="sidebar-menu" style="display: none">
    <div id="slide-out-left" class="side-nav">
        <div class="menuheadertop">
            <div class="filtertoppart">
                <a id="menu-close" href="javascript:void(0)" class="filter-closetop"></a>
                <div class="applyhadding">MENU</div>
                <div class="signinup">
                    <ul>
                        @if(\Auth::check())
                            <li><a href="{{route('logout')}}">Logout</a></li>
                            <li><a href="{{route('cashback.earnings')}}">Cashback</a></li>
                            <li style="border-right:none;">
                                <a href="{{route('myaccount')}}">My Account</a>
                            </li>
                        @else
                            <li><a href="{{route('login_v2')}}">Sign In</a></li>
                            <li style="border-right:none;">
                                <a href="{{route('register_v2')}}">Sign Up</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <!-- App/Site Menu -->
        <div id="main-menu">
            <ul>
                <li><a href="{{route('home_v2')}}"><i class="fa fa-home"></i> Home</a></li>
                @foreach( $categories as $parent )
                    <li class="{{(collect($parent['children'])->isNotEmpty()) ? "has-sub" : ""}} first_level">
                        <a href="{{categoryLink([$parent['category']->name])}}">
                            {{$parent['category']->name}}
                            @if(collect($parent['children'])->isNotEmpty())
                                <span class="arrow-menu"></span>
                            @endif
                        </a>
                        @if(collect($parent['children'])->isNotEmpty())
                            <ul>
                                @foreach( $parent['children'] as $second )
                                    <li class="{{(collect($second['children'])->isNotEmpty()) ? "has-sub" : ""}}">
                                        <a href="{{categoryLink([$parent['category']->name,$second['category']->name])}}">
                                            {{$second['category']->name}}
                                            @if(collect($second['children'])->isNotEmpty())
                                                <span class="arrow-menu"></span>
                                            @endif
                                        </a>
                                        @if(collect($second['children'])->isNotEmpty())
                                            <ul>
                                                @foreach( $second['children'] as $child )
                                                    <li>
                                                        <a href="{{categoryLink([$parent['category']->name,$second['category']->name,$child['category']->name])}}">
                                                            {{$child['category']->name}}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <!-- End Site/App Menu -->
    </div>
</div>