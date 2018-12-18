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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('restaurants', 'RestaurantController', [
    'only' => ['index', 'store', 'update'],
]);

Route::resource('menus', 'MenuController', [
    'except' => ['show'],
]);

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
