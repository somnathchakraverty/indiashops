<?php
Route::pattern('slug', '[a-z-0-9]+');
Route::pattern('vendor', '[a-z-0-9]+');
Route::pattern('category', '[a-z0-9-]+');
Route::pattern('id', '\d+');
Route::pattern('search_id', '\d+');
Route::pattern('good', '\d+');

Route::get('404.html', ['as' => '404-page', 'uses' => 'CommonController@pageNotFound']); // Compare products
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']); //HomePage Route
Route::get('/', ['as' => 'home_v2', 'uses' => 'HomeController@index']); //HomePage Route
Route::get('compare-products', ['as' => 'compare-products', 'uses' => 'CompareController@index']); // Compare products
Route::get('log', ['as' => 'log_data', 'uses' => 'CommonController@log']); // Compare products
Route::any('contact-us', ['as' => 'contact', 'uses' => 'CommonController@contact']); // Contact Us Page.
Route::any('flipkart-plus-loyalty-program', ['as' => 'fk_loyality', 'uses' => 'CommonController@flipkartLoyalty']); // Contact Us Page.
Route::get('flipkart-the-freedom-sale', [ 'as' => 'flipkart-sale', 'uses' => 'CommonController@flipkartSale' ]);
Route::get('flipkart-big-billion-day-sale', [ 'as' => 'bbillion-sale', 'uses' => 'CommonController@bbillionSale' ]);
Route::get('sitemap.html', ['as' => 'sitemap_v2', 'uses' => 'CommonController@sitemap']);
Route::any('about-us', ['as' => 'aboutus_v2', 'uses' => 'CommonController@aboutUS']); //HomePage Route
Route::get('career', ['as' => 'career', 'uses' => 'CommonController@career']); // Career Page.
Route::get('/privacy-policy', [ 'as' => 'privacy_policy', 'uses' => 'CommonController@privacy_policy' ]); // Privacy Page

Route::get('upcoming-mobiles-in-india/{page?}', ['as' => 'upcoming_mobiles', 'uses' => 'ListingController@upcomingMobiles']); //Upcoming Mobiles Page.
Route::get('storage/app/html/mobile-menu.html', ['as' => 'mobile-menu-html', 'uses' => 'CommonAjaxController@menuHtml']);

Route::group(['prefix' => 'v3/ajax-content'], function () {
    Route::get('upcoming-notify', ['as' => 'upcoming-notify', 'uses' => 'CommonController@upcomingNotify']);
    Route::get('main-menu-html', ['as' => 'main-menu-html', 'uses' => 'CommonAjaxController@menuHtml']);
    Route::get('search-feedback/{search_id}/{good}', [ 'as' => 'search-feedback', 'uses' => 'ListingController@searchFeedback' ]);
    Route::any('compare-product', ['as' => 'compare_competitors', 'uses' => 'ProductController@compareProductsList']);
    Route::get('/{section?}', ['as' => 'v3_ajax_home', 'uses' => 'HomeController@getHomeAjaxContent']);
    Route::any('products/{section?}', ['as' => 'detail-ajax-v3', 'uses' => 'ProductController@ajaxContent']);
    Route::any('category/products/{section?}', ['as' => 'listing-ajax-v3', 'uses' => 'ListingController@ajaxContent']);
    Route::any('common/{section?}', ['as' => 'common-ajax', 'uses' => 'CommonAjaxController@index']);
    Route::any('coupon/{section?}', ['as' => 'coupon-ajax', 'uses' => 'CouponController@ajaxContent']);
    Route::any('product/submit-review/{id}',['as' => 'add_product_review', 'uses' => 'ProductController@addProductReview']);
});

Route::get('{parent}/{category}/all-brands', [ 'as' => 'category_all_brands', 'uses' => 'ListingController@categoryAllBrands'] ); // Product Listing page 2nd level...

