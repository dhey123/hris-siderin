<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LegalCompliance extends Model
{
    protected $fillable = [
        'nama_compliance',
        'nomor',
        'tanggal_terbit',
        'tanggal_berakhir',
        'file_path'
    ];

    
public function getSisaHariAttribute()
{
    if (!$this->tanggal_berakhir) return null;

    $today = now()->startOfDay();
    $end   = \Carbon\Carbon::parse($this->tanggal_berakhir)->startOfDay();

    return $today->diffInDays($end, false);
}


// Teks sisa hari
public function getSisaHariTextAttribute()
{
    if ($this->sisa_hari === null) {
        return '-';
    }

    if ($this->sisa_hari > 0) {
        return $this->sisa_hari . ' hari lagi';
    }

    if ($this->sisa_hari == 0) {
        return 'Hari ini';
    }

    return 'Expired ' . abs($this->sisa_hari) . ' hari';
}

    // Status izin
   public function getStatusAttribute()
{
    if (!$this->tanggal_berakhir) {
        return 'Aktif';
    }

    $sisa = $this->sisa_hari;

    if ($sisa < 0) {
        return 'Expired';
    }

    if ($sisa <= 30) {
        return 'H-30';
    }

    return 'Aktif';
}

}