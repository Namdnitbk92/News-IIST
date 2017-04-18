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

Auth::routes();

Route::group(['middleware' => 'auth'] , function (){

	Route::get('/', function (){
	    return view('home');
	});

	Route::get('/home', 'HomeController@index')->name('home');

	Route::resource('news', 'NewsController');

	Route::post('/approveNew', 'NewsController@approveNew')->name('approveNew');

	Route::post('/copyNew', 'NewsController@copyNew')->name('copyNew');

	Route::post('/noticeApprove', 'NewsController@noticeApprove')->name('noticeApprove');

	Route::get('/getRequireToApproveNewsListByCreater', 'NewsController@getRequireToApproveNewsListByCreater')->name('getRequireToApproveNewsListByCreater');
	Route::post('/deleteApproved', 'NewsController@deleteApproved')->name('deleteApproved');




	Route::resource('users', 'UserController');
	Route::get('/profile', 'UserController@profile')->name('profile');

	Route::resource('city', 'CityController');
	Route::resource('county', 'CountyController');
	Route::resource('guild', 'GuildController');
	

	Route::get('/search', 'NewsController@search')->name('search_news');

	Route::get('getGuildList', 'NewsController@getGuildList')->name('getGuildList');
	Route::get('getNotifications', 'HomeController@getNotifications')->name('getNotifications');
	

});
