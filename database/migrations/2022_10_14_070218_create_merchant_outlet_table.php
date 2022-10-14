<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantOutletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_outlet', function (Blueprint $table) {
            $table->id();
            $table->integer('merchant_id');
            $table->integer('merchant_user_id')->nullable();
            $table->string('outlet_secret_key', 30)->nullable();
            $table->string('outlet_name')->nullable();
            $table->string('outlet_address');
            $table->string('outlet_latitude', 25);
            $table->string('outlet_longitude', 25);
            $table->string('outlet_logo')->nullable();
            $table->string('outlet_phone', 15);
            $table->string('outlet_laneline', 20)->nullable();
            $table->string('outlet_email', 100)->nullable();
            $table->string('outlet_discount', 30)->nullable();
            $table->string('outlet_hours', 50);
            $table->integer('primary_outlet')->default(0);
            $table->dateTime('created_at');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->integer('status');
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
        Schema::dropIfExists('merchant_outlet');
    }
}
