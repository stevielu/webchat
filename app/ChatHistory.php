<?php

namespace App;

use Storage;
trait ChatHistory
{

    public function __construct()
    {
       
    }

    public function getChatInfo(){

    }

    public function setChatInfo($message,$channel){
        $path = config('filepath.chat.textrecoder');
        $filename = $path.date('Y-m-d').'-'.$channel.'.txt';

        if($this->_currentHistoryFileExist($filename)){
            //add content
            $ret = $this->_appendChatHistory($message,$filename);
        }
        else{
            //create history file
            $ret = $this->_createChatHistory($filename,$message);
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

    private function _createChatHistory($filename,$message){
        
        $ret = Storage::put($filename, $message);
        return $ret;
    }
   
}

