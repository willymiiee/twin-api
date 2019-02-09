<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateItemTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('qty');
        });

        Schema::table('item_prices', function (Blueprint $table) {
            $table->dropColumn('item_id');
            $table->string('item_code', 10);
        });

        Schema::create('item_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_code', 10);
            $table->integer('warehouse_id')->unsigned();
            $table->integer('qty')->unsigned()->default(0);
            $table->integer('qty_pcs')->unsigned()->default(0);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
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
        Schema::table('items', function (Blueprint $table) {
            $table->integer('qty')->unsigned()->default(0);
        });

        Schema::table('item_prices', function (Blueprint $table) {
            $table->integer('item_id')->unsigned();
            $table->dropColumn('item_code');
        });

        Schema::dropIfExists('item_stocks');
    }
}
