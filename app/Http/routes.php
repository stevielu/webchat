<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::resource('/', 'Auth\AuthController');
Route::get('/logout', 'Auth\AuthController@getLogout');
Route::get('/error', 'ErrorController@index');
Route::group(['middleware' => 'auth'], function(){
	Route::resource('/chat', 'Chat\ChatController');
	Route::group(['prefix' => 'user'], function(){
		Route::resource('/account', 'UserController');
		Route::get('/back', 'UserController@back');
		Route::get('/profile', 'UserController@getProfile');
		Route::post('/profile/{user}/edit', 'UserController@editProfile');
	});
	Route::resource('/viewprofile', 'ViewProfileController');
	//Route::group(['prefix' => 'viewprofile'], function(){
		
	//});
	//Route::get('/user/myprofile', 'UserController@back');
	//Route::get('public/user/back', 'UserController@back');
	Route::get('chat/content/{channel}', 'Chat\ChatController@getChannelContents');
	Route::get('chat/content/{channel}/{date}', 'Chat\ChatController@getChannelHistory');
	//Route::get('/', 'Chat\ChatController@index');
	//Route::post('/{id}', 'Chat\ChatController@show');
	Route::post('/send-message', 'Chat\ChatController@sendMessage');
	Route::post('/login-pch', 'Chat\ChatController@loginPrivateChannel');
	Route::post('/create-channel', 'Chat\ChatController@createChannel');
});

Route::get('/home', 'HomeController@index');
