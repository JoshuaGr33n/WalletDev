<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Outlet extends Model
{
	use SoftDeletes;
	protected $primaryKey = 'id';
    protected $table = 'merchant_outlet';

    public function merchant()
    {
    	return $this->belongsTo('App\Models\Merchant','merchant_id');
    }
}
