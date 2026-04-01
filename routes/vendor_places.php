<?php

use Illuminate\Support\Facades\Route;

exit;
Route::group(['namespace' => 'App\Http\Controllers\Vendor', 'as' => 'vendor.'], function () {
    exit;
    /*authentication*/
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', 'LoginController@login')->name('login');
        Route::post('login', 'LoginController@submit');
        Route::get('logout', 'LoginController@logout')->name('logout');
        Route::group(['prefix' => 'employee', 'as' => 'employee.'], function () {
            Route::post('login', 'EmployeeLoginController@submit')->name('login');
            Route::get('logout', 'EmployeeLoginController@logout')->name('logout');
        });
    });
    /*authentication*/

    Route::group(['middleware' => ['vendor']], function () {
        Route::get('/', 'DashboardController@dashboard')->name('dashboard');
    });
});
