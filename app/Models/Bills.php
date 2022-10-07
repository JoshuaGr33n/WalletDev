<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'receipt_number',
        'business_name',
        'outlet_name',
        'outlet_id',
        'terminal_id',
        'item',
        'discount',
        'amount',
        'payment',
        'date',
        
    ];

    protected $casts = [
        'item' => 'array',
        'discount' => 'array',
        'payment' => 'array',
    ];

}
