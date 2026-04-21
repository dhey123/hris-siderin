<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apk extends Model
{
    use HasFactory;

    protected $table = 'apk'; // atau 'apks' kalau tabelnya plural

    public $timestamps = false; // biar Laravel gak bingung sama created_at/updated_at

protected $fillable = [
    'nama_alat',
    'lokasi',
    'jumlah',
    'kondisi',
    'owner',
    'tanggal_update',
    'expired_date', // ✅ TAMBAH
];
public function getSisaHariAttribute()
{
    if(!$this->expired_date){
        return null;
    }

    return now()->diffInDays($this->expired_date, false);
}
public function getStatusExpiredAttribute()
{
    if(!$this->expired_date){
        return null;
    }

    $sisa = now()->diffInDays($this->expired_date, false);

    if($sisa < 0){
        return 'expired';
    }

    if($sisa <= 30){
        return 'warning';
    }

    return 'aktif';
}

}
