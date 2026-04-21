<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    protected $casts = [
    'tanggal' => 'date',
];

    protected $fillable = [
        'nomor_inspeksi',
        'kode',
        'tanggal',
        'area',
        'jenis',
        'user_id',
        'status',
        'keterangan'
    ];

    public function details()
{
    return $this->hasMany(InspectionDetail::class, 'inspection_id');
}


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
