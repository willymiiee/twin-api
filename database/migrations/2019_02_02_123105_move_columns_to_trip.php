<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveColumnsToTrip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('payment_type');
            $table->dropColumn('term_of_payment');
            $table->dropColumn('limit');
        });

        Schema::table('trips', function (Blueprint $table) {
            $table->integer('team_id')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
        });

        Schema::table('trip_destinations', function (Blueprint $table) {
            $table->enum('payment_type', ['credit', 'cash'])->nullable();
            $table->integer('term_of_payment')->unsigned()->nullable();
            $table->decimal('limit', 13, 2)->nullable();
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
            $table->enum('payment_type', ['credit', 'cash'])->nullable();
            $table->integer('term_of_payment')->unsigned()->nullable();
            $table->decimal('limit', 13, 2)->nullable();
        });

        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn('team_id');
            $table->dropColumn('deleted_by');
        });

        Schema::table('trip_destinations', function (Blueprint $table) {
            $table->dropColumn('payment_type');
            $table->dropColumn('term_of_payment');
            $table->dropColumn('limit');
        });
    }
}
