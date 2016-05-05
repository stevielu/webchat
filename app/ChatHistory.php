<?php

namespace App;

use Storage;
use App\Models\Chat;
use App\Models\ChatHistoryRecoder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
trait ChatHistory
{
    protected $filename;
    protected $room_id;

    public function __construct()
    {
       
    }

    public function getChatInfoNow($chatroomID,$channel){

        //get today file name 
        $path = config('filepath.chat.textrecoder');
        $latestedLog = $path.date('Y-m-d').'-'.$channel.'.txt';
        $contents ='';

        //get today's contents
        $filename = ChatHistoryRecoder::select('contents')
                                        ->where('room_id',$chatroomID)
                                        ->where('contents',$latestedLog)
                                        ->first();
        $filename = $filename->contents;
        //read content from specfic file                     
        if($this->_currentHistoryFileExist($filename)){
            $contents = Storage::get($filename);
        }
        else
        {
            return 'no message history today';
        }

        return $contents;
    }

    public function getChatInfoPrev($channel,$fileDate){

        //get file name 
        $path = config('filepath.chat.textrecoder');
        $filename = $path.$fileDate.'-'.$channel.'.txt';
        $contents ='';

        //get previous contents
        if($this->_currentHistoryFileExist($filename)){
            $contents = Storage::get($this->filename);
        }
        
        return $contents;
    }

    public function setChatInfo($message,$channel,$roomID){
        $path = config('filepath.chat.textrecoder');
        $filename = $path.date('Y-m-d').'-'.$channel.'.txt';
        $this->room_id = $roomID;

        if($this->_currentHistoryFileExist($filename)){
            //add content
            $ret = $this->_appendChatHistory($message,$filename);
        }
        else{
            //create history file
            $ret = $this->_createChatHistory($filename,$message,$channel);
        }

        return $ret;
    }


    private function _currentHistoryFileExist($file){

        $exists = Storage::disk('local')->exists($file);
        return $exists;
    }

    private function _appendChatHistory($message,$filename){

        $ret = Storage::append($filename, $message);
        return $ret;
    }

    private function _createChatHistory($filename,$message,$channel){
        
        //write file name to database 
        $file = ChatHistoryRecoder::create(array(
          'room_id' => $this->room_id,
          'channel' => $channel,
          'contents' => $filename
        ));
        if(!$file){
            return false;
        }
        //creat file
        $ret = Storage::put($filename, $message);
        return $ret;
    }
   
}

