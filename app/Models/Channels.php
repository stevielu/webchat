<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Channels extends Authenticatable{

	protected $guard = "privateChannel";
    protected $table = 'channels';
	protected $fillable = array('channel_name','channel_type','room_id','password');
	protected $hidden = [
        'remember_token',
    ];
}
