<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BasicModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->truncate();

        $basicModules = config('modules.basic');

        foreach ($basicModules as $module) {
            DB::table('modules')->insert([
                'name' => studly_case($module),
                'url' => $module,
                'created_at' => Carbon::now()
            ]);
        }
    }
}
