<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('email', 30)->unique()->nullable();
            $table->string('phone', 15)->unique();
            $table->string('password');
            $table->text('avatar')->nullable();
            $table->string('identity_number', 12)->nullable();
            $table->string('driver_license', 12)->nullable();
            $table->enum('status', ['active', 'non_active', 'need_activation'])->default('need_activation');
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
        Schema::dropIfExists('users');
    }
}
