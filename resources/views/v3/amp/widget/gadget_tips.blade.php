<amp-carousel class="full-bottom" height="260" layout="fixed-height" type="carousel">
    @foreach($blogs as $blog)
        <?php
        $re = '/upload\/(.*)\//';
        $replacement = 'upload/w_240,h_234,c_scale,q_auto,f_auto/';
        $image = preg_replace($re, $replacement, ltrim($blog->path, "."));
        $image = str_replace('http://', 'https://', $image);
        ?>
        <div class="thumnail">
            <a href="{{url('blog/'.$blog->post_name)}}" target="_blank">
                <div class="blogthumnailimgbox">
                    <amp-img class="blogproductimg" src="{{$image}}" width="200" height="221" alt="{{$blog->post_title}} Image"></amp-img>
                </div>
                <div class="bloghadding">{{$blog->post_title}}</div>
                <div class="writtentext">Written by</div>
                <div class="blogpostdate">
                    {{$blog->author}}, {{\Carbon\Carbon::parse($blog->post_date)->format('M d, Y')}}
                </div>
            </a>
        </div>
    @endforeach
</amp-carousel>