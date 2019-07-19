<?php
Route::get('v2/notify/html',[ 'as' => 'notify_html', 'uses' => 'CommonController@getNotifyHtml' ]);
Route::pattern('slug', '[a-z-0-9]+');
Route::pattern('vendor', '[a-z-0-9]+');

Route::group(['prefix' => 'ajax-content'], function () {
    Route::any('products/{section?}', ['as' => 'detail-ajax', 'uses' => 'ProductController@ajaxContent']);
    Route::get('mobile/{section?}', ['as' => 'mobile-detail-ajax', 'uses' => 'ProductController@mobileAjaxContent']);
    Route::get('autocomplete.html', ['as' => 'autocomplete_error', 'uses' => 'CommonController@autocomplete']);
    Route::get('subscribe', ['as' => 'subscribe_email', 'uses' => 'CommonController@subscribe']);

    Route::group(['prefix' => 'mobile'], function () {
        Route::get('page/{section?}', ['as' => 'mobile-page-content', 'uses' => 'MobileController@getAjaxContent']);
    });
});

Route::get('command/{name}/{param?}', 'CommonController@command');
Route::get('fcm/save_token', ['as' => 'fcm_token_save', 'uses' => 'CommonController@saveFCMToken']);

Route::pattern('category', '[a-z0-9-]+');
Route::pattern('id', '\d+');

Route::get('/category-brands', ['as' => 'category_brand', 'uses' => 'ListingController@topBrands']);
?>