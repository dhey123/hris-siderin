<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiskEmergencyPlan extends Model
{
    protected $fillable = [
        'risk_id',
        'rencana',
        'contact_person',
        'catatan',
    ];

    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }
}