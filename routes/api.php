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
    Route::post('/store-authenticated', 'JobController@storeAuthenticated')->middleware('auth:api');
    Route::post('/store-unauthenticated', 'JobController@storeUnauthenticated');
    Route::get('/show', 'JobController@show')->middleware('auth:api');
    Route::get('/get-current/{id}', 'JobController@getCurrent')->middleware('auth:api');
    Route::post('/checkout-credit', 'CheckoutController@checkoutCredit');
    Route::post('/checkout-cash', 'CheckoutController@checkoutCash');
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
        'jobs' => 'DriverJobsController',
        'wallet' => 'WalletController',
    ]);
    Route::post('/request-payment', 'PaymentController@requestPayment')->middleware('auth:api');
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
        'meta' => 'AdminAPI\MetaController',
        'feedback-jobs' => 'AdminAPI\FeedbackJobController',
    ]);
    Route::post('/pages', 'AdminAPI\PageController@index');
    Route::post('/pages/save', 'AdminAPI\PageController@update');
    Route::post('/statistic', 'AdminAPI\StatisticController@index');
});
//Admin email
Route::group(['prefix' => 'admin/email'],function() {
    Route::post('/send', 'AdminAPI\EmailContactUserController@send');
});
//User email
Route::group(['prefix' => 'user/email'],function() {
    Route::post('/send', 'EmailContactUsController@send');
    Route::post('/send-quote', 'EmailSavedQuoteController@sendQuote');
});
//Feedback
Route::group(['prefix' => 'feedback'],function() {
    Route::post('/job/store', 'FeedbackJobController@store')->middleware('auth:api');
    Route::post('/job/show', 'FeedbackJobController@index');
});
//Pages
Route::post('/pages', 'PageController@index');