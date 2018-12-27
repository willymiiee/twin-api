<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_title_id')->unsigned();
            $table->integer('module_id')->unsigned();
            $table->integer('sub_module_id')->unsigned()->nullable();
            $table->boolean('list');
            $table->boolean('detail');
            $table->boolean('create');
            $table->boolean('update');
            $table->boolean('delete');
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
        Schema::dropIfExists('roles');
    }
}
