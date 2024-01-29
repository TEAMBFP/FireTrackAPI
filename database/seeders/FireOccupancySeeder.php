<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class FireOccupancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $occupancies = [
            ## STRUCTURAL
            ['name'=> 'Assembly', 'fire_type_id'=> 1],
            ['name'=> 'Educational', 'fire_type_id'=> 1],
            ['name'=> 'Day Care', 'fire_type_id'=> 1],
            ['name'=> 'Health Care', 'fire_type_id'=> 1],
            ['name'=> 'Residential Board and Care', 'fire_type_id'=> 1],
            ['name'=> 'Detention and Correctional', 'fire_type_id'=> 1],
            ['name'=> 'Residential', 'fire_type_id'=> 1],
            ['name'=> 'Mercantile', 'fire_type_id'=> 1],
            ['name'=> 'Business', 'fire_type_id'=> 1],
            ['name'=> 'Industrial', 'fire_type_id'=> 1],
            ['name'=> 'Storage', 'fire_type_id'=> 1],
            ['name'=> 'Mixed Occupancies', 'fire_type_id'=> 1],
            ['name'=> 'Special Structures', 'fire_type_id'=> 1],
            ## NON-STRUCTURAL
            ['name'=> 'Grass', 'fire_type_id' => 2],
            ['name'=> 'Agricultural(Agro)', 'fire_type_id' => 2],
            ['name'=> 'Forest', 'fire_type_id' => 2],
            ['name'=> 'Rubbish', 'fire_type_id' => 2],
            ['name'=> 'Post', 'fire_type_id' => 2],
            ## VEHICULAR
            ['name'=> 'Motor Vehicle', 'fire_type_id'=> 3],
            ['name'=> 'Ship/Water Vessel', 'fire_type_id'=> 3],
            ['name'=> 'Air Craft', 'fire_type_id'=> 3],
            ['name'=> 'Locomotive', 'fire_type_id'=> 3]
        ];
         DB::table ('fire_occupancies')->insert($occupancies);
    }
}
