<?php

use App\Http\Controllers\Admin\AdminEmployeeController;
use App\Http\Controllers\Admin\AdminRoleEmployeeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CompilationController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PlaceController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ZoneController;
use App\Http\Controllers\Admin\UserWalletController;
use App\Http\Controllers\Admin\OfferController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BusinessSettingController;


Route::group(['namespace' => 'App\Http\Controllers\Admin', 'as' => 'admin.'], function () {

    /*authentication*/
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', 'LoginController@login')->name('login');
        Route::post('submit-login', 'LoginController@submit')->name('postLogin');//->middleware('actch')
        Route::get('logout', 'LoginController@logout')->name('logout');
    });
    /*authentication*/



    Route::group(['middleware' => ['admin']], function () {
        //dashboard
        Route::get('/', 'DashboardController@dashboard')->name('dashboard');
 Route::get('line-chart', 'DashboardController@dashboard_data')->name('line-chart');
        Route::get('index_', 'DashboardController@index')->name('index_');

        /*  Route::get('/', function () {

              return ("hdhskadjasdja");
          })->name('admin.index');*/
        //dashboard
        // Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::group(['prefix' => 'notification', 'as' => 'notification.'], function () {
            Route::get('/', [NotificationController::class, 'index'])->name('index');
            Route::get('create', [NotificationController::class, 'create'])->name('create');
            Route::post('store', 'NotificationController@store')->name('store');
            Route::get('edit/{notification}', 'NotificationController@edit')->name('edit');
            Route::post('update/{notification}', 'NotificationController@update')->name('update');
            Route::get('status/{id}/{status}', 'NotificationController@status')->name('status');
            Route::post('change_status', 'NotificationController@change_status')->name('change-status');
            Route::delete('delete/{notification}', 'NotificationController@destroy')->name('delete');
            Route::post('search', 'NotificationController@search')->name('search');

        });
        Route::group(['prefix' => 'banner', 'as' => 'banner.'], function () {

            Route::get('/', [BannerController::class, 'index'])->name('index');
            Route::get('create', [BannerController::class, 'create'])->name('create');
            Route::post('store', 'BannerController@store')->name('store');
            Route::get('edit/{banner}', 'BannerController@edit')->name('edit');
            Route::post('update/{banner}', 'BannerController@update')->name('update');
            Route::get('status/{id}/{status}', 'BannerController@status')->name('status');
            Route::post('change_status', 'BannerController@change_status')->name('change-status');
            Route::get('delete/{banner}', 'BannerController@delete')->name('delete');
            Route::post('search', 'BannerController@search')->name('search');
            Route::post('place_comp', 'BannerController@place_comp')->name('place-comp');
        });
        Route::group(['prefix' => 'coupon', 'as' => 'coupon.'], function () {

            Route::get('/', [CouponController::class, 'index'])->name('index');
            Route::get('create', [CouponController::class, 'create'])->name('create');
            Route::post('store', 'CouponController@store')->name('store');
            Route::get('edit/{id}', 'CouponController@edit')->name('edit');
            Route::post('update/{id}', 'CouponController@update')->name('update');
            Route::get('status/{id}/{status}', 'CouponController@status')->name('status');
            Route::post('change_status', 'CouponController@change_status')->name('change-status');
            Route::delete('delete/{id}', 'CouponController@destroy')->name('delete');
            Route::post('search', 'CouponController@search')->name('search');
        });

		
		
		        Route::group(['prefix' => 'offer', 'as' => 'offer.'], function () {

            Route::get('/', [OfferController::class, 'index'])->name('index');
            Route::get('create', [OfferController::class, 'create'])->name('create');
            Route::post('store','OfferController@store')->name('store');
            Route::get('edit/{id}', 'OfferController@edit')->name('edit');
            Route::post('update/{id}', 'OfferController@update')->name('update');
            Route::get('status/{id}/{status}', 'OfferController@status')->name('status');
            Route::post('change_status', 'OfferController@change_status')->name('change-status');
            Route::delete('delete/{id}', 'OfferController@destroy')->name('delete');
            Route::post('search', 'OfferController@search')->name('search');
        });
		
		
		
		
        Route::group(['prefix' => 'attribute', 'as' => 'attribute.'/*, 'middleware' => ['module:attribute']*/], function () {
            Route::get('add-new', 'AttributeController@index')->name('add-new');
            Route::post('store', 'AttributeController@store')->name('store');
            Route::get('edit/{id}', 'AttributeController@edit')->name('edit');
            Route::post('update/{id}', 'AttributeController@update')->name('update');
            Route::delete('delete/{id}', 'AttributeController@delete')->name('delete');
            Route::post('search', 'AttributeController@search')->name('search');
            Route::get('export-attributes/{type}', 'AttributeController@export_attributes')->name('export-attributes');
        });
        Route::group(['prefix' => 'compilation', 'as' => 'compilation.'], function () {

            Route::get('/', [CompilationController::class, 'index'])->name('index');
            Route::get('create', [CompilationController::class, 'create'])->name('create');
            Route::post('store', 'CompilationController@store')->name('store');
            Route::get('edit/{id}', 'CompilationController@edit')->name('edit');
            Route::post('update/{id}', 'CompilationController@update')->name('update');
            Route::get('status/{id}/{status}', 'CompilationController@status')->name('status');
            Route::post('change_status', 'CompilationController@change_status')->name('change-status');
            Route::delete('delete/{id}', 'CompilationController@delete')->name('delete');
            Route::post('search', 'CompilationController@search')->name('search');
        });

        Route::group(['prefix' => 'place', 'as' => 'place.'], function () {

            Route::get('/', [PlaceController::class, 'index'])->name('index');
            Route::get('create', [PlaceController::class, 'create'])->name('create');
            Route::post('store', 'PlaceController@store')->name('store');
            Route::get('edit/{id}', 'PlaceController@edit')->name('edit');
            Route::get('details/{id}', 'PlaceController@details')->name('details');
            Route::post('update/{id}', 'PlaceController@update')->name('update');
            Route::post('change_status', 'PlaceController@change_status')->name('change-status');
            Route::get('status/{id}/{status}', 'PlaceController@status')->name('status');
            Route::delete('delete/{id}', 'PlaceController@destroy')->name('delete');
            Route::post('search', 'PlaceController@search')->name('search');
            
            Route::get('fav_status/{id}/{status}', 'PlaceController@fav_status')->name('fav-status');
        });
        Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {

            Route::get('/', [CustomerController::class, 'index'])->name('index');
            //  Route::get('create', [CustumerController::class ,'create'])->name('create');
            //  Route::post('store', 'PlaceController@store')->name('store');
            // Route::get('edit/{id}', 'PlaceController@edit')->name('edit');
            Route::get('view/{id}', 'CustomerController@details')->name('view');
            Route::post('change_status', 'CustomerController@change_status')->name('change-status');
            //  Route::post('update/{id}', 'PlaceController@update')->name('update');
            //  Route::get('status/{id}/{status}', 'PlaceController@status')->name('status');
             Route::get('delete/{id}', 'CustomerController@delete')->name('delete');
            //   Route::post('search', 'PlaceController@search')->name('search');
        });


        Route::group(['prefix' => 'order', 'as' => 'order.'], function () {

            Route::get('/', [OrderController::class, 'index'])->name('index');
            //  Route::get('create', [CustumerController::class ,'create'])->name('create');
            //  Route::post('store', 'PlaceController@store')->name('store');
            // Route::get('edit/{id}', 'PlaceController@edit')->name('edit');
            Route::get('details/{id}', 'OrderController@details')->name('details');
            //  Route::post('update/{id}', 'PlaceController@update')->name('update');
            //  Route::get('status/{id}/{status}', 'PlaceController@status')->name('status');
            //  Route::delete('delete/{id}', 'PlaceController@destroy')->name('delete');
            //   Route::post('search', 'PlaceController@search')->name('search');
        });

        Route::group(['prefix' => 'customer-wallet', 'as' => 'customer-wallet.'], function () {

            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('create', [UserWalletController::class, 'create'])->name('create');
            Route::post('store-charge-wallet', 'UserWalletController@store_charge_wallet')->name('store-charge-wallet');
            // Route::get('edit/{id}', 'PlaceController@edit')->name('edit');
            Route::get('details/{id}', 'OrderController@details')->name('details');
            //  Route::post('update/{id}', 'PlaceController@update')->name('update');
            //  Route::get('status/{id}/{status}', 'PlaceController@status')->name('status');
            //  Route::delete('delete/{id}', 'PlaceController@destroy')->name('delete');
            //   Route::post('search', 'PlaceController@search')->name('search');
        });

        // message
        Route::group(['prefix' => 'message', 'as' => 'message.'], function () {
            Route::get('list', 'ConversationController@list_index')->name('list');
            Route::post('store/{user_id}', 'ConversationController@store')->name('store');
            Route::get('view/{conversation_id}/{user_id}', 'ConversationController@view')->name('view');
        });
        
         Route::group(['prefix' => 'withdraw', 'as' => 'withdraw.'], function () {
            Route::get('list', 'WithdrawRequestController@index')->name('list');
            Route::post('change_status', 'WithdrawRequestController@change_status')->name('change-status');
        });
        
                Route::group(['prefix' => 'role', 'as' => 'role.'], function () {

            Route::get('/', [AdminRoleEmployeeController::class, 'index'])->name('index');
            Route::get('create', [AdminRoleEmployeeController::class, 'create'])->name('create');
            Route::post('store', 'AdminRoleEmployeeController@store')->name('store');
            Route::get('edit/{id}', 'AdminRoleEmployeeController@edit')->name('edit');
            Route::get('details/{id}', 'AdminRoleEmployeeController@details')->name('details');
            Route::post('update/{id}', 'AdminRoleEmployeeController@update')->name('update');
            Route::post('change_status', 'AdminRoleEmployeeController@change_status')->name('change-status');
            Route::get('status/{id}/{status}', 'AdminRoleEmployeeController@status')->name('status');
            Route::delete('delete/{id}', 'AdminRoleEmployeeController@destroy')->name('delete');
            Route::post('search', 'AdminRoleEmployeeController@search')->name('search');
        });

        Route::group(['prefix' => 'employee', 'as' => 'employee.'], function () {

            Route::get('/', [AdminEmployeeController::class, 'index'])->name('index');
            Route::get('create', [AdminEmployeeController::class, 'create'])->name('create');
            Route::post('store', 'AdminEmployeeController@store')->name('store');
            Route::get('edit/{id}', 'AdminEmployeeController@edit')->name('edit');
            Route::get('details/{id}', 'AdminEmployeeController@details')->name('details');
            Route::post('update/{id}', 'AdminEmployeeController@update')->name('update');
            Route::post('change_status', 'AdminEmployeeController@change_status')->name('change-status');
            Route::get('status/{id}/{status}', 'AdminEmployeeController@status')->name('status');
            Route::delete('delete/{id}', 'AdminEmployeeController@destroy')->name('delete');
            Route::post('search', 'AdminEmployeeController@search')->name('search');
        });

            Route::group(['prefix' => 'zone', 'as' => 'zone.'], function () {
            Route::get('/',[ZoneController::class,'index'])->name('index');
            Route::get('create', [ZoneController::class, 'create'])->name('create');
            Route::post('store', 'ZoneController@store')->name('store');
            Route::get('edit/{id}', 'ZoneController@edit')->name('edit');
            Route::post('update/{id}', 'ZoneController@update')->name('update');
            Route::delete('delete/{id}', 'ZoneController@destroy')->name('delete');
            Route::post('change_status', 'ZoneController@change_status')->name('change-status');
            Route::post('search', 'ZoneController@search')->name('search');
            Route::get('zone-filter/{id}', 'ZoneController@zone_filter')->name('zonefilter');
            Route::get('get-all-zone-cordinates/{id?}', 'ZoneController@get_all_zone_cordinates')->name('zoneCoordinates');
            //Route::post('export-zone-cordinates', 'ZoneController@export_zones')->name('export-zones');
            Route::get('export-zone-cordinates/{type}', 'ZoneController@export_zones')->name('export-zones');
        });
        
        Route::group(['prefix' => 'business_setting', 'as' => 'business_setting.'], function () {

            Route::get('/', [BusinessSettingController::class, 'index'])->name('index');
            Route::get('create', [BusinessSettingController::class, 'create'])->name('create');
            Route::post('store', 'BusinessSettingController@store')->name('store');
            Route::get('edit/{id}', 'BusinessSettingController@edit')->name('edit');
            Route::post('update/{id}', 'BusinessSettingController@update')->name('update');
            Route::post('change_status', 'BusinessSettingController@change_status')->name('change-status');
            Route::delete('delete/{id}', 'BusinessSettingController@destroy')->name('delete');
            Route::post('search', 'BusinessSettingController@search')->name('search');
        });
    });
});

