<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class RiskAssessment extends Model
{
    protected $table = 'risk_assessments';

    protected $fillable = [
        'risk_id', 'likelihood', 'impact', 'risk_score', 'risk_level', 'assessed_by', 'assessed_at'
    ];

    protected $casts = [
        'assessed_at' => 'datetime', // <<< ini bikin Laravel otomatis jadi Carbon
    ];

    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }
}

