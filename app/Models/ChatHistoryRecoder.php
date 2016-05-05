<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ChatHistoryRecoder extends Model{
    protected $table = 'chat_recoder';
	protected $fillable = array('room_id','channel','contents');

}
