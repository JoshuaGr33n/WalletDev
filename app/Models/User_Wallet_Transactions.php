<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Wallet_Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'user_id',
        'receipt_no',
        'wallet_address',

        'wallet_balance',
        'rest_id',
        'transaction_date',
        'transaction_type',
        'outlet_id',
        'reason',
        'status',
        'request_amount',
        'staff_id',
        'pay_id'
        
    ];

}
