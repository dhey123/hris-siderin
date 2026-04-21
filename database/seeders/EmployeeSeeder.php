<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'employee_code' => 'EMP001',
                'full_name' => 'Budi Santoso',
                'gender' => 'Laki-laki',
                'birth_place' => 'Jakarta',
                'birth_date' => '1995-04-12',
                'nik_ktp' => '3276011204950001',
                'email' => 'budi@example.com',
                'phone' => '081234567890',

                // KATEGORI
                'company_type' => 'Quantum',
                'employment_type' => 'Tetap',

                // RELASI
                'department_id' => 1,
                'position_id' => 1,

                // PERSONAL
                'mother_name' => 'Siti Aminah',
                'blood_type' => 'O',
                'marital_status' => 'Belum Menikah',
                'education' => 'S1 Informatika',

                // DOKUMEN
                'sim' => 'SIM A',
                'npwp' => '09.234.123.9-888.000',
                'bpjs_tk' => '1234567890',
                'bpjs_kes' => '2233445566',

                // BANK
                'bank_name' => 'BCA',
                'bank_number' => '1234567891',

                'alamat' => 'Depok',
                'status' => 'Aktif'
            ],

            [
                'employee_code' => 'EMP002',
                'full_name' => 'Rina Marlina',
                'gender' => 'Perempuan',
                'birth_place' => 'Bogor',
                'birth_date' => '1998-08-22',
                'nik_ktp' => '3276012208980002',
                'email' => 'rina@example.com',
                'phone' => '081211112222',

                'company_type' => 'Uniland',
                'employment_type' => 'Kontrak',

                'department_id' => 2,
                'position_id' => 2,

                'mother_name' => 'Tina',
                'blood_type' => 'A',
                'marital_status' => 'Menikah',
                'education' => 'SMA',

                'sim' => 'SIM C',
                'npwp' => '11.777.222.9-555.000',
                'bpjs_tk' => '9988776655',
                'bpjs_kes' => '6677889900',

                'bank_name' => 'Mandiri',
                'bank_number' => '9876543211',

                'alamat' => 'Bogor',
                'status' => 'Aktif'
            ],

            [
                'employee_code' => 'EMP003',
                'full_name' => 'Samsul Anwar',
                'gender' => 'Laki-laki',
                'birth_place' => 'Cibinong',
                'birth_date' => '2000-02-10',
                'nik_ktp' => '3276011002000003',
                'email' => 'samsul@example.com',
                'phone' => '082233445566',

                'company_type' => 'Borongan',
                'employment_type' => 'Borongan',

                'department_id' => 7,
                'position_id' => 4,

                'mother_name' => 'Sumiyati',
                'blood_type' => 'B',
                'marital_status' => 'Belum Menikah',
                'education' => 'SMP',

                'sim' => null,
                'npwp' => null,
                'bpjs_tk' => null,
                'bpjs_kes' => null,

                'bank_name' => null,
                'bank_number' => null,

                'alamat' => 'Cibinong',
                'status' => 'Aktif'
            ],
        ];

        foreach ($data as $d) {
            Employee::create($d);
        }
    }
}
