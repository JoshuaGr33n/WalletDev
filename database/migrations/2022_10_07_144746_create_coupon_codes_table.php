<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_codes', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('user_id');
            $table->integer('type')->default(0)->comment("1 - top-up, 2 - paid, 3 - get user info");
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('coupon', 40);
            $table->bigInteger('outlet_id')->nullable();
            $table->integer('merchant_id')->nullable();
            $table->string('firebase_uuid', 30);
            $table->string('transaction_id', 30)->nullable();
            $table->dateTime('tranasaction_datetime')->nullable();
            $table->string('currency', 10)->nullable();
            $table->timestamps();
            $table->string('updated_by', 10)->nullable();
            $table->integer('status')->comment("0 - initiated, 1 - Success, 2- Failure, 3- Expired");
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_codes');
    }
}
