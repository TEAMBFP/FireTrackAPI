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
          'name' => 'Cogon Fire Station',
          'address' => 'Capt. Vicente Roa St, Cagayan de Oro, Misamis Oriental',
          'district_id' => 1,
          'latitude' => 8.48059,
          'longitude' => 124.6512,
          'number' => '09267520623',
        ],
        [
          'name' => 'Station 1A - Barangay 7 Fire Substation',
          'address' => 'Burgos St, Cagayan de Oro, Misamis Oriental',
          'district_id' => 1,
          'latitude' => 8.47953,
          'longitude' => 124.64148,
          'number' => '09267908805',
        ],
        [
          'name' => 'Lapasan Fire Station',
          'address' => 'Claro M. Recto Ave, Cagayan de Oro, Misamis Oriental',
          'district_id' => 1,
          'latitude' => 8.48286,
          'longitude' => 124.6649,
          'number' => '09975267466',
        ],
        [
        'name' => 'Carmen Fire Station',
        'address' => 'Carmen Barangay Hall, Mabolo St, Cagayan de Oro, Misamis Oriental',
        'district_id' => 1,
        'latitude' => 8.48106,
        'longitude' => 124.63583,
        'number' => '09678404415',
        ],
        [
        'name' => 'Balulang Fire Sub-Station',
        'address' => 'Balulang, Barangay Hall, Cagayan de oro, Misamis Oriental',
        'district_id' => 1,
        'latitude' => 8.44635,
        'longitude' => 124.63664,
        'number' => '09061863668',
        ],
        [
          'name' => 'Nazareth Fire Station',
          'address' => '16th Street, 24th St, Cagayan de Oro, Misamis Oriental',
          'district_id' => 1,
          'latitude' => 8.46861,
          'longitude' => 124.64841,
          'number' => '09356577116',
        ],
        [ 
          'name' => 'Macasandig Fire Sub-Station',
          'address' => 'Macasandig, Cagayan de Oro, Misamis Oriental',
          'district_id' => 1,
          'latitude' => 8.45592,
          'longitude' => 124.64621,
          'number' => '09763471933'
        ],
        [
          'name' => 'Indahag Fire Sub-Station',
          'address' => 'Indahag, Cagayan de Oro, Misamis Oriental',
          'district_id' => 1,
          'latitude' => 8.42293,
          'longitude' => 124.66713,
          'number' => '09771123813'
        ],
        [
          'name' => 'Macabalan Fire Station',
          'address' => 'Julio Pacana Street, Cagayan de Oro, Misamis Oriental',
          'district_id' => 1,
          'latitude' => 8.50415,
          'longitude' => 124.65905,
          'number' => '09353805117'
        ],
        [ 
          'name' => 'Kauswagan Fire Station',
          'address' => 'Kauswagan, Cagayan de Oro, Misamis Oriental',
          'district_id' => 1,
          'latitude' => 8.50396,
          'longitude' => 124.6286,
          'number' => '09266694906'
        ],
        [
          'name' => 'Bulua Fire Station',
          'address' => 'Bulua, Zone 6, Cagayan de Oro, Misamis Oriental',
          'district_id' => 1,
          'latitude' => 8.50526,
          'longitude' => 124.6142,
          'number' => '09650622007',
        ],
        [
          'name' => 'Pagatpat Fire Sub-Station',
          'address' => 'FH6M+3QQ, Pagatpat, Cagayan de Oro, Misamis Oriental',
          'district_id' => 1,
          'latitude' => 8.46022,
          'longitude' => 124.58446,
          'number' => '0953 487 7080',
        ],
        [
          'name' => 'Puerto Fire Station',
          'address' => 'Puerto, Cagayan de Oro, Misamis Oriental',
          'district_id' => 1,
          'latitude' => 8.49792,
          'longitude' => 124.76026,
          'number' => '0905 700 8622',
        ],
        [
          'name' => 'Lumbia Fire Station',
          'address' => 'CH2V+VR4, Lumbia, Cagayan de Oro, Misamis Oriental',
          'district_id' => 1,
          'latitude' => 8.40214,
          'longitude' => 124.59458,
          'number' => '0927 422 3410',
        ],
      ];
        DB::table('fire_stations')->insert($firstation);
    }
}
