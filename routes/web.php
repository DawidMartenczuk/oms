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

Route::resourceVerbs(__('resource.verbs'));

Route::get('/', 'ProductController@index')->name('home');

Route::resource('product', 'ProductController')->only(['index', 'show']);
Route::resource('cart', 'CartController')->only(['index', 'store', 'update', 'destroy']);
Route::resource('order', 'OrderController')->only(['index', 'show']);

Auth::routes();