<?php

namespace App\Http\Controllers\Chat;

use App\Events\messageCreate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Chat;
use App\ChatHistory;


use Illuminate\Database\Eloquent\Model;

class ChatController extends Controller
{
	use ChatHistory;

	protected $chatroom;

	public function index()
	{
	    srand(time()); // 亂數種子
	    $username = sprintf('user%06d', rand(1, 100000)); // 決定 user 名稱 (註)
	    
	    //get chat room from database
	    $chatroom = Chat::with('SubClass')->get();
	    $this->chatroom = $chatroom;
	    
	    $contents = $this->getChatInfoNow('1','chat-channel');
	    return view('layouts/chatroom', compact('username','contents','chatroom'));
	}

	public function sendMessage(Request $request)
	{
	   $username = $request->get('username');
	   $message = $request->get('message');
	   $channel = new messageCreate($username, $message);
	   event($channel);

	   //recorde contents
	   $contents = $username.':'.$message;
	   $ret = $this->setChatInfo($contents,'chat-channel',$request->get('chatroom-id'));


	   if($ret==true){
	   	return 'message send';
	   }
	   else
	   {
	   	return 'send fail';
	   }
	    //return view('welcome');
	}
}
