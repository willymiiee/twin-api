<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces')->truncate();
        DB::table('districts')->truncate();
        DB::table('subdistricts')->truncate();
        DB::table('villages')->truncate();

        $this->command->line('Populating provinces...');
        Excel::load(storage_path('app/provinsi.csv'), function($reader) {
            $reader->noHeading = true;
        })->each(function ($csvLine) {
            DB::table('provinces')->insert([
                'id' => $csvLine[0],
                'name' => $csvLine[1]
            ]);
        });

        $this->command->line('Populating districts...');
        Excel::load(storage_path('app/kabupaten.csv'), function($reader) {
            $reader->noHeading = true;
        })->each(function ($csvLine) {
            DB::table('districts')->insert([
                'id' => $csvLine[0],
                'province_id' => $csvLine[1],
                'name' => $csvLine[2]
            ]);
        });

        $this->command->line('Populating subdistricts...');
        Excel::load(storage_path('app/kecamatan.csv'), function($reader) {
            $reader->noHeading = true;
        })->each(function ($csvLine) {
            DB::table('subdistricts')->insert([
                'id' => $csvLine[0],
                'district_id' => $csvLine[1],
                'name' => $csvLine[2]
            ]);
        });

        $this->command->line('Populating villages...');
        Excel::load(storage_path('app/kelurahan.csv'), function($reader) {
            $reader->noHeading = true;
        })->each(function ($csvLine) {
            DB::table('villages')->insert([
                'id' => $csvLine[0],
                'subdistrict_id' => $csvLine[1],
                'name' => $csvLine[2]
            ]);
        });
    }
}
