<?php

namespace App\Exports;

use App\Models\WasteLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class WasteLogExport implements FromCollection, WithHeadings
{
    protected $from;
    protected $to;
    protected $jenis;

    public function __construct($from = null, $to = null, $jenis = null)
    {
        $this->from = $from;
        $this->to = $to;
        $this->jenis = $jenis;
    }

    public function collection()
    {
        $query = WasteLog::with(['waste.logs'])
            ->where('tipe_log', 'Keluar');

        // ✅ FILTER TANGGAL (FIX FULL DAY)
        if ($this->from && $this->to) {
            $query->whereBetween('created_at', [
                Carbon::parse($this->from)->startOfDay(),
                Carbon::parse($this->to)->endOfDay()
            ]);
        }

        // ✅ FILTER JENIS (ANTI CASE SENSITIVE)
        if ($this->jenis) {
            $query->whereHas('waste', function ($q) {
                $q->whereRaw('LOWER(jenis_limbah) = ?', [strtolower($this->jenis)]);
            });
        }

        return $query->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($log) {

                $waste = $log->waste;

                // ❗ SAFETY (biar gak error kalau relasi kosong)
                if (!$waste) {
                    return [];
                }

                // ✅ MAKS SIMPAN
                $hari = $waste->jenis_limbah === 'B3' ? 90 : 180;
                $maks = Carbon::parse($waste->tanggal)
                    ->addDays($hari)
                    ->format('d/m/Y');

                // ✅ HITUNG SISA REAL
                $totalKeluar = $waste->logs
                    ->where('tipe_log', 'Keluar')
                    ->sum('jumlah');

                $sisa = $waste->jumlah - $totalKeluar;

                return [
                    'No Dokumen'     => $waste->no_dokumen ?? '-',
                    'Jenis Limbah'   => $waste->jenis_limbah ?? '-',
                    'Nama Limbah'    => $waste->nama_limbah ?? '-',
                    'Tanggal Masuk'  => $waste->tanggal
                        ? Carbon::parse($waste->tanggal)->format('d/m/Y')
                        : '-',
                    'Sumber'         => $waste->sumber_limbah ?? '-',
                    'Jumlah Masuk'   => number_format($waste->jumlah ?? 0, 2),
                    'Maks Simpan'    => $maks ?? '-',
                    'Tanggal Keluar' => $log->created_at
                        ? $log->created_at->format('d/m/Y')
                        : '-',
                    'Jumlah Keluar'  => number_format($log->jumlah ?? 0, 2),
                    'Tujuan'         => $waste->tujuan_pengelolaan ?? '-',
                    'Sisa'           => number_format($sisa ?? 0, 2),
                ];
            })
            ->filter() // 🔥 buang data kosong kalau ada
            ->values();
    }

    public function headings(): array
    {
        return [
            'No Dokumen',
            'Jenis Limbah',
            'Nama Limbah',
            'Tanggal Masuk',
            'Sumber',
            'Jumlah Masuk',
            'Maks Simpan',
            'Tanggal Keluar',
            'Jumlah Keluar',
            'Tujuan',
            'Sisa'
        ];
    }
}