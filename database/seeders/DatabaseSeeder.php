<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
          $this->call([
            FireStationSeeder::class,
            FireTypeSeeder::class,
            FireStatusSeeder::class,
            DistrictsSeeder::class,
            UserTypeSeeder::class,
            FireOccupancySeeder::class,
        ]);
    }
}
