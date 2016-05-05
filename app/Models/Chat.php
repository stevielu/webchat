<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Chat extends Model{
    protected $table = 'chat_room';
	protected $fillable = array('room_name','room_type');

	public function SubClass(){
		return $this->hasMany('App\Models\ChatHistoryRecoder');
	}
}
