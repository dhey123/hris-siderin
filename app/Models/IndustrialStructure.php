<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustrialStructure extends Model
{
    use HasFactory;

    protected $table = 'industrial_structures';

    protected $fillable = [
        'nama',
        'jabatan',
        'pihak',
        'kontak',
        'keterangan'
    ];
    public function cases()
{
    return $this->hasMany(EmployeeCase::class, 'structure_id');
}

public function relations()
{
    return $this->hasMany(IndustrialRelation::class, 'structure_id');
}
}