<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cdo_incidents = [
            'user_id' => 0,
            'station' => 'N/A',
            'image' => 'N/A',
            'location' => 'RER Drive Kauswagan, CDO'
        ];

        DB::table('incidents')->insert($cdo_incidents);
    }
}
