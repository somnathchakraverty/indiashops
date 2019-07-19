<?php $cats = getCouponsCats();
$images = [
        "recharge"                 => get_file_url('images') . "/coupons/sports.png",
        "mobile-tablets"           => get_file_url('images') . "/coupons/mobile.png",
        "fashion"                  => get_file_url('images') . "/coupons/clothes.png",
        "food-dinning"             => get_file_url('images') . "/coupons/food.png",
        "computers-laptops-gaming" => get_file_url('images') . "/coupons/computer.png",
        "home-furnishing-decor"    => get_file_url('images') . "/coupons/furnish.png",
        "travel"                   => get_file_url('images') . "/coupons/travel.png",
        "beauty-health"            => get_file_url('images') . "/coupons/beauty.png",
        "others"                   => get_file_url('images') . "/coupons/others.png",
        "electronic-appliances"    => get_file_url('images') . "/coupons/electronics.png",
        "kids-babies"              => get_file_url('images') . "/coupons/kids.png",
        "books-stationery"         => get_file_url('images') . "/coupons/books.png",
        "flowers-gifts"            => get_file_url('images') . "/coupons/flower.png",
        "tv-video-movies"          => get_file_url('images') . "/coupons/movies.png",
        "cameras-accessories"      => get_file_url('images') . "/coupons/camera.png",
        "sports-fitness"           => get_file_url('images') . "/coupons/fitness.png",
        "education-learning"       => get_file_url('images') . "/coupons/education.png",
        "entertainment"            => get_file_url('images') . "/coupons/entertainment.png",
        "web-hosting-domains"      => get_file_url('images') . "/coupons/hosting.png"
] ?>
<div class="css-carouseltab padding-btm0">   
        <ul>
            @foreach($cats as $cat)
                <li>
                        <?php $c_slug = create_slug($cat['name']); ?>
                        <a class="thumnail1 couthum" href="{{route('category_page_v2',[$c_slug])}}">
                            <img src="{{$images[$c_slug]}}" alt="mobile" width="88" height="88">
                            <span>{{$cat['name']}}</span>
                        </a>                   
                </li>
            @endforeach
        </ul>   
</div>