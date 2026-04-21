<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditDetail extends Model
{
    protected $fillable = [
        'audit_id',
        'audit_checklist_id',
        'hasil',
        'temuan',
        'tindak_lanjut',
        'target_selesai'
    ];

    // ================= RELATION =================

    public function audit()
    {
        return $this->belongsTo(Audit::class);
    }

    public function checklist()
    {
        return $this->belongsTo(AuditChecklist::class, 'audit_checklist_id');
    }
    
}