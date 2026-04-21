<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelatihan',
        'penyelenggara',
        'tanggal',
        'durasi',
        'department',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // ✅ RELASI RESCHEDULE
    public function reschedules()
    {
        return $this->hasMany(PelatihanReschedule::class);
    }
    public function evaluasi()
{
    return $this->hasOne(PelatihanEvaluasi::class);
}

    
}
