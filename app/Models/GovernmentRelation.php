<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GovernmentRelation extends Model
{
    use HasFactory;

    protected $table = 'government_relations';

    protected $fillable = [
    'instansi',
    'agenda',
    'tanggal',
    'status', 
    'lampiran',
    'keterangan'
];
     public function structure()
{
    return $this->belongsTo(IndustrialStructure::class, 'structure_id');
}
}