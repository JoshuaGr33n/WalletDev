<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('category_id');
            $table->integer('sub_category_id');
            $table->string('item_name');
            $table->string('item_image');
            $table->string('item_best_price', 20);
            $table->string('upc_code', 20);
            $table->string('product_id', 20);
            $table->text('item_description')->nullable();
            $table->integer('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->integer('updated_by')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->tinyInteger('status')->comment("1. Active, 2. Inactive, 3. Deleted");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
