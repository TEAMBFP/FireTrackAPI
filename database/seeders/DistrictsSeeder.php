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
            ['name' => 'Cagayan de Oro'],
            ['name' => 'Misamis Oriental'], 
            ['name' => 'Misamis Occidental'], 
            ['name' => 'Bukidnon'], 
            ['name' => 'Camiguin'], 
            ['name' => 'Lanao'], 
            ['name' => 'Iligan']
        ];

        DB::table ('districts')->insert($districts);
        
    }
}
