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
    // 加入购车
    Route::post('cart', 'CartController@add')->name('cart.add');
    //购物车列表
    Route::get('cart', 'CartController@index')->name('cart.index');
    //删除购物车内的商品
    Route::delete('cart/{sku}', 'CartController@remove')->name('cart.remove');
    //创建订单
    Route::post('orders', 'OrdersController@store')->name('orders.store');
    //订单列表
    Route::get('orders', 'OrdersController@index')->name('orders.index');
    //订单详情
    Route::get('orders/{order}', 'OrdersController@show')->name('orders.show');
    //订单支付
    Route::get('payment/{order}/alipay', 'PaymentController@payByAlipay')->name('payment.alipay');
    //支付宝的前端回调
    Route::get('payment/alipay/return', 'PaymentController@alipayReturn')->name('payment.alipay.return');
    //确认收货
    Route::post('orders/{order}/received', 'OrdersController@received')->name('orders.received');
});
//商品信息
Route::get('products/{product}', 'ProductsController@show')->name('products.show');
//支付宝的后端回调
Route::post('payment/alipay/notify', 'PaymentController@alipayNotify')->name('payment.alipay.notify');