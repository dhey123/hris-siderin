<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditChecklist extends Model
{
    protected $fillable = [
        'kode',
        'item',
        'standar',
        'kategori',
        'aktif'
    ];

    public function details()
    {
        return $this->hasMany(AuditDetail::class);
    }
}