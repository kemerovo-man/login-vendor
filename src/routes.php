<?php

Route::group(['middleware' => 'web'], function () {
    Route::get('/login', '\KemerovoMan\LoginVendor\LoginController@index');
    Route::post('/login', '\KemerovoMan\LoginVendor\LoginController@login');
    Route::get('/logout', '\KemerovoMan\LoginVendor\LoginController@logout');
});