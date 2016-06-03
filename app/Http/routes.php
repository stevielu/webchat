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
Route::resource('/chat', 'Chat\ChatController');
Route::resource('/', 'Auth\AuthController');
Route::get('chat/content/{channel}', 'Chat\ChatController@getChannelContents');
Route::get('chat/content/{channel}/{date}', 'Chat\ChatController@getChannelHistory');
//Route::get('/', 'Chat\ChatController@index');
//Route::post('/{id}', 'Chat\ChatController@show');
Route::post('/send-message', 'Chat\ChatController@sendMessage');
Route::post('/login-pch', 'Chat\ChatController@loginPrivateChannel');
Route::post('/create-channel', 'Chat\ChatController@createChannel');
Route::auth();

Route::get('/home', 'HomeController@index');
