<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HealthReportExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Employee::with(['company','department','position','mcus','suratDokters'])
            ->orderBy('full_name')
            ->get();
    }

    public function headings(): array
    {
        return [
            'NIK',
            'Nama',
            'Department',
            'Divisi',
            'Posisi',
            'MCU Terakhir',
            'Jenis MCU',
            'Total Surat Dokter',
            'Hari Sakit',
            'Status Kesehatan',
        ];
    }

    public function map($emp): array
{
    $lastMcu = $emp->mcus->sortByDesc('tanggal_mcu')->first();

    return [
         $emp->nik,
         $emp->full_name,
        $emp->company->company_name ?? '-',
        $emp->department->department_name ?? '-',
        $emp->position->position_name ?? '-',

        // ✅ FORMAT TANGGAL MCU
        $lastMcu
            ? $lastMcu->tanggal_mcu->format('d-m-Y')
            : '-',

        optional($lastMcu)->jenis_mcu ?? '-',
        $emp->suratDokters->count(),
        $emp->suratDokters->sum('hari_istirahat'),
        $emp->suratDokters->count() > 0
            ? 'Sakit'
            : ($emp->mcus->count() == 0 ? 'Belum MCU' : 'Sehat'),
    ];

    }
}
