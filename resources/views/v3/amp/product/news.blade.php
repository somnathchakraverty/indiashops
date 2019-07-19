<!--THE-NEWS-->
<section>
    <div class="whitecolorbg">
        <div class="container">
        <h2>News</h2>
            <?php $last_key = $news->keys()->last(); ?>
            @foreach($news as $key => $item)
                <div class="spec_box {{($last_key == $key ) ? 'lastbordernone' : ''}}">
                    <div class="newsimgpart">
                        <?php
                        if (isset($item->image) && !empty($item->image)) {
                            $image_url = $item->image;
                        } else {
                            $image_url = $item->image_url;
                        }
                        ?>
                        @if(isValidLink($item->link))
                            <a href="{{$item->link}}" target="_blank">
                                <amp-img class="newsimgsize" src="{{$image_url}}" alt="news" width="150" height="121"></amp-img>
                            </a>
                        @else
                            <amp-img class="newsimgsize" src="{{$image_url}}" alt="news" width="150" height="121"></amp-img>
                        @endif
                    </div>
                    <h3 class="newshadding">
                        @if(isValidLink($item->link))
                            <a href="{{$item->link}}" target="_blank">{{$item->title}}</a>
                        @else
                            {{$item->title}}
                        @endif
                    </h3>
                    <div class="newsdate">{{\Carbon\Carbon::parse($item->created_at)->format("jS F Y")}}</div>
                    <div class="newsnormeltext">
                        {{$item->content}}

                        @if(isValidLink($item->link))
                            <br/><br/>
                            <a href="{{$item->link}}" target="_blank" class="readmore"> READ MORE</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!--END-NEWS-->