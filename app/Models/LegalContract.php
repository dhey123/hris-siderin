<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LegalContract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'nomor_kontrak',
        'nama_kontrak',
        'jenis_kontrak_id',
        'nilai_kontrak',
        'tanggal_mulai',
        'tanggal_berakhir',
        'file_path',
        'keterangan', // kalau ada
    ];
    

    public function vendor()
    {
        return $this->belongsTo(LegalVendor::class, 'vendor_id');
    }

    public function jenis()
    {
        return $this->belongsTo(JenisKontrak::class, 'jenis_kontrak_id');
    }
// Hitung sisa hari (angka)
public function getSisaHariAttribute()
{
    if (!$this->tanggal_berakhir) return null;

    $today = now()->startOfDay();
    $end   = \Carbon\Carbon::parse($this->tanggal_berakhir)->startOfDay();

    return $today->diffInDays($end, false);
}


// Tampilan sisa hari (teks)
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


// Status kontrak
public function getStatusAttribute()
{
    $sisa = $this->sisa_hari;

    if ($sisa === null) return 'Aktif';
    if ($sisa < 0) return 'Expired';
    if ($sisa <= 30) return 'H-30';

    return 'Aktif';
}

}