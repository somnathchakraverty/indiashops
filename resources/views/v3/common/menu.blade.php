<li class="menuhaddingcat">TOP CATEGORIES</li>
<?php $i = 1; ?>
@foreach( $categories as $parent )
    <li class="has-children">
        <a href="{{categoryLink([$parent['category']->name])}}">{{$parent['category']->name}}</a>
        @if(collect($parent['children'])->isNotEmpty())
            <ul class="cd-secondary-dropdown is-hidden">
                <li>
                    <div class="col-md-10">                       
                            <?php $key = 1; ?>
                            @foreach( $parent['children'] as $second )
                                <div class="naviboxdrop">                                   
                                        <a class="navihaddingtop" href="{{categoryLink([$parent['category']->name,$second['category']->name])}}">
                                            {{$second['category']->name}}
                                        </a>                                   
                                    @if(collect($second['children'])->isNotEmpty())
                                        <ol>
                                            <?php $j = 1; ?>
                                            @foreach( $second['children'] as $child )
                                                <li>
                                                    <a href="{{categoryLink([$parent['category']->name,$second['category']->name,$child['category']->name])}}">
                                                        {{$child['category']->name}}
                                                    </a>
                                                </li>
                                                <?php
                                                if(strtolower($parent['category']->name) == "appliances")
                                                {
                                                    if ($j >= 10) {
                                                        break;
                                                    }
                                                }else{
                                                    if ($j >= 5) {
                                                        break;
                                                    }
                                                }

                                                $j++;
                                                ?>
                                            @endforeach
                                        </ol>
                                    @elseif(array_key_exists(str_replace(" ","_",strtolower($second['category']->name)),$menu_brands))
                                        <ol>                                            
                                            @foreach($menu_brands[str_replace(" ","_",strtolower($second['category']->name))] as $brand )
                                                <li>
                                                <a href="{{brandProductList($brand,$second['category'])}}">
                                                        {{$brand}}
                                                    </a>
                                                </li>                                               
                                            @endforeach
                                        </ol>
                                    @endif
                                </div>
                            @endforeach
                       
                    </div>
                    <div class="col-md-2">                       
                            @if(array_key_exists($parent['category']->id,$banners))
                                <?php $banner = $banners[$parent['category']->id] ?>
                                @if(isset($banner->refer_url) && filter_var($banner->refer_url,FILTER_VALIDATE_URL))
                                    <a class="cat-menu-adright" href="{{$banner->refer_url}}" target="_blank" style="height:405px;">
                                        <img style="height:405px;" data-src="{{$banner->image_url}}" alt="{{$banner->alt}}" src="{{getImageNew('',"M")}}">
                                    </a>
                                @else
                                    <img style="height:405px;" data-src="{{$banner->image_url}}" alt="{{$banner->alt}}" src="{{getImageNew('',"M")}}">
                                @endif
                            @endif                       
                    </div>
                </li>
            </ul>
        @endif
    </li>
@endforeach