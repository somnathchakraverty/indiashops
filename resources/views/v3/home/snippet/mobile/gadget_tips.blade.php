<div class="whitecolorbg">
    <div class="container">
        <h2>Tips on gadgets, fashion & much more</h2>
        <div class="tab-content" id="Women">
            <div class="css-carousel">
                <ul>
                    @foreach($blogs as $blog)
                        <?php
                        $re = '/upload\/(.*)\//';
                        $replacement = 'upload/w_200,h_134,c_scale,q_auto,f_auto/';
                        $image = preg_replace($re, $replacement, ltrim($blog->path, "."));
                        $image = str_replace('http://', 'https://', $image);
                        ?>
                        <li>
                            <a class="thumnail" href="{{url('blog/'.$blog->post_name)}}" target="_blank">
                                <div class="blogthumnailimgbox">
                                    <img class="blogproductimg" src="{{getImageNew("")}}" data-src="{{$image}}" alt="{{$blog->post_title}} Image">
                                </div>
                                <div class="bloghadding">{{$blog->post_title}}</div>
                                <div class="writtentext">Written by</div>
                                <div class="blogpostdate">
                                    {{$blog->author}}
                                    , {{\Carbon\Carbon::parse($blog->post_date)->format('M d, Y')}}
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <a href="http://www.indiashopps.com/blog" class="allcateglink" target="_blank">
            View all
            <span class="right-arrow"></span>
        </a>
    </div>
</div>