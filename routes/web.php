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

Route::get('/passwordReset', 'UserController@passwordReset')->name('passwordReset');

Route::group(['middleware' => 'auth'] , function (){

	Route::get('/', 'HomeController@index');

	Route::match(array('GET', 'POST'), '/showLanguage', 'HomeController@showLanguage')->name('showLanguage');

	Route::get('/home', 'HomeController@index')->name('home');

	Route::get('/back', 'HomeController@back')->name('back');

	Route::group(['middleware' => 'is.content.manager'] , function (){
		Route::group(['middleware' => 'is.content.manager'] , function (){
			Route::resource('news', 'NewsController');
			Route::post('/copyNew', 'NewsController@copyNew')->name('copyNew');
			Route::get('/search', 'NewsController@search')->name('search_news');
			Route::post('/noticeApprove', 'NewsController@noticeApprove')->name('noticeApprove');
			Route::get('/getNewListAvaiableApprove', 'NewsController@getNewListAvaiableApprove')->name('getNewListAvaiableApprove');
		});
	});

	Route::post('/getPreview', 'HomeController@getPreview')->name('getPreview');

	

	Route::group(['middleware' => 'is.users.manager'] , function (){
		Route::resource('users', 'UserController');
		Route::get('user/search', 'UserController@search')->name('search_users');
	});

	Route::get('/profile', 'UserController@profile')->name('profile');
	Route::get('/editProfile', 'UserController@editProfile')->name('editProfile');

	Route::group(['middleware' => 'is.approve.manager'] , function (){
		Route::get('/getRequireToApproveNewsListByCreater', 'NewsController@getRequireToApproveNewsListByCreater')->name('getRequireToApproveNewsListByCreater');
		Route::post('/approveNew', 'NewsController@approveNew')->name('approveNew');
		Route::post('/deleteApproved', 'NewsController@deleteApproved')->name('deleteApproved');
		Route::resource('city', 'CityController');
		Route::resource('county', 'CountyController');
		Route::resource('guild', 'GuildController');
	});

	Route::get('getGuildList', 'NewsController@getGuildList')->name('getGuildList');
	Route::get('getNotifications', 'HomeController@getNotifications')->name('getNotifications');
});
