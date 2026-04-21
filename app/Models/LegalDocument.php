<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class LegalDocument extends Model
{
    protected $fillable = [
    'nama_dokumen',
    'kategori',
    'nomor_dokumen',
    'tanggal_terbit',
    'tanggal_berakhir',
    'vendor_id',
    'file_path',
    'status',
];

public function vendor()
{
    return $this->belongsTo(LegalVendor::class, 'vendor_id');
}

public function getStatusAttribute()
{
    if (!$this->tanggal_berakhir) {
        return 'Aktif';
    }

    $expiredDate = Carbon::parse($this->tanggal_berakhir);
    $today = Carbon::today();

    if ($expiredDate->lt($today)) {
        return 'Expired';
    }

    if ($expiredDate->diffInDays($today) <= 30) {
        return 'Hampir Habis';
    }

    return 'Aktif';
}
}




