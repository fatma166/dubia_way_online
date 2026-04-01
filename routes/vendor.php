<?php
use App\Http\Controllers\Vendor\VendorEmployeeController;
use App\Http\Controllers\Vendor\CategoryController;
use App\Http\Controllers\Vendor\OrderController;
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\Vendor\CustomerController;
use App\Http\Controllers\Vendor\ConversationController;
use Illuminate\Support\Facades\Route;

App::setLocale('ar');
Route::group(['namespace' => 'App\Http\Controllers\Vendor', 'as' => 'vendor.'], function () {

    /*authentication*/
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', 'LoginController@login')->name('login');
        Route::post('submit-login', 'LoginController@submit')->name('postLogin');//->middleware('actch')
        Route::get('logout', 'LoginController@logout')->name('logout');
    });
    /*authentication*/

    Route::group(['middleware' => ['vendor']], function () {
        //dashboard
        Route::get('/', 'DashboardController@dashboard')->name('dashboard');
        Route::get('line-chart', 'DashboardController@dashboard_data')->name('line-chart');

        Route::get('index_', 'DashboardController@index')->name('index_');
        Route::group(['prefix' => 'category', 'as' => 'category.'], function () {

            Route::get('/', [CategoryController::class ,'index'])->name('index');
            Route::get('create', [CategoryController::class ,'create'])->name('create');
            Route::post('store', 'CategoryController@store')->name('store');
            Route::get('edit/{id}', 'CategoryController@edit')->name('edit');
            Route::post('update/{id}', 'CategoryController@update')->name('update');
            Route::get('status/{id}/{status}', 'CategoryController@status')->name('status');
            Route::post('change_status', 'CategoryController@change_status')->name('change-status');
            Route::delete('delete/{id}', 'CategoryController@destroy')->name('delete');
            Route::post('search', 'CategoryController@search')->name('search');
        });

        Route::group(['prefix' => 'product', 'as' => 'product.'], function () {

            Route::get('/', [ProductController::class ,'index'])->name('index');
            Route::get('create', [ProductController::class ,'create'])->name('create');
            Route::post('store', 'ProductController@store')->name('store');
            Route::get('edit/{id}', 'ProductController@edit')->name('edit');
            Route::post('update/{id}', 'ProductController@update')->name('update');
            Route::get('status/{id}/{status}', 'ProductController@status')->name('status');
            Route::get('fav_status/{id}/{status}', 'ProductController@fav_status')->name('fav-status');
            Route::post('change_status', 'ProductController@change_status')->name('change-status');
            Route::get('view/{id}', 'ProductController@details')->name('view');
            Route::delete('delete/{id}', 'ProductController@destroy')->name('delete');
            Route::delete('delete_image', 'ProductController@delete_image')->name('delete-image');
            Route::post('search', 'ProductController@search')->name('search');
            Route::post('uploadimages', 'ProductController@upload_images')->name('upload_images');
            Route::post('variant-combination', 'ProductController@variant_combination')->name('variant-combination');
        });

        Route::group(['prefix' => 'order', 'as' => 'order.'], function () {

            Route::get('/', [OrderController::class ,'index'])->name('index');
            //  Route::get('create', [CustumerController::class ,'create'])->name('create');
            //  Route::post('store', 'PlaceController@store')->name('store');
            // Route::get('edit/{id}', 'PlaceController@edit')->name('edit');
            Route::get('details/{id}', 'OrderController@details')->name('details');
            Route::post('change_status', 'OrderController@change_status')->name('change-status');
			Route::post('update_customer_details', 'OrderController@update_customer_details')->name('update-customer-details');

            //  Route::post('update/{id}', 'PlaceController@update')->name('update');
            //  Route::get('status/{id}/{status}', 'PlaceController@status')->name('status');
            //  Route::delete('delete/{id}', 'PlaceController@destroy')->name('delete');
            //   Route::post('search', 'PlaceController@search')->name('search');
        });

        Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {

            Route::get('/', [CustomerController::class ,'index'])->name('index');
            //  Route::get('create', [CustumerController::class ,'create'])->name('create');
            //  Route::post('store', 'PlaceController@store')->name('store');
            // Route::get('edit/{id}', 'PlaceController@edit')->name('edit');
            Route::get('view/{id}', 'CustomerController@details')->name('view');
            Route::post('change_status', 'CustomerController@change_status')->name('change-status');
            //  Route::post('update/{id}', 'PlaceController@update')->name('update');
            //  Route::get('status/{id}/{status}', 'PlaceController@status')->name('status');
            //  Route::delete('delete/{id}', 'PlaceController@destroy')->name('delete');
            //   Route::post('search', 'PlaceController@search')->name('search');
        });

        // message
        Route::group(['prefix' => 'message', 'as' => 'message.'], function () {
            Route::get('list', 'ConversationController@list_index')->name('list');
            Route::post('store/{user_id}/{user_type}', 'ConversationController@store')->name('store');
            Route::get('view/{conversation_id}/{user_id}', 'ConversationController@view')->name('view');
        });
        
        
        Route::group(['prefix' => 'employee', 'as' => 'employee.'], function () {

            Route::get('/', [VendorEmployeeController::class, 'index'])->name('index');
            Route::get('create', [VendorEmployeeController::class, 'create'])->name('create');
            Route::post('store', 'VendorEmployeeController@store')->name('store');
            Route::get('edit/{id}', 'VendorEmployeeController@edit')->name('edit');
            Route::get('details/{id}', 'VendorEmployeeController@details')->name('details');
            Route::post('update/{id}', 'VendorEmployeeController@update')->name('update');
            Route::post('change_status', 'VendorEmployeeController@change_status')->name('change-status');
            Route::get('status/{id}/{status}', 'VendorEmployeeController@status')->name('status');
            Route::delete('delete/{id}', 'VendorEmployeeController@destroy')->name('delete');
            Route::post('search', 'VendorEmployeeController@search')->name('search');
        });
    });


  /*  Route::group(['middleware' => ['vendor']], function () {
        Route::get('/', function () {
            return ("hdhskadjasdja");
        })->name('admin.index');
        //dashboard
        // Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    });*/
});

