<?php

use App\Http\Controllers\Api\V1\BannerController;
use App\Http\Controllers\Api\V1\BusinessSettingController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CompilationController;
use App\Http\Controllers\Api\V1\FoodController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\RestaurantController;
use App\Http\Controllers\Api\V1\ReviewController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ZoneController;
use App\Http\Controllers\Api\V1\ConversationController;
use App\Http\Controllers\Api\V1\SearchController;
use App\Http\Controllers\StripeController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::namespace('Api\V1')->prefix('business_setting')->group (function() {

    route::get('get_country',[BusinessSettingController::class, 'get_defaultcountry'])->name('get_country')->withoutMiddleware([auth::class, 'auth_api']);
    route::get('get_currency',[BusinessSettingController::class, 'get_currency'])->name('get_currency')->withoutMiddleware([auth::class, 'auth_api']);
});
Route::namespace('Api\V1\Auth')->prefix('auth')->group (function() {

    route::post('login','AuthUserController@login')->name('login_api')->withoutMiddleware([auth::class,'auth_api']);
    route::post('logout','AuthUserController@logout')->name('logout_api');
    route::post('register','AuthUserController@register')->name('register')->withoutMiddleware([auth::class,'auth_api']);
    route::post('verify','AuthUserController@verify')->name('verify')->withoutMiddleware([auth::class,'auth_api']);
     route::post('resend_code','AuthUserController@resend_code')->name('resend_code')->withoutMiddleware([auth::class,'auth_api']);

    route::post('forgetPassword','AuthUserController@forgetPassword')->name('forgetPassword')->withoutMiddleware([auth::class,'auth_api']);

    route::post('validatePassowrd','AuthUserController@validatePassowrd')->name('validatePassowrd')->withoutMiddleware([auth::class,'auth_api']);
    route::get('get-user-data','AuthUserController@getData')->name('getUserData');
    route::post('refresh','AuthUserController@refresh')->name('refresh_api')/*->withoutMiddleware([auth::class,'auth_api'])*/;
    route::post('refresh','AuthUserController@refresh')->name('refresh_api')/*->withoutMiddleware([auth::class,'auth_api'])*/;
    route::post('check-login','AuthUserController@checkLogin')->name('check-login')/*->withoutMiddleware([auth::class,'auth_api'])*/;
    route::post('update-device-token','AuthUserController@updateDeviceToken')->name('update-fcm');
    route::post('change-pass','AuthUserController@changePassword')->name('change-pass')->withoutMiddleware([auth::class,'auth_api']);
});

Route::group(['namespace' => 'App\Http\Controllers\Api\V1'], function () {


    /* Route::get('zone/list', 'ZoneController@get_zones');
     Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
         Route::post('sign-up', 'CustomerAuthController@register');
         Route::post('login', 'CustomerAuthController@login');
         Route::post('verify-phone', 'CustomerAuthController@verify_phone');

         Route::post('check-email', 'CustomerAuthController@check_email');
         Route::post('verify-email', 'CustomerAuthController@verify_email');
 */
    /*  Route::post('forgot-password', 'PasswordResetController@reset_password_request');
      Route::post('verify-token', 'PasswordResetController@verify_token');
      Route::put('reset-password', 'PasswordResetController@reset_password_submit');*/
    //});
});
/* home search*/
Route::get('/home-search', [SearchController::class, 'home_search'])->withoutMiddleware('auth_api');
Route::get('/home-search2', [SearchController::class, 'home_search2'])->withoutMiddleware('auth_api');
Route::get('/advanced-rest-search', [SearchController::class, 'advanced_rest_search'])->withoutMiddleware('auth_api');
/* get zones*/
Route::get('/zones', [ZoneController::class, 'get_zones'])->withoutMiddleware('auth_api');
Route::get('/get-banner', [BannerController::class, 'get_banner'])->withoutMiddleware('auth_api');
Route::namespace('Api\V1')->prefix('category')->withoutMiddleware('auth_api')->group (function() {


    Route::get('/list', [CategoryController::class, 'list_cats']);
    Route::get('/get-cat/{id?}', [CategoryController::class, 'get_category'])->name('get-cat');

});

Route::namespace('Api\V1')->prefix('restaurants')->group (function() {


    Route::get('/list', [RestaurantController::class, 'list_rest'])->name('restaurants')->withoutMiddleware('auth_api');

    Route::get('/popular', [RestaurantController::class, 'get_popular_restaurants'])->name('popular-restaurants') ->withoutMiddleware('auth_api');
    Route::get('/details/{id}', [RestaurantController::class, 'get_details'])->name('details-restaurants')->withoutMiddleware('auth_api');;
    Route::get('/latest', [RestaurantController::class, 'get_latest'])->name('latest-restaurants')->withoutMiddleware('auth_api');
    Route::get('/get-selected-restaurant', [RestaurantController::class, 'get_selected_restaurant'])->name('get_selected_restaurant')->withoutMiddleware('auth_api');
    Route::group(['middleware'=>['auth_api:api']], function () {

    Route::get('/get-user-fav-restaurant', [RestaurantController::class, 'get_user_fav_restaurant'])->name('get_user_fav_restaurant');
    Route::post('/add-fav-restaurant', [RestaurantController::class, 'add_fav_restaurant'])->name('add_fav_restaurant');

    });
});

