<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Channels extends Model{
    protected $table = 'channels';
	protected $fillable = array('channel_name','channel_type','room_id');

}
