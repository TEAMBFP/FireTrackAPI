<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlarmLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $alarms = [
             [
                'name' => 'False alarm',
            ],
            [
                'name' => 'Level 1',
            ],
            [
                'name' => 'Level 2',
            ],
            [
                'name' => 'Level 3',
            ],
            [
                'name' => 'General alarm',
            ]
        ];

        DB::table('alarm_levels')->insert($alarms);


    }
}
