<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $data = [
        [
            'name' => 'Cuti Tahunan',
            'category' => 'cuti',
            'default_quota' => 12,
            'is_paid' => true,
        ],
        [
            'name' => 'Cuti Sakit',
            'category' => 'izin',
            'default_quota' => null,
            'is_paid' => true,
        ],
        [
            'name' => 'Cuti Menikah',
            'category' => 'cuti',
            'default_quota' => 3,
            'is_paid' => true,
        ],
        [
            'name' => 'Cuti Melahirkan',
            'category' => 'cuti',
            'default_quota' => 90,
            'is_paid' => true,
        ],
        [
            'name' => 'Izin Keluarga',
            'category' => 'izin',
            'default_quota' => null,
            'is_paid' => true,
        ],
        [
            'name' => 'Izin Tidak Masuk',
            'category' => 'izin',
            'default_quota' => null,
            'is_paid' => false,
        ],
    ];

    foreach ($data as $row) {
        \App\Models\LeaveType::create($row);
    }
}

}
