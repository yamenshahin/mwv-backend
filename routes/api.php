<?php

// User Auth
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::get('/user', 'AuthController@user');
Route::post('/logout', 'AuthController@logout');

//Job Customer
Route::group(['prefix' => 'jobs'],function() {
    Route::post('/store', 'JobController@store')->middleware('auth:api');
    Route::get('/show', 'JobController@show')->middleware('auth:api');
    Route::get('/get-current/{id}', 'JobController@getCurrent')->middleware('auth:api');
    Route::post('/checkout', 'CheckoutController@checkout');
});

//Search Places
Route::group(['prefix' => 'places'],function() {
    Route::post('/', 'DriverPlaceController@search');
});
//Driver
Route::group(['prefix' => 'driver'],function() {
    Route::post('/create-update-price', 'DriverPlaceController@createOrUpdatePrice')->middleware('auth:api');
    Route::get('/get-price', 'DriverPlaceController@getPrice')->middleware('auth:api');
    Route::post('/create-update-location', 'DriverPlaceController@createOrUpdateLocation')->middleware('auth:api');
    Route::get('/get-location', 'DriverPlaceController@getLocation')->middleware('auth:api');
});

//User's files
Route::group(['prefix' => 'files'],function() {
    Route::apiResources([
        'user-file' => 'UserFileController'
    ]);
});
//Admin
Route::group(['prefix' => 'admin'],function() {
    Route::apiResources([
        'user' => 'AdminAPI\UserController',
        'admin' => 'AdminAPI\AdminController',
        'job' => 'AdminAPI\JobController'
    ]);
});