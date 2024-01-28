<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usertypes = [
            ['name' => 'Regional Director'],
            ['name' => 'District director'],
            ['name' => 'Fire station director'],
            ['name' => 'User'],
            ['name' => 'Admin'],
            ['name' => 'Employee']
        ];
        DB::table('user_types')->insert($usertypes);
    }
}
