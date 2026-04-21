<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class EmployeesSheet implements WithHeadings, WithTitle, WithEvents
{
    public function title(): string
    {
        return 'Employees';
    }

    public function headings(): array
    {
        return [
            'No Absen',             // kolom pertama                 
            'Nama Lengkap',        // full_name
            'NIK',
            'Jenis Kelamin',       // gender
            'Tempat Lahir',        // birth_place
            'Tanggal Lahir',       // birth_date
            'Pendidikan',          // education
            'Status Pernikahan',   // marital_status
            'Agama',               // religion
            'Golongan Darah',      // blood_type
            'Department',          // company
            'Divisi',          // department
            'Bagian',             // position
            'Tipe Pekerjaan',      // employment_type
            'Status Pekerjaan',    // employment_status
            'Tanggal Masuk',        // join_date
            'Rekomendasi',
            'Email',
            'Telepon',             // phone
            'Alamat KTP',          // address_ktp
            'Alamat Domisili',     // address_domisili
            'NPWP',
            'BPJS_Kes',      // bpjs_kes
            'BPJS_TK',             // bpjs_tk
            'Nama Ibu',            // mother_name
            'Bank',                // bank_id → dropdown
            'Nomor Rekening',      // bank_account
            'Nama Darurat',        // emergency_name
            'Hubungan Darurat',    // emergency_relation
            'Telp Darurat',        // emergency_phone
            'No KK',              // kk_number
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // Dropdown otomatis, sesuaikan kolom terbaru
                $dropdowns = [
                    'D' => 'Genders',              // Jenis Kelamin
                    'G' => 'Educations',           // Pendidikan
                    'H' => 'MaritalStatuses',      // Status Pernikahan
                    'I' => 'Religions',            // Agama
                    'J' => 'BloodTypes',           // Golongan Darah
                    'K' => 'Companies',            // Perusahaan
                    'L' => 'Departments',          // Departemen
                    'M' => 'Positions',            // Jabatan
                    'N' => 'EmploymentTypes',      // Tipe Pekerjaan
                    'O' => 'EmploymentStatuses',   // Status Pekerjaan
                    'z' => 'Banks',                // Bank (dropdown)
                ];

                // Loop untuk setiap row dropdown
                foreach ($dropdowns as $col => $sheetName) {
                    for ($row = 2; $row <= 2000; $row++) {
                        $validation = new DataValidation();
                        $validation->setType(DataValidation::TYPE_LIST);
                        $validation->setErrorStyle(DataValidation::STYLE_STOP);
                        $validation->setAllowBlank(true);
                        $validation->setShowDropDown(true);
                        $validation->setFormula1("={$sheetName}!A:A");

                        $sheet->getCell("{$col}{$row}")->setDataValidation($validation);
                    }
                }
            }
        ];
    }
}
