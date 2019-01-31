<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->text('barcode')->nullable();
            $table->decimal('weight', 13, 2)->default(0);
            $table->string('weight_unit', 10)->default('g');
            $table->integer('contents')->unsigned()->default(0);
            $table->string('unit', 10);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
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
            $table->decimal('price', 13, 2)->default(0);
            $table->dropColumn('barcode');
            $table->dropColumn('weight');
            $table->dropColumn('weight_unit');
            $table->dropColumn('contents');
            $table->dropColumn('unit');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            $table->dropColumn('deleted_by');
        });
    }
}
