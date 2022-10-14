<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('outlet_ids')->nullable();
            $table->integer('voucher_type_id');
            $table->string('voucher_code', 30)->nullable();
            $table->string('voucher_name');
            $table->text('voucher_description');
            $table->date('sale_start_date');
            $table->date('sale_end_date');
            $table->integer('discount_type')->nullable();
            $table->float('voucher_value')->nullable();
            $table->double('max_discount_amount', 10, 2)->default(0.00);
            $table->integer('total_required_points')->nullable();
            $table->string('voucher_image')->nullable();
            $table->string('tAndC')->nullable();
            $table->integer('max_qty')->nullable();
            $table->integer('single_user_qty')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('deleted_at')->nullable();
            $table->tinyInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}
