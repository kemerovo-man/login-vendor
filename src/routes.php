<?php

Route::group(['middleware' => 'web'], function () {
    $loginRoute = config('login.loginRoute', 'login');
    $logoutRoute = config('login.logoutRoute', 'logout');
    Route::get($loginRoute, '\KemerovoMan\LoginVendor\LoginController@index');
    Route::post($loginRoute, '\KemerovoMan\LoginVendor\LoginController@login');
    Route::get($logoutRoute, '\KemerovoMan\LoginVendor\LoginController@logout');
});
