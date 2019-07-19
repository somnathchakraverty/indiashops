<?php
Route::get('earnings', ['as' => 'earnings', 'uses' => 'UserController@earnings']);
Route::any('withdraw', ['as' => 'withdraw', 'uses' => 'UserController@withdraw']);
Route::any('missing-cashback', ['as' => 'missing', 'uses' => 'UserController@missing']);
Route::get('missing-claim', ['as' => 'missing.claim', 'uses' => 'UserController@missingClaim']);
Route::any('profile-settings', ['as' => 'settings', 'uses' => 'UserController@settings']);
Route::get('claim/detail/{ticket_id}', ['as' => 'claim.detail', 'uses' => 'UserController@claimDetail']);
Route::post('claim/add-comment/{ticket_id}', ['as' => 'claim.comment', 'uses' => 'UserController@addComment']);
Route::any('users/create', ['as' => 'users.create', 'uses' => 'UserController@createUser']);
Route::any('users/{user_id?}', ['as' => 'users', 'uses' => 'UserController@users']);
Route::any('purchase-orders/{order_id?}', ['as' => 'purchase.orders', 'uses' => 'UserController@purchaseOrders']);
Route::get('add-product-to-order', ['as' => 'add-product-order', 'uses' => 'UserController@addProductToPurchaseOrder']);
Route::get('update-product-quantity', ['as' => 'update-prod-qty', 'uses' => 'UserController@updateProductQuantity']);
