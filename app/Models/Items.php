<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Items extends Model
{

	
    protected $table = 'items';

	protected $fillable = [
        'item_code',
		'item_name',
		'outlet_id',
		'status'
    ];

 }
