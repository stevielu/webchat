<?php

namespace App\Http\Controllers\Chat;

use App\Events\messageCreate;
use App\Events\ChannelOperation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Chat;
use App\Models\ChatHistoryRecoder;
use App\Models\Channels;
use App\ChatHistory;


use Illuminate\Database\Eloquent\Model;

class ChatController extends Controller
{
	use ChatHistory;

	protected $chatroom;
	public function Index()
	{
	    srand(time()); // 亂數種子
	    $username = sprintf('user%06d', rand(1, 100000)); // 決定 user 名稱 (註)
	    
	    //get chat room from database
	    $chatroom = Chat::with('SubClass')->get();
	    $this->chatroom = $chatroom;
	    
	    //$contents = $this->getChatInfoNow('1','chat-channel');
	    return view('layouts/chatroom', compact('username','chatroom'));
	}

	public function show($id, Request $request)
    {
        $channels = Channels::select()->where('room_id',$id)->get();
        $request->session()->put('room_id', $id);

        return $channels;
        //return view('layouts/chatroom', compact('channels'));        
    }

    public function getChannelContents(Request $request, $channel)
    {
    	$roomid = $request->session()->get('room_id');

    	$contents = $this->getChatInfoNow($roomid,$channel);
    	
     	srand(time()); // 亂數種子
	    $username = sprintf('user%06d', rand(1, 100000)); // 決定 user 名稱 (註)
	    return ['username'=>$username,'contents'=>$contents];
	    // //get chat room from database
	    // $chatroom = Chat::with('SubClass')->get();
	    // $this->chatroom = $chatroom;
	    
	    // $contents = $this->getChatInfoNow('1','chat-channel');
	    // return;        
    }

	public function sendMessage(Request $request)
	{
	   $username = $request->get('username');
	   $message = $request->get('message');
	   $ch = $request->get('current-channel');
	   $channel = new messageCreate($username, $message,$ch);
	   event($channel);

	   //recorde contents
	   $contents = $username.':'.$message;
	   $ret = $this->setChatInfo($contents,$ch,$request->get('chatroom-id'));


	   if($ret==true){
	   	return $ch;
	   }
	   else
	   {
	   	return 'send fail';
	   }
	    //return view('welcome');
	}

	public function createChannel(Request $request)
	{
	   $chdetials['channelName'] = $request->get('channelName');
	   $chdetials['channelPassword'] = $request->get('channelPassword');
	   $chdetials['channelType'] = $request->get('channelType');
	   $chdetials['id'] = $request->get('id');

	   //wirte to DB
	   if($chdetials['id']== null){
	   		return false;
	   }
	   else{
		   	if($chdetials['channelType']=='Private'){
		   		$ch_type = 'private';
		   	}
		   	else {
		   		$ch_type = 'public';
		   	}
		   
	   		$exist = Channels::where('room_id', $chdetials['id'])
              ->where('channel_name', $chdetials['channelName'])->exists();
            if($exist){
            	$ret = 'The Name was Existed, Please Change Another Name';
            	return $ret;
            }
            else{
            	Channels::create(array(
	          	'room_id' => $chdetials['id'],
	          	'channel_name' => $chdetials['channelName'],
	          	'ch_pwd' => $chdetials['channelPassword'],
	          	'channel_type' => $ch_type
        		));
            }
		   		
		   	
	   }

	   $op = new ChannelOperation($chdetials,'create');
	   $ret = event($op);

	   return $ret;
	   
	}
}
