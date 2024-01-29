<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FireTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ## STRUCTURAL
            ['name'=> 'Structural'],
            ## NON-STRUCTURAL
            ['name'=>'Non-Structural'],
            ## VEHICULAR
            ['name'=> 'Vehicular']
        ];

     
        DB::table ('fire_types')->insert($types);
       
    }
}