Route::namespace('Api\V1')->prefix('compilations')->group (function() {
    Route::get('/list', [CompilationController::class, 'list'])->name('list-compilaions')->withoutMiddleware('auth_api');
});

Route::namespace('Api\V1')->prefix('food')->withoutMiddleware('auth_api')->group (function() {
    Route::get('/list', [FoodController::class, 'get_food'])->name('list-food');
    Route::get('/single-food', [FoodController::class, 'single_food'])->name('single-food');
});
Route::namespace('Api\V1')->prefix('order')->group (function() {
    Route::group(['middleware'=>['auth_api:api']], function () {
        Route::post('/cart', [OrderController::class, 'cart_order'])->name('cart-order');
        Route::get('/pervious-address',[OrderController::class,'get_pervious_address'])->name('pervious-address');
        Route::get('/get-address',[OrderController::class,'get_address'])->name('get-address');
        Route::get('/track-order',[OrderController::class,'track_order'])->name('track-order');
        Route::get('/list',[OrderController::class,'list_'])->name('list-order');
        Route::get('/cancel-order',[OrderController::class,'cancel_order'])->name('cancel-order');
        Route::get('/get-order-details',[OrderController::class,'get_order_details'])->name('get-order-details');
        //  Route::get('/single-food', [FoodController::class, 'single_food'])->name('single-food');
        Route::post('/check-coupon', [OrderController::class, 'check_coupon']);
        Route::post('/calcualate-order', [OrderController::class, 'calcualate_order_amount']);

        Route::post('/payment-link', [OrderController::class, 'generatePaymentLink']);
        Route::post('/payment/callback', [OrderController::class, 'paymentCallback']);
        Route::post('/sucess', [OrderController::class, 'success']);
    });
});
Route::namespace('Api\V1')->prefix('payment')->group (function() {
    Route::group(['middleware' => ['auth_api:api']], function () {
        Route::post('/create-payment-link', [PaymentController::class, 'pay']);
        Route::get('/status', [PaymentController::class, 'status']);
        Route::post('/create-payment-wallet-link', [PaymentController::class, 'create_payment_wallet_link']);
        Route::get('/wallet-status', [PaymentController::class, 'wallet_status']);
        Route::get('/payment-method', [PaymentController::class, 'payment_method']);
        Route::get('/list-wallet-transaction', [PaymentController::class, 'transactions']);
    });

     //   Route::get('/after-payment/{reference}', [PaymentController::class, 'afterPayment'])->name('payment.complete')->withoutMiddleware([auth::class,'auth_api']);

});

// Chatting

    Route::namespace('Api\V1')->prefix('message')->group (function() {
        Route::group(['middleware' => ['auth_api:api']], function () {
            Route::get('list', [ConversationController::class,'conversations']);
            Route::get('search-list', [ConversationController::class,'get_searched_conversations']);
            Route::get('details', [ConversationController::class,'messages']);
            Route::post('send', [ConversationController::class,'messages_store']);
            Route::post('chat-image', [ConversationController::class,'chat_image']);
         });
     });


Route::namespace('Api\V1')->prefix('user')->group (function() {
    Route::group(['middleware'=>['auth_api:api']], function () {
        Route::post('/add-address', [UserController::class,'add_new_address'])->name('add-address');
        Route::post('/update-address',[UserController::class,'update_address'])->name('update-address');
        Route::post('/delete-address',[UserController::class,'delete_address'])->name('delete_address');
        Route::get('/info',[UserController::class,'info'])->name('user-info');
        Route::post('/edit-profile', [UserController::class,'edit_profile'])->name('edit-profile');
        Route::post('/delete-profile', [UserController::class,'delete_profile'])->name('delete-profile');
        Route::get('notifications', [NotificationController::class,'get_notifications'])->name('notifications');

    });
    });

Route::namespace('Api\V1')->prefix('review')->group (function() {
    Route::group(['middleware'=>['auth_api:api']], function () {
    Route::post('/review-restaurant', [ReviewController::class,'review'])->name('review-restaurant');
    Route::post('/add-restaurant-review',[ReviewController::class,'add_restaurant_review'])->name('add-restaurant-review');
    Route::get('/get-restaurant-review',[ReviewController::class,'get_restaurant_review'])->name('get-restaurant-review');
    });
});
Route::namespace('/')->prefix('stripe')->group (function() {
    Route::group(['middleware'=>['auth_api:api']], function () {
        Route::post('/charge', [StripeController::class, 'charge']);
        Route::post('make-payment',[StripeController::class,'makePayment']);
    });
});



/*get banners*/






