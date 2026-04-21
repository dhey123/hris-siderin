<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
    'id_karyawan',
    'full_name',
    'nik',
    'kk_number',
    'npwp',
    'mother_name',
    'gender',
    'birth_place',
    'birth_date',
    'blood_type',
    'email',
    'phone',
    'address_ktp',
    'address_domisili',
    'company_id',
    'department_id',
    'position_id',
    'religion_id',
    'education_id',
    'marital_status_id',
    'employment_type_id',
    'employment_status_id',
    'join_date',
    'tanggal_akhir_kontrak',
    'exit_date',
    'reason_resign',
    'rekomendasi',
    'bpjs_tk',
    'bpjs_kes',
    'bank_id',
    'bank_account',
    'emergency_name',
    'emergency_relation',
    'emergency_phone',
    'photo',
    'source_applicant_id',
    'status',
];

    protected $casts = [
        'birth_date' => 'date',
        'join_date'  => 'date',
        'exit_date'  => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class, 'religion_id');
    }

    public function education()
    {
        return $this->belongsTo(Education::class, 'education_id');
    }

    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class, 'marital_status_id');
    }

    public function employmentType()
    {
        return $this->belongsTo(EmploymentType::class, 'employment_type_id');
    }

    public function employmentStatus()
    {
        return $this->belongsTo(EmploymentStatus::class, 'employment_status_id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class, 'employee_id', 'id');
    }

    public function applicant()
    {
    return $this->belongsTo(RecruitmentApplicant::class, 'source_applicant_id');
    }

    public function leaveRequests()
    {
    return $this->hasMany(LeaveRequest::class);
    }

    public function leaveBalances()
    {
    return $this->hasMany(LeaveBalance::class);
    
    }
    public function suratDokters()
    {
    return $this->hasMany(SuratDokter::class, 'employee_id');
    }

    public function mcus()
    {
    return $this->hasMany(Mcu::class, 'employee_id');
    }

        public function bpjs()
    {
        return $this->hasMany(BpjsRecord::class);
    }
    public function histories()
{
    return $this->hasMany(EmployeeHistory::class)->latest();
}

    public function isBorongan()
    {
        return strtolower($this->employmentType->type_name ?? '') === 'borongan';
    }

protected static function booted()
{
    static::saving(function ($employee) {

        // =========================
        // AUTO FORMAT ID KARYAWAN
        // =========================
        if (!empty($employee->id_karyawan)) {

            // 🔥 CEK: kalau sudah ada prefix (ada "-") → skip
            if (!str_contains($employee->id_karyawan, '-')) {

                // Ambil prefix dari company
                $prefix = 'IDK';

                if ($employee->company_id) {
                    $company = \App\Models\Company::find($employee->company_id);

                    if ($company) {
                        $name = strtolower($company->company_name);

                        if (str_contains($name, 'quantum')) {
                            $prefix = 'QTY';
                        } elseif (str_contains($name, 'uniland')) {
                            $prefix = 'UNL';
                        } else {
                            $prefix = strtoupper(substr($company->company_name, 0, 3));
                        }
                    }
                }

                // 🔥 hanya generate kalau belum ada prefix
                $employee->id_karyawan = $prefix . '-' . $employee->id_karyawan;
            }
        }

        // =========================
        // EXISTING LOGIC LO (AMAN)
        // =========================
        if (!$employee->company_id && !empty($employee->company_type)) {
            $company = Company::where('company_name', $employee->company_type)->first();
            if ($company) $employee->company_id = $company->id;
        }

        if (!$employee->department_id) {
            $dept = Department::first();
            if ($dept) $employee->department_id = $dept->id;
        }

        if (!$employee->position_id) {
            $pos = Position::first();
            if ($pos) $employee->position_id = $pos->id;
        }
    });
}

    /*
|--------------------------------------------------------------------------
| ACCESSORS (AUTO HITUNG PAJAK)
|--------------------------------------------------------------------------
*/

public function getJumlahTanggunganAttribute()
{
    return min(
        $this->familyMembers
            ->filter(fn ($m) =>
                $m->is_dependent &&
                str_contains(strtolower($m->relationship ?? ''), 'anak')
            )
            ->count(),
        3
    );
}

public function getStatusPajakAttribute()
{
    $this->loadMissing('familyMembers', 'maritalStatus');

    $status = strtolower(optional($this->maritalStatus)->marital_status_name);

    $menikah = ['menikah', 'married'];
    $cerai   = ['cerai', 'divorced', 'duda', 'janda'];

    // MENIKAH → K0/K1/K2/K3
    if (in_array($status, $menikah)) {
        return 'K/' . $this->jumlah_tanggungan;
    }

    // CERAI tapi punya anak → K1/K2/K3
    if (in_array($status, $cerai) && $this->jumlah_tanggungan > 0) {
        return 'K/' . $this->jumlah_tanggungan;
    }

    // SINGLE / CERAI tanpa anak
    return 'TK/0';
}


public function getGenderTextAttribute()
{
    return $this->gender == 'L'
        ? 'Laki-Laki'
        : ($this->gender == 'P' ? 'Perempuan' : '-');
}

public function getPhotoUrlAttribute()
{
    return $this->photo 
        ? asset('storage/'.$this->photo)
        : asset('images/default-avatar.png');
}

public function scopeKontrakAkanHabis($query)
{
    return $query
        ->active() // 🔥 pake scope
        ->whereNotNull('tanggal_akhir_kontrak')
        ->whereBetween('tanggal_akhir_kontrak', [
            Carbon::today(),
            Carbon::today()->addDays(30)
        ]);
}
public function getSisaHariKontrakAttribute()
{
    if (!$this->tanggal_akhir_kontrak) {
        return null;
    }

    return Carbon::today()->diffInDays(
        Carbon::parse($this->tanggal_akhir_kontrak),
        false
    );
}
public function isEligibleForAnnualLeave()
{
    if (!$this->employmentStatus) {
        return false;
    }

    $status = strtolower($this->employmentStatus->status_name);

    return in_array($status, ['tetap', 'kontrak']);
}
public function scopeActive($q)
{
    return $q->where('status', 'Active');
}

public function scopeArchived($q)
{
    return $q->where('status', '!=', 'Active');
}
}
