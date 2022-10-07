<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class VoucherType extends Model
{
    use SoftDeletes;
    protected $table = 'voucher_type';

    public static function boot()
    {
        parent::boot();
        static::deleting(function($voutype)
        {
             $VoucherType = VoucherType::find($voutype->id);
             $VoucherType->type_id = $voutype->type_id.'_deleted';
             $VoucherType->save();
        });
    }
}
