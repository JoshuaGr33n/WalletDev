<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class User_wallet extends Model
{
	use SoftDeletes;
	
    protected $table = 'user_wallets';

	protected $fillable = [
        'amount',
		'user_id',
		'member_id',
		'wallet_address',
		'status',
    ];

    public function users()
	{
	    return $this->hasOne('App\Models\User');
	}
}
