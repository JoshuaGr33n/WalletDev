<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class User_reward_history extends Model
{
	use SoftDeletes;
	
    protected $table = 'user_reward_history';

    protected $fillable = [
        'couponcode_id',
        'user_id',
        'member_id',
        'reward_point',
        'type',    
        'rpoint_per_currency',
        'amount',
        'outlet_id',
        'merchant_id',
        'created_by',
        'status',    
    ];
}
