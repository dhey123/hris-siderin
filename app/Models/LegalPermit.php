<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LegalPermit extends Model
{
    protected $fillable = [
        'nama_izin',
        'nomor_izin',
        'instansi_penerbit',
        'tanggal_terbit',
        'tanggal_berakhir',
        'keterangan',
        'file'
    ];

    protected $dates = [
        'tanggal_terbit',
        'tanggal_berakhir'
    ];

    // Hitung sisa hari
   // Hitung sisa hari (angka)
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