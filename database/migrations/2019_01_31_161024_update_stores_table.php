<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('subdistrict');
            $table->dropColumn('village');
            $table->string('mars_code')->nullable();
            $table->string('province_id', 2)->nullable();
            $table->string('district_id', 4)->nullable();
            $table->string('subdistrict_id', 7)->nullable();
            $table->string('village_id', 10)->nullable();
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
        Schema::table('stores', function (Blueprint $table) {
            $table->string('subdistrict')->nullable();
            $table->string('village')->nullable();
            $table->dropColumn('mars_code');
            $table->dropColumn('province_id');
            $table->dropColumn('district_id');
            $table->dropColumn('subdistrict_id');
            $table->dropColumn('village_id');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            $table->dropColumn('deleted_by');
        });
    }
}
