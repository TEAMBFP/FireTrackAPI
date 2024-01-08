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
            ['name'=> 'Assembly', 'type'=> 'Structural'],
            ['name'=> 'Educational', 'type'=> 'Structural'],
            ['name'=> 'Day Care', 'type'=> 'Structural'],
            ['name'=> 'Health Care', 'type'=> 'Structural'],
            ['name'=> 'Residential Board and Care', 'type'=> 'Structural'],
            ['name'=> 'Detention and Correctional', 'type'=> 'Structural'],
            ['name'=> 'Residential', 'type'=> 'Structural'],
            ['name'=> 'Mercantile', 'type'=>'Structural'],
            ['name'=> 'Business', 'type'=>'Structural'],
            ['name'=> 'Industrial', 'type'=> 'Structural'],
            ['name'=> 'Storage', 'type'=> 'Structural'],
            ['name'=> 'Mixed Occupancies', 'type'=> 'Structural'],
            ['name'=> 'Special Structures', 'type'=> 'Structural'],
            ## NON-STRUCTURAL
            ['name'=> 'Grass', 'type'=> 'Non-Structural'],
            ['name'=> 'Agricultural(Agro)', 'type'=> 'Non-Structural'],
            ['name'=> 'Rubbish', 'type'=> 'Non-Structural'],
            ['name'=> 'Post', 'type'=>'Non-Structural'],
            ['name'=> 'Forest', 'type'=>'Non-Structural'],
            ## VEHICULAR
            ['name'=> 'Motor Vehicle', 'type'=> 'Vehicular'],
            ['name'=> 'Ship/Water Vessel', 'type'=> 'Vehicular'],
            ['name'=> 'Air Craft', 'type'=> 'Vehicular'],
            ['name'=> 'Locomotive', 'type'=> 'Vehicular']

        ];
        DB::table ('fire_types')->insert( $types);
    }
}
