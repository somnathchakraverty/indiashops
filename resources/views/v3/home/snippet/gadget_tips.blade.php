<div class="cs_dkt_si">
    <ul>
        @foreach($blogs as $blog)
            <?php
            $re = '/upload\/(.*)\//';
            $replacement = 'upload/w_240,h_234,c_scale,q_auto,f_auto/';
            $image = preg_replace($re, $replacement, ltrim($blog->path, "."));
            $image = str_replace('http://', 'https://', $image);
            ?>
            <li class="thumnail">              
                    <a href="{{url('blog/'.$blog->post_name)}}" target="_blank">
                        <div class="blogthumnailimgbox">
                            <img class="blogproductimg" src="{{getImageNew("","M")}}" data-src="{{$image}}" alt="{{$blog->post_title}} Image">
                        </div>
                        <span class="bloghadding">{{$blog->post_title}}</span>
                        <span class="writtentext">Written by</span>
                        <span class="blogpostdate">
                            {{$blog->author}}, {{\Carbon\Carbon::parse($blog->post_date)->format('M d, Y')}}
                        </span>
                    </a>              
            </li>
        @endforeach
    </ul>
</div>