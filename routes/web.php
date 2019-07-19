<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix' => 'api'], function () {
    require base_path('routes/Api/ApiRoutes.php'); // All V2 New Routes
});

Route::group(['prefix'    => '/', 'namespace' => 'v2', 'middleware' => ['min_html','tracking','mobile_site']], function () {
    require base_path('routes/V2/routes.php'); // All V2 New Routes
});

Route::group(['prefix'    => '/', 'namespace' => 'v3', 'middleware' => ['min_html','tracking','mobile_site']], function () {
    require base_path('routes/V3/web.php'); // All V3 New Routes
});

Route::group(['middleware' => ['min_html','tracking','mobile_site']], function (){

    Route::pattern('page', '\d+');

    Route::get('notify/subscribe', ['as' => 'notify_subscribe', 'uses' => 'FcmController@subscribe']);
    Route::get('/amazon-great-indian-sale/{page?}', [ 'as' => 'amazon-sale', 'uses' => 'ListingController@amazonSale' ]);
    Route::get('/amazon-great-indian-festival-sale/{page?}', [ 'as' => 'amazon-festival-sale', 'uses' => 'ListingController@amazonfestivalSale' ]);
    Route::get('/get-the-real-deal', [ 'as' => 'real-deal-page', 'uses' => 'ScrapeController@real_time_deal' ]);
    Route::post('/get-the-real-deal', [ 'as' => 'real-deal-page', 'uses' => 'ScrapeController@real_time_deal' ]);
    /***************************************************SNIPPET*******************************************************************/
    Route::get('/{brand}-shoes-for-{group}/{page?}', [ 'as' => 'sports_shoes', 'uses' => 'ListingController@brandwise_sports_shoes_for' ]);
    /***************************************************SNIPPET*******************************************************************//***************************************************SNIPPET*******************************************************************/
    Route::get('/mobile/smartphones/{page?}', [ 'as' => 'smartphone', 'uses' => 'ListingController@smartphone' ]);
    Route::get('/mobile/dual-sim-phones/{page?}', [ 'as' => 'dual_sim', 'uses' => 'v3\ListingController@dual_sim' ]);
    Route::get('/mobile/android-phones/{page?}', [ 'as' => 'android_phones', 'uses' => 'v3\ListingController@android_phones' ]);
    Route::get('/mobile/windows-phones/{page?}', [ 'as' => 'windows_phones', 'uses' => 'v3\ListingController@windows_phones' ]);
    /***************************************************SNIPPET*******************************************************************/
    Route::get('/scrape-it', ['uses' => 'ScrapeController@scrape']);

    /******************************Custom Links****************************************************/
    Route::get('/list-of-{group}-{category}', [ 'as' => 'listing', 'uses' => 'CustomLinksController@listing' ] )->where(array('page'=>'[0-9]+'));
    Route::get('/list-of-photo-{category}/{keyword}/{page?}', [ 'as' => 'list_of_category', 'uses' => 'CustomLinksController@list_of_category' ] )->where(array('page'=>'[0-9]+'));
    Route::get('/list-of-soft-{category}/{keyword}/{page?}', [ 'as' => 'list_of_category', 'uses' => 'CustomLinksController@list_of_category' ] )->where(array('page'=>'[0-9]+'));

    Route::get('/list-of-{group}-{category}/{keyword}/{page?}', [ 'as' => 'list_of_men_women', 'uses' => 'v3\ListingController@list_of_men_women' ] )->where(array('page'=>'[0-9]+'));
    Route::get('/list-of-{category}/{keyword}/{page?}', [ 'as' => 'list_of_category', 'uses' => 'v3\ListingController@list_of_category' ] )->where(array('page'=>'[0-9]+'));

    /******************************Spcial Occasions Routes****************************************************/
    Route::get('/mothers-day-gift-ideas-online/{page?}', [ 'as' => 'mothers_day', 'uses' => 'OccasionsController@day' ]);
    /******************************Valentine Day****************************************************/
    Route::get('/romantic-february-valentines-special', [ 'as' => 'feb_valentine', 'uses' => 'ValentineController@index' ]);
    Route::get('/{day_name}-day-gifts-ideas-online/{page?}', [ 'as' => 'gifts_online', 'uses' => 'ValentineController@day' ]);
    Route::get('/valentine-day-contest-online-in-india', [ 'as' => 'conetst_online', 'uses' => 'ContestController@index' ]);
    Route::get('/valentine-day-contest-upload-romantic-couple-video-in-india', [ 'as' => 'romantic_couple_video', 'uses' => 'ContestController@video' ]);
    Route::post('/contest/upload', 'ContestController@file_upload');
    Route::get('/valentine-day-contest-upload-romantic-couple-photo-in-india', [ 'as' => 'romantic_couple_photo', 'uses' => 'ContestController@photo' ]);
    Route::get('/valentine-day-contest-showcase-your-valentine-moments-in-india', [ 'as' => 'showcase_talent', 'uses' => 'ContestController@storyBoard']);
    Route::post('/storyboard/album', 'ContestController@storyAlbum');
    Route::post('/storyboard/log_insert', 'ContestController@storyAlbum_insert');
    Route::get('/valentine-day-contest-write-own-love-quotation-story-in-india', [ 'as' => 'love_quotation', 'uses' => 'ContestController@quotation' ]);
    Route::post('/contest/quotation', 'ContestController@quotation_insert');
    Route::get('/valentine-day-contest-write-own-love-story-in-india', [ 'as' => 'write_love_story', 'uses' => 'ContestController@love_story' ]);
    Route::post('/contest/love_story', 'ContestController@love_story_insert');
    /******************************Valentine Day****************************************************/

    Route::get('/loghotdeal', 'RedirectController@loghotdeal1');

    Route::any('/myaccount', [ 'as' => 'myaccount', 'uses' => 'LoginController@myaccount' ]); //User Account
    Route::get('/user/logout', [ 'as' => 'logout', 'uses' => 'LoginController@logout' ]); // User Logout
    Route::any('/user/resetPassword', [ 'as' => 'reset', 'uses' => 'LoginController@resetPassword' ]); // Password reset

    Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
        Route::get('reset', [ 'as' => 'reset_form', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
        Route::post('email', [ 'as' => 'send_reset', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
        Route::get('reset/{token}', [ 'as' => 'reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
        Route::post('reset', [ 'as' => 'reset_submit', 'uses' => 'Auth\ResetPasswordController@reset']);
    });

    Route::get('instagram', [ 'as' => 'instagram', 'uses' => 'HomeController@instagram' ]); // instagram Page
    Route::get('/storyboard/privacy-policy', [ 'as' => 'about', 'uses' => 'HomeController@privacy_policy' ]); // About Us Page
    Route::get('/thankyou.html', [ 'as' => 'thankyou', 'uses' => 'ExtensionController@thankyou' ] ); //Extn thank you page
    Route::post('/thankyou.html', [ 'as' => 'thankyou', 'uses' => 'ExtensionController@thankyou' ] ); // Extn Thank you page submitting the values.
    Route::get( '/slogin/process/facebook', [ "as" => 'fb_auth', "uses" => "ExtensionController@processFbAuth" ] ); // Social Login/Registration process request page
    Route::get( '/slogin/process', [ "as" => 'google_auth', "uses" => "ExtensionController@processGoogleAuth" ] ); // Social Login/Registration process request page
    Route::get( '/slogin/{provider}', "ExtensionController@login" ); // Social Login/Registration Page
    Route::get('/coupons/{vendor}-coupons.html/{page?}', [ 'as' => 'couponlist', 'uses' => 'CouponController@couponlist' ] ); // Coupon Lising by Vendor..

    Route::get('mobiles/{brand}/best-phones-under-rs-{price}.html/{page?}', [ 'as' => 'bbphones', 'uses' => 'ListingController@bBrandPhones' ] ); // Mobile phone listing by Max price & Brand wise filter

    Route::get('mobiles/best-mobile-phones-between-{minprice}-{maxprice}-india.html/{page?}', [ 'as' => 'bbetphones', 'uses' => 'ListingController@bbetPhones' ] ); // Mobile phone listing by Min & Max price filter

    Route::get('mobiles/best-phones-under-rs-{price}.html/{page?}', [ 'as' => 'bestphones', 'uses' => 'v3\ListingController@bestPhones' ] ); // Mobile phone listing by Max price filter


    Route::get('coupons/discount/{category}/{page?}', [ 'as' => 'couponcat', 'uses' => 'CouponController@couponlistcategory' ] ); // Coupon Listing by Category
    Route::get('coupon/couponlistdetail', [ 'as' => 'coupondetail', 'uses' => 'CouponController@couponlistdetail' ] ); // Coupon Detail page old ..
    Route::get('coupon/{name}/{promo}', [ 'as' => 'coupondetail', 'uses' => 'CouponController@couponlistdetail' ] ); // Coupon detail page new.
    Route::post('coupon/{name}/{promo}', [ 'as' => 'coupondetail', 'uses' => 'CouponController@couponlistdetail' ] );// Coupon Report POST request
    Route::get('coupon/filter/{page?}', 'CouponController@filter'); // Coupon Filter Ajax request..
    Route::get('search/{group}/{keyword}/{page?}', [ 'as' => 'search_new', 'uses' => 'v3\ListingController@searchList' ] )->where(array('page'=>'[0-9]+')); // Product search page and controller.
    Route::get('search', [ 'as' => 'search', 'uses' => 'ListingController@searchList' ] ); // Product search page and controller.

    Route::get('products-list/{brand}/{cat}/{order_by?}/{sort_order?}/{page?}', 'ProductController@list_products')->where(array('page'=>'[0-9]+')); // Product Listing by brand and category.... this is not used by still there to avoid 404 requests.

    Route::get('ajaxContent/{section}', 'HomeController@ajaxContent'); // GET request for Ajax request on home page
    #Route::get('products/vendor/{vendorid}/{page?}', 'ProductController@productList'); // ProductList old..

    Route::get('most-compared-mobiles.html', [ 'as' => 'most-compared', 'uses' => 'v3\CompareController@mostCompared' ] ); // Most Compared mobiles route
    Route::get('compare-mobiles/{mobile1?}/{mobile2?}', [ 'as' => 'compare-mobiles', 'uses' => 'v3\CompareController@compareMobile' ]); // Compare two mobiles with their product ID
    Route::get('redirect', [ 'as' => 'track_url', 'uses' => 'RedirectController@send'] ); // redirect controller to send out the link on other websites
    // Route::get('product/detail/{name}/{id}', 'ProductController@product_detail_old' ); //Product detail page non comparitive
    Route::get('product/detail/{name}/{id}-{vendor}', 'ProductController@product_detail_red_comp' ); //Product detail page non comparitive
    Route::get('product/{name}/{id}-{vendor}', 'ProductController@product_detail_red_comp' ); //Product detail page non comparitive
    /*Route::get('{name}/{id}-{vendor}', 'ProductController@product_detail' ); //Product detail page non comparitive*/

    Route::get('product/list_products/{parent}/{cat_id}/{d?}/{b?}/{c?}', ['as' => 'old_listing_page', 'uses' => 'v2\ListingController@redirectOldListingPage']);
    Route::get('product/{slug}/{id}-{vendor}/amp', [ 'as' => 'amp_detail_non_comp', 'uses' => 'v3\AmpController@nonComparative'] ); //Product detail page non comparitive
    Route::get('product/{name}/{id}', 'ProductController@product_detail_red' ); // Product detail page comparitive, mobiles etc

    Route::get('product/{slug}/{id}/amp', [ 'as' => 'amp_detail_comp', 'uses' => 'v3\AmpController@comparative' ] ); // Product detail page comparitive, mobiles etc
    Route::get('books/{slug}/{id}-{vendor}/amp', [ 'as' => 'amp_detail_books', 'uses' => 'v3\AmpController@books' ] ); // Product detail page comparitive, mobiles etc
    Route::get('product/detail1/{name}/{id}', 'ProductController@product_detail_red' ); // Product detail page comparitive, mobiles etc

    Route::get('{parent}/{category}-{page?}.html', [ 'as' => 'sub_category', 'uses' => 'v3\ListingController@subCategoryList'] )->where(array('page'=>'[0-9]+')); // Product Listing page 2nd level...
    Route::get('{parent}/{category}.html', [ 'as' => 'sub_category', 'uses' => 'v3\ListingController@subCategoryList'] )->middleware(['myHeader']); // Product Listing page 2nd level...


    Route::get('{parent}/{category}/{page?}', [ 'as' => 'sub_category', 'uses' => 'v3\ListingController@subCategoryList' ] )->where(array('page'=>'[0-9]+')); // Product Listing page 2nd level..used to redirect link to .html link

    Route::get('{parent}/pricelist/{category}.html/{page?}',['as' =>'product_list_old1','uses'=>'ListingController@error_404']); // 404

    // seoEnable is defined in config/app.php
    if( !config('app.seoEnable') )
    {
        Route::get('{parent}/{child}/{category}/{page?}', [ 'as' => 'product_list', 'uses' => 'v3\ListingController@categoryList' ] )->where(array('page'=>'[0-9]+')); // Product Listing page 3rd level

    }
    else
    {
        Route::get('{parent}/{child}/{category}-{page?}.html',['as' =>'product_list','uses'=>'v3\ListingController@childCategoryList'])->where(array('page'=>'[0-9]+')); // Product Listing page 3rd level.
        Route::get('{parent}/{child}/{category}.html',['as' =>'product_list','uses'=>'v3\ListingController@childCategoryList']); // Product Listing page 3rd level.
        Route::get('{parent}/{child}/{category}/{page?}', [ 'as' => 'product_list', 'uses'=>'v3\ListingController@childCategoryList' ])->where(array('page'=>'[0-9]+')); // Product Listing page 3rd level..used to redirect link to .html link
    }

    Route::get('/livesearch', 'HomeController@livesearch'); // AutoSuggest json file
    Route::get('/couponImage', 'CouponController@resizeCouponImages'); // Storing dealz image on indiashopps server

    Route::get('/pimages', 'ImageController@index'); // Storing image to local server from remote server with different image sizes...




    Route::get('log_live_data', 'RedirectController@log'); // Logging controller to get the trending products.
    Route::get('hot-trending-products', [ 'as' => 'trending', 'uses' => 'ProductController@trending' ] ); // Trending Products..
    Route::get('/all-categories', [ 'as' => 'all-cat', 'uses' => 'v2\CommonController@categories' ] ); // List of all categories..
    Route::get('/create_sitemap', 'ProductController@sitemap'); // Generate Sitemap with categories and products.
    Route::get('{category}', ['as' => 'category_list', 'uses' => 'v3\ListingController@categoryList'])->middleware(['myHeader']); //Category page..
});
Route::get('500', function()
{
    abort(500);
});
