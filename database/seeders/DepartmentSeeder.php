<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departments')->insert([
            ['name' => 'Human Resource', 'description' => 'Departemen HR'],
            ['name' => 'Finance', 'description' => 'Departemen Keuangan'],
            ['name' => 'IT', 'description' => 'Departemen Teknologi Informasi'],
        ]);
    }
}
