<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Audit extends Model
{
    protected $fillable = [
        'kode_audit',
        'jenis_audit',
        'area',
        'tanggal_audit',
        'auditor',
        'status',
        'catatan',
        'created_by'
    ];

    protected $appends = ['skor'];

    // ================= RELATION =================
    public function details()
    {
        return $this->hasMany(AuditDetail::class);
    }

    // ================= ACCESSOR =================
    public function getTanggalAuditFormattedAttribute()
    {
        return Carbon::parse($this->tanggal_audit)->format('d/m/Y');
    }

    public function getSkorAttribute()
    {
        $details = $this->details;

        if ($details->count() == 0) return 0;

        $totalScore = 0;

        foreach ($details as $detail) {
            if ($detail->hasil == 'sesuai') {
                $totalScore += 1;
            } elseif ($detail->hasil == 'observasi') {
                $totalScore += 0.5;
            }
        }

        return round(($totalScore / $details->count()) * 100);
    }
}