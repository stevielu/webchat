<?php

namespace App\Http\Controllers\Chat;
use Hash;
use App\Events\messageCreate;
use App\Events\ChannelOperation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Chat;
use App\Models\ChatHistoryRecoder;
use App\Models\Channels;
use App\ChatHistory;
/*Auth*/
use Illuminate\Contracts\Auth\Registrar;
use App\User;
use Validator;
use Auth;
use Session;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Database\Eloquent\Model;

class ChatController extends Controller
{
	use ChatHistory;
	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	protected $chatroom;
	protected $auth;
	protected $user;

	public function __construct()
    {
        // $this->middleware('guest', ['except' => 'getLogout']);
       	$user = Session::get('loginInfo');
	    //$username = User::select('name')->where('email',$user['email'])->first();
	    $this->user = User::where('email',$user['email'])->first();
	    //var_dump($test['my_avatar']);
	    $user = Session::put('loginInfo.name',$this->user['name']);
    }

	public function Index()
	{
	   
	   
	    $username = $this->user['name'];
	    //get chat room from database
	    $chatroom = Chat::with('SubClass')->get();
	    $this->chatroom = $chatroom;

	    $currentfocus = 'sidebar_chat';
	    //$contents = $this->getChatInfoNow('1','chat-channel');
	    return view('layouts/chatroom', compact('username','chatroom','currentfocus'));
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
    	if($contents==null){
    		if(!$this->ChannelRecoderExist($roomid,$channel)){
    			$empty =  'null recordes';
    		}
    		else{
    			$empty = 'true';
    		}
    		
    	}
    	else{
    		$empty = 'false';
    	}

	    $user = Session::get('loginInfo');
	    $username = $user['name'];
	    return ['username'=>$username,'contents'=>$contents,'empty'=>$empty];
	   
    }

    private function _getdateLastUpdate(){
    	$lastRecode = ChatHistoryRecoder::
    			->select('created_at')
                ->orderBy('created_at', 'asc')
                ->first()->format('Y-m-d');
    	return $lastRecode;
    }

    public function getChannelHistory(Request $request, $channel, $date)
    {
    	$roomid = $request->session()->get('room_id');
    	$contents = null;
    	// while ( $contents != null) {
    	// 	$contents = $this->getChatInfoPrev($roomid,$channel,$date);
    	// 	if($contents==null){
	    // 		if(!$this->ChannelRecoderExist($roomid,$channel)){
	    // 			$empty =  'null recordes';
	    // 		}
	    // 		else{
	    // 			$empty = 'true';
	    // 		}
	    		
	    // 	}
	    // 	else{
	    // 		$empty = 'false';
	    // 	}
    	// }
    	$date =$this->_getdateLastUpdate();
    	var_dump($date);
    	$contents = $this->getChatInfoPrev($roomid,$channel,$date);
    		if($contents==null){
	    		if(!$this->ChannelRecoderExist($roomid,$channel)){
	    			$empty =  'null recordes';
	    		}
	    		else{
	    			$empty = 'true';
	    		}
	    		
	    	}
	    	else{
	    		$empty = 'false';
	    	}

    	

     	
     	$user = Session::get('loginInfo');
	    $username = $user['name'];//sprintf('user%06d', rand(1, 100000));


	    return ['username'=>$username,'contents'=>$contents,'empty'=>$empty];
	    
    }

    public function loginPrivateChannel(Request $request)
    {
    	$roomid = $request->session()->get('room_id');

    	$credentials = $request->only('p-chn', 'loginPass');

		      
        if (auth()->guard('privateChannel')->attempt(['channel_name' => $credentials['p-chn'], 'password' => $credentials['loginPass']])) {

            $login = 'success';
            $contents = $this->getChatInfoNow($roomid,$credentials['p-chn']);
            if($contents==null){
	    		if(!$this->ChannelRecoderExist($roomid,$credentials['p-chn'])){
	    			$empty =  'null recordes';
	    		}
	    		else{
		    			$empty = 'true';
		    		}
		    		
		    	}
	    	else{
	    		$empty = 'false';
	    	}
           // $data = response()->json(['redirect' => '/']);
        }
        else{
        	$empty = 'null recordes';
            $login = 'fail';
            $contents = $credentials;//'Password Wrong, Try Again...';
            
        }
  


    	


     	//srand(time()); // 亂數種子
	    //$username = sprintf('user%06d', rand(1, 100000)); // 決定 user 名稱 (註)
	    return ['ch_login'=>$login,'channel'=>$credentials['p-chn'],'contents'=>$contents,'empty'=>$empty];
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
	   $channel = new messageCreate($username, $message,$ch,$this->user);
	   event($channel);

	   //recorde contents
	   if($this->user['my_avatar']!=null){
	   		$contents = $this->user['my_avatar'].'*'.$username.':'.$message;
	   }
	   else{
	   		$contents = $username.':'.$message;
	   }
	   
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
		   	if($chdetials['channelType']=='private'){
		   		$chdetials['channelPassword'] = Hash::make($chdetials['channelPassword']);
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
	          	'password' => $chdetials['channelPassword'],
	          	'channel_type' => $ch_type
        		));
            }
		   		
		   	
	   }

	   $op = new ChannelOperation($chdetials,'create');
	   $ret = event($op);

	   return $ret;
	   
	}
}
