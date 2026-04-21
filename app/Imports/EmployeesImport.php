<?php

namespace App\Imports;

use App\Models\Bank;
use App\Models\Employee;
use App\Models\Company;
use App\Models\Department;
use App\Models\Position;
use App\Models\EmploymentType;
use App\Models\EmploymentStatus;
use App\Models\Education;
use App\Models\MaritalStatus;
use App\Models\Religion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EmployeesImport implements ToCollection, WithHeadingRow
{
    public int $inserted = 0;
    public int $skipped  = 0;

    /* =========================
     * HELPER
     * ========================= */
    private function parseDate($value)
    {
        if (empty($value)) return null;

        if (is_numeric($value)) {
            return Date::excelToDateTimeObject($value)->format('Y-m-d');
        }

        $timestamp = strtotime($value);
        return $timestamp ? date('Y-m-d', $timestamp) : null;
    }
    
    private function safeLike($model, $column, $value)
    {
        if (!$value) return null;

        return $model::where($column, 'LIKE', '%' . trim($value) . '%')
            ->value('id');
    }

    private function getCompanyPrefix($companyName)
{
    $name = strtolower(trim($companyName));

    if (str_contains($name, 'quantum')) return 'QTM';
    if (str_contains($name, 'uniland')) return 'UNL';
    if (str_contains($name, 'excel')) return 'EXL';

    return 'OTH';

    }

    /* =========================
     * MAIN IMPORT
     * ========================= */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            /* =========================
             * NIK = KUNCI UTAMA
             * ========================= */
            $nik = trim($row['nik'] ?? '');

            if (!$nik) {
                $this->skipped++;
                continue;
            }

            if (Employee::where('nik', $nik)->exists()) {
                $this->skipped++;
                continue;
            }

/* =========================
 * BASIC IDENTITY
 * ========================= */
$fullName = trim($row['full_name'] ?? $row['nama_lengkap'] ?? '');
if (!$fullName) {
    $this->skipped++;
    continue;
}

// ✅ EMAIL BOLEH KOSONG
$email = trim($row['email'] ?? '');
$email = $email !== '' ? $email : null;

/* =========================
 * 🔥 GENERATE ID KARYAWAN (FINAL FIX - NO DOUBLE)
 * ========================= */

// ambil raw dari excel
$nomorAbsenRaw = trim(
    $row['no absen']
    ?? $row['no_absen']
    ?? $row['nomor absen']
    ?? $row['nomor_absen']
    ?? ''
);

// ambil angka doang
$nomorAbsen = preg_replace('/[^0-9]/', '', $nomorAbsenRaw);

$idKaryawan = null;

if (!empty($nomorAbsen)) {

    // 🔥 KIRIM ANGKA DOANG KE MODEL
    // biar model yang handle prefix
    $idKaryawan = $nomorAbsen;

    // 🚫 ANTI DUPLIKAT (cek juga angka & prefix kemungkinan)
    if (
        Employee::where('id_karyawan', $idKaryawan)->exists() ||
        Employee::where('id_karyawan', 'LIKE', '%-' . $nomorAbsen)->exists()
    ) {
        $this->skipped++;
        continue;
    }
}
            /* =========================
             * GENDER
             * ========================= */
            $genderRaw = strtolower(trim($row['gender'] ?? $row['jenis_kelamin'] ?? ''));
            $gender = match ($genderRaw) {
                'laki-laki', 'l', 'male' => 'L',
                'perempuan', 'p', 'female' => 'P',
                default => null,
            };

            /* =========================
             * BLOOD TYPE
             * ========================= */
            $bloodRaw = strtoupper(trim(
                $row['blood_type']
                ?? $row['golongan_darah']
                ?? $row['gol_darah']
                ?? ''
            ));

            $bloodClean = str_replace(['+', '-'], '', $bloodRaw);
            $bloodType = in_array($bloodClean, ['A', 'B', 'AB', 'O'])
                ? $bloodClean
                : null;

            /* =========================
             * MARITAL STATUS
             * ========================= */
            $maritalRaw = strtolower(trim(
                $row['marital_status']
                ?? $row['status_pernikahan']
                ?? $row['status_nikah']
                ?? ''
            ));

            $maritalId = null;

            if ($maritalRaw) {
                if (str_contains($maritalRaw, 'cerai')) {
                    $maritalId = MaritalStatus::where('marital_status_name', 'Divorced')->value('id');
                } elseif (
                    str_contains($maritalRaw, 'menikah') ||
                    str_contains($maritalRaw, 'kawin')
                ) {
                    $maritalId = MaritalStatus::where('marital_status_name', 'Married')->value('id');
                } else {
                    $maritalId = MaritalStatus::where('marital_status_name', 'Single')->value('id');
                }
            }

            /* =========================
             * BPJS
             * ========================= */
            $bpjsKes = is_numeric($row['bpjs_kes'] ?? $row['bpjs_kesehatan'] ?? null)
                ? ($row['bpjs_kes'] ?? $row['bpjs_kesehatan'])
                : null;

            $bpjsTk = is_numeric($row['bpjs_tk'] ?? null)
                ? $row['bpjs_tk']
                : null;

            /* =========================
             * INSERT
             * ========================= */
            Employee::create([
                'id_karyawan' => $idKaryawan, // 🔥 HASIL FINAL

                'full_name' => $fullName,
                'mother_name' => $row['mother_name'] ?? $row['nama_ibu'] ?? null,
                'gender' => $gender,
                'birth_place' => $row['birth_place'] ?? $row['tempat_lahir'] ?? null,
                'birth_date' => $this->parseDate($row['birth_date'] ?? $row['tanggal_lahir'] ?? null),
                'email' => $email,
                'phone' => $row['phone'] ?? $row['telepon'] ?? null,
                'nik' => $nik,
                'npwp' => $row['npwp'] ?? null,
                'bpjs_tk' => $bpjsTk,
                'bpjs_kes' => $bpjsKes,
                'address_ktp' => $row['address_ktp'] ?? $row['alamat_ktp'] ?? null,
                'address_domisili' => $row['address_domisili'] ?? $row['alamat_domisili'] ?? null,
                'join_date' => $this->parseDate($row['join_date'] ?? $row['tanggal_masuk'] ?? null),
                'blood_type' => $bloodType,
                'rekomendasi' => $row['rekomendasi'] ?? null,

                // RELATIONS
                'company_id' => $this->safeLike(Company::class, 'company_name', $row['company'] ?? $row['department'] ?? null),
                'department_id' => $this->safeLike(Department::class, 'department_name', $row['department'] ?? $row['divisi'] ?? null),
                'position_id' => $this->safeLike(Position::class, 'position_name', $row['position'] ?? $row['posisi'] ?? $row['bagian'] ?? null),
                'employment_type_id' => $this->safeLike(EmploymentType::class, 'type_name', $row['employment_type'] ?? $row['tipe_pekerjaan'] ?? null),
                'employment_status_id' => $this->safeLike(EmploymentStatus::class, 'status_name', $row['employment_status'] ?? $row['status_pekerjaan'] ?? null),
                'education_id' => $this->safeLike(Education::class, 'education_level', $row['education'] ?? $row['pendidikan'] ?? null),
                'marital_status_id' => $maritalId,
                'religion_id' => $this->safeLike(Religion::class, 'religion_name', $row['religion'] ?? $row['agama'] ?? null),

                // BANK
                'bank_id' => $this->safeLike(Bank::class, 'bank_name', $row['bank'] ?? null),
                'bank_account' => $row['bank_account'] ?? $row['nomor_rekening'] ?? null,

                // EMERGENCY
                'emergency_name' => $row['emergency_name'] ?? $row['nama_darurat'] ?? null,
                'emergency_relation' => $row['emergency_relation'] ?? $row['hubungan_darurat'] ?? null,
                'emergency_phone' => $row['emergency_phone'] ?? $row['telp_darurat'] ?? null,
                'kk_number' => $row['kk_number'] ?? $row['no_kk'] ?? null,
            ]);

            $this->inserted++;
        }
    }
}