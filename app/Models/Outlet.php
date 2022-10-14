<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Outlet extends Model
{
	use SoftDeletes;
	protected $primaryKey = 'id';
    protected $table = 'merchant_outlet';

    protected $fillable = [
        'merchant_id',
        'outlet_name',
        'outlet_address' ,
        'outlet_latitude',
        'outlet_longitude',
        'outlet_phone',
        'outlet_hours',
        'created_at',
        'status',
        
    ];

    public function merchant()
    {
    	return $this->belongsTo('App\Models\Merchant','merchant_id');
    }
}
