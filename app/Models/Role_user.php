<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role_user extends Model
{
	protected $table = 'role_user';
	
	public function users()
	{
	    return $this->hasMany('App\Models\User');
	}
}
