<div class="comparison">
<h2>News</h2>
<div class="comparisontable">
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
                        <img class="newsimgsize" src="{{getImageNew('')}}" data-src="{{$image_url}}" alt="news" />
                    </a>
                @else
                    <img class="newsimgsize" src="{{getImageNew('')}}" data-src="{{$image_url}}" alt="news" />
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
                    <a href="{{$item->link}}" target="_blank" style="color:#ff3131"> READ MORE</a>
                @endif
            </div>
        </div>
    @endforeach
</div>
</div>