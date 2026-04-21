<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiskMitigation extends Model
{
    protected $fillable = [
    'risk_id',
    'tindakan',
    'pic',
    'deadline',
    'status',
    'efektivitas',
    'lampiran',
];

    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }
}