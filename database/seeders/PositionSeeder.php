<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('positions')->insert([
            ['name' => 'HR Staff', 'department_id' => 1],
            ['name' => 'Accountant', 'department_id' => 2],
            ['name' => 'Software Developer', 'department_id' => 3],
            ['name' => 'IT Support', 'department_id' => 3],
        ]);
    }
}
