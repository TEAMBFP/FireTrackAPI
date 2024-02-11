<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class FireStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            ['status'=> 'pending'],
            ['status'=> 'acknowledged'],
            ['status'=> 'ongoing'],
            ['status'=> 'done'],
        ];
        DB::table('fire_statuses')->insert($status);
    }
}
