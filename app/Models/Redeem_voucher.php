<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Redeem_voucher extends Model
{
    use SoftDeletes;
    protected $table = 'redeem_vouchers';
}
