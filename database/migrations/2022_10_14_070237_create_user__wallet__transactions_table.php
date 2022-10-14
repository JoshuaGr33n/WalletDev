<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user__wallet__transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('receipt_no');
            $table->integer('user_id');
            $table->string('wallet_address');
            $table->string('wallet_balance');
            $table->string('rest_id');
            $table->string('transaction_date');
            $table->string('transaction_type', 50);
            $table->integer('outlet_id');
            $table->string('reason');
            $table->string('status', 50)->default('1');
            $table->string('request_amount');
            $table->string('staff_id', 50);
            $table->string('pay_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user__wallet__transactions');
    }
}
