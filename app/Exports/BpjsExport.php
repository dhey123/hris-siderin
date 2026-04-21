<?php

namespace App\Exports;

use App\Models\BpjsRecord;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BpjsExport implements FromCollection, WithHeadings
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan = null, $tahun = null)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        $query = BpjsRecord::with('employee');

        // 🔥 FILTER (biar sesuai tampilan)
        if ($this->bulan) {
            $query->where('bulan', $this->bulan);
        }

        if ($this->tahun) {
            $query->where('tahun', $this->tahun);
        }

        return $query->get()->map(function ($item) {

            return [
                'id_karyawan' => $item->employee->id_karyawan,
                'nama' => $item->employee->full_name,
                'nik' => $item->employee->nik,
                'bulan' => $item->bulan,
                'tahun' => $item->tahun,
                'bpjs_kesehatan' => $item->bpjs_kesehatan,
                'bpjs_ketenagakerjaan' => $item->bpjs_ketenagakerjaan,
                'tanggal_bayar_kesehatan' => $item->tanggal_bayar_kesehatan
                    ? Carbon::parse($item->tanggal_bayar_kesehatan)->format('Y-m-d')
                    : '',
                'tanggal_bayar_ketenagakerjaan' => $item->tanggal_bayar_ketenagakerjaan
                    ? Carbon::parse($item->tanggal_bayar_ketenagakerjaan)->format('Y-m-d')
                    : '',
                'total_iuran' => $item->total_iuran ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'id_karyawan',
            'nama',
            'nik',
            'bulan',
            'tahun',
            'bpjs_kesehatan',
            'bpjs_ketenagakerjaan',
            'tanggal_bayar_kesehatan',
            'tanggal_bayar_ketenagakerjaan',
            'total_iuran',
        ];
    }
}