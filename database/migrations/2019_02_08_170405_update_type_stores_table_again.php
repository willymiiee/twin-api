<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTypeStoresTableAgain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE stores MODIFY type ENUM('R1', 'R2', 'W', 'MM', 'KOP', 'HRC', 'HCO', 'B&D')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE stores MODIFY type ENUM('R1', 'R2', 'W', 'MM', 'KOP', 'HRC')");
    }
}
