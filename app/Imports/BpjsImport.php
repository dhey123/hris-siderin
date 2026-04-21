<?php

namespace App\Imports;

use App\Models\BpjsRecord;
use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;

class BpjsImport implements ToCollection
{
    public $errors = [];

    public function collection(Collection $rows)
    {
        // 🔥 LOOP DATA
        foreach ($rows->skip(1) as $index => $row) {

            try {

                // 🔥 AMBIL DATA (INDEX BASED)
                $nik   = trim((string) ($row[0] ?? ''));
                $nama  = trim((string) ($row[1] ?? ''));
                $bulanInput = trim((string) ($row[2] ?? ''));
                $tahun = $row[3] ?? null;
                $bpjsKes = strtolower(trim((string) ($row[4] ?? 'unpaid')));
                $bpjsTk  = strtolower(trim((string) ($row[5] ?? 'unpaid')));
                $total   = $row[6] ?? 0;

                // 🔥 VALIDASI WAJIB
                if (!$nik || !$bulanInput || !$tahun) {
                    $this->errors[] = "Baris ".($index+2)." : data wajib kosong";
                    continue;
                }

                // 🔥 FIX NIK (ANTI SPASI / FORMAT EXCEL)
                $nik = trim($nik);

                // 🔥 CONVERT BULAN
                if (is_numeric($bulanInput)) {
                    $bulan = (int) $bulanInput;
                } else {
                    try {
                        $bulan = Carbon::parse($bulanInput)->month;
                    } catch (\Exception $e) {
                        $bulan = null;
                    }
                }

                if (!$bulan || $bulan < 1 || $bulan > 12) {
                    $this->errors[] = "Baris ".($index+2)." : bulan tidak valid ($bulanInput)";
                    continue;
                }

                // 🔥 CARI EMPLOYEE (LEBIH TOLERAN)
                $employee = Employee::whereRaw('TRIM(nik) = ?', [$nik])->first();

                if (!$employee) {
                    $this->errors[] = "Baris ".($index+2)." : NIK tidak ditemukan ($nik)";
                    continue;
                }

                $isBorongan = $employee->isBorongan();

                // 🔥 VALIDASI VALUE
                $allowed = ['paid', 'unpaid'];

                if (!in_array($bpjsKes, $allowed)) $bpjsKes = 'unpaid';
                if (!in_array($bpjsTk, $allowed)) $bpjsTk = 'unpaid';

                // 🔥 HANDLE BORONGAN
                if ($isBorongan) {
                    $bpjsKes = 'mandiri';
                }

                // 🔥 SIMPAN
                BpjsRecord::updateOrCreate(
                    [
                        'employee_id' => $employee->id,
                        'bulan' => $bulan,
                        'tahun' => (int) $tahun,
                    ],
                    [
                        'bpjs_kesehatan' => $bpjsKes,
                        'bpjs_ketenagakerjaan' => $bpjsTk,

                        'tanggal_bayar_kesehatan' =>
                            $bpjsKes === 'paid' ? Carbon::now() : null,

                        'tanggal_bayar_ketenagakerjaan' =>
                            $bpjsTk === 'paid' ? Carbon::now() : null,

                        'total_iuran' => (float) $total,
                    ]
                );

            } catch (\Exception $e) {

                $this->errors[] = "Baris ".($index+2)." : ".$e->getMessage();

            }
        }
    }
}