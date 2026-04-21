<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApdLog extends Model
{
    use HasFactory;

    protected $table = 'apd_logs'; // pastikan tabelnya sesuai DB

    protected $fillable = [
        'apd_id',
        'tanggal',
        'stok_awal',     // tambahkan
        'jumlah',
        'stok_akhir',    // tambahkan
        'dipakai_oleh',  // tambahkan
        'user',          // tambahkan
        'keterangan',
    ];

    public function apd()
    {
        return $this->belongsTo(Apd::class);
    }
}
