<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRewardHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_reward_history', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('couponcode_id');
            $table->bigInteger('user_id');
            $table->string('member_id');
            $table->integer('type')->default(0)->comment("1 - top-up, 2 - paid");
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('rpoint_per_currency', 20)->nullable();
            $table->string('reward_point', 10)->nullable();
            $table->bigInteger('outlet_id')->default(0);
            $table->integer('merchant_id')->nullable();
            $table->integer('created_by')->default(0);
            $table->timestamps();
            $table->integer('status')->comment("1 - Active");
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
        Schema::dropIfExists('user_reward_history');
    }
}
