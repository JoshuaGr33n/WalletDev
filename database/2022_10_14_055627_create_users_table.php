<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string('user_unique_id', 100)->nullable();
            $table->string('member_id', 30)->nullable();
            $table->string('first_name', 191)->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name', 100)->nullable();
            $table->string('gender', 15)->nullable();
            $table->string('user_name', 60)->nullable();
            $table->string('referral_code')->nullable();
            $table->string('role')->nullable();
            $table->integer('donotdisturb', 11);
            $table->date('dob')->nullable();
            $table->string('photo')->nullable();
            $table->string('country_code', 15)->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->string('postal_code', 15)->nullable();
            $table->string('location', 30);
            $table->string('state', 30);
            $table->string('home_phone', 30)->nullable();
            $table->boolean('is_email_verified')->default(0);
            $table->boolean('is_phone_verified')->default(0);
            $table->string('email', 191)->unique('users_email_unique');
            $table->string('password', 191);
            $table->rememberToken();
            $table->text('transaction_pin')->nullable();
            $table->date('registered_date')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->boolean('is_approved')->default(0);
            $table->integer('is_logged_in')->default(0);
            $table->string('user_qr_image', 36)->nullable();
            $table->enum('status', ['1', '2', '3'])->default('1');
            $table->integer('sign_up_type')->nullable();
            $table->string('facebook_id', 30)->nullable();
            $table->string('lang', 2)->nullable();
            $table->integer('rest_id')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('users');
    }
}
