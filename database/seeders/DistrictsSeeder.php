<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $districts = [ 
            [
                'name' => 'Cagayan de Oro',
                'region_id' => '1'
            ],
            [
                'name' => 'Misamis Oriental',
                'region_id' => '1'
            ], 
            [
                'name' => 'Misamis Occidental',
                'region_id' => '1'
            ], 
            [
                'name' => 'Bukidnon',
                'region_id' => '1'
            ], 
            [
                'name' => 'Camiguin',
                'region_id' => '1'
            ], 
            [
                'name' => 'Lanao',
                'region_id' => '1'
            ], 
            [
                'name' => 'Iligan',
                'region_id' => '1'
            ]
        ];

        DB::table ('districts')->insert($districts);
        
    }
}
