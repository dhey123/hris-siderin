<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeesDataExport implements FromCollection, WithHeadings, WithMapping
{
    protected $kategori;

    public function __construct($kategori = null)
    {
        $this->kategori = $kategori;
    }

    public function collection()
    {
        $query = Employee::with([
            'company',
            'department',
            'position',
            'employmentType',
            'employmentStatus',
            'maritalStatus',
            'religion',
            'bank',
            'familyMembers',
        ]);

        // 🔥 FILTER BERDASARKAN TIPE KARYAWAN
        if ($this->kategori) {
            $query->whereHas('employmentType', function ($q) {
                $q->whereRaw('LOWER(type_name) = ?', [strtolower($this->kategori)]);
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID Karyawan',
            'Department',
            'Nama Lengkap',
            'NIK',
            'No KK',
            'NPWP',
            'Status Pajak',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Golongan Darah',
            'Nama Ibu',
            'Status Pernikahan',
            'Jumlah Anak',
            'Agama',
            'Email',
            'No HP',
            'Alamat',
            'Divisi',
            'Posisi',
            'Tipe Karyawan',
            'Status Karyawan',
            'Tanggal Masuk',
            'BPJS Kesehatan',
            'BPJS Ketenagakerjaan',
            'Bank',
            'No Rekening',
        ];
    }

    public function map($e): array
    {
        return [
            $e->id_karyawan,
            optional($e->company)->company_name,
            $e->full_name,
            $e->nik,
            $e->kk_number,
            $e->npwp,
            $e->status_pajak,
            $e->gender,
            $e->birth_place,
            optional($e->birth_date)->format('Y-m-d'),
            $e->blood_type,
            $e->mother_name,
            optional($e->maritalStatus)->marital_status_name,
            $e->jumlah_tanggungan,
            optional($e->religion)->religion_name,
            $e->email,
            $e->phone,
            $e->address_ktp,
            optional($e->department)->department_name,
            optional($e->position)->position_name,
            optional($e->employmentType)->type_name,
            optional($e->employmentStatus)->status_name,
            optional($e->join_date)->format('Y-m-d'),
            $e->bpjs_kes,
            $e->bpjs_tk,
            optional($e->bank)->bank_name,
            $e->bank_account,
        ];
    }
}