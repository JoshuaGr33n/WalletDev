<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('merchant_id', 50)->nullable();
            $table->integer('merchant_user_id')->nullable();
            $table->string('company_name', 100)->nullable();
            $table->string('merchant_logo')->nullable();
            $table->string('contact_name', 30)->nullable();
            $table->string('merchant_email', 100)->nullable();
            $table->string('contact_phone', 12)->nullable();
            $table->text('address')->nullable();
            $table->string('post_code', 10)->nullable();
            $table->integer('merchant_category')->nullable();
            $table->string('reg_no', 20)->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->integer('created_by');
            $table->boolean('is_deleted')->default(0);
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
        Schema::dropIfExists('merchants');
    }
}
