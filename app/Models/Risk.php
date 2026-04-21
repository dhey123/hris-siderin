<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    use HasFactory;

   protected $fillable = [
    'nama_risiko',
    'deskripsi',
    'kategori',
    'owner',
    'status',
    'tanggal_identifikasi',
    'tanggal_update',

];
// ================= RELATIONS =================

public function assessments()
{
    return $this->hasMany(RiskAssessment::class);
}

public function mitigations()
{
    return $this->hasMany(RiskMitigation::class);
}

public function emergencyPlan()
{
    return $this->hasOne(RiskEmergencyPlan::class);
}
}