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
Route::get('chat/content/{channel}', 'Chat\ChatController@getChannelContents');
//Route::get('/', 'Chat\ChatController@index');
//Route::post('/{id}', 'Chat\ChatController@show');
Route::post('/send-message', 'Chat\ChatController@sendMessage');
Route::post('/create-channel', 'Chat\ChatController@createChannel');