<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'member_id',
        'receipt_id',
        'reference_no',

        'table_no',
        'cashier_id',
        'customer_id',
        'customer_count',
        'receipt_type',
        'service_charge',
        'taxable_total',
        'svc_tax_amt',
        'vat_tax_amt',
        'total_tax',
        'rounding_adj',
        'refund_flag',
        'cancel_flag',

        'business_name',
        'outlet_name',
        'outlet_id',
        'pos_sno',
        'purch_items',
        'gross_sales',
        'discount',
        'grand_total',
        'payment',
        'receipt_date',
        
    ];

    protected $casts = [
        'purch_items' => 'array',
        'discount' => 'array',
        'payment' => 'array',
    ];

}