Route::group(['prefix' => '/', 'as' => 'brands.'], function () {
    Route::get('{group}/brands/{brand}/{category}-price-list-in-india/{page?}', [ 'as' => 'listing', 'uses' => 'ListingController@categoryBrandList' ]);
});
/*------------------ Mobile Review PAGE ROUTES-----------*/
Route::get('mobile/{slug}-review-{id}', ['as' => 'mobile_review_page', 'uses' => 'ProductController@mobileReview']);
Route::get('ajax/mobile/reviews/{product_id}', ['as' => 'reviews_ajax', 'uses' => 'ProductController@mobileReviewAjax']);

################## AMP ROUTES START ##############
Route::group(['prefix' => 'amp', 'as' => "amp."], function () {
    Route::any('/', ['as' => 'home', 'uses' => 'AmpController@index']);

    ################## AMP LISTING PAGES STARTS ##############
    Route::get('{parent}/{category}-{page?}.html', [ 'as' => 'sub_category', 'uses' => 'AmpController@subCategoryList'] )->where(array('page'=>'[0-9]+')); // Product Listing page 2nd level...
    Route::get('{parent}/{category}.html', [ 'as' => 'sub_category', 'uses' => 'AmpController@subCategoryList'] ); // Product Listing page 2nd level...
    Route::get('{parent}/{category}/{page?}', [ 'as' => 'sub_category', 'uses' => 'AmpController@subCategoryList' ] )->where(array('page'=>'[0-9]+')); // Product Listing page 2nd level..used to redirect link to .html link

    Route::get('{parent}/{child}/{category}-{page?}.html',['as' =>'product_list','uses'=>'AmpController@childCategoryList'])->where(array('page'=>'[0-9]+')); // Product Listing page 3rd level.
    Route::get('{parent}/{child}/{category}.html',['as' =>'product_list','uses'=>'AmpController@childCategoryList']); // Product Listing page 3rd level.
    Route::get('{parent}/{child}/{category}/{page?}', [ 'as' => 'product_list', 'uses'=>'AmpController@childCategoryList' ])->where(array('page'=>'[0-9]+')); // Product Listing page 3rd level..used to redirect link to .html link
    ################## AMP LISTING PAGES ENDS ##############
    ################## AMP BRAND LISTING PAGES ENDS ##############
    Route::group(['prefix' => '/', 'as' => 'brands.'], function () {
        Route::get('{group}/brands/{brand}/{category}-price-list-in-india/{page?}', [ 'as' => 'listing', 'uses' => 'AmpController@categoryBrandList' ]);
    });
    Route::get('{brand}-{category}-price-list-in-india-{id}-{page}',
        ['as' => 'brand_category_list_comp', 'uses' => 'AmpController@brandCategoryListComp'])
         ->where(['page' => '[0-9]+']);

    Route::get('{brand}-{category}-price-list-in-india-{id}',
        ['as' => 'brand_category_list_comp_1', 'uses' => 'AmpController@brandCategoryListComp']);

    Route::get('{brand}-{group}-{category}-price-list-in-india/{page}',
        ['as' => 'brand_category_list', 'uses' => 'AmpController@brandCategoryList'])
         ->where(['page' => '[0-9]+']);

    Route::get('{brand}-{group}-{category}-price-list-in-india',
        ['as' => 'brand_category_list', 'uses' => 'AmpController@brandCategoryList']);

    Route::get('{category}', ['as' => 'category_list', 'uses' => 'AmpController@categoryList']); //Category page..
});
################## AMP ROUTES END ##############

################## PRODUCT CASHBACK START ##############
Route::group(['prefix'    => '/', 'namespace' => 'Cashback'], function () {
    Route::get('coupons/out/{offerid}', ['as' => 'coupon_out_page', 'uses' => 'RedirectController@couponRedirect']);
    Route::get('out/send-to-store/{id}-{vendor}', ['as' => 'product_redirect_non_comp', 'uses' => 'RedirectController@redirectNonComp']);
    Route::get('out/send-to-store/{id}/{ref_id}', ['as' => 'product_redirect_comp', 'uses' => 'RedirectController@redirectComp']);
    Route::get('out/send-to-store/{vendor_id}', ['as' => 'vendor_redirect_page', 'uses' => 'RedirectController@vendorRedirect']);
    Route::get('ext/out/send-to-store', ['as' => 'ext_product_redirect', 'uses' => 'RedirectController@extRedirect']);
});
################## PRODUCT CASHBACK END ##############

