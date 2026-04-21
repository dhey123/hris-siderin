<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelatihanReschedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelatihan_id',
        'tanggal_lama',
        'tanggal_baru',
        'alasan',
    ];

    protected $casts = [
        'tanggal_lama' => 'date',
        'tanggal_baru' => 'date',
    ];

    // Relasi ke Pelatihan
    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }
    
}
