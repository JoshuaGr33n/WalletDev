<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Voucher extends Model
{
    use SoftDeletes;
    protected $table = 'vouchers';

    public function voucherType()
    {
        return $this->hasOne('App\Models\VoucherType','id','voucher_type_id');
    }
}
