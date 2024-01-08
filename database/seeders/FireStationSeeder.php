<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class FireStationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
      $firstation =  [
        [
          'address' => 'Cogon Fire Station',
          'latitude' => 8.48059,
          'longitude' => 124.6512,
          'number' => '09267520623',
        ],
        [
          'address' => 'Station 1A - Barangay 7 Fire Substation',
          'latitude' => 8.47953,
          'longitude' => 124.64148,
          'number' => '09267908805',
        ],
        [
          'address' => 'Lapasan Fire Station',
          'latitude' => 8.48286,
          'longitude' => 124.6649,
          'number' => '09975267466',
        ],
        [
        'address' => 'Carmen Fire Station',
        'latitude' => 8.48106,
        'longitude' => 124.63583,
        'number' => '09678404415',
        ],
        [
        'address' => 'Balulang Fire Sub-Station',
        'latitude' => 8.44635,
        'longitude' => 124.63664,
        'number' => '09061863668',
        ],
        [
          'address' => 'Nazareth Fire Station',
          'latitude' => 8.46861,
          'longitude' => 124.64841,
          'number' => '09356577116',
        ],
        [ 
          'address' => 'Macasandig Fire Sub-Station',
          'latitude' => 8.45592,
          'longitude' => 124.64621,
          'number' => '09763471933'
        ],
        [
          'address' => 'Indahag Fire Sub-Station',
          'latitude' => 8.42293,
          'longitude' => 124.66713,
          'number' => '09771123813'
        ],
        [
          'address' => 'Macabalan Fire Station',
          'latitude' => 8.50415,
          'longitude' => 124.65905,
          'number' => '09353805117'
        ],
        [ 
          'address' => 'Kauswagan Fire Station',
          'latitude' => 8.50396,
          'longitude' => 124.6286,
          'number' => '09266694906'
        ],
        [
          'address' => 'Bulua Fire Station',
          'latitude' => 8.50526,
          'longitude' => 124.6142,
          'number' => '09650622007',
        ],
        [
          'address' => 'Pagatpat Fire Sub-Station',
          'latitude' => 8.46022,
          'longitude' => 124.58446,
          'number' => '0953 487 7080',
        ],
        [
          'address' => 'Puerto Fire Station',
          'latitude' => 8.49792,
          'longitude' => 124.76026,
          'number' => '0905 700 8622',
        ],
        [
          'address' => 'Lumbia Fire Station',
          'latitude' => 8.40214,
          'longitude' => 124.59458,
          'number' => '0927 422 3410',
        ],
      ];
        DB::table('fire_stations')->insert($firstation);
    }
}
