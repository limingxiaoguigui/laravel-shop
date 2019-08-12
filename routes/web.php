<?php

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
Route::redirect('/', '/products')->name('root');
Route::get('products', 'ProductsController@index')->name('products.index');
Auth::routes(['verify' => true]);
// auth 中间件代表需要登录，verified中间件代表需要经过邮箱验证
Route::group(['middleware' => ['auth', 'verified']], function () {
    // 收货地址的列表路由
    Route::get('user_addresses', 'UserAddressesController@index')->name('user_addresses.index');
    // 收货地址的新建页面路由
    Route::get('user_addresses/create', 'UserAddressesController@create')->name('user_addresses.create');
    // 收货地址新建处理路由
    Route::post('user_addresses', 'UserAddressesController@store')->name('user_addresses.store');
    // 收货地址的修改页面路由
    Route::get('user_addresses/{user_address}', 'UserAddressesController@edit')->name('user_addresses.edit');
    // 收货地址的修改逻辑路由
    Route::put('user_addresses/{user_address}', 'UserAddressesController@update')->name('user_addresses.update');
    // 收货地址的删除路由
    Route::delete('user_addresses/{user_address}', 'UserAddressesController@destroy')->name('user_addresses.destroy');
    // 收藏商品
    Route::post('products/{product}/favorite', 'ProductsController@favor')->name('products.favor');
    // 取消收藏
    Route::delete('products/{product}/favorite', 'ProductsController@disfavor')->name('products.disfavor');
    //商品收藏列表
    Route::get('products/favorites', 'ProductsController@favorites')->name('products.favorites');
});
Route::get('products/{product}', 'ProductsController@show')->name('products.show');