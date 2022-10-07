<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class User_reward extends Model
{
	use SoftDeletes;
	
    protected $table = 'user_rewards';

	protected $fillable = [
        'member_id',
        'user_id',
        'member_id',
        'reward_point',
        'status',    
    ];

    public function users()
	{
	    return $this->hasOne('App\Models\User');
	}
}
