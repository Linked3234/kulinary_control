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

//Route::get('/', function () {
//    return view('welcome');
//});


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * категории
 */
Route::get('/categories/{type}', 'CategoryController@index')->name('categories.index')->middleware('auth');
Route::get('/categories/{type}/create', 'CategoryController@create')->name('categories.create')->middleware('auth');
Route::post('/categories/{type}/store', 'CategoryController@store')->name('categories.store')->middleware('auth');
Route::get('/categories/{type}/{id}/edit', 'CategoryController@edit')->name('categories.edit')->middleware('auth');
Route::post('/categories/{type}/{id}/edit', 'CategoryController@update')->name('categories.update')->middleware('auth');
Route::delete('/categories/{type}/{id}/destroy', 'CategoryController@destroy')->name('categories.destroy')->middleware('auth');

/**
 * товары
 */
Route::get('/goods', 'GoodController@index')->name('goods.index')->middleware('auth');
Route::get('/goods/create', 'GoodController@create')->name('goods.create')->middleware('auth');
Route::post('/goods/store', 'GoodController@store')->name('goods.store')->middleware('auth');
Route::get('/goods/{id}/edit', 'GoodController@edit')->name('goods.edit')->middleware('auth');
Route::post('/goods/{id}/edit', 'GoodController@update')->name('goods.update')->middleware('auth');
Route::delete('/goods/{id}/destroy', 'GoodController@destroy')->name('goods.destroy')->middleware('auth');

/**
 * добавление в корзину
 */
Route::get('/order/{category_id}', 'GoodController@goods_list')->name('goods.list')->middleware('auth');
Route::post('/goods/basket/create', 'GoodController@basket_create')->name('basket.create');
Route::post('/goods/ajax/get_tree', 'GoodController@basket_list')->name('basket.list')->middleware('auth');

/**
 * оформление заказа
 */
Route::post('/order/create', 'OrderController@store')->name('order.create')->middleware('auth');

/**
 * список оформленных заказов
 */
Route::get('/orders/all', 'OrderController@order_all')->name('order.all')->middleware('auth');

Route::get('/orders/users/all', 'OrderController@order_users_all')->name('order_users_all')->middleware('auth');

Route::get('/orders/{id}/watch', 'OrderController@watch')->name('order.watch')->middleware('auth');

// чистка корзины
Route::post('/basket/clear', 'BasketController@clear')->name('basket.clear')->middleware('auth');

// поиск товара
Route::post('/goods/search', 'GoodController@index')->name('goods.search')->middleware('auth');

// изменение кол-ва товаров в корзине
Route::post('/basket/change_count', 'BasketController@change_count_items')->name('basket.change')->middleware('auth');