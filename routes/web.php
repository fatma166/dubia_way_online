<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/set-locale/{locale}', function ($locale) {
    // Validate the locale
    if (in_array($locale, ['en', 'ar'])) {
        App::setLocale($locale);
        Session::put('locale', $locale); // Store the locale in session
    }
    return redirect()->back(); // Redirect back to the previous page
})->name('set.locale');

Route::get('/', [\App\Http\Controllers\website\HomeController::class, 'index'])->name('home.index');
Route::get('/about-us', [\App\Http\Controllers\website\AboutController::class, 'index'])->name('about-us');
Route::post('/add-fav', [\App\Http\Controllers\website\ProductsController::class, 'add_fav'])->name('add_delete_fav');
Route::get('/get-user-fav', [\App\Http\Controllers\website\ProductsController::class, 'get_user_fav'])->name('get_user_fav');
Route::get('privacy-policy', function () {
    // You might want to fetch content from the database in a real application
    return view('website-views.privacy-policy');
})->name('privacy.policy');




Route::group(['namespace' => 'App\Http\Controllers\website', 'prefix' => 'order', 'as' => 'order.'], function () {
    Route::get('order-details/{id}', 'OrderController@details')->name('details');
    Route::get('/order-list', [\App\Http\Controllers\website\OrderController::class,'index'])->name('order-list');
    
});

Route::group(['namespace' => 'App\Http\Controllers\website\Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::get('login', 'LoginController@login')->name('login');
    Route::post('submit-login', 'LoginController@submit')->name('postLogin');//->middleware('actch')
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::get('show-register', 'LoginController@showregister')->name('show-register');
    Route::post('register', 'LoginController@register')->name('register');
});

Route::group(['namespace' => 'App\Http\Controllers\website', 'prefix' => 'products', 'as' => 'products.'], function () {
    Route::get('popular-products', 'FoodController@get_popular_food')->name('popular-products');
    Route::get('latest-products', 'FoodController@get_latest_food')->name('latest-products');
     Route::get('products', 'FoodController@list_food')->name('products');
    Route::get('list', 'ProductsController@list_')->name('list');
    Route::get('details/{product_id}', 'ProductsController@details')->name('details');
    Route::get('/xml-feed',  'ProductsController@xmlFeed')->name('xml.feed');

});
Route::group(['namespace' => 'App\Http\Controllers\website', 'prefix' => 'carts', 'as' => 'carts.'], function () {
    Route::get('/', 'CartController@index')->name('list-cart');
    Route::post('add-to-cart', 'CartController@addToCart')->name('add-to-cart');
    Route::post('/cart/update', 'CartController@update')->name('cart.update');
    Route::post('/cart/remove', 'CartController@remove')->name('cart.remove');
    // Route::post('add-ajax', 'CartController@addToCartAjax')->name('add-ajax'); // Method does not exist in controller
    Route::get('side-cart-view', 'CartController@getSideCartView')->name('side-cart-view'); // Alias for side_drawer_view
    Route::get('/side-drawer-view', 'CartController@side_drawer_view')->name('side-drawer-view');
});

Route::group(['namespace' => 'App\Http\Controllers\website', 'prefix' => 'checkout', 'as' => 'checkout.'], function () {
    Route::get('/', 'CheckOutController@index')->name('index');
    Route::post('make-order', 'CheckOutController@cart_order')->name('make-order');
    Route::post('/check-coupon', 'CheckOutController@check_coupon')->name('check-coupon');
	Route::get('/success', 'CheckOutController@success')->name('success');

});




Route::namespace('App\Http\Controllers\website')->prefix('review')->group (function() {
        Route::get('/review-product', [ReviewController::class,'review'])->name('review-product');
       // Route::post('/review-restaurant', [ReviewController::class,'review'])->name('review-restaurant');
      //  Route::post('/add-restaurant-review',[ReviewController::class,'add_restaurant_review'])->name('add-restaurant-review');
        //Route::get('/get-product-review',[ReviewController::class,'get_product_review'])->name('get-product-review');

});

//Route::get('/', function () {
   // return view('welcome');

//});


Route::prefix('payment')->group(function () {
    Route::group(['middleware' => []], function () {
        Route::get('/after-payment/{reference}', [PaymentController::class, 'afterPayment'])->name('payment.complete');
    });
});
