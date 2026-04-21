<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustrialRelation extends Model
{
    use HasFactory;

    protected $table = 'industrial_relations';

    protected $fillable = [
    'jenis',
    'judul',
    'tanggal',
    'status',
    'keterangan',
    'file_dokumen'
];
public function structure()
{
    return $this->belongsTo(IndustrialStructure::class, 'structure_id');
}
}