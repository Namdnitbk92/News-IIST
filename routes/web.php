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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('news', 'NewsController');

Route::post('/approveNew', 'NewsController@approveNew')->name('approveNew');

Route::get('getGuildList', 'NewsController@getGuildList')->name('getGuildList');
