<?php

// User Auth
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::get('/user', 'AuthController@user');
Route::post('/logout', 'AuthController@logout');

//Job
Route::group(['prefix' => 'jobs'],function() {
    Route::post('/', 'JobController@store')->middleware('auth:api');
});