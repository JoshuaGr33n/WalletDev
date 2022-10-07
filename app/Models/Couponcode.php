<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Couponcode extends Model
{
	use SoftDeletes;
	protected $fillable = ['status'];
	
    protected $table = 'couponcodes';

    public function Outlet()
    {
        return $this->hasOne('App\Models\Outlet','id','outlet_id');
    }
    public function reward_history()
    {
        return $this->hasOne('App\Models\User_reward_history');
    }
}
