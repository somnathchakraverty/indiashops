<?php
$cat_image = str_replace("100x100","160x180",$category->children[0]->image);
?>
<div class="col-md-4">
    <div class="category">
        <div class="title"><h4>{{$category->name}}</h4></div>
        <div class="uptodiscount">Up to <span>40%-70%</span> OFF</div>
        <div class="image">
            <?php $url = newUrl( create_slug($category->group_name)."/".seoUrl( create_slug($category->name) ) ); ?>
            <a href="{{$url}}" target="_blank">
                <img src="{{$cat_image}}" class="img-thumbnail"/>
            </a>
        </div>
        <div class="category-list">
            <ul class="list">
                @foreach( $category->children as $child )
                    <?php $url = newUrl( create_slug($category->group_name)."/".create_slug( $category->name )."/".seoUrl( create_slug($child->name) ) ); ?>
                    <li>
                        <a href="{{$url}}" title="Explore More {{$child->name}}" target="_blank" >{{$child->name}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<style>
.list{list-style:none;padding:0px;}
.list li{list-style:none;border-bottom:1px solid #ddd;padding:10px 10px 15px;}
.category .image{text-align:center;max-height:200px;width:auto;margin-bottom:15px;}
.list li:after{font-family:'FontAwesome';content:"\f138";position:absolute;right:30px;font-size:20px;}
.list a{color:#e40046;}
.list a:hover{color:#000;text-decoration:none;}
.category .title h4{color:#fff;text-shadow:1px 0px 6px #0a0a0a;}
.category{background:#f2f2f2;padding-bottom:10px;border-radius:0px 0px 6px 6px;}
.uptodiscount{font-size:16px;}
.uptodiscount span{font-size:18px;font-style:italic;}
</style>