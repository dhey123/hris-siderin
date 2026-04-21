<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class She extends Model
{
    use HasFactory;

    // Nama tabel SHE
    protected $table = 'she';

    protected $fillable = [
        'modul',
        'submodul',

        // umum
        'tanggal',
        'status',
        'deskripsi',

        // APD (nanti)
        'nama_apd',
        'jenis_apd',
        'stok',
        'kondisi',

        // Pelatihan (nanti)
        'judul_pelatihan',
        'tanggal_pelatihan',
        'peserta',
    ];
}
