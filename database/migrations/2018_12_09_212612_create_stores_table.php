<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->string('acc_number')->nullable();
            $table->string('name');
            $table->text('address')->nullable();
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->string('phone')->nullable();
            $table->string('subdistrict')->nullable();
            $table->string('village')->nullable();
            $table->integer('zipcode')->unsigned()->nullable();
            $table->enum('type', ['grosir', 'retail', 'high class outlet'])->nullable();
            $table->string('key_person')->nullable();
            $table->enum('payment_type', ['credit', 'cash'])->nullable();
            $table->integer('term_of_payment')->unsigned()->nullable();
            $table->decimal('limit', 13, 2)->nullable();
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
        Schema::dropIfExists('stores');
    }
}
