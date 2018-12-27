<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripDestinationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_destination_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trip_destination_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->integer('qty')->unsigned()->default(1);
            $table->string('unit', 10)->default('pcs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_destination_items');
    }
}
