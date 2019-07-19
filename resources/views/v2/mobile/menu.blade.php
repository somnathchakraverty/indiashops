<ul class="sidebar-nav">
    <a id="menu-close" href="#" class="btn btn-lg pull-right toggle" style="background:#fff;width:25px;height:25px;margin-top:7px;padding:1px;color:#000;border-radius:50%;"><i class="glyphicon glyphicon-remove"></i></a>
    <li class="sidebar-brand" style="background:rgb(90, 87, 87);color:#fff;font-weight:bold;height:40px;line-height:40px;text-transform:uppercase;"> Menu </li>
    <li> <a href="{{route('home_v2')}}">Home </a> </li>
    {{--<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Works <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li><a href="#">Separated link</a></li>
            <li><a href="#">One more separated link</a></li>
        </ul>
    </li>--}}
    @foreach( config('mobile_menu') as $url => $title )
    <li> <a href="{{newUrl($url)}}">{{$title}}</a> </li>
    @endforeach
</ul>