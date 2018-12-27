<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->string('name', 50);
            $table->text('address')->nullable();
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->string('country', 2);
            $table->string('state', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('timezone', 5);
            $table->string('currency', 3);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
