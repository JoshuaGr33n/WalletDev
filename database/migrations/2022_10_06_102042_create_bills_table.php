<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('member_id');
            $table->string('receipt_number');
            $table->string('business_name');
            $table->string('outlet_name');
            $table->string('terminal_id');
            $table->json('item');
            $table->integer('quantity');
            $table->json('discount');
            $table->decimal('amount', 5,2);
            $table->json('payment');
            $table->dateTime('date');
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
        Schema::dropIfExists('transactions');
    }
};
