<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WasteLog;

class Waste extends Model
{
    protected $casts = [
    'jumlah' => 'decimal:2',
    'sisa_limbah' => 'decimal:2',
    'tanggal' => 'date',
    'tanggal_maksimal' => 'date',
];
    protected $table = 'wastes';

    // ================================
    // MASS ASSIGNMENT
    // ================================
    protected $fillable = [
        'no_dokumen',          // Nomor dokumen
        'tanggal',             // Tanggal masuk limbah
        'jenis_limbah',        // B3 / Non-B3
        'nama_limbah',         // Nama limbah
        'kategori',            // Padat / Cair / Gas
        'jumlah',              // Jumlah limbah
        'satuan',              // Satuan (kg / liter / drum)
        'sumber_limbah',       // Sumber limbah
        'metode_pengelolaan',  // Metode pengelolaan (default '-')
        'tujuan_pengelolaan',  // Tujuan pengelolaan / Vendor
        'vendor',              // Vendor / optional
        'lokasi_penyimpanan',  // Lokasi penyimpanan
        'status_pengelolaan',  
        'foto',                // Path foto
        'keterangan',          // Keterangan tambahan
        'tanggal_maksimal',    // Tanggal maksimal simpan
        'sisa_limbah',         // Jumlah sisa limbah
    ];

    // ================================
    // RELATIONSHIP
    // ================================
    public function logs()
    {
        return $this->hasMany(WasteLog::class, 'waste_id');
    
}

}
