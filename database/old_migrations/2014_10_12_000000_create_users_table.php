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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('country_code');
            $table->string('phone_number')->unique();
            $table->dateTime('phone_verified_at')->nullable();
            $table->string('email')->unique()->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->boolean('gender')->nullable()->comment('1 for female and 0 for male');
            $table->date('DOB')->nullable()->comment('1 for female and 0 for male');
            $table->string('referral_code')->unique();
            $table->unsignedBigInteger('referrer_id')->nullable();
            $table->foreign('referrer_id')->references('id')->on('users');
            $table->string('PIN')->nullable();
            $table->string('profile_image')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
