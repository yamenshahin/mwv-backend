<?php

// User Auth
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::get('/user', 'AuthController@user');
Route::post('/logout', 'AuthController@logout');

//User
Route::group(['prefix' => 'user'],function() {
    Route::post('/set-role', 'AuthController@setRole')->middleware('auth:api');
    Route::post('/update', 'AuthController@update')->middleware('auth:api');
});


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
    Route::get('/all', 'DriverPlaceController@getAllPlaces');
});
//Driver
Route::group(['prefix' => 'driver'],function() {
    Route::post('/create-update-price', 'DriverPlaceController@createOrUpdatePrice')->middleware('auth:api');
    Route::post('/create-update-legal', 'DriverPlaceController@createOrUpdateLegal')->middleware('auth:api');
    Route::get('/get-price', 'DriverPlaceController@getPrice')->middleware('auth:api');
    Route::get('/get-legal', 'DriverPlaceController@getLegal')->middleware('auth:api');
    Route::post('/create-update-location', 'DriverPlaceController@createOrUpdateLocation')->middleware('auth:api');
    Route::get('/get-location', 'DriverPlaceController@getLocation')->middleware('auth:api');
    Route::apiResources([
        'jobs' => 'DriverJobsController'
    ]);
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
        'job' => 'AdminAPI\JobController',
        'meta' => 'AdminAPI\MetaController'
    ]);
});
//Email
Route::group(['prefix' => 'email'],function() {
    Route::post('/send', 'EmailController@send');
});