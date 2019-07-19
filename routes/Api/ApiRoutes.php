<?php
Route::group(['prefix' => 'fcm'], function () {
    Route::post('single/send_notification', [
        'as'   => 'send_single_notification',
        'uses' => 'FcmController@singleNotification'
    ]);
    Route::post('send_notification', [
        'as'   => 'send_fcm_notification',
        'uses' => 'FcmController@fcmNotificationRequest'
    ]);
    Route::get('get_token', ['as' => 'fcm_token', 'uses' => 'FcmController@getToken']);
    Route::get('save_token', ['as' => 'vendor_save_fcm_token', 'uses' => 'v2\CommonController@vendorSaveFcmToken']);
    Route::get('subscribe', [
        'as'   => 'track_service_worker_subscriber',
        'uses' => 'FcmController@serviceWorkerSubscriber'
    ]);
});

Route::group([
    'prefix'     => 'android',
    'as'         => 'api.android.',
    'namespace'  => 'android',
    'middleware' => ['api_check']
], function () {
    Route::get('get-home-json', ['as' => 'home_json', 'uses' => 'ApiController@homeJson']);
    Route::post('insert-feedback', ['as' => 'app_feedback', 'uses' => 'ApiController@insertFeedback']);
    Route::get('get-token', ['as' => 'android_token', 'uses' => 'ApiController@getToken']);
});

Route::group(['prefix' => 'facebook', 'namespace' => 'background'], function () {
    Route::get('get-token', ['as' => 'fcm_token', 'uses' => 'FacebookController@getToken']);
    Route::get('get-image/{id}', ['as' => 'fcm_token', 'uses' => 'FacebookController@getImage']);
    Route::any('update-products', ['as' => 'fb_product_update', 'uses' => 'FacebookController@productUpdate']);
});

Route::group(['prefix' => 'commands/run', 'as' => 'run.'], function () {
    Route::get('clear-cache/{key?}', ['uses' => 'v3\CommonController@clearCache', 'as' => 'clear-cache']);
});

Route::group([
    'prefix'     => 'store',
    'as'         => 'store.api.',
    'namespace'  => 'store',
    'middleware' => ['api_check']
], function () {
    Route::group([
        'prefix' => 'product',
        'as'     => 'product',
    ], function () {
        Route::get('launched/{product_id}',[ 'as' => 'launched', 'uses' => 'ApiController@productLaunched' ]);
    });
});