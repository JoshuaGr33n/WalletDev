<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_id')->unique('transaction_id');
            $table->string('receipt_id');
            $table->dateTime('receipt_date');
            $table->string('receipt_type');
            $table->string('reference_no');
            $table->integer('table_no');
            $table->string('cashier_id');
            $table->string('customer_id');
            $table->integer('customer_count');
            $table->string('business_name');
            $table->string('outlet_name');
            $table->integer('outlet_id');
            $table->string('pos_sno');
            $table->json('purch_items');
            $table->decimal('gross_sales', 5, 2);
            $table->json('discount');
            $table->decimal('service_charge', 5, 2);
            $table->decimal('taxable_total', 5, 2);
            $table->decimal('svc_tax_amt', 5, 2);
            $table->decimal('vat_tax_amt', 5, 2);
            $table->decimal('rounding_adj', 5, 2);
            $table->decimal('total_tax', 5, 2);
            $table->decimal('grand_total', 5, 2);
            $table->json('payment');
            $table->integer('refund_flag');
            $table->integer('cancel_flag');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
