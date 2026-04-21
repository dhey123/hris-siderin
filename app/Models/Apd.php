<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apd extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_apd',
        'jenis_apd',
        'department',
        'stok_awal',
        'stok_saat_ini',
        'kondisi',
        'keterangan',
        'tanggal_pengadaan',
    ];
}
