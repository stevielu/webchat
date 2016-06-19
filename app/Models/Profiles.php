<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Profiles extends Model{
	public $timestamps = false;
    protected $table = 'user_profile';
	protected $fillable = array('user_id','user_intro','address_city','address_suburb','user_age','user_gender');

}