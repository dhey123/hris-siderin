<?php

namespace App\Models;

use App\Models\LeaveRequest;
use Illuminate\Database\Eloquent\Model;

class SuratDokter extends Model
{
    protected $table = 'doctor_letters';

    protected $fillable = [
        'employee_id',
        'tanggal_surat',
        'diagnosa',
        'hari_istirahat',
        'tanggal_mulai',
        'tanggal_selesai',
        'nama_dokter',
        'klinik',
        'file_surat',
    ];

    // 🔹 CAST tanggal ke Carbon
    protected $casts = [
        'tanggal_surat'   => 'date',
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];

    // 🔹 Relasi ke Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // 🔹 Relasi ke LeaveRequest
   

public function leaveRequests()
{
    return $this->hasMany(LeaveRequest::class, 'doctor_letter_id');

    }
    public function department() {
    return $this->belongsTo(Department::class);
}

public function position() {
    return $this->belongsTo(Position::class);
}


}
