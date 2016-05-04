<?php

namespace App\Http\Controllers\Chat;

use App\Events\messageCreate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\ChatHistory;


class ChatController extends Controller
{
	use ChatHistory;

	public function index()
	{
	    srand(time()); // 亂數種子
	    $username = sprintf('user%06d', rand(1, 100000)); // 決定 user 名稱 (註)
	    return view('layouts/chatroom', compact('username'));
	}

	public function sendMessage(Request $request)
	{
	   $username = $request->get('username');
	   $message = $request->get('message');
	   $channel = new messageCreate($username, $message);
	   event($channel);
	   $ret = $this->setChatInfo($message,'chat-channel');
	   return $ret;
	    //return view('welcome');
	}
}
