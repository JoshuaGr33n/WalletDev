<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BundleVouchers extends Model
{
    use SoftDeletes;
    protected $table = 'bundle_vouchers';

    protected $fillable = [
        'status' 
    ];

    // public function voucherType()
    // {
    //     return $this->hasOne('App\Models\VoucherType','id','voucher_type_id');
    // }
}
