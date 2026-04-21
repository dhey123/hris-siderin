<?php

namespace App\Exports;

use App\Models\LeaveBalance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeaveBalanceExport implements FromCollection, WithHeadings
{
    protected $year;

    public function __construct($year = null)
    {
        $this->year = $year ?? date('Y');
    }

    public function collection()
    {
        return LeaveBalance::with('employee')
            ->where('year', $this->year)
            ->get()
            ->map(function ($bal) {
                return [
                    'Nama Karyawan' => $bal->employee->full_name,
                    'Tahun' => $bal->year,
                    'Total Cuti' => $bal->quota,
                    'Cuti Terpakai' => $bal->used,
                    'Sisa Cuti' => $bal->quota - $bal->used,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Karyawan',
            'Tahun',
            'Total Cuti',
            'Cuti Terpakai',
            'Sisa Cuti',
        ];
    }
}