Route::group(['prefix' => 'ajax-content'], function () {
    Route::get('exit-popup', ['as' => 'exit_popup_html', 'uses' => 'CommonController@exitPopupHTML']);
});

/*------------------ CUSTOM PAGES ROUTES-----------*/

Route::get('{slug}-90001-{page}', ['as' => 'custom_page_list', 'uses' => 'ListingController@customPageListing'])
     ->where(['page' => '[0-9]+']);
Route::get('{slug}-90001', ['as' => 'custom_page_list', 'uses' => 'ListingController@customPageListing']);

/*------------------ CUSTOM PAGES NEW ROUTES-----------*/
Route::get('{category_group}/prices/{slug}-price-list/{page?}', ['as' => 'custom_page_list_v3', 'uses' => 'ListingController@customPageListingV3'])
     ->where(['page' => '[0-9]+']);
/*------------------ CUSTOM PAGES ROUTES-----------*/

Route::group(['prefix'    => 'cashback', 'as' => 'cashback.', 'namespace' => 'Cashback', 'middleware' => ['login']], function () {
    require base_path('routes/V3/cashback_routes.php'); // All Cashback Routes
});

Route::any('user/register', ['as' => 'register_v2', 'uses' => 'AuthController@signup']); //HomePage Route
Route::any('user/login', ['as' => 'login_v2', 'uses' => 'AuthController@login']); //HomePage Route

Route::pattern('category', '[a-z0-9-]+');
Route::get('discount/{category}-coupons/{page?}', ['as' => 'category_page_v2', 'uses' => 'CouponController@category']);
//Coupons Page..
Route::get('coupons', ['as' => 'coupons_v2', 'uses' => 'CouponController@index']);
//Coupon Listing Page
Route::get('{vendor}-coupons/{page?}', ['as' => 'vendor_page_v2', 'uses' => 'CouponController@vendor']);
Route::get('couponsearch/{page?}', ['as' => 'coupon_search', 'uses' => 'CouponController@search']);

Route::get('{brand}-{category}-price-list-in-india-{id}-{page}',
    ['as' => 'brand_category_list_comp', 'uses' => 'ListingController@brandCategoryListComp'])
     ->where(['page' => '[0-9]+']);
Route::get('{brand}-{category}-price-list-in-india-{id}',
    ['as' => 'brand_category_list_comp_1', 'uses' => 'ListingController@brandCategoryListComp']);
Route::get('{brand}-{group}-{category}-price-list-in-india/{page}',
    ['as' => 'brand_category_list', 'uses' => 'ListingController@brandCategoryList'])
     ->where(['page' => '[0-9]+']);
Route::get('{brand}-{group}-{category}-price-list-in-india',
    ['as' => 'brand_category_list', 'uses' => 'ListingController@brandCategoryList']);

Route::get('{slug}-price-in-india-{id}', ['as' => 'product_detail_v2', 'uses' => 'ProductController@comparative']);
Route::get('{slug}-price-in-india-{id}-{vendor?}',
    ['as' => 'product_detail_v2_1', 'uses' => 'ProductController@comparative']);

Route::get('books/{slug}-price-in-india-{id}-{vendor}',
    ['as' => 'product_detail_non_book', 'uses' => 'ProductController@bookDetail']);
Route::get('{cat_name}/{slug}-price-in-india-{id}-{vendor?}',
    ['as' => 'product_detail_non', 'uses' => 'ProductController@nonComparative']);

Route::group(['prefix' => 'mobile'], function () {
    Route::group(['prefix' => 'ajax-content'], function () {
        Route::any('get-page',['as' => 'get_mobile_ajax_page', 'uses' => 'MobileController@getPage' ]);
    });
});
?>